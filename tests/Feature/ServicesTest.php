<?php

use App\DTOs\OrderData;
use App\DTOs\OrderItemData;
use App\DTOs\CustomerData;
use App\DTOs\WooCommerceOrderData;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use App\Models\Shipment;
use App\Models\ShipmentTrackingLog;
use App\Models\Tenant;
use App\Models\User;
use App\Services\OrderCreateService;
use App\Services\ShipmentCreateService;
use App\Services\WooCommerceOrderMapper;
use App\Services\WooCommerceImportService;
use App\Services\Courier\CourierProviderFactory;
use App\Services\Courier\PathaoProvider;
use App\Jobs\SyncTrackingJob;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function setupTenant(): array
{
    $tenant = Tenant::create([
        'name' => 'Test Store', 'slug' => 'svc-test-' . uniqid(),
        'email' => 'store@test.com', 'currency' => 'BDT', 'timezone' => 'Asia/Dhaka',
    ]);
    $user = User::create([
        'tenant_id' => $tenant->id, 'name' => 'Owner',
        'email' => 'owner-' . uniqid() . '@test.com',
        'password' => bcrypt('password'), 'role' => 'owner', 'is_active' => true,
    ]);

    return [$tenant, $user];
}

// -----------------------------------------------
// OrderItemData DTO
// -----------------------------------------------
describe('OrderItemData DTO', function () {
    it('calculates line total correctly', function () {
        $item = new OrderItemData(
            product_name: 'T-Shirt',
            quantity: 3,
            unit_price: 500,
            discount_amount: 100,
        );
        expect($item->lineTotal())->toBe(1400.0);
    });

    it('creates from array', function () {
        $item = OrderItemData::fromArray([
            'product_name' => 'Shoes',
            'quantity' => 2,
            'unit_price' => 1000,
            'product_sku' => 'SH-001',
        ]);
        expect($item->product_name)->toBe('Shoes')
            ->and($item->quantity)->toBe(2)
            ->and($item->product_sku)->toBe('SH-001')
            ->and($item->lineTotal())->toBe(2000.0);
    });

    it('defaults discount_amount to zero', function () {
        $item = OrderItemData::fromArray([
            'product_name' => 'Hat',
            'quantity' => 1,
            'unit_price' => 200,
        ]);
        expect($item->discount_amount)->toBe(0.0);
    });
});

// -----------------------------------------------
// CustomerData DTO
// -----------------------------------------------
describe('CustomerData DTO', function () {
    it('creates from array', function () {
        $dto = CustomerData::fromArray([
            'name' => 'Rahim',
            'phone' => '01712345678',
            'email' => 'rahim@example.com',
        ]);
        expect($dto->name)->toBe('Rahim')
            ->and($dto->phone)->toBe('01712345678')
            ->and($dto->email)->toBe('rahim@example.com');
    });

    it('handles missing optional fields', function () {
        $dto = CustomerData::fromArray(['name' => 'Rahim']);
        expect($dto->phone)->toBeNull()
            ->and($dto->email)->toBeNull();
    });
});

// -----------------------------------------------
// OrderData DTO
// -----------------------------------------------
describe('OrderData DTO', function () {
    it('creates from request array', function () {
        $data = OrderData::fromRequest([
            'source' => 'manual',
            'customer_name' => 'Test Customer',
            'payment_status' => 'unpaid',
            'items' => [
                ['product_name' => 'Widget', 'quantity' => 2, 'unit_price' => 100],
            ],
        ], tenantId: 1, userId: 1);

        expect($data->source)->toBe('manual')
            ->and($data->customer_name)->toBe('Test Customer')
            ->and($data->items)->toHaveCount(1)
            ->and($data->items[0])->toBeInstanceOf(OrderItemData::class);
    });
});

// -----------------------------------------------
// OrderCreateService
// -----------------------------------------------
describe('OrderCreateService', function () {
    it('creates an order with items in a transaction', function () {
        [$tenant, $user] = setupTenant();

        $service = new OrderCreateService();

        $data = new OrderData(
            tenant_id: $tenant->id,
            created_by: $user->id,
            source: 'manual',
            customer_name: 'Karim',
            items: [
                new OrderItemData('T-Shirt', 2, 500),
                new OrderItemData('Jeans', 1, 1200),
            ],
            customer_phone: '01799999999',
            payment_status: 'unpaid',
            shipping_charge: 60,
        );

        $order = $service->create($data);

        expect($order->id)->toBeGreaterThan(0)
            ->and($order->order_number)->toStartWith('ORD-')
            ->and($order->source)->toBe('manual')
            ->and($order->customer_name)->toBe('Karim')
            ->and($order->status)->toBe('pending')
            ->and((float) $order->subtotal)->toBe(2200.0)
            ->and((float) $order->total_amount)->toBe(2260.0)
            ->and($order->items)->toHaveCount(2);
    });

    it('auto-creates customer from phone number', function () {
        [$tenant, $user] = setupTenant();
        $service = new OrderCreateService();

        $data = new OrderData(
            tenant_id: $tenant->id,
            created_by: $user->id,
            source: 'phone',
            customer_name: 'Rahim',
            items: [new OrderItemData('Widget', 1, 300)],
            customer_phone: '01811111111',
        );

        $order = $service->create($data);

        expect($order->customer_id)->not->toBeNull();
        $customer = Customer::find($order->customer_id);
        expect($customer->name)->toBe('Rahim')
            ->and($customer->phone)->toBe('01811111111');
    });

    it('reuses existing customer by phone', function () {
        [$tenant, $user] = setupTenant();

        Customer::create([
            'tenant_id' => $tenant->id,
            'name' => 'Existing Customer',
            'phone' => '01822222222',
        ]);

        $service = new OrderCreateService();
        $data = new OrderData(
            tenant_id: $tenant->id,
            created_by: $user->id,
            source: 'manual',
            customer_name: 'Same Customer',
            items: [new OrderItemData('Item', 1, 100)],
            customer_phone: '01822222222',
        );

        $order = $service->create($data);
        expect(Customer::where('phone', '01822222222')->count())->toBe(1);
    });

    it('creates a status log entry', function () {
        [$tenant, $user] = setupTenant();
        $service = new OrderCreateService();

        $data = new OrderData(
            tenant_id: $tenant->id,
            created_by: $user->id,
            source: 'manual',
            customer_name: 'Test',
            items: [new OrderItemData('Item', 1, 100)],
        );

        $order = $service->create($data);
        $log = OrderStatusLog::where('order_id', $order->id)->first();

        expect($log)->not->toBeNull()
            ->and($log->to_status)->toBe('pending')
            ->and($log->from_status)->toBeNull();
    });

    it('stores source_raw_payload for imported orders', function () {
        [$tenant, $user] = setupTenant();
        $service = new OrderCreateService();

        $payload = ['id' => 123, 'status' => 'processing'];
        $data = new OrderData(
            tenant_id: $tenant->id,
            created_by: $user->id,
            source: 'woocommerce',
            customer_name: 'WC Customer',
            items: [new OrderItemData('Product', 1, 500)],
            source_order_id: '123',
            source_raw_payload: $payload,
        );

        $order = $service->create($data);
        expect($order->source_raw_payload)->toBe($payload)
            ->and($order->source_order_id)->toBe('123');
    });
});

// -----------------------------------------------
// WooCommerceOrderMapper
// -----------------------------------------------
describe('WooCommerceOrderMapper', function () {
    it('maps a WooCommerce order payload', function () {
        $mapper = new WooCommerceOrderMapper();

        $payload = [
            'id' => 456,
            'status' => 'processing',
            'currency' => 'BDT',
            'total' => '1500.00',
            'shipping_total' => '60.00',
            'discount_total' => '100.00',
            'total_tax' => '0.00',
            'payment_method' => 'cod',
            'payment_method_title' => 'Cash on Delivery',
            'billing' => [
                'first_name' => 'Rahim',
                'last_name' => 'Uddin',
                'phone' => '01712345678',
                'email' => 'rahim@test.com',
                'address_1' => '123 Main St',
                'city' => 'Dhaka',
            ],
            'line_items' => [
                ['name' => 'T-Shirt', 'quantity' => 2, 'price' => 500, 'sku' => 'TS-001'],
                ['name' => 'Cap', 'quantity' => 1, 'price' => 300, 'sku' => 'CP-001'],
            ],
        ];

        $result = $mapper->map($payload);

        expect($result)->toBeInstanceOf(WooCommerceOrderData::class)
            ->and($result->source_order_id)->toBe('456')
            ->and($result->customer->name)->toBe('Rahim Uddin')
            ->and($result->customer->phone)->toBe('01712345678')
            ->and($result->items)->toHaveCount(2)
            ->and($result->status)->toBe('confirmed')
            ->and($result->payment_status)->toBe('paid')
            ->and($result->shipping_charge)->toBe(60.0)
            ->and($result->discount_amount)->toBe(100.0)
            ->and($result->total_amount)->toBe(1500.0);
    });

    it('maps WooCommerce statuses correctly', function () {
        $mapper = new WooCommerceOrderMapper();

        expect($mapper->mapStatus('pending'))->toBe('pending')
            ->and($mapper->mapStatus('processing'))->toBe('confirmed')
            ->and($mapper->mapStatus('completed'))->toBe('delivered')
            ->and($mapper->mapStatus('cancelled'))->toBe('cancelled')
            ->and($mapper->mapStatus('refunded'))->toBe('refunded')
            ->and($mapper->mapStatus('on-hold'))->toBe('on_hold')
            ->and($mapper->mapStatus('unknown'))->toBe('pending');
    });

    it('maps payment statuses correctly', function () {
        $mapper = new WooCommerceOrderMapper();

        expect($mapper->mapPaymentStatus('processing'))->toBe('paid')
            ->and($mapper->mapPaymentStatus('completed'))->toBe('paid')
            ->and($mapper->mapPaymentStatus('pending'))->toBe('unpaid')
            ->and($mapper->mapPaymentStatus('refunded'))->toBe('refunded');
    });

    it('handles missing billing data gracefully', function () {
        $mapper = new WooCommerceOrderMapper();

        $payload = [
            'id' => 789,
            'status' => 'pending',
            'total' => '0',
            'shipping_total' => '0',
            'discount_total' => '0',
            'total_tax' => '0',
            'line_items' => [],
        ];

        $result = $mapper->map($payload);
        expect($result->customer->name)->toBe('WooCommerce Customer')
            ->and($result->customer->phone)->toBeNull();
    });
});

// -----------------------------------------------
// WooCommerceImportService
// -----------------------------------------------
describe('WooCommerceImportService', function () {
    it('imports a WooCommerce order', function () {
        [$tenant, $user] = setupTenant();

        $service = new WooCommerceImportService(
            new WooCommerceOrderMapper(),
            new OrderCreateService(),
        );

        $payload = [
            'id' => 100,
            'status' => 'processing',
            'currency' => 'BDT',
            'total' => '1000.00',
            'shipping_total' => '60.00',
            'discount_total' => '0.00',
            'total_tax' => '0.00',
            'payment_method_title' => 'bKash',
            'billing' => [
                'first_name' => 'Kamal',
                'last_name' => 'Hasan',
                'phone' => '01999999999',
                'email' => 'kamal@test.com',
                'address_1' => '45 Road',
                'city' => 'Chittagong',
            ],
            'line_items' => [
                ['name' => 'Polo Shirt', 'quantity' => 2, 'price' => 470, 'sku' => 'PS-01'],
            ],
        ];

        $order = $service->import($payload, $tenant->id, $user->id);

        expect($order)->not->toBeNull()
            ->and($order->source)->toBe('woocommerce')
            ->and($order->source_order_id)->toBe('100')
            ->and($order->customer_name)->toBe('Kamal Hasan')
            ->and($order->source_raw_payload)->toBeArray()
            ->and($order->items)->toHaveCount(1);
    });

    it('prevents duplicate WooCommerce imports', function () {
        [$tenant, $user] = setupTenant();

        $service = new WooCommerceImportService(
            new WooCommerceOrderMapper(),
            new OrderCreateService(),
        );

        $payload = [
            'id' => 200,
            'status' => 'processing',
            'currency' => 'BDT',
            'total' => '500.00',
            'shipping_total' => '0.00',
            'discount_total' => '0.00',
            'total_tax' => '0.00',
            'billing' => ['first_name' => 'Test', 'last_name' => 'User'],
            'line_items' => [['name' => 'Item', 'quantity' => 1, 'price' => 500]],
        ];

        $first = $service->import($payload, $tenant->id, $user->id);
        $second = $service->import($payload, $tenant->id, $user->id);

        expect($first)->not->toBeNull()
            ->and($second)->toBeNull()
            ->and(Order::where('source_order_id', '200')->count())->toBe(1);
    });

    it('detects duplicates correctly', function () {
        [$tenant, $user] = setupTenant();

        $service = new WooCommerceImportService(
            new WooCommerceOrderMapper(),
            new OrderCreateService(),
        );

        expect($service->isDuplicate($tenant->id, '999'))->toBeFalse();

        Order::create([
            'tenant_id' => $tenant->id,
            'source' => 'woocommerce',
            'source_order_id' => '999',
            'customer_name' => 'Test',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'ordered_at' => now(),
        ]);

        expect($service->isDuplicate($tenant->id, '999'))->toBeTrue();
    });
});

// -----------------------------------------------
// Courier Provider Factory
// -----------------------------------------------
describe('CourierProviderFactory', function () {
    it('creates a pathao provider', function () {
        $provider = CourierProviderFactory::make('pathao');
        expect($provider)->toBeInstanceOf(PathaoProvider::class)
            ->and($provider->getProviderName())->toBe('pathao');
    });

    it('throws for unknown provider', function () {
        CourierProviderFactory::make('unknown-courier');
    })->throws(\InvalidArgumentException::class);

    it('checks if provider exists', function () {
        expect(CourierProviderFactory::has('pathao'))->toBeTrue()
            ->and(CourierProviderFactory::has('unknown'))->toBeFalse();
    });

    it('allows registering new providers', function () {
        CourierProviderFactory::register('test-courier', PathaoProvider::class);
        expect(CourierProviderFactory::has('test-courier'))->toBeTrue();
    });
});

// -----------------------------------------------
// PathaoProvider
// -----------------------------------------------
describe('PathaoProvider', function () {
    it('normalizes Pathao statuses', function () {
        $provider = new PathaoProvider();

        expect($provider->normalizeStatus('Delivered'))->toBe('delivered')
            ->and($provider->normalizeStatus('In Transit'))->toBe('in_transit')
            ->and($provider->normalizeStatus('Out for Delivery'))->toBe('out_for_delivery')
            ->and($provider->normalizeStatus('Picked'))->toBe('picked_up')
            ->and($provider->normalizeStatus('Return'))->toBe('returned')
            ->and($provider->normalizeStatus('Failed Delivery'))->toBe('failed')
            ->and($provider->normalizeStatus('Unknown Status'))->toBe('pending');
    });

    it('validates config on test connection', function () {
        $provider = new PathaoProvider();

        expect($provider->testConnection([
            'client_id' => 'test',
            'client_secret' => 'secret',
            'base_url' => 'https://api.pathao.com',
        ]))->toBeTrue();
    });

    it('throws on missing config fields', function () {
        $provider = new PathaoProvider();
        $provider->testConnection(['client_id' => 'test']);
    })->throws(\InvalidArgumentException::class);
});

// -----------------------------------------------
// ShipmentCreateService
// -----------------------------------------------
describe('ShipmentCreateService', function () {
    it('rejects orders without customer name', function () {
        [$tenant, $user] = setupTenant();
        $order = Order::create([
            'tenant_id' => $tenant->id,
            'source' => 'manual',
            'customer_name' => '',
            'status' => 'confirmed',
            'payment_status' => 'unpaid',
            'ordered_at' => now(),
        ]);

        $courier = Courier::create([
            'tenant_id' => $tenant->id,
            'name' => 'Pathao',
            'code' => 'pathao',
            'base_rate' => 60,
            'is_active' => true,
            'api_config' => ['client_id' => 'x', 'client_secret' => 'y', 'base_url' => 'https://api.pathao.com'],
        ]);

        $service = new ShipmentCreateService();
        $service->create($order, $courier);
    })->throws(\InvalidArgumentException::class, 'customer name');

    it('rejects cancelled orders', function () {
        [$tenant, $user] = setupTenant();
        $order = Order::create([
            'tenant_id' => $tenant->id,
            'source' => 'manual',
            'customer_name' => 'Test',
            'customer_phone' => '01712345678',
            'status' => 'cancelled',
            'payment_status' => 'unpaid',
            'ordered_at' => now(),
        ]);

        $courier = Courier::create([
            'tenant_id' => $tenant->id,
            'name' => 'Pathao',
            'code' => 'pathao',
            'base_rate' => 60,
            'is_active' => true,
            'api_config' => ['client_id' => 'x', 'client_secret' => 'y', 'base_url' => 'https://api.pathao.com'],
        ]);

        $service = new ShipmentCreateService();
        $service->create($order, $courier);
    })->throws(\InvalidArgumentException::class, 'cancelled or refunded');

    it('prevents duplicate active shipments', function () {
        [$tenant, $user] = setupTenant();
        $order = Order::create([
            'tenant_id' => $tenant->id,
            'source' => 'manual',
            'customer_name' => 'Test',
            'customer_phone' => '01712345678',
            'status' => 'confirmed',
            'payment_status' => 'unpaid',
            'ordered_at' => now(),
        ]);

        Shipment::create([
            'order_id' => $order->id,
            'status' => 'pending',
        ]);

        $courier = Courier::create([
            'tenant_id' => $tenant->id,
            'name' => 'Pathao',
            'code' => 'pathao',
            'base_rate' => 60,
            'is_active' => true,
            'api_config' => ['client_id' => 'x', 'client_secret' => 'y', 'base_url' => 'https://api.pathao.com'],
        ]);

        $service = new ShipmentCreateService();
        $service->create($order, $courier);
    })->throws(\RuntimeException::class, 'active shipment');
});

// -----------------------------------------------
// SyncTrackingJob
// -----------------------------------------------
describe('SyncTrackingJob', function () {
    it('skips if shipment not found', function () {
        $job = new SyncTrackingJob(99999);
        $job->handle();

        // No exception means it gracefully skipped
        expect(true)->toBeTrue();
    });

    it('skips shipments with delivered status', function () {
        [$tenant, $user] = setupTenant();
        $order = Order::create([
            'tenant_id' => $tenant->id,
            'source' => 'manual',
            'customer_name' => 'Test',
            'status' => 'delivered',
            'payment_status' => 'paid',
            'ordered_at' => now(),
        ]);

        $courier = Courier::create([
            'tenant_id' => $tenant->id,
            'name' => 'Pathao',
            'code' => 'pathao',
            'base_rate' => 60,
            'is_active' => true,
        ]);

        $shipment = Shipment::create([
            'order_id' => $order->id,
            'courier_id' => $courier->id,
            'status' => 'delivered',
            'tracking_number' => 'TR123',
        ]);

        $job = new SyncTrackingJob($shipment->id);
        $job->handle();

        // Should not create any tracking log since status is terminal
        expect(ShipmentTrackingLog::count())->toBe(0);
    });

    it('has unique id based on shipment', function () {
        $job = new SyncTrackingJob(42);
        expect($job->uniqueId())->toBe('tracking-sync-42');
    });
});

// -----------------------------------------------
// StoreOrderRequest validation rules
// -----------------------------------------------
describe('StoreOrderRequest', function () {
    it('has required validation rules', function () {
        $request = new \App\Http\Requests\StoreOrderRequest();
        $rules = $request->rules();

        expect($rules)->toHaveKeys([
            'source', 'customer_name', 'payment_status',
            'items', 'items.*.product_name', 'items.*.quantity', 'items.*.unit_price',
        ]);
    });

    it('authorizes all users', function () {
        $request = new \App\Http\Requests\StoreOrderRequest();
        expect($request->authorize())->toBeTrue();
    });
});

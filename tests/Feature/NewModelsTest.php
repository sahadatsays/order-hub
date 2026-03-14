<?php

use App\Models\Courier;
use App\Models\Integration;
use App\Models\IntegrationLog;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\Permission;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Role;
use App\Models\Shipment;
use App\Models\ShipmentTrackingLog;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Shared helpers
function newTenant(): Tenant
{
    return Tenant::create([
        'name' => 'Test Store', 'slug' => 'test-' . uniqid(),
        'email' => 'store@test.com', 'currency' => 'BDT', 'timezone' => 'Asia/Dhaka',
    ]);
}

function newUser(?Tenant $tenant = null): User
{
    $tenant ??= newTenant();
    return User::create([
        'tenant_id' => $tenant->id,
        'name' => 'Owner',
        'email' => 'owner-' . uniqid() . '@test.com',
        'password' => bcrypt('password'),
        'role' => 'owner',
        'is_active' => true,
    ]);
}

function newOrder(int $tenantId, array $extra = []): Order
{
    return Order::create(array_merge([
        'tenant_id' => $tenantId,
        'source' => 'manual',
        'customer_name' => 'Test Customer',
        'status' => 'pending',
        'payment_status' => 'unpaid',
        'currency' => 'BDT',
        'ordered_at' => now(),
    ], $extra));
}

function newProduct(int $tenantId, array $extra = []): Product
{
    return Product::create(array_merge([
        'tenant_id' => $tenantId,
        'name' => 'Test Product',
        'price' => 500,
        'cost_price' => 200,
        'is_active' => true,
        'track_inventory' => true,
    ], $extra));
}

// -----------------------------------------------
// ProductVariant model
// -----------------------------------------------
describe('ProductVariant model', function () {
    it('creates a variant for a product', function () {
        $tid = newTenant()->id;
        $product = newProduct($tid);
        $variant = ProductVariant::create([
            'tenant_id' => $tid,
            'product_id' => $product->id,
            'name' => 'Red / XL',
            'sku' => 'TST-RED-XL',
            'price' => 550,
            'cost_price' => 220,
            'quantity_on_hand' => 25,
            'option_values' => ['color' => 'Red', 'size' => 'XL'],
            'is_active' => true,
        ]);
        expect($variant->id)->not->toBeNull()
            ->and($variant->option_values)->toBe(['color' => 'Red', 'size' => 'XL'])
            ->and($variant->product->id)->toBe($product->id);
    });

    it('scopes active variants', function () {
        $tid = newTenant()->id;
        $product = newProduct($tid);
        ProductVariant::create(['tenant_id' => $tid, 'product_id' => $product->id, 'name' => 'Active', 'is_active' => true]);
        ProductVariant::create(['tenant_id' => $tid, 'product_id' => $product->id, 'name' => 'Inactive', 'is_active' => false]);
        expect(ProductVariant::active()->count())->toBe(1);
    });

    it('returns effective price from variant or product', function () {
        $tid = newTenant()->id;
        $product = newProduct($tid, ['price' => 500]);
        $withPrice = ProductVariant::create(['tenant_id' => $tid, 'product_id' => $product->id, 'name' => 'A', 'price' => 600]);
        $withoutPrice = ProductVariant::create(['tenant_id' => $tid, 'product_id' => $product->id, 'name' => 'B', 'price' => null]);
        expect($withPrice->effective_price)->toBe(600.0)
            ->and($withoutPrice->effective_price)->toBe(500.0);
    });

    it('belongs to product via relationship', function () {
        $tid = newTenant()->id;
        $product = newProduct($tid);
        ProductVariant::create(['tenant_id' => $tid, 'product_id' => $product->id, 'name' => 'V1']);
        ProductVariant::create(['tenant_id' => $tid, 'product_id' => $product->id, 'name' => 'V2']);
        expect($product->variants()->count())->toBe(2);
    });
});

// -----------------------------------------------
// OrderStatusLog model
// -----------------------------------------------
describe('OrderStatusLog model', function () {
    it('logs a status change', function () {
        $tid = newTenant()->id;
        $order = newOrder($tid);
        $log = OrderStatusLog::log($order->id, null, 'pending', 'confirmed', 'Customer confirmed by phone');
        expect($log->id)->not->toBeNull()
            ->and($log->from_status)->toBe('pending')
            ->and($log->to_status)->toBe('confirmed')
            ->and($log->note)->toBe('Customer confirmed by phone');
    });

    it('is accessible from order relationship', function () {
        $tid = newTenant()->id;
        $order = newOrder($tid);
        OrderStatusLog::log($order->id, null, 'pending', 'confirmed');
        OrderStatusLog::log($order->id, null, 'confirmed', 'processing');
        expect($order->statusLogs()->count())->toBe(2);
    });

    it('tracks who changed the status', function () {
        $user = newUser();
        $order = newOrder($user->tenant_id);
        $log = OrderStatusLog::log($order->id, $user->id, 'pending', 'confirmed');
        expect($log->changedBy->id)->toBe($user->id);
    });
});

// -----------------------------------------------
// IntegrationLog model
// -----------------------------------------------
describe('IntegrationLog model', function () {
    it('creates a sync log', function () {
        $tid = newTenant()->id;
        $integration = Integration::create([
            'tenant_id' => $tid, 'type' => 'woocommerce', 'name' => 'WC Store', 'is_active' => true,
        ]);
        $log = IntegrationLog::create([
            'integration_id' => $integration->id,
            'tenant_id' => $tid,
            'action' => 'sync_orders',
            'status' => 'started',
            'started_at' => now(),
        ]);
        expect($log->id)->not->toBeNull()
            ->and($log->action)->toBe('sync_orders');
    });

    it('marks log as completed', function () {
        $tid = newTenant()->id;
        $integration = Integration::create([
            'tenant_id' => $tid, 'type' => 'woocommerce', 'name' => 'WC', 'is_active' => true,
        ]);
        $log = IntegrationLog::create([
            'integration_id' => $integration->id,
            'tenant_id' => $tid,
            'action' => 'sync_orders',
            'status' => 'started',
            'started_at' => now(),
        ]);
        $log->markCompleted(15, 2);
        expect($log->fresh()->status)->toBe('success')
            ->and($log->fresh()->records_processed)->toBe(15)
            ->and($log->fresh()->records_failed)->toBe(2)
            ->and($log->fresh()->completed_at)->not->toBeNull();
    });

    it('marks log as failed', function () {
        $tid = newTenant()->id;
        $integration = Integration::create([
            'tenant_id' => $tid, 'type' => 'facebook', 'name' => 'FB', 'is_active' => true,
        ]);
        $log = IntegrationLog::create([
            'integration_id' => $integration->id,
            'tenant_id' => $tid,
            'action' => 'sync_orders',
            'status' => 'started',
            'started_at' => now(),
        ]);
        $log->markFailed('API timeout');
        expect($log->fresh()->status)->toBe('failed')
            ->and($log->fresh()->error_message)->toBe('API timeout');
    });

    it('stores request and response payloads', function () {
        $tid = newTenant()->id;
        $integration = Integration::create([
            'tenant_id' => $tid, 'type' => 'woocommerce', 'name' => 'WC', 'is_active' => true,
        ]);
        $log = IntegrationLog::create([
            'integration_id' => $integration->id,
            'tenant_id' => $tid,
            'action' => 'sync_orders',
            'status' => 'success',
            'request_payload' => ['page' => 1, 'per_page' => 50],
            'response_payload' => ['orders' => [['id' => 101]]],
            'started_at' => now(),
        ]);
        expect($log->fresh()->request_payload)->toBe(['page' => 1, 'per_page' => 50])
            ->and($log->fresh()->response_payload)->toBe(['orders' => [['id' => 101]]]);
    });

    it('is accessible from integration relationship', function () {
        $tid = newTenant()->id;
        $integration = Integration::create([
            'tenant_id' => $tid, 'type' => 'woocommerce', 'name' => 'WC', 'is_active' => true,
        ]);
        IntegrationLog::create([
            'integration_id' => $integration->id, 'tenant_id' => $tid,
            'action' => 'sync_orders', 'status' => 'success', 'started_at' => now(),
        ]);
        expect($integration->logs()->count())->toBe(1);
    });

    it('scopes by failed status', function () {
        $tid = newTenant()->id;
        $integration = Integration::create([
            'tenant_id' => $tid, 'type' => 'woocommerce', 'name' => 'WC', 'is_active' => true,
        ]);
        IntegrationLog::create([
            'integration_id' => $integration->id, 'tenant_id' => $tid,
            'action' => 'sync_orders', 'status' => 'success', 'started_at' => now(),
        ]);
        IntegrationLog::create([
            'integration_id' => $integration->id, 'tenant_id' => $tid,
            'action' => 'sync_orders', 'status' => 'failed', 'error_message' => 'timeout', 'started_at' => now(),
        ]);
        expect(IntegrationLog::failed()->count())->toBe(1);
    });
});

// -----------------------------------------------
// ShipmentTrackingLog model
// -----------------------------------------------
describe('ShipmentTrackingLog model', function () {
    it('creates a tracking log entry', function () {
        $tid = newTenant()->id;
        $order = newOrder($tid);
        $courier = Courier::create(['tenant_id' => $tid, 'name' => 'Pathao', 'code' => 'pathao', 'base_rate' => 60]);
        $shipment = Shipment::create([
            'order_id' => $order->id, 'courier_id' => $courier->id,
            'status' => 'pending', 'shipping_cost' => 60,
        ]);
        $log = ShipmentTrackingLog::create([
            'shipment_id' => $shipment->id,
            'status' => 'picked_up',
            'location' => 'Dhaka Hub',
            'description' => 'Package picked up from merchant',
            'raw_payload' => ['courier_status' => 'PICKED', 'timestamp' => '2026-03-14T10:00:00Z'],
            'tracked_at' => now(),
            'created_at' => now(),
        ]);
        expect($log->id)->not->toBeNull()
            ->and($log->status)->toBe('picked_up')
            ->and($log->raw_payload)->toHaveKey('courier_status');
    });

    it('is accessible from shipment relationship', function () {
        $tid = newTenant()->id;
        $order = newOrder($tid);
        $courier = Courier::create(['tenant_id' => $tid, 'name' => 'Pathao', 'code' => 'pathao', 'base_rate' => 60]);
        $shipment = Shipment::create([
            'order_id' => $order->id, 'courier_id' => $courier->id,
            'status' => 'in_transit', 'shipping_cost' => 60,
        ]);
        ShipmentTrackingLog::create(['shipment_id' => $shipment->id, 'status' => 'picked_up', 'created_at' => now()]);
        ShipmentTrackingLog::create(['shipment_id' => $shipment->id, 'status' => 'in_transit', 'created_at' => now()]);
        expect($shipment->trackingLogs()->count())->toBe(2);
    });
});

// -----------------------------------------------
// InventoryTransaction model
// -----------------------------------------------
describe('InventoryTransaction model', function () {
    it('records a stock transaction', function () {
        $tid = newTenant()->id;
        $product = newProduct($tid);
        $tx = InventoryTransaction::create([
            'tenant_id' => $tid,
            'product_id' => $product->id,
            'type' => 'purchase',
            'quantity' => 50,
            'quantity_before' => 0,
            'quantity_after' => 50,
            'note' => 'Initial stock',
            'created_at' => now(),
        ]);
        expect($tx->id)->not->toBeNull()
            ->and($tx->type_label)->toBe('Purchase')
            ->and($tx->quantity_after)->toBe(50);
    });

    it('records a sale transaction with negative quantity', function () {
        $tid = newTenant()->id;
        $product = newProduct($tid);
        $order = newOrder($tid);
        $tx = InventoryTransaction::create([
            'tenant_id' => $tid,
            'product_id' => $product->id,
            'type' => 'sale',
            'quantity' => -5,
            'quantity_before' => 50,
            'quantity_after' => 45,
            'reference_type' => Order::class,
            'reference_id' => $order->id,
            'created_at' => now(),
        ]);
        expect($tx->quantity)->toBe(-5)
            ->and($tx->type_label)->toBe('Sale')
            ->and($tx->reference_type)->toBe(Order::class);
    });

    it('has correct type labels', function () {
        expect(InventoryTransaction::TYPES['purchase'])->toBe('Purchase')
            ->and(InventoryTransaction::TYPES['sale'])->toBe('Sale')
            ->and(InventoryTransaction::TYPES['adjustment'])->toBe('Adjustment')
            ->and(InventoryTransaction::TYPES['return'])->toBe('Return')
            ->and(InventoryTransaction::TYPES['damage'])->toBe('Damage');
    });
});

// -----------------------------------------------
// Role and Permission models
// -----------------------------------------------
describe('Role and Permission models', function () {
    it('creates a role with permissions', function () {
        $tid = newTenant()->id;
        $role = Role::create(['tenant_id' => $tid, 'name' => 'Order Manager', 'slug' => 'order-manager']);
        $perm = Permission::create(['name' => 'Create Orders', 'slug' => 'orders.create', 'group' => 'orders']);
        $role->permissions()->attach($perm->id);

        expect($role->permissions()->count())->toBe(1)
            ->and($role->hasPermission('orders.create'))->toBeTrue()
            ->and($role->hasPermission('orders.delete'))->toBeFalse();
    });

    it('assigns permission to user directly', function () {
        $user = newUser();
        $perm = Permission::create(['name' => 'View Reports', 'slug' => 'reports.view', 'group' => 'reports']);
        $user->directPermissions()->attach($perm->id);

        expect($user->directPermissions()->count())->toBe(1);
    });

    it('permission belongs to many roles', function () {
        $tid = newTenant()->id;
        $perm = Permission::create(['name' => 'View Orders', 'slug' => 'orders.view', 'group' => 'orders']);
        $role1 = Role::create(['tenant_id' => $tid, 'name' => 'Admin', 'slug' => 'admin', 'is_system' => true]);
        $role2 = Role::create(['tenant_id' => $tid, 'name' => 'Manager', 'slug' => 'manager']);
        $perm->roles()->attach([$role1->id, $role2->id]);

        expect($perm->roles()->count())->toBe(2);
    });

    it('tenant has roles', function () {
        $tenant = newTenant();
        Role::create(['tenant_id' => $tenant->id, 'name' => 'Admin', 'slug' => 'admin', 'is_system' => true]);
        Role::create(['tenant_id' => $tenant->id, 'name' => 'Staff', 'slug' => 'staff', 'is_system' => true]);

        expect($tenant->roles()->count())->toBe(2);
    });
});

// -----------------------------------------------
// Raw payload columns on existing models
// -----------------------------------------------
describe('Order raw payload', function () {
    it('stores source_raw_payload as JSON', function () {
        $tid = newTenant()->id;
        $order = newOrder($tid, [
            'source' => 'woocommerce',
            'source_order_id' => 'WC-12345',
            'source_raw_payload' => ['id' => 12345, 'status' => 'processing', 'line_items' => [['name' => 'T-Shirt']]],
        ]);
        $fresh = $order->fresh();
        expect($fresh->source_raw_payload)->toBe(['id' => 12345, 'status' => 'processing', 'line_items' => [['name' => 'T-Shirt']]])
            ->and($fresh->source_order_id)->toBe('WC-12345');
    });

    it('allows null source_raw_payload for manual orders', function () {
        $tid = newTenant()->id;
        $order = newOrder($tid, ['source' => 'manual']);
        expect($order->fresh()->source_raw_payload)->toBeNull();
    });
});

describe('Shipment raw payloads', function () {
    it('stores request and response payloads', function () {
        $tid = newTenant()->id;
        $order = newOrder($tid);
        $courier = Courier::create(['tenant_id' => $tid, 'name' => 'Pathao', 'code' => 'pathao', 'base_rate' => 60]);
        $shipment = Shipment::create([
            'order_id' => $order->id,
            'courier_id' => $courier->id,
            'status' => 'pending',
            'shipping_cost' => 60,
            'request_payload' => ['recipient_name' => 'Test', 'recipient_phone' => '01712345678'],
            'response_payload' => ['consignment_id' => 'PT-123', 'status' => 'created'],
        ]);
        $fresh = $shipment->fresh();
        expect($fresh->request_payload)->toBe(['recipient_name' => 'Test', 'recipient_phone' => '01712345678'])
            ->and($fresh->response_payload)->toBe(['consignment_id' => 'PT-123', 'status' => 'created']);
    });
});

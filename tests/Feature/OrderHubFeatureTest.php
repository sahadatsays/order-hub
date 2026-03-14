<?php

use App\Models\AuditLog;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Integration;
use App\Models\InventoryItem;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Shared helper: create tenant + owner user
function createTenant(): Tenant
{
    return Tenant::create([
        'name' => 'Test Store', 'slug' => 'test-store-' . uniqid(),
        'email' => 'store@test.com', 'currency' => 'BDT', 'timezone' => 'Asia/Dhaka',
    ]);
}

function createUser(?Tenant $tenant = null): User
{
    $tenant ??= createTenant();
    return User::create([
        'tenant_id' => $tenant->id,
        'name' => 'Owner',
        'email' => 'owner-' . uniqid() . '@test.com',
        'password' => bcrypt('password'),
        'role' => 'owner',
        'is_active' => true,
    ]);
}

function makeOrder(int $tenantId, array $extra = []): Order
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

function makeProduct(int $tenantId, array $extra = []): Product
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
// Route middleware: auth routes redirect guests
// -----------------------------------------------
describe('Route middleware', function () {
    it('redirects guests from dashboard', fn () => $this->get('/dashboard')->assertRedirect('/login'));
    it('redirects guests from orders', fn () => $this->get('/orders')->assertRedirect('/login'));
    it('redirects guests from customers', fn () => $this->get('/customers')->assertRedirect('/login'));
    it('redirects guests from products', fn () => $this->get('/products')->assertRedirect('/login'));
    it('redirects guests from inventory', fn () => $this->get('/inventory')->assertRedirect('/login'));
    it('redirects guests from invoices', fn () => $this->get('/invoices')->assertRedirect('/login'));
    it('redirects guests from reports', fn () => $this->get('/reports')->assertRedirect('/login'));
    it('redirects guests from integrations', fn () => $this->get('/integrations')->assertRedirect('/login'));
});

// -----------------------------------------------
// Plan model
// -----------------------------------------------
describe('Plan model', function () {
    it('creates with features cast as array', function () {
        $plan = Plan::create([
            'name' => 'Starter', 'slug' => 'starter',
            'monthly_price' => 9.99, 'yearly_price' => 99.99,
            'is_active' => true, 'sort_order' => 1,
            'features' => ['Orders', 'Customers'],
        ]);
        expect($plan->features)->toBe(['Orders', 'Customers']);
    });

    it('scopes to active plans only', function () {
        Plan::create(['name' => 'A', 'slug' => 'a', 'monthly_price' => 9, 'yearly_price' => 90, 'is_active' => true, 'sort_order' => 1]);
        Plan::create(['name' => 'B', 'slug' => 'b', 'monthly_price' => 0, 'yearly_price' => 0, 'is_active' => false, 'sort_order' => 2]);
        expect(Plan::active()->count())->toBe(1);
    });
});

// -----------------------------------------------
// Order model
// -----------------------------------------------
describe('Order model', function () {
    it('auto-generates an order number', function () {
        $tid = createTenant()->id;
        $order = makeOrder($tid);
        expect($order->order_number)->toStartWith('ORD-');
    });

    it('returns correct status label and color', function () {
        $tid = createTenant()->id;
        $order = makeOrder($tid, ['source' => 'facebook', 'status' => 'processing']);
        expect($order->status_label)->toBe('Processing')
            ->and($order->status_color)->toBe('indigo');
    });

    it('returns correct source label', function () {
        $tid = createTenant()->id;
        $order = makeOrder($tid, ['source' => 'shopify']);
        expect($order->source_label)->toBe('Shopify');
    });

    it('calculates due amount correctly', function () {
        $tid = createTenant()->id;
        $order = makeOrder($tid, ['total_amount' => 1000, 'paid_amount' => 300, 'payment_status' => 'partial']);
        expect($order->due_amount)->toBe(700.0);
    });

    it('scopes orders by status', function () {
        $tid = createTenant()->id;
        makeOrder($tid, ['status' => 'pending']);
        makeOrder($tid, ['status' => 'delivered', 'payment_status' => 'paid']);
        expect(Order::byStatus('pending')->count())->toBe(1)
            ->and(Order::byStatus('delivered')->count())->toBe(1);
    });
});

// -----------------------------------------------
// Product model
// -----------------------------------------------
describe('Product model', function () {
    it('calculates margin correctly', function () {
        $tid = createTenant()->id;
        $p = makeProduct($tid, ['price' => 500, 'cost_price' => 200]);
        expect($p->margin)->toBe(60.0);
    });

    it('scopes active products', function () {
        $tid = createTenant()->id;
        makeProduct($tid, ['name' => 'Active', 'is_active' => true]);
        makeProduct($tid, ['name' => 'Inactive', 'is_active' => false]);
        expect(Product::active()->count())->toBe(1);
    });
});

// -----------------------------------------------
// InventoryItem model
// -----------------------------------------------
describe('InventoryItem model', function () {
    it('computes available quantity', function () {
        $tid = createTenant()->id;
        $product = makeProduct($tid);
        $item = InventoryItem::create(['product_id' => $product->id, 'tenant_id' => $tid, 'quantity_on_hand' => 50, 'quantity_reserved' => 10, 'reorder_point' => 5, 'reorder_quantity' => 20]);
        expect($item->quantity_available)->toBe(40);
    });

    it('detects low stock', function () {
        $tid = createTenant()->id;
        $product = makeProduct($tid);
        $item = InventoryItem::create(['product_id' => $product->id, 'tenant_id' => $tid, 'quantity_on_hand' => 3, 'quantity_reserved' => 0, 'reorder_point' => 10, 'reorder_quantity' => 50]);
        expect($item->isLowStock())->toBeTrue()
            ->and($item->isOutOfStock())->toBeFalse();
    });

    it('detects out of stock', function () {
        $tid = createTenant()->id;
        $product = makeProduct($tid);
        $item = InventoryItem::create(['product_id' => $product->id, 'tenant_id' => $tid, 'quantity_on_hand' => 0, 'quantity_reserved' => 0, 'reorder_point' => 5, 'reorder_quantity' => 20]);
        expect($item->isOutOfStock())->toBeTrue();
    });
});

// -----------------------------------------------
// Invoice model
// -----------------------------------------------
describe('Invoice model', function () {
    it('auto-generates invoice number', function () {
        $tid = createTenant()->id;
        $order = makeOrder($tid);
        $invoice = Invoice::create(['order_id' => $order->id, 'tenant_id' => $tid, 'subtotal' => 1000, 'total_amount' => 1000, 'status' => 'draft', 'issued_at' => now()]);
        expect($invoice->invoice_number)->toStartWith('INV-');
    });

    it('computes due amount', function () {
        $tid = createTenant()->id;
        $order = makeOrder($tid, ['payment_status' => 'partial']);
        $invoice = Invoice::create(['order_id' => $order->id, 'tenant_id' => $tid, 'subtotal' => 1000, 'total_amount' => 1000, 'paid_amount' => 400, 'status' => 'sent', 'issued_at' => now()]);
        expect($invoice->due_amount)->toBe(600.0);
    });
});

// -----------------------------------------------
// User roles
// -----------------------------------------------
describe('User roles', function () {
    it('owner has all permissions', function () {
        $user = new User(['role' => 'owner']);
        expect($user->isOwner())->toBeTrue()
            ->and($user->isAdmin())->toBeTrue()
            ->and($user->isManager())->toBeTrue()
            ->and($user->hasRole('staff'))->toBeTrue();
    });

    it('staff cannot act as admin', function () {
        $user = new User(['role' => 'staff']);
        expect($user->isAdmin())->toBeFalse()
            ->and($user->isOwner())->toBeFalse()
            ->and($user->hasRole('staff'))->toBeTrue();
    });
});

// -----------------------------------------------
// Integration model
// -----------------------------------------------
describe('Integration model', function () {
    it('has correct type labels', function () {
        expect(Integration::TYPES['facebook'])->toBe('Facebook')
            ->and(Integration::TYPES['woocommerce'])->toBe('WooCommerce')
            ->and(Integration::TYPES['shopify'])->toBe('Shopify');
    });

    it('scope active filters by is_active', function () {
        $tid = createTenant()->id;
        Integration::create(['tenant_id' => $tid, 'type' => 'facebook', 'name' => 'FB', 'is_active' => true]);
        Integration::create(['tenant_id' => $tid, 'type' => 'shopify', 'name' => 'Shopify', 'is_active' => false]);
        expect(Integration::active()->count())->toBe(1);
    });
});

// -----------------------------------------------
// AuditLog model
// -----------------------------------------------
describe('AuditLog model', function () {
    it('records an audit event', function () {
        $tid = createTenant()->id;
        $order = makeOrder($tid);
        AuditLog::record($tid, null, Order::class, $order->id, 'status_changed', 'status', 'pending', 'confirmed');
        expect(AuditLog::count())->toBe(1)
            ->and(AuditLog::first()->event)->toBe('status_changed');
    });
});

// -----------------------------------------------
// HTTP routes for authenticated users
// -----------------------------------------------
describe('Dashboard', function () {
    it('renders for authenticated user', function () {
        $this->actingAs(createUser())->get('/dashboard')->assertSuccessful();
    });
});

describe('Orders HTTP', function () {
    it('renders orders index', fn () => $this->actingAs(createUser())->get('/orders')->assertSuccessful());
    it('renders create form', fn () => $this->actingAs(createUser())->get('/orders/create')->assertSuccessful());

    it('stores a new order with items', function () {
        $user = createUser();
        $product = makeProduct($user->tenant_id, ['track_inventory' => false]);
        $this->actingAs($user)->post('/orders', [
            'source' => 'manual',
            'customer_name' => 'Test Customer',
            'payment_status' => 'unpaid',
            'items' => [
                ['product_id' => $product->id, 'product_name' => $product->name, 'quantity' => 2, 'unit_price' => 500],
            ],
        ])->assertRedirect();
        expect(Order::count())->toBe(1)
            ->and(OrderItem::count())->toBe(1)
            ->and(Order::first()->subtotal)->toBe('1000.00');
    });

    it('shows order detail', function () {
        $user = createUser();
        $order = makeOrder($user->tenant_id);
        $this->actingAs($user)->get("/orders/{$order->id}")->assertSuccessful();
    });

    it('updates order status', function () {
        $user = createUser();
        $order = makeOrder($user->tenant_id);
        $this->actingAs($user)->patch("/orders/{$order->id}/status", ['status' => 'confirmed'])->assertRedirect();
        expect($order->fresh()->status)->toBe('confirmed');
    });
});

describe('Customers HTTP', function () {
    it('renders index', fn () => $this->actingAs(createUser())->get('/customers')->assertSuccessful());

    it('stores a customer', function () {
        $user = createUser();
        $this->actingAs($user)->post('/customers', ['name' => 'Rahim Uddin', 'phone' => '01712345678'])->assertRedirect();
        expect(Customer::count())->toBe(1);
    });

    it('shows customer detail', function () {
        $user = createUser();
        $customer = Customer::create(['tenant_id' => $user->tenant_id, 'name' => 'Test', 'phone' => '01712345678']);
        $this->actingAs($user)->get("/customers/{$customer->id}")->assertSuccessful();
    });
});

describe('Products HTTP', function () {
    it('renders index', fn () => $this->actingAs(createUser())->get('/products')->assertSuccessful());

    it('stores a product', function () {
        $user = createUser();
        $this->actingAs($user)->post('/products', ['name' => 'Classic T-Shirt', 'price' => 450])->assertRedirect();
        expect(Product::count())->toBe(1);
    });
});

describe('Inventory HTTP', function () {
    it('renders index', fn () => $this->actingAs(createUser())->get('/inventory')->assertSuccessful());
});

describe('Invoices HTTP', function () {
    it('renders index', fn () => $this->actingAs(createUser())->get('/invoices')->assertSuccessful());
});

describe('Reports HTTP', function () {
    it('renders page', fn () => $this->actingAs(createUser())->get('/reports')->assertSuccessful());
});

describe('Integrations HTTP', function () {
    it('renders page', fn () => $this->actingAs(createUser())->get('/integrations')->assertSuccessful());

    it('can connect an integration', function () {
        $user = createUser();
        $this->actingAs($user)->post('/integrations/facebook/connect', [])->assertRedirect('/integrations');
        expect(Integration::where('type', 'facebook')->where('is_active', true)->count())->toBe(1);
    });
});

describe('Settings couriers', function () {
    it('renders couriers page', fn () => $this->actingAs(createUser())->get('/settings/couriers')->assertSuccessful());

    it('can create a courier', function () {
        $user = createUser();
        $this->actingAs($user)->post('/settings/couriers', ['name' => 'Pathao', 'code' => 'pathao', 'base_rate' => 60])->assertRedirect('/settings/couriers');
        expect(Courier::count())->toBe(1);
    });
});

<?php

use App\Models\Courier;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createOrdersTestTenant(): Tenant
{
    return Tenant::create([
        'name' => 'Test Store', 'slug' => 'orders-test-' . uniqid(),
        'email' => 'store@test.com', 'currency' => 'BDT', 'timezone' => 'Asia/Dhaka',
    ]);
}

function createOrdersTestUser(?Tenant $tenant = null): User
{
    $tenant ??= createOrdersTestTenant();
    return User::create([
        'tenant_id' => $tenant->id,
        'name' => 'Owner',
        'email' => 'owner-' . uniqid() . '@test.com',
        'password' => bcrypt('password'),
        'role' => 'owner',
        'is_active' => true,
    ]);
}

function makeTestOrder(int $tenantId, array $extra = []): Order
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

// -----------------------------------------------
// Orders List Filters
// -----------------------------------------------
describe('Orders List Filters', function () {

    it('filters by source', function () {
        $user = createOrdersTestUser();
        makeTestOrder($user->tenant_id, ['source' => 'manual', 'customer_name' => 'Manual Order']);
        makeTestOrder($user->tenant_id, ['source' => 'woocommerce', 'customer_name' => 'WC Order']);

        $this->actingAs($user)
            ->get('/orders?source=woocommerce')
            ->assertSuccessful()
            ->assertSeeText('WC Order')
            ->assertDontSeeText('Manual Order');
    });

    it('filters by payment status', function () {
        $user = createOrdersTestUser();
        makeTestOrder($user->tenant_id, ['payment_status' => 'paid', 'customer_name' => 'Paid Order']);
        makeTestOrder($user->tenant_id, ['payment_status' => 'unpaid', 'customer_name' => 'Unpaid Order']);

        $this->actingAs($user)
            ->get('/orders?payment_status=paid')
            ->assertSuccessful()
            ->assertSeeText('Paid Order')
            ->assertDontSeeText('Unpaid Order');
    });

    it('searches by source_order_id', function () {
        $user = createOrdersTestUser();
        makeTestOrder($user->tenant_id, ['source' => 'woocommerce', 'source_order_id' => 'WC-12345', 'customer_name' => 'WC Customer']);
        makeTestOrder($user->tenant_id, ['source' => 'manual', 'customer_name' => 'Other Customer']);

        $this->actingAs($user)
            ->get('/orders?search=WC-12345')
            ->assertSuccessful()
            ->assertSeeText('WC Customer');
    });

    it('searches by customer phone', function () {
        $user = createOrdersTestUser();
        makeTestOrder($user->tenant_id, ['customer_name' => 'Phone Customer', 'customer_phone' => '01712345678']);
        makeTestOrder($user->tenant_id, ['customer_name' => 'Other Customer', 'customer_phone' => '01899999999']);

        $this->actingAs($user)
            ->get('/orders?search=01712345678')
            ->assertSuccessful()
            ->assertSeeText('Phone Customer');
    });

    it('filters by status via tab', function () {
        $user = createOrdersTestUser();
        makeTestOrder($user->tenant_id, ['status' => 'pending', 'customer_name' => 'Pending One']);
        makeTestOrder($user->tenant_id, ['status' => 'delivered', 'customer_name' => 'Delivered One', 'payment_status' => 'paid']);

        $this->actingAs($user)
            ->get('/orders?status=pending')
            ->assertSuccessful()
            ->assertSeeText('Pending One')
            ->assertDontSeeText('Delivered One');
    });

    it('filters by date range', function () {
        $user = createOrdersTestUser();
        makeTestOrder($user->tenant_id, ['customer_name' => 'Today Order', 'ordered_at' => now()]);
        makeTestOrder($user->tenant_id, ['customer_name' => 'Old Order', 'ordered_at' => now()->subMonth()]);

        $this->actingAs($user)
            ->get('/orders?from=' . now()->format('Y-m-d') . '&to=' . now()->format('Y-m-d'))
            ->assertSuccessful()
            ->assertSeeText('Today Order')
            ->assertDontSeeText('Old Order');
    });

    it('filters by assigned user (created_by)', function () {
        $tenant = createOrdersTestTenant();
        $user1 = User::create([
            'tenant_id' => $tenant->id, 'name' => 'Staff One',
            'email' => 'staff1-' . uniqid() . '@test.com', 'password' => bcrypt('password'),
            'role' => 'staff', 'is_active' => true,
        ]);
        $user2 = User::create([
            'tenant_id' => $tenant->id, 'name' => 'Staff Two',
            'email' => 'staff2-' . uniqid() . '@test.com', 'password' => bcrypt('password'),
            'role' => 'staff', 'is_active' => true,
        ]);
        makeTestOrder($tenant->id, ['created_by' => $user1->id, 'customer_name' => 'User1 Order']);
        makeTestOrder($tenant->id, ['created_by' => $user2->id, 'customer_name' => 'User2 Order']);

        $this->actingAs($user1)
            ->get('/orders?created_by=' . $user1->id)
            ->assertSuccessful()
            ->assertSeeText('User1 Order')
            ->assertDontSeeText('User2 Order');
    });

    it('filters by shipment status', function () {
        $user = createOrdersTestUser();
        $order1 = makeTestOrder($user->tenant_id, ['status' => 'shipped', 'customer_name' => 'Shipped Order']);
        $order2 = makeTestOrder($user->tenant_id, ['status' => 'pending', 'customer_name' => 'Pending Order']);
        Shipment::create(['order_id' => $order1->id, 'status' => 'in_transit']);

        $this->actingAs($user)
            ->get('/orders?shipment_status=in_transit')
            ->assertSuccessful()
            ->assertSeeText('Shipped Order')
            ->assertDontSeeText('Pending Order');
    });

    it('filters by courier', function () {
        $user = createOrdersTestUser();
        $courier = Courier::create([
            'tenant_id' => $user->tenant_id,
            'name' => 'Pathao', 'code' => 'pathao', 'base_rate' => 60, 'is_active' => true,
        ]);
        $order1 = makeTestOrder($user->tenant_id, ['customer_name' => 'Pathao Order']);
        $order2 = makeTestOrder($user->tenant_id, ['customer_name' => 'No Courier Order']);
        Shipment::create(['order_id' => $order1->id, 'courier_id' => $courier->id, 'status' => 'pending']);

        $this->actingAs($user)
            ->get('/orders?courier_id=' . $courier->id)
            ->assertSuccessful()
            ->assertSeeText('Pathao Order')
            ->assertDontSeeText('No Courier Order');
    });
});

// -----------------------------------------------
// Orders List Display
// -----------------------------------------------
describe('Orders List Display', function () {

    it('shows dynamic stats', function () {
        $user = createOrdersTestUser();
        makeTestOrder($user->tenant_id, ['status' => 'pending']);
        makeTestOrder($user->tenant_id, ['status' => 'processing']);

        $this->actingAs($user)
            ->get('/orders')
            ->assertSuccessful()
            ->assertSeeText('All Orders')
            ->assertSeeText('Pending')
            ->assertSeeText('Processing');
    });

    it('shows source badges', function () {
        $user = createOrdersTestUser();
        makeTestOrder($user->tenant_id, ['source' => 'woocommerce', 'customer_name' => 'WC Test']);

        $this->actingAs($user)
            ->get('/orders')
            ->assertSuccessful()
            ->assertSeeText('WooCommerce');
    });

    it('shows empty state when no orders', function () {
        $user = createOrdersTestUser();

        $this->actingAs($user)
            ->get('/orders')
            ->assertSuccessful()
            ->assertSeeText('No orders found');
    });

    it('shows empty state with filter hint when filtering', function () {
        $user = createOrdersTestUser();

        $this->actingAs($user)
            ->get('/orders?source=woocommerce')
            ->assertSuccessful()
            ->assertSeeText('Try adjusting your filters');
    });

    it('shows shipment status when shipment exists', function () {
        $user = createOrdersTestUser();
        $order = makeTestOrder($user->tenant_id, ['status' => 'shipped', 'customer_name' => 'Shipped Test']);
        Shipment::create(['order_id' => $order->id, 'status' => 'in_transit']);

        $this->actingAs($user)
            ->get('/orders')
            ->assertSuccessful()
            ->assertSeeText('In Transit');
    });

    it('passes couriers and users to view', function () {
        $user = createOrdersTestUser();
        Courier::create([
            'tenant_id' => $user->tenant_id,
            'name' => 'Test Courier', 'code' => 'test', 'base_rate' => 50, 'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get('/orders')
            ->assertSuccessful()
            ->assertSeeText('Test Courier');
    });
});

// -----------------------------------------------
// Shipment Model Enhancements
// -----------------------------------------------
describe('Shipment model enhancements', function () {
    it('has status constants', function () {
        expect(Shipment::STATUSES)->toHaveKeys(['pending', 'picked_up', 'in_transit', 'out_for_delivery', 'delivered', 'failed', 'returned']);
    });

    it('has status color constants', function () {
        expect(Shipment::STATUS_COLORS)->toHaveKeys(['pending', 'in_transit', 'delivered']);
    });

    it('returns status label', function () {
        $shipment = new Shipment(['status' => 'in_transit']);
        expect($shipment->status_label)->toBe('In Transit');
    });

    it('returns status color', function () {
        $shipment = new Shipment(['status' => 'delivered']);
        expect($shipment->status_color)->toBe('green');
    });
});

// -----------------------------------------------
// Order Model Enhancements
// -----------------------------------------------
describe('Order model enhancements', function () {
    it('has source color constants', function () {
        expect(Order::SOURCE_COLORS)->toHaveKeys(['facebook', 'woocommerce', 'manual', 'phone']);
    });

    it('has payment status color constants', function () {
        expect(Order::PAYMENT_STATUS_COLORS)->toHaveKeys(['unpaid', 'partial', 'paid', 'refunded']);
    });

    it('returns source color', function () {
        $order = new Order(['source' => 'woocommerce']);
        expect($order->source_color)->toBe('purple');
    });

    it('returns payment status label', function () {
        $order = new Order(['payment_status' => 'paid']);
        expect($order->payment_status_label)->toBe('Paid');
    });

    it('returns payment status color', function () {
        $order = new Order(['payment_status' => 'unpaid']);
        expect($order->payment_status_color)->toBe('red');
    });
});

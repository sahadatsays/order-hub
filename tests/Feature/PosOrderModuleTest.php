<?php

use App\DTOs\OrderData;
use App\DTOs\OrderItemData;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use App\Services\OrderCalculationService;
use App\Services\OrderCreateService;
use App\Services\OrderPaymentService;
use App\Services\OrderStatusService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function posUser(): User
{
    $tenant = Tenant::create([
        'name' => 'POS Store', 'slug' => 'pos-store-' . uniqid(),
        'email' => 'pos@test.com', 'currency' => 'BDT', 'timezone' => 'Asia/Dhaka',
    ]);
    return User::create([
        'tenant_id' => $tenant->id,
        'name' => 'Cashier',
        'email' => 'cashier-' . uniqid() . '@test.com',
        'password' => bcrypt('password'),
        'role' => 'owner',
        'is_active' => true,
    ]);
}

function posProduct(int $tenantId, array $extra = []): Product
{
    return Product::create(array_merge([
        'tenant_id' => $tenantId,
        'name' => 'Test Product ' . uniqid(),
        'sku' => 'SKU-' . uniqid(),
        'price' => 100,
        'cost_price' => 50,
        'is_active' => true,
    ], $extra));
}

function posOrder(int $tenantId, array $extra = []): Order
{
    return Order::create(array_merge([
        'tenant_id' => $tenantId,
        'source' => 'pos',
        'order_type' => 'pos',
        'customer_name' => 'Walk-in Customer',
        'status' => 'pending',
        'payment_status' => 'unpaid',
        'subtotal' => 500,
        'total_amount' => 500,
        'paid_amount' => 0,
        'currency' => 'BDT',
        'ordered_at' => now(),
    ], $extra));
}

// ─── OrderCalculationService Tests ───

test('calculation service computes subtotal from items', function () {
    $calc = new OrderCalculationService();
    $items = [
        ['quantity' => 2, 'unit_price' => 100, 'discount_amount' => 10],
        ['quantity' => 1, 'unit_price' => 50],
    ];
    expect($calc->calculateSubtotal($items))->toBe(240.0);
});

test('calculation service computes total correctly', function () {
    $calc = new OrderCalculationService();
    expect($calc->calculateTotal(1000, 50, 100, 20))->toBe(1070.0);
    expect($calc->calculateTotal(100, 200, 0, 0))->toBe(0.0); // Cannot go negative
});

test('calculation service derives payment status', function () {
    $calc = new OrderCalculationService();
    expect($calc->derivePaymentStatus(0, 500))->toBe('unpaid');
    expect($calc->derivePaymentStatus(250, 500))->toBe('partial');
    expect($calc->derivePaymentStatus(500, 500))->toBe('paid');
    expect($calc->derivePaymentStatus(600, 500))->toBe('paid');
    expect($calc->derivePaymentStatus(0, 0))->toBe('paid');
});

test('calculation service calculates due amount', function () {
    $calc = new OrderCalculationService();
    expect($calc->dueAmount(500, 200))->toBe(300.0);
    expect($calc->dueAmount(500, 600))->toBe(0.0); // Cannot go negative
});

// ─── OrderStatusService Tests ───

test('status service validates transitions', function () {
    $svc = new OrderStatusService();
    expect($svc->canTransition('pending', 'confirmed'))->toBeTrue();
    expect($svc->canTransition('pending', 'cancelled'))->toBeTrue();
    expect($svc->canTransition('pending', 'delivered'))->toBeFalse();
    expect($svc->canTransition('cancelled', 'pending'))->toBeFalse();
    expect($svc->canTransition('delivered', 'refunded'))->toBeTrue();
});

test('status service returns allowed transitions', function () {
    $svc = new OrderStatusService();
    expect($svc->allowedTransitions('pending'))->toContain('confirmed');
    expect($svc->allowedTransitions('cancelled'))->toBe([]);
});

test('status service determines edit eligibility', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id, ['status' => 'pending']);
    $svc = new OrderStatusService();
    expect($svc->canEdit($order))->toBeTrue();

    $order->status = 'shipped';
    expect($svc->canEdit($order))->toBeFalse();
});

test('status service transitions order and logs', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id, ['status' => 'pending']);
    $svc = new OrderStatusService();
    $svc->transition($order, 'confirmed', $user->id, 'Test transition');

    expect($order->fresh()->status)->toBe('confirmed');
    expect($order->statusLogs()->count())->toBe(1);
});

test('status service rejects invalid transition', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id, ['status' => 'pending']);
    $svc = new OrderStatusService();

    $this->expectException(InvalidArgumentException::class);
    $svc->transition($order, 'delivered', $user->id);
});

test('status service rejects cancellation with payments', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id, ['status' => 'pending', 'paid_amount' => 100]);
    $svc = new OrderStatusService();

    $this->expectException(InvalidArgumentException::class);
    $svc->transition($order, 'cancelled', $user->id);
});

// ─── OrderPaymentService Tests ───

test('payment service records payment and updates order', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id);

    $svc = new OrderPaymentService(new OrderCalculationService());
    $payment = $svc->recordPayment($order, 'cash', 300, $user->id, 500);

    expect($payment)->toBeInstanceOf(OrderPayment::class);
    expect((float) $payment->amount)->toBe(300.0);
    expect((float) $payment->tendered)->toBe(500.0);
    expect((float) $payment->change_amount)->toBe(200.0);

    $order->refresh();
    expect((float) $order->paid_amount)->toBe(300.0);
    expect($order->payment_status)->toBe('partial');
});

test('payment service marks fully paid', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id);

    $svc = new OrderPaymentService(new OrderCalculationService());
    $svc->recordPayment($order, 'cash', 500, $user->id);

    $order->refresh();
    expect((float) $order->paid_amount)->toBe(500.0);
    expect($order->payment_status)->toBe('paid');
});

test('payment service rejects zero amount', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id);

    $svc = new OrderPaymentService(new OrderCalculationService());
    $this->expectException(InvalidArgumentException::class);
    $svc->recordPayment($order, 'cash', 0, $user->id);
});

// ─── POS Controller Tests ───

test('pos index loads', function () {
    $user = posUser();
    $this->actingAs($user)->get(route('pos.index'))->assertOk();
});

test('pos customer search returns results', function () {
    $user = posUser();
    Customer::create([
        'tenant_id' => $user->tenant_id,
        'name' => 'John Doe',
        'phone' => '01711111111',
        'email' => 'john@test.com',
    ]);

    $this->actingAs($user)
        ->getJson(route('pos.customers.search', ['q' => 'John']))
        ->assertOk()
        ->assertJsonCount(1);
});

test('pos barcode resolves product', function () {
    $user = posUser();
    $product = posProduct($user->tenant_id, ['sku' => 'BAR123']);

    $this->actingAs($user)
        ->getJson(route('pos.barcode', ['barcode' => 'BAR123']))
        ->assertOk()
        ->assertJsonFragment(['name' => $product->name]);
});

test('pos barcode returns 404 for unknown sku', function () {
    $user = posUser();
    $this->actingAs($user)
        ->getJson(route('pos.barcode', ['barcode' => 'UNKNOWN']))
        ->assertNotFound();
});

test('pos creates order via json', function () {
    $user = posUser();
    $product = posProduct($user->tenant_id);

    $this->actingAs($user)
        ->postJson(route('pos.store'), [
            'customer_name' => 'Walk-in Customer',
            'items' => [
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => 2,
                    'unit_price' => 100,
                ],
            ],
            'payment_method' => 'cash',
            'paid_amount' => 200,
            'tendered' => 300,
        ])
        ->assertOk()
        ->assertJsonFragment(['success' => true, 'payment_status' => 'paid']);

    expect(Order::where('tenant_id', $user->tenant_id)->where('source', 'pos')->count())->toBe(1);
});

test('pos validates required items', function () {
    $user = posUser();
    $this->actingAs($user)
        ->postJson(route('pos.store'), [
            'customer_name' => 'Walk-in',
            'items' => [],
        ])
        ->assertUnprocessable();
});

// ─── OrderController Refactor Tests ───

test('order store uses service and creates properly', function () {
    $user = posUser();
    $product = posProduct($user->tenant_id);

    $this->actingAs($user)
        ->post(route('orders.store'), [
            'source' => 'manual',
            'customer_name' => 'Admin Customer',
            'customer_phone' => '01800000000',
            'payment_status' => 'unpaid',
            'items' => [
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => 3,
                    'unit_price' => 200,
                ],
            ],
        ])
        ->assertRedirect();

    $order = Order::where('tenant_id', $user->tenant_id)->where('source', 'manual')->first();
    expect($order)->not->toBeNull();
    expect((float) $order->subtotal)->toBe(600.0);
    expect((float) $order->total_amount)->toBe(600.0);
});

test('order update recalculates totals', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id, ['discount_amount' => 0, 'shipping_charge' => 0]);
    $order->items()->create([
        'product_name' => 'Prod', 'quantity' => 2, 'unit_price' => 100, 'line_total' => 200,
    ]);

    $this->actingAs($user)
        ->patch(route('orders.update', $order), [
            'customer_name' => 'Updated Name',
            'discount_amount' => 50,
            'shipping_charge' => 30,
        ])
        ->assertRedirect();

    $order->refresh();
    expect($order->customer_name)->toBe('Updated Name');
    expect((float) $order->subtotal)->toBe(200.0);
    expect((float) $order->total_amount)->toBe(180.0); // 200 - 50 + 30
});

test('order update blocks non-editable statuses', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id, ['status' => 'shipped']);

    $this->actingAs($user)
        ->patch(route('orders.update', $order), [
            'customer_name' => 'New Name',
        ])
        ->assertRedirect()
        ->assertSessionHas('error');
});

test('order status update uses service with transition validation', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id, ['status' => 'pending']);

    $this->actingAs($user)
        ->patch(route('orders.status', $order), ['status' => 'confirmed'])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($order->fresh()->status)->toBe('confirmed');
});

test('order status update rejects invalid transition', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id, ['status' => 'pending']);

    $this->actingAs($user)
        ->patch(route('orders.status', $order), ['status' => 'delivered'])
        ->assertRedirect()
        ->assertSessionHas('error');
});

test('order add payment endpoint works', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id);

    $this->actingAs($user)
        ->post(route('orders.payment', $order), [
            'method' => 'cash',
            'amount' => 200,
            'tendered' => 300,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $order->refresh();
    expect((float) $order->paid_amount)->toBe(200.0);
    expect($order->payment_status)->toBe('partial');
    expect($order->payments()->count())->toBe(1);
});

test('order edit view loads for editable order', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id, ['status' => 'pending']);

    $this->actingAs($user)
        ->get(route('orders.edit', $order))
        ->assertOk();
});

test('order edit view redirects for non-editable order', function () {
    $user = posUser();
    $order = posOrder($user->tenant_id, ['status' => 'shipped']);

    $this->actingAs($user)
        ->get(route('orders.edit', $order))
        ->assertRedirect();
});

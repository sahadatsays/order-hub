<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function searchTenant(): Tenant
{
    return Tenant::create([
        'name' => 'Search Store', 'slug' => 'search-store-' . uniqid(),
        'email' => 'search@test.com', 'currency' => 'BDT', 'timezone' => 'Asia/Dhaka',
    ]);
}

function searchUser(?Tenant $tenant = null): User
{
    $tenant ??= searchTenant();
    return User::create([
        'tenant_id' => $tenant->id, 'name' => 'Search User',
        'email' => 'search-' . uniqid() . '@test.com', 'password' => bcrypt('password'),
        'role' => 'admin',
    ]);
}

it('requires authentication for global search', function () {
    $this->getJson('/search?q=test')->assertStatus(401);
});

it('returns empty results for short queries', function () {
    $user = searchUser();

    $response = $this->actingAs($user)
        ->getJson('/search?q=a');

    $response->assertOk()
        ->assertJson(['results' => []]);
});

it('searches orders by order number', function () {
    $user = searchUser();
    $customer = Customer::create([
        'tenant_id' => $user->tenant_id, 'name' => 'Test Customer',
        'phone' => '01700000000',
    ]);
    $order = Order::create([
        'tenant_id' => $user->tenant_id, 'customer_id' => $customer->id,
        'customer_name' => $customer->name,
        'order_number' => 'ORD-SEARCH-001', 'status' => 'pending',
        'payment_status' => 'unpaid', 'source' => 'manual',
        'subtotal_amount' => 100, 'total_amount' => 100,
        'paid_amount' => 0, 'due_amount' => 100, 'ordered_at' => now(),
    ]);

    $response = $this->actingAs($user)
        ->getJson('/search?q=SEARCH-001');

    $response->assertOk();
    $results = $response->json('results');
    expect(count($results))->toBeGreaterThanOrEqual(1);
    expect($results[0]['type'])->toBe('order');
    expect($results[0]['label'])->toBe('ORD-SEARCH-001');
});

it('searches customers by name', function () {
    $user = searchUser();
    Customer::create([
        'tenant_id' => $user->tenant_id, 'name' => 'John Doe Unique',
        'phone' => '01700000001',
    ]);

    $response = $this->actingAs($user)
        ->getJson('/search?q=Unique');

    $response->assertOk();
    $results = $response->json('results');
    expect(count($results))->toBeGreaterThanOrEqual(1);
    expect($results[0]['type'])->toBe('customer');
    expect($results[0]['label'])->toBe('John Doe Unique');
});

it('searches products by name', function () {
    $user = searchUser();
    Product::create([
        'tenant_id' => $user->tenant_id, 'name' => 'Rare Widget XYZ',
        'sku' => 'WIDGET-001', 'price' => 500, 'stock' => 10,
    ]);

    $response = $this->actingAs($user)
        ->getJson('/search?q=Rare Widget');

    $response->assertOk();
    $results = $response->json('results');
    expect(count($results))->toBeGreaterThanOrEqual(1);
    expect($results[0]['type'])->toBe('product');
    expect($results[0]['label'])->toBe('Rare Widget XYZ');
});

it('isolates search results by tenant', function () {
    $tenant1 = searchTenant();
    $user1 = searchUser($tenant1);
    $tenant2 = searchTenant();
    $user2 = searchUser($tenant2);

    Customer::create([
        'tenant_id' => $tenant1->id, 'name' => 'Tenant1 Customer',
        'phone' => '01700000002',
    ]);
    Customer::create([
        'tenant_id' => $tenant2->id, 'name' => 'Tenant2 Customer',
        'phone' => '01700000003',
    ]);

    $response = $this->actingAs($user1)
        ->getJson('/search?q=Customer');

    $response->assertOk();
    $results = $response->json('results');
    $labels = array_column($results, 'label');
    expect($labels)->toContain('Tenant1 Customer');
    expect($labels)->not->toContain('Tenant2 Customer');
});

<?php

use App\Models\ApiKey;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\SettingAuditLog;
use App\Models\SettingGroup;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Webhook;
use App\Models\WebhookLog;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// ── Helper ──────────────────────────────────────────────────────────────
function createSettingsTestUser(string $role = 'owner'): User
{
    $plan = Plan::create([
        'name' => 'Growth',
        'slug' => 'growth',
        'monthly_price' => 79,
        'annual_price' => 790,
        'features' => ['orders' => 5000, 'team_members' => 10],
        'limits' => ['orders_per_month' => 5000],
        'is_active' => true,
    ]);

    $tenant = Tenant::create([
        'name' => 'Test Corp',
        'slug' => 'test-corp',
        'email' => 'admin@testcorp.com',
        'phone' => '+8801711111111',
        'timezone' => 'Asia/Dhaka',
        'currency' => 'BDT',
        'plan_id' => $plan->id,
        'status' => 'active',
        'trial_ends_at' => now()->addDays(14),
    ]);

    return User::create([
        'tenant_id' => $tenant->id,
        'name' => 'Test User',
        'email' => 'testuser@testcorp.com',
        'password' => bcrypt('password'),
        'role' => $role,
        'is_active' => true,
    ]);
}

// ── Settings Model Tests ────────────────────────────────────────────────

it('can create a setting group', function () {
    $group = SettingGroup::create([
        'key' => 'orders',
        'label' => 'Order Settings',
        'sort_order' => 1,
    ]);
    expect($group->key)->toBe('orders');
    expect($group->label)->toBe('Order Settings');
});

it('can create settings with value types', function () {
    $user = createSettingsTestUser();

    $setting = Setting::create([
        'tenant_id' => $user->tenant_id,
        'group' => 'orders',
        'key' => 'order_prefix',
        'value' => 'ORD',
        'value_type' => 'string',
    ]);
    expect($setting->typed_value)->toBe('ORD');
});

it('casts boolean settings correctly', function () {
    $user = createSettingsTestUser();

    $setting = Setting::create([
        'tenant_id' => $user->tenant_id,
        'group' => 'orders',
        'key' => 'auto_confirm',
        'value' => '1',
        'value_type' => 'boolean',
    ]);
    expect($setting->typed_value)->toBeTrue();

    $setting2 = Setting::create([
        'tenant_id' => $user->tenant_id,
        'group' => 'orders',
        'key' => 'draft_orders',
        'value' => '0',
        'value_type' => 'boolean',
    ]);
    expect($setting2->typed_value)->toBeFalse();
});

it('casts number settings correctly', function () {
    $user = createSettingsTestUser();

    $setting = Setting::create([
        'tenant_id' => $user->tenant_id,
        'group' => 'orders',
        'key' => 'padding',
        'value' => '5',
        'value_type' => 'number',
    ]);
    expect($setting->typed_value)->toBe(5.0);
});

it('casts json settings correctly', function () {
    $user = createSettingsTestUser();

    $setting = Setting::create([
        'tenant_id' => $user->tenant_id,
        'group' => 'orders',
        'key' => 'statuses',
        'value' => json_encode(['pending', 'processing']),
        'value_type' => 'json',
    ]);
    expect($setting->typed_value)->toBe(['pending', 'processing']);
});

it('prepares values for storage correctly', function () {
    expect(Setting::prepareValue(true, 'boolean'))->toBe('1');
    expect(Setting::prepareValue(false, 'boolean'))->toBe('0');
    expect(Setting::prepareValue(42, 'number'))->toBe('42');
    expect(Setting::prepareValue(['a' => 1], 'json'))->toBe('{"a":1}');
    expect(Setting::prepareValue('hello', 'string'))->toBe('hello');
});

// ── Settings Service Tests ──────────────────────────────────────────────

it('can get and set settings via service', function () {
    $user = createSettingsTestUser();
    $service = new SettingsService();

    $service->set('orders.prefix', 'ORD', 'string', $user->tenant_id);
    $value = $service->get('orders.prefix', null, $user->tenant_id);

    expect($value)->toBe('ORD');
});

it('returns default when setting not found', function () {
    $service = new SettingsService();

    $value = $service->get('orders.nonexistent', 'DEFAULT');
    expect($value)->toBe('DEFAULT');
});

it('respects tenant isolation', function () {
    $user1 = createSettingsTestUser();
    $tenant2 = Tenant::create([
        'name' => 'Other Corp',
        'slug' => 'other-corp',
        'email' => 'other@corp.com',
        'status' => 'active',
    ]);

    $service = new SettingsService();
    $service->set('orders.prefix', 'T1', 'string', $user1->tenant_id);
    $service->set('orders.prefix', 'T2', 'string', $tenant2->id);

    expect($service->get('orders.prefix', null, $user1->tenant_id))->toBe('T1');
    expect($service->get('orders.prefix', null, $tenant2->id))->toBe('T2');
});

it('can update a group of settings', function () {
    $user = createSettingsTestUser();
    $service = new SettingsService();

    $this->actingAs($user);

    $service->updateGroup('orders', [
        'prefix' => 'INV',
        'padding' => '6',
        'auto_confirm' => true,
    ], [
        'auto_confirm' => 'boolean',
    ], $user->tenant_id);

    $group = $service->getGroup('orders', $user->tenant_id);
    expect($group['prefix'])->toBe('INV');
    expect($group['padding'])->toBe('6');
    expect($group['auto_confirm'])->toBeTrue();
});

it('logs setting changes for audit', function () {
    $user = createSettingsTestUser();
    $service = new SettingsService();

    $this->actingAs($user);

    $service->set('orders.prefix', 'OLD', 'string', $user->tenant_id);
    $service->updateGroup('orders', [
        'prefix' => 'NEW',
    ], [], $user->tenant_id);

    $log = SettingAuditLog::where('key', 'prefix')
        ->where('group', 'orders')
        ->latest('id')
        ->first();

    expect($log)->not->toBeNull();
    expect($log->old_value)->toBe('OLD');
    expect($log->new_value)->toBe('NEW');
    expect($log->user_id)->toBe($user->id);
});

it('throws for invalid key format', function () {
    $service = new SettingsService();
    $service->get('invalidkey');
})->throws(\InvalidArgumentException::class);

// ── API Key Model Tests ─────────────────────────────────────────────────

it('can create api keys', function () {
    $user = createSettingsTestUser();

    $apiKey = ApiKey::create([
        'tenant_id' => $user->tenant_id,
        'user_id' => $user->id,
        'name' => 'Test Key',
        'key_prefix' => 'ohk_abc12345',
        'key_hash' => hash('sha256', 'test-key'),
        'scopes' => ['*'],
        'is_active' => true,
    ]);

    expect($apiKey->name)->toBe('Test Key');
    expect($apiKey->scopes)->toBe(['*']);
    expect($apiKey->isValid())->toBeTrue();
    expect($apiKey->isExpired())->toBeFalse();
});

it('detects expired api keys', function () {
    $user = createSettingsTestUser();

    $apiKey = ApiKey::create([
        'tenant_id' => $user->tenant_id,
        'user_id' => $user->id,
        'name' => 'Expired Key',
        'key_prefix' => 'ohk_expired1',
        'key_hash' => hash('sha256', 'expired-key'),
        'scopes' => ['*'],
        'expires_at' => now()->subDay(),
    ]);

    expect($apiKey->isExpired())->toBeTrue();
    expect($apiKey->isValid())->toBeFalse();
});

// ── Webhook Model Tests ─────────────────────────────────────────────────

it('can create webhooks', function () {
    $user = createSettingsTestUser();

    $webhook = Webhook::create([
        'tenant_id' => $user->tenant_id,
        'url' => 'https://example.com/webhook',
        'events' => ['order.created', 'order.updated'],
        'signing_secret' => 'whsec_test123',
        'is_active' => true,
    ]);

    expect($webhook->url)->toBe('https://example.com/webhook');
    expect($webhook->events)->toBe(['order.created', 'order.updated']);
    expect($webhook->is_active)->toBeTrue();
});

it('can create webhook logs', function () {
    $user = createSettingsTestUser();

    $webhook = Webhook::create([
        'tenant_id' => $user->tenant_id,
        'url' => 'https://example.com/webhook',
        'events' => ['order.created'],
        'signing_secret' => 'whsec_test',
    ]);

    $log = WebhookLog::create([
        'webhook_id' => $webhook->id,
        'event' => 'order.created',
        'payload' => ['order_id' => 1],
        'response_status' => 200,
        'status' => 'success',
        'created_at' => now(),
    ]);

    expect($log->webhook_id)->toBe($webhook->id);
    expect($log->status)->toBe('success');
    expect($log->payload)->toBe(['order_id' => 1]);
});

// ── HTTP Settings Route Tests ───────────────────────────────────────────

it('redirects guests from settings', function () {
    $this->get('/settings/profile')->assertRedirect('/login');
    $this->get('/settings/general')->assertRedirect('/login');
    $this->get('/settings/branding')->assertRedirect('/login');
    $this->get('/settings/billing')->assertRedirect('/login');
    $this->get('/settings/team')->assertRedirect('/login');
    $this->get('/settings/order-settings')->assertRedirect('/login');
    $this->get('/settings/api-keys')->assertRedirect('/login');
    $this->get('/settings/webhooks')->assertRedirect('/login');
});

it('allows authenticated users to view profile', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->get('/settings/profile')
        ->assertStatus(200)
        ->assertSee('Profile');
});

it('allows authenticated users to update profile', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->patch('/settings/profile', [
            'name' => 'Updated Name',
            'email' => $user->email,
            'phone' => '+8801722222222',
            'timezone' => 'Asia/Dhaka',
        ])
        ->assertRedirect();

    $user->refresh();
    expect($user->name)->toBe('Updated Name');
});

it('allows authenticated users to view general settings', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->get('/settings/general')
        ->assertStatus(200)
        ->assertSee('Test Corp');
});

it('allows admins to update general settings', function () {
    $user = createSettingsTestUser('owner');
    $this->actingAs($user)
        ->patch('/settings/general', [
            'name' => 'Updated Corp',
            'email' => 'updated@corp.com',
        ])
        ->assertRedirect();

    $tenant = Tenant::find($user->tenant_id);
    expect($tenant->name)->toBe('Updated Corp');
});

it('allows authenticated users to view order settings', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->get('/settings/order-settings')
        ->assertStatus(200)
        ->assertSee('Order Settings');
});

it('saves order settings to database', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->patch('/settings/order-settings', [
            'order_prefix' => 'INV',
            'order_sequence_start' => 100,
            'order_number_padding' => 6,
            'default_order_status' => 'confirmed',
        ])
        ->assertRedirect();

    $service = new SettingsService();
    $value = $service->get('orders.order_prefix', null, $user->tenant_id);
    expect($value)->toBe('INV');
});

it('allows authenticated users to view billing', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->get('/settings/billing')
        ->assertStatus(200);
});

it('allows authenticated users to view team', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->get('/settings/team')
        ->assertStatus(200)
        ->assertSee('Test User');
});

it('allows admins to invite team members', function () {
    $user = createSettingsTestUser('owner');
    $this->actingAs($user)
        ->post('/settings/team/invite', [
            'name' => 'New Member',
            'email' => 'newmember@testcorp.com',
            'role' => 'staff',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('users', [
        'email' => 'newmember@testcorp.com',
        'role' => 'staff',
        'tenant_id' => $user->tenant_id,
    ]);
});

it('prevents non-admins from inviting team members', function () {
    $owner = createSettingsTestUser('owner');
    $staff = User::create([
        'tenant_id' => $owner->tenant_id,
        'name' => 'Staff User',
        'email' => 'staff@testcorp.com',
        'password' => bcrypt('password'),
        'role' => 'staff',
        'is_active' => true,
    ]);

    $this->actingAs($staff)
        ->post('/settings/team/invite', [
            'name' => 'Another',
            'email' => 'another@testcorp.com',
            'role' => 'staff',
        ])
        ->assertStatus(403);
});

it('prevents removing owner from team', function () {
    $owner = createSettingsTestUser('owner');
    $admin = User::create([
        'tenant_id' => $owner->tenant_id,
        'name' => 'Admin User',
        'email' => 'admin2@testcorp.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'is_active' => true,
    ]);

    $this->actingAs($admin)
        ->delete("/settings/team/{$owner->id}")
        ->assertRedirect();

    $owner->refresh();
    expect($owner->is_active)->toBeTrue();
});

it('allows admins to view api keys', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->get('/settings/api-keys')
        ->assertStatus(200);
});

it('allows admins to create api keys', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->post('/settings/api-keys', [
            'name' => 'My API Key',
            'scopes' => ['orders.read', 'orders.write'],
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('api_keys', [
        'tenant_id' => $user->tenant_id,
        'name' => 'My API Key',
    ]);
});

it('allows admins to revoke api keys', function () {
    $user = createSettingsTestUser();
    $apiKey = ApiKey::create([
        'tenant_id' => $user->tenant_id,
        'user_id' => $user->id,
        'name' => 'Revokable Key',
        'key_prefix' => 'ohk_revoke12',
        'key_hash' => hash('sha256', 'revoke-test'),
        'scopes' => ['*'],
    ]);

    $this->actingAs($user)
        ->post("/settings/api-keys/{$apiKey->id}/revoke")
        ->assertRedirect();

    $apiKey->refresh();
    expect($apiKey->is_active)->toBeFalse();
});

it('allows admins to view webhooks', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->get('/settings/webhooks')
        ->assertStatus(200);
});

it('allows admins to create webhooks', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->post('/settings/webhooks', [
            'url' => 'https://example.com/hook',
            'events' => ['order.created'],
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('webhooks', [
        'tenant_id' => $user->tenant_id,
        'url' => 'https://example.com/hook',
    ]);
});

it('allows admins to toggle webhooks', function () {
    $user = createSettingsTestUser();
    $webhook = Webhook::create([
        'tenant_id' => $user->tenant_id,
        'url' => 'https://example.com/hook',
        'events' => ['order.created'],
        'signing_secret' => 'whsec_test',
    ]);

    $this->actingAs($user)
        ->post("/settings/webhooks/{$webhook->id}/toggle")
        ->assertRedirect();

    $webhook->refresh();
    expect($webhook->is_active)->toBeFalse();
});

it('allows admins to view branding settings', function () {
    $user = createSettingsTestUser();
    $this->actingAs($user)
        ->get('/settings/branding')
        ->assertStatus(200);
});

it('allows admins to update branding settings', function () {
    $user = createSettingsTestUser('owner');
    $this->actingAs($user)
        ->patch('/settings/branding', [
            'app_name' => 'My Custom App',
            'primary_color' => '#ff0000',
        ])
        ->assertRedirect();

    $service = new SettingsService();
    $value = $service->get('branding.app_name', null, $user->tenant_id);
    expect($value)->toBe('My Custom App');
});

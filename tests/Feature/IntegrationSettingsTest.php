<?php

use App\Models\Integration;
use App\Models\IntegrationLog;
use App\Models\Tenant;
use App\Models\User;
use App\Services\IntegrationConnectionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createTestTenant(): Tenant
{
    return Tenant::create([
        'name' => 'Test Store', 'slug' => 'test-store-' . uniqid(),
        'email' => 'store@test.com', 'currency' => 'BDT', 'timezone' => 'Asia/Dhaka',
    ]);
}

function createTestUser(?Tenant $tenant = null, string $role = 'owner'): User
{
    $tenant ??= createTestTenant();

    return User::create([
        'tenant_id' => $tenant->id,
        'name' => 'Test User',
        'email' => 'user-' . uniqid() . '@test.com',
        'password' => bcrypt('password'),
        'role' => $role,
        'is_active' => true,
    ]);
}

function createTestIntegration(int $tenantId, string $type = 'woocommerce', array $extra = []): Integration
{
    return Integration::create(array_merge([
        'tenant_id' => $tenantId,
        'type' => $type,
        'name' => Integration::TYPES[$type] ?? ucfirst($type),
        'is_active' => true,
        'credentials' => ['store_url' => 'https://test.com', 'consumer_key' => 'ck_test', 'consumer_secret' => 'cs_test'],
    ], $extra));
}

// -----------------------------------------------
// Integration Model enhancements
// -----------------------------------------------
describe('Integration model enhancements', function () {
    it('includes pathao in TYPES', function () {
        expect(Integration::TYPES)->toHaveKey('pathao')
            ->and(Integration::TYPES['pathao'])->toBe('Pathao');
    });

    it('has CATEGORIES with sales_channel and courier', function () {
        expect(Integration::CATEGORIES)->toHaveKey('sales_channel')
            ->and(Integration::CATEGORIES)->toHaveKey('courier')
            ->and(Integration::CATEGORIES['courier'])->toContain('pathao')
            ->and(Integration::CATEGORIES['sales_channel'])->toContain('woocommerce');
    });

    it('has CREDENTIAL_FIELDS for woocommerce', function () {
        $fields = Integration::CREDENTIAL_FIELDS['woocommerce'];
        $names = array_column($fields, 'name');
        expect($names)->toContain('store_url')
            ->and($names)->toContain('consumer_key')
            ->and($names)->toContain('consumer_secret');
    });

    it('has CREDENTIAL_FIELDS for pathao', function () {
        $fields = Integration::CREDENTIAL_FIELDS['pathao'];
        $names = array_column($fields, 'name');
        expect($names)->toContain('base_url')
            ->and($names)->toContain('client_id')
            ->and($names)->toContain('client_secret');
    });

    it('returns category attribute', function () {
        $woo = new Integration(['type' => 'woocommerce']);
        $pathao = new Integration(['type' => 'pathao']);
        expect($woo->category)->toBe('sales_channel')
            ->and($pathao->category)->toBe('courier');
    });

    it('returns credential_fields attribute', function () {
        $integration = new Integration(['type' => 'woocommerce']);
        expect($integration->credential_fields)->toBeArray()
            ->and(count($integration->credential_fields))->toBe(3);
    });

    it('returns settings_fields attribute', function () {
        $integration = new Integration(['type' => 'woocommerce']);
        expect($integration->settings_fields)->toBeArray()
            ->and(count($integration->settings_fields))->toBe(3);
    });

    it('checks if integration has credential fields', function () {
        $woo = new Integration(['type' => 'woocommerce']);
        $fb = new Integration(['type' => 'facebook']);
        expect($woo->hasCredentialFields())->toBeTrue()
            ->and($fb->hasCredentialFields())->toBeFalse();
    });

    it('checks if integration is syncable', function () {
        $woo = new Integration(['type' => 'woocommerce']);
        $pathao = new Integration(['type' => 'pathao']);
        expect($woo->isSyncable())->toBeTrue()
            ->and($pathao->isSyncable())->toBeFalse();
    });

    it('checks if integration is courier', function () {
        $pathao = new Integration(['type' => 'pathao']);
        $woo = new Integration(['type' => 'woocommerce']);
        expect($pathao->isCourier())->toBeTrue()
            ->and($woo->isCourier())->toBeFalse();
    });

    it('returns default status mapping when none is set', function () {
        $integration = new Integration(['type' => 'woocommerce']);
        expect($integration->status_mapping_or_default)->toBe(Integration::DEFAULT_STATUS_MAPPING['woocommerce']);
    });

    it('returns custom status mapping when set', function () {
        $customMapping = ['pending' => 'on_hold'];
        $integration = new Integration(['type' => 'woocommerce', 'status_mapping' => $customMapping]);
        expect($integration->status_mapping_or_default)->toBe($customMapping);
    });

    it('returns webhook endpoint', function () {
        $tenant = createTestTenant();
        $integration = createTestIntegration($tenant->id);
        expect($integration->webhook_endpoint)->toContain('/api/webhooks/woocommerce/');
    });

    it('scopes by type', function () {
        $tenant = createTestTenant();
        createTestIntegration($tenant->id, 'woocommerce');
        createTestIntegration($tenant->id, 'pathao', [
            'credentials' => ['base_url' => 'https://api.pathao.com', 'client_id' => 'x', 'client_secret' => 'y', 'username' => 'u', 'password' => 'p'],
        ]);
        expect(Integration::byType('woocommerce')->count())->toBe(1)
            ->and(Integration::byType('pathao')->count())->toBe(1);
    });
});

// -----------------------------------------------
// Integration Settings HTTP routes
// -----------------------------------------------
describe('Integration Settings HTTP', function () {
    it('shows integration settings page for admin', function () {
        $user = createTestUser(role: 'owner');
        $integration = createTestIntegration($user->tenant_id);

        $this->actingAs($user)
            ->get("/settings/integrations/{$integration->id}")
            ->assertSuccessful()
            ->assertSee('API Credentials')
            ->assertSee('WooCommerce');
    });

    it('denies access to staff users', function () {
        $tenant = createTestTenant();
        $owner = createTestUser($tenant, 'owner');
        $staff = createTestUser($tenant, 'staff');
        $integration = createTestIntegration($tenant->id);

        $this->actingAs($staff)
            ->get("/settings/integrations/{$integration->id}")
            ->assertForbidden();
    });

    it('denies access to other tenant integrations', function () {
        $user1 = createTestUser();
        $user2 = createTestUser();
        $integration = createTestIntegration($user1->tenant_id);

        $this->actingAs($user2)
            ->get("/settings/integrations/{$integration->id}")
            ->assertForbidden();
    });

    it('updates integration credentials', function () {
        $user = createTestUser(role: 'owner');
        $integration = createTestIntegration($user->tenant_id);

        $this->actingAs($user)
            ->patch("/settings/integrations/{$integration->id}", [
                'credentials' => [
                    'store_url' => 'https://updated-store.com',
                    'consumer_key' => 'ck_updated',
                    'consumer_secret' => 'cs_updated',
                ],
            ])
            ->assertRedirect();

        $integration->refresh();
        expect($integration->credentials['store_url'])->toBe('https://updated-store.com')
            ->and($integration->credentials['consumer_key'])->toBe('ck_updated');
    });

    it('preserves existing credentials when blank values submitted', function () {
        $user = createTestUser(role: 'owner');
        $integration = createTestIntegration($user->tenant_id);

        $this->actingAs($user)
            ->patch("/settings/integrations/{$integration->id}", [
                'credentials' => [
                    'store_url' => 'https://new-url.com',
                    'consumer_key' => '',
                    'consumer_secret' => '',
                ],
            ])
            ->assertRedirect();

        $integration->refresh();
        expect($integration->credentials['store_url'])->toBe('https://new-url.com')
            ->and($integration->credentials['consumer_key'])->toBe('ck_test')
            ->and($integration->credentials['consumer_secret'])->toBe('cs_test');
    });

    it('updates status mapping', function () {
        $user = createTestUser(role: 'owner');
        $integration = createTestIntegration($user->tenant_id);

        $this->actingAs($user)
            ->patch("/settings/integrations/{$integration->id}", [
                'status_mapping' => ['pending' => 'on_hold', 'processing' => 'confirmed'],
            ])
            ->assertRedirect();

        $integration->refresh();
        expect($integration->status_mapping)->toBe(['pending' => 'on_hold', 'processing' => 'confirmed']);
    });

    it('toggles integration active status', function () {
        $user = createTestUser(role: 'owner');
        $integration = createTestIntegration($user->tenant_id);
        expect($integration->is_active)->toBeTrue();

        $this->actingAs($user)
            ->post("/settings/integrations/{$integration->id}/toggle")
            ->assertRedirect();

        expect($integration->fresh()->is_active)->toBeFalse();

        $this->actingAs($user)
            ->post("/settings/integrations/{$integration->id}/toggle")
            ->assertRedirect();

        expect($integration->fresh()->is_active)->toBeTrue();
    });

    it('shows integration logs page', function () {
        $user = createTestUser(role: 'owner');
        $integration = createTestIntegration($user->tenant_id);

        IntegrationLog::create([
            'integration_id' => $integration->id,
            'tenant_id' => $user->tenant_id,
            'action' => 'manual_sync',
            'status' => 'success',
            'records_processed' => 5,
            'started_at' => now()->subMinutes(5),
            'completed_at' => now(),
        ]);

        $this->actingAs($user)
            ->get("/settings/integrations/{$integration->id}/logs")
            ->assertSuccessful()
            ->assertSee('manual_sync');
    });

    it('cannot sync inactive integration', function () {
        $user = createTestUser(role: 'owner');
        $integration = createTestIntegration($user->tenant_id, 'woocommerce', ['is_active' => false]);

        $this->actingAs($user)
            ->post("/settings/integrations/{$integration->id}/sync")
            ->assertRedirect()
            ->assertSessionHas('error', 'Cannot sync an inactive integration.');
    });

    it('regenerates webhook secret for owner', function () {
        $user = createTestUser(role: 'owner');
        $integration = createTestIntegration($user->tenant_id);

        $this->actingAs($user)
            ->post("/settings/integrations/{$integration->id}/regenerate-webhook-secret")
            ->assertRedirect();

        $integration->refresh();
        expect($integration->webhook_secret)->not->toBeNull()
            ->and(strlen($integration->webhook_secret))->toBe(40);
    });

    it('denies webhook secret regeneration for non-owner', function () {
        $tenant = createTestTenant();
        $admin = createTestUser($tenant, 'admin');
        $integration = createTestIntegration($tenant->id);

        $this->actingAs($admin)
            ->post("/settings/integrations/{$integration->id}/regenerate-webhook-secret")
            ->assertForbidden();
    });
});

// -----------------------------------------------
// Integration Connection Service
// -----------------------------------------------
describe('IntegrationConnectionService', function () {
    it('returns error for missing woocommerce credentials', function () {
        $service = app(IntegrationConnectionService::class);
        $tenant = createTestTenant();
        $integration = createTestIntegration($tenant->id, 'woocommerce', [
            'credentials' => [],
        ]);

        $result = $service->testConnection($integration);
        expect($result['success'])->toBeFalse()
            ->and($result['message'])->toContain('Missing required credentials');
    });

    it('returns error for missing pathao credentials', function () {
        $service = app(IntegrationConnectionService::class);
        $tenant = createTestTenant();
        $integration = createTestIntegration($tenant->id, 'pathao', [
            'credentials' => [],
        ]);

        $result = $service->testConnection($integration);
        expect($result['success'])->toBeFalse()
            ->and($result['message'])->toContain('Missing required credentials');
    });

    it('returns unavailable for unknown integration types', function () {
        $service = app(IntegrationConnectionService::class);
        $tenant = createTestTenant();
        $integration = createTestIntegration($tenant->id, 'facebook', [
            'credentials' => [],
        ]);

        $result = $service->testConnection($integration);
        expect($result['success'])->toBeFalse()
            ->and($result['message'])->toContain('not available');
    });

    it('generates webhook secret of correct length', function () {
        $service = app(IntegrationConnectionService::class);
        $secret = $service->generateWebhookSecret();
        expect(strlen($secret))->toBe(40);
    });

    it('creates sync log when triggering sync', function () {
        $service = app(IntegrationConnectionService::class);
        $tenant = createTestTenant();
        $integration = createTestIntegration($tenant->id);

        $result = $service->triggerSync($integration, $tenant->id);
        expect($result['success'])->toBeTrue()
            ->and(IntegrationLog::count())->toBe(1);

        $log = IntegrationLog::first();
        expect($log->action)->toBe('manual_sync')
            ->and($log->status)->toBe('success');
    });

    it('rejects sync for inactive integration', function () {
        $service = app(IntegrationConnectionService::class);
        $tenant = createTestTenant();
        $integration = createTestIntegration($tenant->id, 'woocommerce', ['is_active' => false]);

        $result = $service->triggerSync($integration, $tenant->id);
        expect($result['success'])->toBeFalse()
            ->and($result['message'])->toContain('not active');
    });
});

// -----------------------------------------------
// Integrations Index page updates
// -----------------------------------------------
describe('Integrations Index', function () {
    it('shows courier and sales channel categories', function () {
        $user = createTestUser();

        $this->actingAs($user)
            ->get('/integrations')
            ->assertSuccessful()
            ->assertSee('Sales Channels')
            ->assertSee('Courier Services')
            ->assertSee('Pathao');
    });

    it('shows settings link for connected integrations with credential fields', function () {
        $user = createTestUser();
        $integration = createTestIntegration($user->tenant_id);

        $this->actingAs($user)
            ->get('/integrations')
            ->assertSuccessful()
            ->assertSee('Settings');
    });
});

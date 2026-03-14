<?php

use App\Models\AuditLog;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\NotificationLog;
use App\Models\NotificationRule;
use App\Models\NotificationTemplate;
use App\Models\Order;
use App\Models\Tenant;
use App\Models\User;
use App\Services\Notification\NotificationEngine;
use App\Services\Notification\RecipientResolver;
use App\Services\Notification\TemplateRenderer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function makeNotifTenant(): Tenant
{
    return Tenant::create([
        'name' => 'Notif Store', 'slug' => 'notif-store-' . uniqid(),
        'email' => 'notif@test.com', 'currency' => 'BDT', 'timezone' => 'Asia/Dhaka',
    ]);
}

function makeNotifUser(?Tenant $tenant = null, string $role = 'owner'): User
{
    $tenant ??= makeNotifTenant();

    return User::create([
        'tenant_id' => $tenant->id,
        'name' => 'Notif User',
        'email' => 'notif-' . uniqid() . '@test.com',
        'password' => bcrypt('password'),
        'role' => $role,
        'is_active' => true,
    ]);
}

// -----------------------------------------------
// Dashboard Dynamic Data
// -----------------------------------------------
describe('Dashboard Dynamic Data', function () {
    it('renders dashboard with dynamic data for authenticated user', function () {
        $user = makeNotifUser();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertSuccessful()
            ->assertSee('Dashboard')
            ->assertSee('Revenue Over Time')
            ->assertSee('Order Status')
            ->assertSee('Recent Orders')
            ->assertSee('Orders by Source')
            ->assertSee('Recent Activity');
    });

    it('renders dashboard with correct stat card values', function () {
        $user = makeNotifUser();

        // Create some orders
        Order::create([
            'tenant_id' => $user->tenant_id,
            'source' => 'manual',
            'customer_name' => 'Customer A',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'currency' => 'BDT',
            'total_amount' => 1000,
            'ordered_at' => now(),
        ]);
        Order::create([
            'tenant_id' => $user->tenant_id,
            'source' => 'manual',
            'customer_name' => 'Customer B',
            'status' => 'delivered',
            'payment_status' => 'paid',
            'currency' => 'BDT',
            'total_amount' => 2000,
            'ordered_at' => now(),
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertSuccessful()
            ->assertSee('2') // total orders count
            ->assertSee('1') // pending orders count
            ->assertSee('3,000.00'); // total revenue
    });

    it('renders empty dashboard without errors when no data', function () {
        $user = makeNotifUser();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertSuccessful()
            ->assertSee('No orders yet')
            ->assertSee('No recent activity to show');
    });

    it('shows dynamic activity feed from audit logs', function () {
        $user = makeNotifUser();

        AuditLog::record(
            $user->tenant_id,
            $user->id,
            Order::class,
            1,
            'created',
            null,
            null,
            null,
            []
        );

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertSuccessful()
            ->assertSee('Order')
            ->assertSee('created');
    });

    it('shows dynamic revenue chart from real order data', function () {
        $user = makeNotifUser();

        Order::create([
            'tenant_id' => $user->tenant_id,
            'source' => 'manual',
            'customer_name' => 'Rev Customer',
            'status' => 'delivered',
            'payment_status' => 'paid',
            'currency' => 'BDT',
            'total_amount' => 5000,
            'ordered_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertSuccessful();
        // The current month abbreviation should appear
        $response->assertSee(now()->format('M'));
    });
});

// -----------------------------------------------
// Template Renderer
// -----------------------------------------------
describe('TemplateRenderer', function () {
    it('renders template with variables', function () {
        $renderer = new TemplateRenderer();
        $result = $renderer->render('Hello {{customer_name}}, order #{{order_no}} placed.', [
            'customer_name' => 'John',
            'order_no' => 'ORD-001',
        ]);

        expect($result)->toBe('Hello John, order #ORD-001 placed.');
    });

    it('replaces missing variables with empty string', function () {
        $renderer = new TemplateRenderer();
        $result = $renderer->render('Hello {{customer_name}}, tracking: {{tracking_code}}', [
            'customer_name' => 'Jane',
        ]);

        expect($result)->toBe('Hello Jane, tracking: ');
    });

    it('renders template data with subject and body', function () {
        $renderer = new TemplateRenderer();
        $result = $renderer->renderTemplate([
            'subject' => 'Order {{order_no}} confirmed',
            'body' => 'Dear {{customer_name}}, your order is confirmed.',
        ], [
            'order_no' => 'ORD-099',
            'customer_name' => 'Alice',
        ]);

        expect($result['subject'])->toBe('Order ORD-099 confirmed')
            ->and($result['body'])->toBe('Dear Alice, your order is confirmed.');
    });

    it('extracts variables from template', function () {
        $renderer = new TemplateRenderer();
        $vars = $renderer->extractVariables('Hello {{customer_name}}, order #{{order_no}}. Amount: {{total_amount}}');

        expect($vars)->toContain('customer_name')
            ->and($vars)->toContain('order_no')
            ->and($vars)->toContain('total_amount')
            ->and(count($vars))->toBe(3);
    });

    it('handles template with no variables', function () {
        $renderer = new TemplateRenderer();
        $result = $renderer->render('Plain text message with no variables.', []);

        expect($result)->toBe('Plain text message with no variables.');
    });
});

// -----------------------------------------------
// Recipient Resolver
// -----------------------------------------------
describe('RecipientResolver', function () {
    it('resolves customer recipient', function () {
        $resolver = new RecipientResolver();
        $recipients = $resolver->resolve(['customer'], [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '+8801234567890',
        ]);

        expect($recipients)->toHaveCount(1)
            ->and($recipients[0]['type'])->toBe('customer')
            ->and($recipients[0]['email'])->toBe('john@example.com')
            ->and($recipients[0]['phone'])->toBe('+8801234567890');
    });

    it('resolves admin recipients', function () {
        $tenant = makeNotifTenant();
        $owner = makeNotifUser($tenant, 'owner');
        $admin = makeNotifUser($tenant, 'admin');
        $staff = makeNotifUser($tenant, 'staff');

        $resolver = new RecipientResolver();
        $recipients = $resolver->resolve(['admins'], [
            'tenant_id' => $tenant->id,
        ]);

        $ids = array_column($recipients, 'id');
        expect($recipients)->toHaveCount(2)
            ->and($ids)->toContain($owner->id)
            ->and($ids)->toContain($admin->id)
            ->and($ids)->not->toContain($staff->id);
    });

    it('resolves owner recipient', function () {
        $tenant = makeNotifTenant();
        $owner = makeNotifUser($tenant, 'owner');
        makeNotifUser($tenant, 'admin');

        $resolver = new RecipientResolver();
        $recipients = $resolver->resolve(['owner'], [
            'tenant_id' => $tenant->id,
        ]);

        expect($recipients)->toHaveCount(1)
            ->and($recipients[0]['id'])->toBe($owner->id);
    });

    it('returns empty for customer without contact info', function () {
        $resolver = new RecipientResolver();
        $recipients = $resolver->resolve(['customer'], [
            'customer_name' => 'No Contact',
        ]);

        expect($recipients)->toBeEmpty();
    });

    it('deduplicates recipients', function () {
        $tenant = makeNotifTenant();
        $owner = makeNotifUser($tenant, 'owner');

        $resolver = new RecipientResolver();
        $recipients = $resolver->resolve(['admins', 'owner'], [
            'tenant_id' => $tenant->id,
        ]);

        // Owner appears in both admins and owner, should be deduplicated
        expect($recipients)->toHaveCount(1);
    });
});

// -----------------------------------------------
// Notification Rule model
// -----------------------------------------------
describe('NotificationRule model', function () {
    it('evaluates conditions correctly', function () {
        $rule = new NotificationRule([
            'conditions' => ['source' => 'woocommerce'],
        ]);

        expect($rule->evaluateConditions(['source' => 'woocommerce']))->toBeTrue()
            ->and($rule->evaluateConditions(['source' => 'manual']))->toBeFalse();
    });

    it('evaluates min_amount condition', function () {
        $rule = new NotificationRule([
            'conditions' => ['min_amount' => 1000],
        ]);

        expect($rule->evaluateConditions(['total_amount' => 1500]))->toBeTrue()
            ->and($rule->evaluateConditions(['total_amount' => 500]))->toBeFalse();
    });

    it('passes with empty conditions', function () {
        $rule = new NotificationRule(['conditions' => []]);
        expect($rule->evaluateConditions(['anything' => 'value']))->toBeTrue();
    });

    it('passes with null conditions', function () {
        $rule = new NotificationRule(['conditions' => null]);
        expect($rule->evaluateConditions(['anything' => 'value']))->toBeTrue();
    });
});

// -----------------------------------------------
// Notification Engine
// -----------------------------------------------
describe('NotificationEngine', function () {
    it('creates notifications from matching rules', function () {
        $tenant = makeNotifTenant();
        $owner = makeNotifUser($tenant, 'owner');

        NotificationRule::create([
            'tenant_id' => $tenant->id,
            'name' => 'Admin new order alert',
            'event' => 'order_created',
            'channels' => ['database'],
            'targets' => ['admins'],
            'is_active' => true,
        ]);

        $engine = app(NotificationEngine::class);
        $notifications = $engine->handle('order_created', [
            'tenant_id' => $tenant->id,
            'order_no' => 'ORD-001',
            'customer_name' => 'Test Customer',
        ]);

        expect($notifications)->toHaveCount(1)
            ->and($notifications[0]->event)->toBe('order_created')
            ->and($notifications[0]->channel)->toBe('database')
            ->and($notifications[0]->recipient_id)->toBe($owner->id);
    });

    it('prevents duplicate notifications via idempotency', function () {
        $tenant = makeNotifTenant();
        makeNotifUser($tenant, 'owner');

        NotificationRule::create([
            'tenant_id' => $tenant->id,
            'name' => 'Duplicate test',
            'event' => 'order_created',
            'channels' => ['database'],
            'targets' => ['owner'],
            'is_active' => true,
        ]);

        $engine = app(NotificationEngine::class);
        $context = [
            'tenant_id' => $tenant->id,
            'order_no' => 'ORD-DUP',
            'related_type' => 'Order',
            'related_id' => 1,
        ];

        $first = $engine->handle('order_created', $context);
        $second = $engine->handle('order_created', $context);

        expect($first)->toHaveCount(1)
            ->and($second)->toHaveCount(0);
    });

    it('skips inactive rules', function () {
        $tenant = makeNotifTenant();
        makeNotifUser($tenant, 'owner');

        NotificationRule::create([
            'tenant_id' => $tenant->id,
            'name' => 'Inactive rule',
            'event' => 'order_created',
            'channels' => ['database'],
            'targets' => ['owner'],
            'is_active' => false,
        ]);

        $engine = app(NotificationEngine::class);
        $result = $engine->handle('order_created', ['tenant_id' => $tenant->id]);

        expect($result)->toBeEmpty();
    });

    it('skips rules with non-matching conditions', function () {
        $tenant = makeNotifTenant();
        makeNotifUser($tenant, 'owner');

        NotificationRule::create([
            'tenant_id' => $tenant->id,
            'name' => 'WooCommerce only',
            'event' => 'order_created',
            'channels' => ['database'],
            'targets' => ['owner'],
            'conditions' => ['source' => 'woocommerce'],
            'is_active' => true,
        ]);

        $engine = app(NotificationEngine::class);
        $result = $engine->handle('order_created', [
            'tenant_id' => $tenant->id,
            'source' => 'manual',
        ]);

        expect($result)->toBeEmpty();
    });

    it('uses template for rendering when available', function () {
        $tenant = makeNotifTenant();
        makeNotifUser($tenant, 'owner');

        NotificationTemplate::create([
            'tenant_id' => $tenant->id,
            'name' => 'Order Created',
            'event' => 'order_created',
            'channel' => 'database',
            'subject' => 'New Order {{order_no}}',
            'body' => 'New order {{order_no}} from {{customer_name}}',
            'is_active' => true,
        ]);

        NotificationRule::create([
            'tenant_id' => $tenant->id,
            'name' => 'With template',
            'event' => 'order_created',
            'channels' => ['database'],
            'targets' => ['owner'],
            'is_active' => true,
        ]);

        $engine = app(NotificationEngine::class);
        $result = $engine->handle('order_created', [
            'tenant_id' => $tenant->id,
            'order_no' => 'ORD-TPL',
            'customer_name' => 'Template Customer',
        ]);

        expect($result)->toHaveCount(1)
            ->and($result[0]->subject)->toBe('New Order ORD-TPL')
            ->and($result[0]->body)->toBe('New order ORD-TPL from Template Customer');
    });

    it('returns empty when no tenant_id provided', function () {
        $engine = app(NotificationEngine::class);
        $result = $engine->handle('order_created', []);

        expect($result)->toBeEmpty();
    });
});

// -----------------------------------------------
// Notification Model
// -----------------------------------------------
describe('Notification model', function () {
    it('marks notification as sent', function () {
        $tenant = makeNotifTenant();

        $notification = Notification::create([
            'tenant_id' => $tenant->id,
            'event' => 'test_event',
            'channel' => 'database',
            'recipient_type' => 'user',
            'recipient_id' => 1,
            'body' => 'Test body',
            'status' => 'pending',
        ]);

        $notification->markAsSent();

        expect($notification->status)->toBe('sent')
            ->and($notification->sent_at)->not->toBeNull();
    });

    it('marks notification as read only once', function () {
        $tenant = makeNotifTenant();

        $notification = Notification::create([
            'tenant_id' => $tenant->id,
            'event' => 'test_event',
            'channel' => 'database',
            'recipient_type' => 'user',
            'recipient_id' => 1,
            'body' => 'Test body',
            'status' => 'sent',
        ]);

        $notification->markAsRead();
        $firstReadAt = $notification->read_at;

        // Call again - should not change
        $notification->markAsRead();

        expect($notification->read_at->toDateTimeString())->toBe($firstReadAt->toDateTimeString());
    });

    it('scopes unread notifications', function () {
        $tenant = makeNotifTenant();

        Notification::create([
            'tenant_id' => $tenant->id,
            'event' => 'ev1',
            'channel' => 'database',
            'recipient_type' => 'user',
            'recipient_id' => 1,
            'body' => 'Unread',
            'status' => 'sent',
        ]);

        Notification::create([
            'tenant_id' => $tenant->id,
            'event' => 'ev2',
            'channel' => 'database',
            'recipient_type' => 'user',
            'recipient_id' => 1,
            'body' => 'Read',
            'status' => 'read',
            'read_at' => now(),
        ]);

        expect(Notification::unread()->count())->toBe(1);
    });
});

// -----------------------------------------------
// Notification HTTP routes
// -----------------------------------------------
describe('Notification HTTP', function () {
    it('renders notifications index', function () {
        $user = makeNotifUser();

        $this->actingAs($user)
            ->get('/notifications')
            ->assertSuccessful()
            ->assertSee('Notifications');
    });

    it('renders notification rules page for admins', function () {
        $user = makeNotifUser(role: 'owner');

        $this->actingAs($user)
            ->get('/notifications/rules')
            ->assertSuccessful()
            ->assertSee('Notification Rules');
    });

    it('denies rules page to staff', function () {
        $tenant = makeNotifTenant();
        $staff = makeNotifUser($tenant, 'staff');

        $this->actingAs($staff)
            ->get('/notifications/rules')
            ->assertForbidden();
    });

    it('creates a notification rule', function () {
        $user = makeNotifUser(role: 'owner');

        $this->actingAs($user)
            ->post('/notifications/rules', [
                'name' => 'Test Rule',
                'event' => 'order_created',
                'channels' => ['database', 'email'],
                'targets' => ['admins'],
            ])
            ->assertRedirect();

        expect(NotificationRule::count())->toBe(1);
        $rule = NotificationRule::first();
        expect($rule->name)->toBe('Test Rule')
            ->and($rule->channels)->toBe(['database', 'email'])
            ->and($rule->targets)->toBe(['admins']);
    });

    it('toggles a notification rule', function () {
        $user = makeNotifUser(role: 'owner');

        $rule = NotificationRule::create([
            'tenant_id' => $user->tenant_id,
            'name' => 'Toggle Rule',
            'event' => 'order_created',
            'channels' => ['database'],
            'targets' => ['owner'],
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->post("/notifications/rules/{$rule->id}/toggle")
            ->assertRedirect();

        expect($rule->fresh()->is_active)->toBeFalse();
    });

    it('deletes a notification rule', function () {
        $user = makeNotifUser(role: 'owner');

        $rule = NotificationRule::create([
            'tenant_id' => $user->tenant_id,
            'name' => 'Delete Rule',
            'event' => 'order_created',
            'channels' => ['database'],
            'targets' => ['owner'],
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->delete("/notifications/rules/{$rule->id}")
            ->assertRedirect();

        expect(NotificationRule::count())->toBe(0);
    });

    it('renders templates page for admin', function () {
        $user = makeNotifUser(role: 'owner');

        $this->actingAs($user)
            ->get('/notifications/templates')
            ->assertSuccessful()
            ->assertSee('Notification Templates');
    });

    it('creates a notification template', function () {
        $user = makeNotifUser(role: 'owner');

        $this->actingAs($user)
            ->post('/notifications/templates', [
                'name' => 'Test Template',
                'event' => 'order_created',
                'channel' => 'email',
                'subject' => 'Order {{order_no}}',
                'body' => 'Hello {{customer_name}}',
            ])
            ->assertRedirect();

        expect(NotificationTemplate::count())->toBe(1);
    });

    it('renders notification logs page', function () {
        $user = makeNotifUser(role: 'owner');

        $this->actingAs($user)
            ->get('/notifications/logs')
            ->assertSuccessful()
            ->assertSee('Notification Delivery Logs');
    });

    it('marks notification as read', function () {
        $user = makeNotifUser(role: 'owner');

        $notification = Notification::create([
            'tenant_id' => $user->tenant_id,
            'event' => 'test',
            'channel' => 'database',
            'recipient_type' => 'user',
            'recipient_id' => $user->id,
            'body' => 'Test notification',
            'status' => 'sent',
        ]);

        $this->actingAs($user)
            ->post("/notifications/{$notification->id}/mark-read")
            ->assertRedirect();

        expect($notification->fresh()->read_at)->not->toBeNull();
    });

    it('marks all notifications as read', function () {
        $user = makeNotifUser(role: 'owner');

        Notification::create([
            'tenant_id' => $user->tenant_id,
            'event' => 'test1',
            'channel' => 'database',
            'recipient_type' => 'user',
            'recipient_id' => $user->id,
            'body' => 'Test 1',
            'status' => 'sent',
        ]);
        Notification::create([
            'tenant_id' => $user->tenant_id,
            'event' => 'test2',
            'channel' => 'database',
            'recipient_type' => 'user',
            'recipient_id' => $user->id,
            'body' => 'Test 2',
            'status' => 'sent',
        ]);

        $this->actingAs($user)
            ->post('/notifications/mark-all-read')
            ->assertRedirect();

        expect(Notification::whereNull('read_at')->count())->toBe(0);
    });

    it('retries a failed notification', function () {
        $user = makeNotifUser(role: 'owner');

        $notification = Notification::create([
            'tenant_id' => $user->tenant_id,
            'event' => 'test',
            'channel' => 'database',
            'recipient_type' => 'user',
            'recipient_id' => $user->id,
            'body' => 'Failed notification',
            'status' => 'failed',
        ]);

        $this->actingAs($user)
            ->post("/notifications/{$notification->id}/retry")
            ->assertRedirect();

        // Database channel notifications are marked as sent immediately
        expect($notification->fresh()->status)->toBe('sent');
    });

    it('rejects retry of non-failed notification', function () {
        $user = makeNotifUser(role: 'owner');

        $notification = Notification::create([
            'tenant_id' => $user->tenant_id,
            'event' => 'test',
            'channel' => 'database',
            'recipient_type' => 'user',
            'recipient_id' => $user->id,
            'body' => 'Sent notification',
            'status' => 'sent',
        ]);

        $this->actingAs($user)
            ->post("/notifications/{$notification->id}/retry")
            ->assertRedirect()
            ->assertSessionHas('error');
    });
});

// -----------------------------------------------
// NotificationLog model
// -----------------------------------------------
describe('NotificationLog model', function () {
    it('records a notification log entry', function () {
        $tenant = makeNotifTenant();

        $notification = Notification::create([
            'tenant_id' => $tenant->id,
            'event' => 'test',
            'channel' => 'email',
            'recipient_type' => 'user',
            'body' => 'Log test',
            'status' => 'pending',
        ]);

        $log = NotificationLog::record(
            $notification->id,
            $tenant->id,
            'email',
            'sent',
            'smtp',
            ['to' => 'test@example.com'],
            ['message_id' => '123'],
        );

        expect($log->status)->toBe('sent')
            ->and($log->provider)->toBe('smtp')
            ->and($log->request_payload)->toBe(['to' => 'test@example.com']);
    });
});

// -----------------------------------------------
// NotificationTemplate model
// -----------------------------------------------
describe('NotificationTemplate model', function () {
    it('has correct event constants', function () {
        expect(NotificationTemplate::EVENTS)->toHaveKey('order_created')
            ->and(NotificationTemplate::EVENTS)->toHaveKey('shipment_delivered')
            ->and(NotificationTemplate::EVENTS)->toHaveKey('integration_sync_failed');
    });

    it('has correct channel constants', function () {
        expect(NotificationTemplate::CHANNELS)->toHaveKey('database')
            ->and(NotificationTemplate::CHANNELS)->toHaveKey('email')
            ->and(NotificationTemplate::CHANNELS)->toHaveKey('sms');
    });

    it('scopes for tenant including system templates', function () {
        $tenant = makeNotifTenant();

        NotificationTemplate::create([
            'tenant_id' => null,
            'name' => 'System Template',
            'event' => 'order_created',
            'channel' => 'database',
            'body' => 'System template body',
            'is_system' => true,
        ]);

        NotificationTemplate::create([
            'tenant_id' => $tenant->id,
            'name' => 'Tenant Template',
            'event' => 'order_created',
            'channel' => 'email',
            'body' => 'Tenant template body',
        ]);

        $templates = NotificationTemplate::forTenant($tenant->id)->get();
        expect($templates)->toHaveCount(2);
    });
});

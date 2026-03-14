<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Settings\BillingController;
use App\Http\Controllers\Settings\BrandingController;
use App\Http\Controllers\Settings\CourierController;
use App\Http\Controllers\Settings\GeneralController;
use App\Http\Controllers\Settings\ApiKeyController;
use App\Http\Controllers\Settings\IntegrationController as SettingsIntegrationController;
use App\Http\Controllers\Settings\OrderSettingsController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\TeamController;
use App\Http\Controllers\Settings\WebhookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/forgot-password', [PasswordController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'email'])->name('password.email');

    Route::get('/reset-password/{token}', [PasswordController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'update'])->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Global search
    Route::get('/search', [DashboardController::class, 'search'])->name('search');

    // Orders
    Route::resource('orders', OrderController::class);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{order}/payment', [OrderController::class, 'addPayment'])->name('orders.payment');

    // POS
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/orders', [PosController::class, 'store'])->name('pos.store');
    Route::get('/pos/customers/search', [PosController::class, 'searchCustomers'])->name('pos.customers.search');
    Route::get('/pos/products/search', [PosController::class, 'searchProducts'])->name('pos.products.search');
    Route::get('/pos/barcode', [PosController::class, 'resolveBarcode'])->name('pos.barcode');

    // Customers
    Route::resource('customers', CustomerController::class);

    // Products
    Route::resource('products', ProductController::class);

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::patch('/inventory/{inventoryItem}', [InventoryController::class, 'update'])->name('inventory.update');

    // Invoices
    Route::resource('invoices', InvoiceController::class)->only(['index', 'show']);
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Integrations
    Route::get('/integrations', [IntegrationController::class, 'index'])->name('integrations.index');
    Route::post('/integrations/{type}/connect', [IntegrationController::class, 'connect'])->name('integrations.connect');
    Route::delete('/integrations/{integration}', [IntegrationController::class, 'disconnect'])->name('integrations.disconnect');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/rules', [NotificationController::class, 'rules'])->name('notifications.rules');
    Route::post('/notifications/rules', [NotificationController::class, 'storeRule'])->name('notifications.rules.store');
    Route::post('/notifications/rules/{rule}/toggle', [NotificationController::class, 'toggleRule'])->name('notifications.rules.toggle');
    Route::delete('/notifications/rules/{rule}', [NotificationController::class, 'destroyRule'])->name('notifications.rules.destroy');
    Route::get('/notifications/templates', [NotificationController::class, 'templates'])->name('notifications.templates');
    Route::post('/notifications/templates', [NotificationController::class, 'storeTemplate'])->name('notifications.templates.store');
    Route::delete('/notifications/templates/{template}', [NotificationController::class, 'destroyTemplate'])->name('notifications.templates.destroy');
    Route::get('/notifications/logs', [NotificationController::class, 'logs'])->name('notifications.logs');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/{notification}/retry', [NotificationController::class, 'retry'])->name('notifications.retry');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::redirect('/', '/settings/profile')->name('index');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::get('/general', [GeneralController::class, 'index'])->name('general');
        Route::patch('/general', [GeneralController::class, 'update'])->name('general.update');
        Route::get('/branding', [BrandingController::class, 'index'])->name('branding');
        Route::patch('/branding', [BrandingController::class, 'update'])->name('branding.update');
        Route::get('/team', [TeamController::class, 'index'])->name('team');
        Route::post('/team/invite', [TeamController::class, 'invite'])->name('team.invite');
        Route::delete('/team/{user}', [TeamController::class, 'remove'])->name('team.remove');
        Route::get('/billing', [BillingController::class, 'index'])->name('billing');
        Route::get('/order-settings', [OrderSettingsController::class, 'index'])->name('order-settings');
        Route::patch('/order-settings', [OrderSettingsController::class, 'update'])->name('order-settings.update');
        Route::get('/couriers', [CourierController::class, 'index'])->name('couriers');
        Route::post('/couriers', [CourierController::class, 'store'])->name('couriers.store');
        Route::patch('/couriers/{courier}', [CourierController::class, 'update'])->name('couriers.update');
        Route::delete('/couriers/{courier}', [CourierController::class, 'destroy'])->name('couriers.destroy');
        Route::get('/api-keys', [ApiKeyController::class, 'index'])->name('api-keys');
        Route::post('/api-keys', [ApiKeyController::class, 'store'])->name('api-keys.store');
        Route::post('/api-keys/{apiKey}/revoke', [ApiKeyController::class, 'revoke'])->name('api-keys.revoke');
        Route::delete('/api-keys/{apiKey}', [ApiKeyController::class, 'destroy'])->name('api-keys.destroy');
        Route::get('/webhooks', [WebhookController::class, 'index'])->name('webhooks');
        Route::post('/webhooks', [WebhookController::class, 'store'])->name('webhooks.store');
        Route::post('/webhooks/{webhook}/toggle', [WebhookController::class, 'toggle'])->name('webhooks.toggle');
        Route::delete('/webhooks/{webhook}', [WebhookController::class, 'destroy'])->name('webhooks.destroy');
        Route::get('/webhooks/{webhook}/logs', [WebhookController::class, 'logs'])->name('webhooks.logs');

        // Integration settings
        Route::get('/integrations/{integration}', [SettingsIntegrationController::class, 'show'])->name('integrations.show');
        Route::patch('/integrations/{integration}', [SettingsIntegrationController::class, 'update'])->name('integrations.update');
        Route::post('/integrations/{integration}/toggle', [SettingsIntegrationController::class, 'toggle'])->name('integrations.toggle');
        Route::post('/integrations/{integration}/test-connection', [SettingsIntegrationController::class, 'testConnection'])->name('integrations.test-connection');
        Route::post('/integrations/{integration}/sync', [SettingsIntegrationController::class, 'sync'])->name('integrations.sync');
        Route::get('/integrations/{integration}/logs', [SettingsIntegrationController::class, 'logs'])->name('integrations.logs');
        Route::post('/integrations/{integration}/regenerate-webhook-secret', [SettingsIntegrationController::class, 'regenerateWebhookSecret'])->name('integrations.regenerate-webhook-secret');
    });

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');
});

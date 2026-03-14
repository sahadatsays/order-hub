<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Settings\BillingController;
use App\Http\Controllers\Settings\CourierController;
use App\Http\Controllers\Settings\OrderSettingsController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\TeamController;
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

    // Orders
    Route::resource('orders', OrderController::class);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

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

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::redirect('/', '/settings/profile')->name('index');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
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
    });

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');
});

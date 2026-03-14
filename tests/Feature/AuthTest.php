<?php

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// -----------------------------------------------
// Registration
// -----------------------------------------------
describe('Registration', function () {
    it('renders the registration page', function () {
        $this->get('/register')->assertSuccessful();
    });

    it('registers a new user and creates a tenant', function () {
        $this->post('/register', [
            'name' => 'Jane Smith',
            'email' => 'jane@company.com',
            'password' => 'SecureP@ss1',
            'company_name' => 'Jane Corp',
            'company_size' => '1-10',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();

        expect(Tenant::where('slug', 'jane-corp')->exists())->toBeTrue()
            ->and(User::where('email', 'jane@company.com')->exists())->toBeTrue();

        $user = User::where('email', 'jane@company.com')->first();
        expect($user->role)->toBe('owner')
            ->and($user->is_active)->toBeTrue()
            ->and($user->tenant)->not->toBeNull()
            ->and($user->tenant->name)->toBe('Jane Corp')
            ->and($user->tenant->trial_ends_at)->not->toBeNull();
    });

    it('generates a unique slug when company name conflicts', function () {
        Tenant::create([
            'name' => 'Acme Corp',
            'slug' => 'acme-corp',
            'email' => 'existing@acme.com',
        ]);

        $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@acme.com',
            'password' => 'SecureP@ss1',
            'company_name' => 'Acme Corp',
            'company_size' => '11-50',
        ])->assertRedirect(route('dashboard'));

        expect(Tenant::count())->toBe(2);

        $newTenant = Tenant::where('email', 'john@acme.com')->first();
        expect($newTenant->slug)->not->toBe('acme-corp')
            ->and($newTenant->slug)->toStartWith('acme-corp-');
    });

    it('requires all fields', function () {
        $this->post('/register', [])->assertSessionHasErrors([
            'name', 'email', 'password', 'company_name', 'company_size',
        ]);
    });

    it('rejects duplicate email', function () {
        User::create([
            'name' => 'Existing',
            'email' => 'taken@test.com',
            'password' => 'password',
        ]);

        $this->post('/register', [
            'name' => 'New User',
            'email' => 'taken@test.com',
            'password' => 'SecureP@ss1',
            'company_name' => 'Test Co',
            'company_size' => '1-10',
        ])->assertSessionHasErrors(['email']);
    });

    it('rejects passwords shorter than 8 characters', function () {
        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'short',
            'company_name' => 'Test Co',
            'company_size' => '1-10',
        ])->assertSessionHasErrors(['password']);
    });

    it('rejects invalid company size', function () {
        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'SecureP@ss1',
            'company_name' => 'Test Co',
            'company_size' => 'invalid',
        ])->assertSessionHasErrors(['company_size']);
    });

    it('redirects authenticated users away from register page', function () {
        $tenant = Tenant::create([
            'name' => 'Test Store', 'slug' => 'test-store',
            'email' => 'store@test.com',
        ]);
        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Owner',
            'email' => 'owner@test.com',
            'password' => 'password',
            'role' => 'owner',
            'is_active' => true,
        ]);

        $this->actingAs($user)->get('/register')->assertRedirect();
    });
});

// -----------------------------------------------
// Login
// -----------------------------------------------
describe('Login', function () {
    it('renders the login page', function () {
        $this->get('/login')->assertSuccessful();
    });

    it('authenticates with valid credentials', function () {
        $tenant = Tenant::create([
            'name' => 'Test Store', 'slug' => 'login-test',
            'email' => 'store@test.com',
        ]);
        User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Owner',
            'email' => 'login@test.com',
            'password' => 'password',
            'role' => 'owner',
            'is_active' => true,
        ]);

        $this->post('/login', [
            'email' => 'login@test.com',
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
    });

    it('rejects invalid credentials', function () {
        $this->post('/login', [
            'email' => 'nobody@test.com',
            'password' => 'wrongpassword',
        ])->assertSessionHasErrors(['email']);

        $this->assertGuest();
    });

    it('requires email and password', function () {
        $this->post('/login', [])->assertSessionHasErrors(['email', 'password']);
    });

    it('redirects authenticated users away from login page', function () {
        $tenant = Tenant::create([
            'name' => 'Test Store', 'slug' => 'auth-redirect',
            'email' => 'store@test.com',
        ]);
        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Owner',
            'email' => 'authed@test.com',
            'password' => 'password',
            'role' => 'owner',
            'is_active' => true,
        ]);

        $this->actingAs($user)->get('/login')->assertRedirect();
    });
});

// -----------------------------------------------
// Logout
// -----------------------------------------------
describe('Logout', function () {
    it('logs out an authenticated user', function () {
        $tenant = Tenant::create([
            'name' => 'Test Store', 'slug' => 'logout-test',
            'email' => 'store@test.com',
        ]);
        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Owner',
            'email' => 'logout@test.com',
            'password' => 'password',
            'role' => 'owner',
            'is_active' => true,
        ]);

        $this->actingAs($user)->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    });
});

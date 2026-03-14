<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_size' => ['required', 'string', 'in:1-10,11-50,51-200,200+'],
        ]);

        $slug = Str::slug($validated['company_name']);
        while (Tenant::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['company_name']).'-'.Str::random(5);
        }

        $tenant = Tenant::create([
            'name' => $validated['company_name'],
            'slug' => $slug,
            'email' => $validated['email'],
            'status' => 'active',
            'trial_ends_at' => now()->addDays(14),
            'settings' => ['company_size' => $validated['company_size']],
        ]);

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'owner',
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}

<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GeneralController extends Controller
{
    public function __construct(protected SettingsService $settings) {}

    public function index(): View
    {
        $tenant = Tenant::find($this->tenantId());

        return view('settings.general', compact('tenant'));
    }

    public function update(Request $request): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'url', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:2'],
            'timezone' => ['nullable', 'string', 'max:50'],
            'currency' => ['nullable', 'string', 'max:3'],
        ]);

        $tenant = Tenant::find($this->tenantId());
        $tenant->update($validated);

        return back()->with('success', 'Organization settings updated successfully.');
    }
}

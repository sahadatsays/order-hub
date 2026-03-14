<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandingController extends Controller
{
    public function __construct(protected SettingsService $settings) {}

    public function index(): View
    {
        $brandingSettings = $this->settings->getGroup('branding', $this->tenantId());

        $defaults = [
            'app_name' => config('app.name'),
            'short_name' => '',
            'primary_color' => '#4f46e5',
            'secondary_color' => '#0ea5e9',
            'logo' => '',
            'favicon' => '',
            'invoice_logo' => '',
        ];

        $brandingSettings = array_merge($defaults, $brandingSettings);

        return view('settings.branding', compact('brandingSettings'));
    }

    public function update(Request $request): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:100'],
            'short_name' => ['nullable', 'string', 'max:20'],
            'primary_color' => ['nullable', 'string', 'max:7'],
            'secondary_color' => ['nullable', 'string', 'max:7'],
        ]);

        $this->settings->updateGroup('branding', $validated, [], $this->tenantId());

        return back()->with('success', 'Branding settings updated successfully.');
    }
}

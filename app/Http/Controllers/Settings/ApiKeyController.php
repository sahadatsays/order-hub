<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ApiKeyController extends Controller
{
    public function index(): View
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $apiKeys = ApiKey::where('tenant_id', $this->tenantId())
            ->with('user')
            ->latest()
            ->get();

        return view('settings.api-keys', compact('apiKeys'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'scopes' => ['nullable', 'array'],
            'scopes.*' => ['string'],
            'expires_at' => ['nullable', 'date', 'after:today'],
        ]);

        $plainKey = 'ohk_' . Str::random(40);
        $prefix = substr($plainKey, 0, 12);

        $apiKey = ApiKey::create([
            'tenant_id' => $this->tenantId(),
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'key_prefix' => $prefix,
            'key_hash' => hash('sha256', $plainKey),
            'scopes' => $validated['scopes'] ?? ['*'],
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        return back()->with('success', 'API key created. Copy it now — it will not be shown again.')
            ->with('new_api_key', $plainKey);
    }

    public function revoke(ApiKey $apiKey): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($apiKey->tenant_id !== $this->tenantId()) {
            abort(403);
        }

        $apiKey->update(['is_active' => false]);

        return back()->with('success', 'API key revoked successfully.');
    }

    public function destroy(ApiKey $apiKey): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($apiKey->tenant_id !== $this->tenantId()) {
            abort(403);
        }

        $apiKey->delete();

        return back()->with('success', 'API key deleted successfully.');
    }
}

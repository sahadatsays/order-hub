<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Webhook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WebhookController extends Controller
{
    public function index(): View
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $webhooks = Webhook::where('tenant_id', $this->tenantId())
            ->withCount('logs')
            ->latest()
            ->get();

        return view('settings.webhooks', compact('webhooks'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'url' => ['required', 'url', 'max:500'],
            'events' => ['required', 'array', 'min:1'],
            'events.*' => ['string', 'in:' . implode(',', Webhook::SUPPORTED_EVENTS)],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Webhook::create([
            'tenant_id' => $this->tenantId(),
            'url' => $validated['url'],
            'events' => $validated['events'],
            'signing_secret' => 'whsec_' . Str::random(32),
            'description' => $validated['description'] ?? null,
        ]);

        return back()->with('success', 'Webhook endpoint created successfully.');
    }

    public function toggle(Webhook $webhook): RedirectResponse
    {
        if (!auth()->user()->isAdmin() || $webhook->tenant_id !== $this->tenantId()) {
            abort(403);
        }

        $webhook->update(['is_active' => !$webhook->is_active]);

        return back()->with('success', $webhook->is_active ? 'Webhook activated.' : 'Webhook deactivated.');
    }

    public function destroy(Webhook $webhook): RedirectResponse
    {
        if (!auth()->user()->isAdmin() || $webhook->tenant_id !== $this->tenantId()) {
            abort(403);
        }

        $webhook->delete();

        return back()->with('success', 'Webhook deleted successfully.');
    }

    public function logs(Webhook $webhook): View
    {
        if (!auth()->user()->isAdmin() || $webhook->tenant_id !== $this->tenantId()) {
            abort(403);
        }

        $logs = $webhook->logs()->latest('created_at')->paginate(25);

        return view('settings.webhook-logs', compact('webhook', 'logs'));
    }
}

<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Integration;
use App\Models\IntegrationLog;
use App\Models\Order;
use App\Services\IntegrationConnectionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IntegrationController extends Controller
{
    public function __construct(
        private IntegrationConnectionService $connectionService,
    ) {}

    public function show(Integration $integration): View
    {
        abort_unless($integration->tenant_id === $this->tenantId(), 403);
        abort_unless(auth()->user()->isAdmin(), 403);

        $logs = $integration->logs()->take(20)->get();
        $lastSuccess = $integration->getLastSuccessfulLog();
        $lastFailed = $integration->getLastFailedLog();
        $internalStatuses = Order::STATUSES;

        return view('settings.integrations.show', compact(
            'integration',
            'logs',
            'lastSuccess',
            'lastFailed',
            'internalStatuses',
        ));
    }

    public function update(Request $request, Integration $integration)
    {
        abort_unless($integration->tenant_id === $this->tenantId(), 403);
        abort_unless(auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'name'           => 'nullable|string|max:255',
            'credentials'    => 'nullable|array',
            'settings'       => 'nullable|array',
            'status_mapping' => 'nullable|array',
        ]);

        // Filter out empty credential values to avoid overwriting with blanks
        if (isset($validated['credentials'])) {
            $existing = $integration->credentials ?? [];
            foreach ($validated['credentials'] as $key => $value) {
                if ($value === null || $value === '') {
                    $validated['credentials'][$key] = $existing[$key] ?? '';
                }
            }
        }

        $integration->update(array_filter($validated, fn ($v) => $v !== null));

        return redirect()->route('settings.integrations.show', $integration)
            ->with('success', 'Integration settings updated.');
    }

    public function toggle(Integration $integration)
    {
        abort_unless($integration->tenant_id === $this->tenantId(), 403);
        abort_unless(auth()->user()->isAdmin(), 403);

        $integration->update(['is_active' => !$integration->is_active]);

        $status = $integration->is_active ? 'enabled' : 'disabled';

        return redirect()->route('settings.integrations.show', $integration)
            ->with('success', "Integration {$status}.");
    }

    public function testConnection(Integration $integration)
    {
        abort_unless($integration->tenant_id === $this->tenantId(), 403);
        abort_unless(auth()->user()->isAdmin(), 403);

        $result = $this->connectionService->testConnection($integration);

        $flashType = $result['success'] ? 'success' : 'error';

        return redirect()->route('settings.integrations.show', $integration)
            ->with($flashType, $result['message']);
    }

    public function sync(Integration $integration)
    {
        abort_unless($integration->tenant_id === $this->tenantId(), 403);
        abort_unless(auth()->user()->isAdmin(), 403);

        if (!$integration->is_active) {
            return redirect()->route('settings.integrations.show', $integration)
                ->with('error', 'Cannot sync an inactive integration.');
        }

        $result = $this->connectionService->triggerSync($integration, $this->tenantId());

        $flashType = $result['success'] ? 'success' : 'error';

        return redirect()->route('settings.integrations.show', $integration)
            ->with($flashType, $result['message']);
    }

    public function logs(Integration $integration)
    {
        abort_unless($integration->tenant_id === $this->tenantId(), 403);
        abort_unless(auth()->user()->isAdmin(), 403);

        $logs = IntegrationLog::where('integration_id', $integration->id)
            ->orderByDesc('created_at')
            ->paginate(25);

        return view('settings.integrations.logs', compact('integration', 'logs'));
    }

    public function regenerateWebhookSecret(Integration $integration)
    {
        abort_unless($integration->tenant_id === $this->tenantId(), 403);
        abort_unless(auth()->user()->isOwner(), 403);

        $integration->update([
            'webhook_secret' => $this->connectionService->generateWebhookSecret(),
        ]);

        return redirect()->route('settings.integrations.show', $integration)
            ->with('success', 'Webhook secret regenerated.');
    }
}

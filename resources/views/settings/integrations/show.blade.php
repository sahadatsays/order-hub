<x-layouts.app :title="$integration->type_label . ' Settings'">
<div class="max-w-4xl mx-auto">

    {{-- Page Header --}}
    <x-app.page-header :title="$integration->type_label . ' Integration'">
        <x-slot:description>
            Manage configuration, credentials, and sync settings for your {{ $integration->type_label }} integration.
        </x-slot:description>
        <x-slot:actions>
            <div class="flex items-center gap-3">
                {{-- Enable/Disable Toggle --}}
                <form action="{{ route('settings.integrations.toggle', $integration) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    <span class="text-sm text-zinc-600">{{ $integration->is_active ? 'Active' : 'Inactive' }}</span>
                    <button type="submit" role="switch" aria-checked="{{ $integration->is_active ? 'true' : 'false' }}" class="relative inline-flex shrink-0 cursor-pointer rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-10 h-6 {{ $integration->is_active ? 'bg-indigo-600' : 'bg-zinc-300' }}">
                        <span class="pointer-events-none inline-block w-4 h-4 rounded-full bg-white shadow-sm transition-transform {{ $integration->is_active ? 'translate-x-4' : 'translate-x-0.5' }}" style="margin-top: 4px;" aria-hidden="true"></span>
                    </button>
                </form>

                <a href="{{ route('integrations.index') }}" class="px-3 py-1.5 text-sm border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 font-medium rounded-md transition-colors">
                    ← Back
                </a>
            </div>
        </x-slot:actions>
    </x-app.page-header>

    {{-- Flash Messages --}}
    @if(session('success'))
    <x-ui.alert type="success" class="mb-4" dismissible>{{ session('success') }}</x-ui.alert>
    @endif
    @if(session('error'))
    <x-ui.alert type="error" class="mb-4" dismissible>{{ session('error') }}</x-ui.alert>
    @endif

    {{-- Status Overview --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <x-ui.card>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ $integration->is_active ? 'bg-green-50' : 'bg-zinc-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="{{ $integration->is_active ? '#16a34a' : '#71717a' }}" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                </div>
                <div>
                    <p class="text-xs text-zinc-500">Status</p>
                    <p class="text-sm font-semibold {{ $integration->is_active ? 'text-green-700' : 'text-zinc-500' }}">
                        {{ $integration->is_active ? 'Connected' : 'Disconnected' }}
                    </p>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
                </div>
                <div>
                    <p class="text-xs text-zinc-500">Last Synced</p>
                    <p class="text-sm font-semibold text-zinc-900">
                        {{ $integration->last_synced_at ? $integration->last_synced_at->diffForHumans() : 'Never' }}
                    </p>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center gap-3">
                @php
                    $syncColor = match($integration->sync_status) {
                        'syncing' => 'bg-yellow-50',
                        'error' => 'bg-red-50',
                        default => 'bg-zinc-50',
                    };
                    $syncStroke = match($integration->sync_status) {
                        'syncing' => '#ca8a04',
                        'error' => '#dc2626',
                        default => '#71717a',
                    };
                    $syncLabel = match($integration->sync_status) {
                        'syncing' => 'Syncing...',
                        'error' => 'Error',
                        'idle' => 'Idle',
                        default => 'Not Started',
                    };
                @endphp
                <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ $syncColor }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="{{ $syncStroke }}" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
                </div>
                <div>
                    <p class="text-xs text-zinc-500">Sync Status</p>
                    <p class="text-sm font-semibold text-zinc-900">{{ $syncLabel }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-wrap gap-2 mb-6">
        @if($integration->hasCredentialFields())
        <form action="{{ route('settings.integrations.test-connection', $integration) }}" method="POST">
            @csrf
            <x-ui.button type="submit" variant="secondary" size="sm">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                </x-slot:icon>
                Test Connection
            </x-ui.button>
        </form>
        @endif

        @if($integration->isSyncable())
        <form action="{{ route('settings.integrations.sync', $integration) }}" method="POST">
            @csrf
            <x-ui.button type="submit" variant="secondary" size="sm" :disabled="!$integration->is_active">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
                </x-slot:icon>
                Sync Now
            </x-ui.button>
        </form>
        @endif

        <a href="{{ route('settings.integrations.logs', $integration) }}">
            <x-ui.button variant="ghost" size="sm">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
                </x-slot:icon>
                View All Logs
            </x-ui.button>
        </a>
    </div>

    {{-- Tabs --}}
    <x-ui.tabs variant="line">
        <x-slot:triggers>
            <x-ui.tab-trigger tab="configuration" :active="true">Configuration</x-ui.tab-trigger>
            @if(!empty(\App\Models\Integration::DEFAULT_STATUS_MAPPING[$integration->type] ?? []))
            <x-ui.tab-trigger tab="status-mapping">Status Mapping</x-ui.tab-trigger>
            @endif
            <x-ui.tab-trigger tab="logs">Recent Logs</x-ui.tab-trigger>
            @if($integration->hasCredentialFields())
            <x-ui.tab-trigger tab="webhooks">Webhooks</x-ui.tab-trigger>
            @endif
        </x-slot:triggers>

        {{-- Configuration Tab --}}
        <x-ui.tab-panel tab="configuration" :active="true">
            <form action="{{ route('settings.integrations.update', $integration) }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- Credentials Section --}}
                @if($integration->hasCredentialFields())
                <x-ui.card class="mb-6">
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-zinc-900">API Credentials</h3>
                        <p class="text-xs text-zinc-500 mt-0.5">Enter your {{ $integration->type_label }} API credentials. Secrets are encrypted at rest.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($integration->credential_fields as $field)
                        @php
                            $currentValue = ($integration->credentials[$field['name']] ?? '');
                            $isMasked = in_array($field['type'], ['password']);
                            $displayValue = $isMasked && $currentValue ? '' : $currentValue;
                        @endphp
                        <div class="{{ $field['type'] === 'url' ? 'sm:col-span-2' : '' }}">
                            <x-ui.input
                                :name="'credentials[' . $field['name'] . ']'"
                                :label="$field['label']"
                                :type="$field['type'] === 'password' ? 'password' : ($field['type'] === 'url' ? 'url' : 'text')"
                                :value="$displayValue"
                                :placeholder="$isMasked && $currentValue ? '••••••••  (leave blank to keep current)' : $field['placeholder']"
                                :required="$field['required'] && !$currentValue"
                            />
                        </div>
                        @endforeach
                    </div>
                </x-ui.card>
                @endif

                {{-- Settings Section --}}
                @if(!empty($integration->settings_fields))
                <x-ui.card class="mb-6">
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-zinc-900">Settings</h3>
                        <p class="text-xs text-zinc-500 mt-0.5">Configure behavior for this integration.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($integration->settings_fields as $field)
                        @php $currentVal = $integration->settings[$field['name']] ?? $field['default']; @endphp

                        @if($field['type'] === 'toggle')
                        <div class="sm:col-span-2" data-toggle-wrapper>
                            <x-ui.toggle
                                :name="'settings[' . $field['name'] . ']'"
                                :label="$field['label']"
                                :checked="(bool) $currentVal"
                            />
                        </div>
                        @elseif($field['type'] === 'number')
                        <div>
                            <x-ui.input
                                :name="'settings[' . $field['name'] . ']'"
                                :label="$field['label']"
                                type="number"
                                :value="$currentVal"
                                min="1"
                            />
                        </div>
                        @else
                        <div>
                            <x-ui.input
                                :name="'settings[' . $field['name'] . ']'"
                                :label="$field['label']"
                                type="text"
                                :value="$currentVal"
                            />
                        </div>
                        @endif
                        @endforeach
                    </div>
                </x-ui.card>
                @endif

                {{-- Save Button --}}
                <div class="flex justify-end">
                    <x-ui.button type="submit" variant="primary">Save Configuration</x-ui.button>
                </div>
            </form>
        </x-ui.tab-panel>

        {{-- Status Mapping Tab --}}
        @if(!empty(\App\Models\Integration::DEFAULT_STATUS_MAPPING[$integration->type] ?? []))
        <x-ui.tab-panel tab="status-mapping">
            <form action="{{ route('settings.integrations.update', $integration) }}" method="POST">
                @csrf
                @method('PATCH')

                <x-ui.card class="mb-6">
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-zinc-900">Status Mapping</h3>
                        <p class="text-xs text-zinc-500 mt-0.5">Map {{ $integration->type_label }} statuses to your internal order statuses.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-zinc-200">
                                    <th class="text-left py-2 px-3 font-medium text-zinc-600">{{ $integration->type_label }} Status</th>
                                    <th class="text-left py-2 px-3 font-medium text-zinc-600">Internal Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($integration->status_mapping_or_default as $externalStatus => $internalStatus)
                                <tr class="border-b border-zinc-100">
                                    <td class="py-2 px-3">
                                        <span class="text-sm font-mono text-zinc-700">{{ $externalStatus }}</span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <select name="status_mapping[{{ $externalStatus }}]" class="w-full border border-zinc-300 rounded-md px-3 py-1.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            @foreach($internalStatuses as $key => $label)
                                            <option value="{{ $key }}" {{ $internalStatus === $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-ui.card>

                <div class="flex justify-end">
                    <x-ui.button type="submit" variant="primary">Save Status Mapping</x-ui.button>
                </div>
            </form>
        </x-ui.tab-panel>
        @endif

        {{-- Logs Tab --}}
        <x-ui.tab-panel tab="logs">
            <x-ui.card>
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-zinc-900">Sync Logs</h3>
                        <p class="text-xs text-zinc-500 mt-0.5">Recent sync activity for this integration.</p>
                    </div>
                    <a href="{{ route('settings.integrations.logs', $integration) }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">View All →</a>
                </div>

                @if($logs->isEmpty())
                <x-ui.empty-state title="No sync logs yet" description="Run a sync to see activity here.">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                    </x-slot:icon>
                </x-ui.empty-state>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200">
                                <th class="text-left py-2 px-3 font-medium text-zinc-600">Action</th>
                                <th class="text-left py-2 px-3 font-medium text-zinc-600">Status</th>
                                <th class="text-left py-2 px-3 font-medium text-zinc-600">Records</th>
                                <th class="text-left py-2 px-3 font-medium text-zinc-600">Started</th>
                                <th class="text-left py-2 px-3 font-medium text-zinc-600">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr class="border-b border-zinc-100 hover:bg-zinc-50">
                                <td class="py-2 px-3 font-mono text-xs">{{ $log->action }}</td>
                                <td class="py-2 px-3">
                                    @php
                                        $logColor = match($log->status) {
                                            'success' => 'green',
                                            'failed' => 'red',
                                            'started' => 'yellow',
                                            default => 'zinc',
                                        };
                                    @endphp
                                    <x-ui.badge :color="$logColor">{{ ucfirst($log->status) }}</x-ui.badge>
                                </td>
                                <td class="py-2 px-3 text-zinc-600">
                                    {{ $log->records_processed }} processed
                                    @if($log->records_failed > 0)
                                    <span class="text-red-600">/ {{ $log->records_failed }} failed</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-zinc-500 text-xs">
                                    {{ $log->started_at?->format('M d, H:i') ?? '-' }}
                                </td>
                                <td class="py-2 px-3 text-zinc-500 text-xs">
                                    @if($log->started_at && $log->completed_at)
                                    {{ $log->started_at->diffForHumans($log->completed_at, true) }}
                                    @elseif($log->status === 'started')
                                    <span class="text-yellow-600">In progress...</span>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            @if($log->error_message)
                            <tr class="bg-red-50">
                                <td colspan="5" class="py-2 px-3 text-xs text-red-700">
                                    <strong>Error:</strong> {{ $log->error_message }}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </x-ui.card>

            {{-- Last Sync Results --}}
            @if($lastSuccess || $lastFailed)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                @if($lastSuccess)
                <x-ui.card>
                    <h4 class="text-xs font-semibold text-green-700 uppercase tracking-wider mb-2">Last Successful Sync</h4>
                    <p class="text-sm text-zinc-700">{{ $lastSuccess->records_processed }} records processed</p>
                    <p class="text-xs text-zinc-500 mt-1">{{ $lastSuccess->completed_at?->format('M d, Y H:i') }}</p>
                </x-ui.card>
                @endif
                @if($lastFailed)
                <x-ui.card>
                    <h4 class="text-xs font-semibold text-red-700 uppercase tracking-wider mb-2">Last Failed Sync</h4>
                    <p class="text-sm text-red-700">{{ Str::limit($lastFailed->error_message, 100) }}</p>
                    <p class="text-xs text-zinc-500 mt-1">{{ $lastFailed->completed_at?->format('M d, Y H:i') }}</p>
                </x-ui.card>
                @endif
            </div>
            @endif
        </x-ui.tab-panel>

        {{-- Webhooks Tab --}}
        @if($integration->hasCredentialFields())
        <x-ui.tab-panel tab="webhooks">
            <x-ui.card class="mb-6">
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900">Webhook Configuration</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">Use this endpoint to receive real-time updates from {{ $integration->type_label }}.</p>
                </div>

                <div class="space-y-4">
                    {{-- Webhook URL --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1">Webhook URL</label>
                        <div class="flex gap-2">
                            <input
                                type="text"
                                readonly
                                value="{{ $integration->webhook_endpoint }}"
                                class="flex-1 px-3 py-2 text-sm bg-zinc-50 border border-zinc-300 rounded-md font-mono text-zinc-700"
                                id="webhook-url"
                            />
                            <button
                                type="button"
                                onclick="navigator.clipboard.writeText(document.getElementById('webhook-url').value).then(() => { this.textContent = 'Copied!'; setTimeout(() => { this.textContent = 'Copy'; }, 2000); })"
                                class="px-3 py-2 text-sm border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 font-medium rounded-md transition-colors"
                            >
                                Copy
                            </button>
                        </div>
                        <p class="text-xs text-zinc-500 mt-1">Configure this URL in your {{ $integration->type_label }} webhook settings.</p>
                    </div>

                    {{-- Webhook Secret --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1">Webhook Secret</label>
                        <div class="flex gap-2">
                            <input
                                type="text"
                                readonly
                                value="{{ $integration->webhook_secret ?: 'Not generated yet' }}"
                                class="flex-1 px-3 py-2 text-sm bg-zinc-50 border border-zinc-300 rounded-md font-mono text-zinc-700"
                                id="webhook-secret"
                            />
                            @if($integration->webhook_secret)
                            <button
                                type="button"
                                onclick="navigator.clipboard.writeText(document.getElementById('webhook-secret').value).then(() => { this.textContent = 'Copied!'; setTimeout(() => { this.textContent = 'Copy'; }, 2000); })"
                                class="px-3 py-2 text-sm border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 font-medium rounded-md transition-colors"
                            >
                                Copy
                            </button>
                            @endif
                        </div>
                    </div>

                    {{-- Regenerate Secret --}}
                    @if(auth()->user()->isOwner())
                    <form action="{{ route('settings.integrations.regenerate-webhook-secret', $integration) }}" method="POST">
                        @csrf
                        <x-ui.button type="submit" variant="destructive" size="sm"
                            onclick="return confirm('Are you sure? This will invalidate the current webhook secret.')">
                            Regenerate Secret
                        </x-ui.button>
                    </form>
                    @endif

                    {{-- Webhook Events Info --}}
                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                        <h4 class="text-sm font-medium text-blue-800 mb-1">Supported Events</h4>
                        <ul class="text-xs text-blue-700 space-y-0.5">
                            @if($integration->type === 'woocommerce')
                            <li>• <code>order.created</code> — New order received</li>
                            <li>• <code>order.updated</code> — Order status changed</li>
                            <li>• <code>order.deleted</code> — Order removed</li>
                            @elseif($integration->type === 'pathao')
                            <li>• <code>order.status_update</code> — Shipment status changed</li>
                            <li>• <code>order.delivered</code> — Order delivered</li>
                            <li>• <code>order.returned</code> — Order returned</li>
                            @elseif($integration->type === 'shopify')
                            <li>• <code>orders/create</code> — New order received</li>
                            <li>• <code>orders/updated</code> — Order modified</li>
                            <li>• <code>orders/cancelled</code> — Order cancelled</li>
                            @else
                            <li>• Contact support for webhook event details.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </x-ui.card>
        </x-ui.tab-panel>
        @endif
    </x-ui.tabs>

</div>
</x-layouts.app>

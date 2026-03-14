<x-layouts.app :title="$integration->type_label . ' Logs'">
<div class="max-w-4xl mx-auto">

    <x-app.page-header :title="$integration->type_label . ' — Sync Logs'">
        <x-slot:description>
            Complete log history for your {{ $integration->type_label }} integration.
        </x-slot:description>
        <x-slot:actions>
            <a href="{{ route('settings.integrations.show', $integration) }}" class="px-3 py-1.5 text-sm border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 font-medium rounded-md transition-colors">
                ← Back to Settings
            </a>
        </x-slot:actions>
    </x-app.page-header>

    <x-ui.card>
        @if($logs->isEmpty())
        <x-ui.empty-state>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
            </x-slot:icon>
            No sync logs found for this integration.
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
                        <th class="text-left py-2 px-3 font-medium text-zinc-600">Completed</th>
                        <th class="text-left py-2 px-3 font-medium text-zinc-600">Error</th>
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
                            {{ $log->records_processed }} / {{ $log->records_failed }} failed
                        </td>
                        <td class="py-2 px-3 text-zinc-500 text-xs">
                            {{ $log->started_at?->format('M d, Y H:i:s') ?? '-' }}
                        </td>
                        <td class="py-2 px-3 text-zinc-500 text-xs">
                            {{ $log->completed_at?->format('M d, Y H:i:s') ?? '-' }}
                        </td>
                        <td class="py-2 px-3 text-xs text-red-600 max-w-xs truncate">
                            {{ $log->error_message ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
        @endif
    </x-ui.card>

</div>
</x-layouts.app>

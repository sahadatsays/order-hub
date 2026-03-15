<x-layouts.app title="Notification Logs">

    <x-app.page-header
        title="Notification Delivery Logs"
        description="Track all notification delivery attempts and results."
        backHref="{{ route('notifications.index') }}"
        backLabel="Back to Notifications"
    />

    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
        @if($logs->isEmpty())
        <x-ui.empty-state
            title="No delivery logs"
            description="Logs will appear here when notifications are sent."
        />
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-zinc-50 border-b border-zinc-100">
                        <th class="px-4 sm:px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Notification</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Channel</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden sm:table-cell">Provider</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden md:table-cell">Attempt</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden lg:table-cell">Error</th>
                        <th class="px-4 sm:px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @foreach($logs as $log)
                    <tr class="hover:bg-zinc-50 transition-colors">
                        <td class="px-4 sm:px-5 py-3.5">
                            @if($log->notification)
                            <a href="{{ route('notifications.show', $log->notification) }}" class="text-xs text-indigo-600 hover:underline font-mono">#{{ $log->notification_id }}</a>
                            @else
                            <span class="text-xs text-zinc-400">#{{ $log->notification_id }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5">
                            @php
                                $channelColor = match($log->channel) {
                                    'database' => 'indigo',
                                    'email'    => 'blue',
                                    'sms'      => 'green',
                                    default    => 'zinc',
                                };
                            @endphp
                            <x-ui.badge :color="$channelColor">{{ ucfirst($log->channel) }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-3.5 text-sm text-zinc-600 hidden sm:table-cell">{{ $log->provider ?? '-' }}</td>
                        <td class="px-4 py-3.5">
                            @php
                                $logColor = match($log->status) {
                                    'sent', 'delivered' => 'green',
                                    'failed' => 'red',
                                    'attempted' => 'yellow',
                                    default => 'zinc',
                                };
                            @endphp
                            <x-ui.badge :color="$logColor">{{ ucfirst($log->status) }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-3.5 text-sm text-zinc-600 hidden md:table-cell">#{{ $log->attempt_number }}</td>
                        <td class="px-4 py-3.5 text-xs text-red-600 hidden lg:table-cell max-w-[200px] truncate">{{ $log->error_message ?? '-' }}</td>
                        <td class="px-4 sm:px-5 py-3.5 text-xs text-zinc-400">{{ $log->attempted_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-zinc-100">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</x-layouts.app>

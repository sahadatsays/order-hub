<x-layouts.app title="Notification Details">

    <x-app.page-header
        title="Notification Details"
        backHref="{{ route('notifications.index') }}"
        backLabel="Back to Notifications"
    />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Main Content --}}
        <div class="lg:col-span-2">
            <x-ui.card>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900">{{ $notification->subject ?? 'Notification' }}</h3>
                    <p class="text-xs text-zinc-400 mt-1">{{ $notification->created_at->format('M d, Y H:i:s') }}</p>
                </div>

                <div class="prose prose-sm prose-zinc max-w-none">
                    {!! nl2br(e($notification->body)) !!}
                </div>
            </x-ui.card>

            {{-- Delivery Logs --}}
            @if($logs->isNotEmpty())
            <div class="mt-4 bg-white border border-zinc-200 rounded-xl overflow-hidden">
                <div class="px-4 sm:px-6 py-4 border-b border-zinc-100">
                    <h3 class="text-sm font-semibold text-zinc-900">Delivery Logs</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-zinc-50 border-b border-zinc-100">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Attempt</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Provider</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden sm:table-cell">Error</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50">
                            @foreach($logs as $log)
                            <tr>
                                <td class="px-4 py-3 text-sm text-zinc-700">#{{ $log->attempt_number }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-700">{{ $log->provider ?? '-' }}</td>
                                <td class="px-4 py-3">
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
                                <td class="px-4 py-3 text-xs text-red-600 hidden sm:table-cell max-w-[200px] truncate">{{ $log->error_message ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs text-zinc-400">{{ $log->attempted_at->format('H:i:s') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            <x-ui.card>
                <h4 class="text-xs font-semibold text-zinc-500 uppercase tracking-wide mb-3">Details</h4>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-zinc-400">Event</dt>
                        <dd class="text-sm font-medium text-zinc-900">{{ \App\Models\NotificationTemplate::EVENTS[$notification->event] ?? $notification->event }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-zinc-400">Channel</dt>
                        <dd class="text-sm text-zinc-700">{{ ucfirst($notification->channel) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-zinc-400">Status</dt>
                        <dd><x-ui.badge :color="$notification->status_color">{{ $notification->status_label }}</x-ui.badge></dd>
                    </div>
                    <div>
                        <dt class="text-xs text-zinc-400">Recipient</dt>
                        <dd class="text-sm text-zinc-700">{{ $notification->recipient_contact ?? ucfirst($notification->recipient_type) }}</dd>
                    </div>
                    @if($notification->related_type)
                    <div>
                        <dt class="text-xs text-zinc-400">Related</dt>
                        <dd class="text-sm text-zinc-700">{{ class_basename($notification->related_type) }} #{{ $notification->related_id }}</dd>
                    </div>
                    @endif
                    @if($notification->sent_at)
                    <div>
                        <dt class="text-xs text-zinc-400">Sent At</dt>
                        <dd class="text-sm text-zinc-700">{{ $notification->sent_at->format('M d, Y H:i') }}</dd>
                    </div>
                    @endif
                    @if($notification->read_at)
                    <div>
                        <dt class="text-xs text-zinc-400">Read At</dt>
                        <dd class="text-sm text-zinc-700">{{ $notification->read_at->format('M d, Y H:i') }}</dd>
                    </div>
                    @endif
                </dl>
            </x-ui.card>

            @if($notification->status === 'failed')
            <x-ui.card>
                <form method="POST" action="{{ route('notifications.retry', $notification) }}">
                    @csrf
                    <x-ui.button type="submit" variant="primary" size="sm" class="w-full justify-center">
                        Retry Send
                    </x-ui.button>
                </form>
            </x-ui.card>
            @endif
        </div>

    </div>

</x-layouts.app>

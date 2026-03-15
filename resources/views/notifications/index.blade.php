<x-layouts.app title="Notifications">

    <x-app.page-header
        title="Notifications"
        description="View and manage your notifications."
    >
        <x-slot:actions>
            @if($unreadCount > 0)
            <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                @csrf
                <x-ui.button type="submit" variant="secondary" size="sm">
                    Mark All Read ({{ $unreadCount }})
                </x-ui.button>
            </form>
            @endif
        </x-slot:actions>
    </x-app.page-header>

    {{-- Filters --}}
    <div class="mb-4 flex flex-wrap gap-2">
        <a href="{{ route('notifications.index') }}"
           class="px-3 py-1.5 text-xs font-medium rounded-md {{ !request('channel') && !request('status') ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-zinc-50 text-zinc-600 border border-zinc-200 hover:bg-zinc-100' }} transition-colors">
            All
        </a>
        @foreach(['database' => 'In-App', 'email' => 'Email', 'sms' => 'SMS'] as $ch => $label)
        <a href="{{ route('notifications.index', ['channel' => $ch]) }}"
           class="px-3 py-1.5 text-xs font-medium rounded-md {{ request('channel') === $ch ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-zinc-50 text-zinc-600 border border-zinc-200 hover:bg-zinc-100' }} transition-colors">
            {{ $label }}
        </a>
        @endforeach
        <span class="w-px bg-zinc-200 mx-1"></span>
        @foreach(['pending' => 'Pending', 'sent' => 'Sent', 'failed' => 'Failed'] as $st => $label)
        <a href="{{ route('notifications.index', ['status' => $st]) }}"
           class="px-3 py-1.5 text-xs font-medium rounded-md {{ request('status') === $st ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-zinc-50 text-zinc-600 border border-zinc-200 hover:bg-zinc-100' }} transition-colors">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
        @if($notifications->isEmpty())
        <x-ui.empty-state
            title="No notifications"
            description="When notifications are generated, they will appear here."
        />
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-zinc-50 border-b border-zinc-100">
                        <th class="px-4 sm:px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Event</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden sm:table-cell">Channel</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden md:table-cell">Recipient</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden lg:table-cell">Date</th>
                        <th class="px-4 sm:px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @foreach($notifications as $n)
                    <tr class="hover:bg-zinc-50 transition-colors {{ !$n->read_at && $n->channel === 'database' ? 'bg-indigo-50/30' : '' }}">
                        <td class="px-4 sm:px-5 py-3.5">
                            <span class="text-sm font-medium text-zinc-900">{{ \App\Models\NotificationTemplate::EVENTS[$n->event] ?? $n->event }}</span>
                            @if($n->subject)
                            <p class="text-xs text-zinc-500 mt-0.5 truncate max-w-[200px]">{{ $n->subject }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 hidden sm:table-cell">
                            @php
                                $channelColor = match($n->channel) {
                                    'database' => 'indigo',
                                    'email'    => 'blue',
                                    'sms'      => 'green',
                                    default    => 'zinc',
                                };
                            @endphp
                            <x-ui.badge :color="$channelColor">{{ ucfirst($n->channel) }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-3.5 hidden md:table-cell text-sm text-zinc-600">
                            {{ $n->recipient_contact ?? ucfirst($n->recipient_type) . ($n->recipient_id ? " #{$n->recipient_id}" : '') }}
                        </td>
                        <td class="px-4 py-3.5">
                            <x-ui.badge :color="$n->status_color">{{ $n->status_label }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-3.5 text-xs text-zinc-400 hidden lg:table-cell">{{ $n->created_at->diffForHumans() }}</td>
                        <td class="px-4 sm:px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                @if($n->status === 'failed')
                                <form method="POST" action="{{ route('notifications.retry', $n) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Retry</button>
                                </form>
                                @endif
                                @if(!$n->read_at && $n->channel === 'database')
                                <form method="POST" action="{{ route('notifications.mark-read', $n) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-zinc-500 hover:text-zinc-700">Mark Read</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-zinc-100">
            {{ $notifications->withQueryString()->links() }}
        </div>
        @endif
    </div>

</x-layouts.app>

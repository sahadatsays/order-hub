<x-layouts.app title="Notification Rules">

    <x-app.page-header
        title="Notification Rules"
        description="Configure when and how notifications are sent."
        backHref="{{ route('notifications.index') }}"
        backLabel="Back to Notifications"
    />

    {{-- Create Rule Form --}}
    <div class="bg-white border border-zinc-200 rounded-xl p-4 sm:p-6 mb-4">
        <h3 class="text-sm font-semibold text-zinc-900 mb-4">Create New Rule</h3>
        <form method="POST" action="{{ route('notifications.rules.store') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Rule Name</label>
                    <x-ui.input name="name" placeholder="e.g. Notify admin on new order" required />
                </div>
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Event</label>
                    <x-ui.select name="event" required>
                        <option value="">Select event...</option>
                        @foreach($events as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </x-ui.select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Delay (seconds)</label>
                    <x-ui.input name="delay_seconds" type="number" value="0" min="0" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-2">Channels</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach(['database' => 'In-App', 'email' => 'Email', 'sms' => 'SMS'] as $ch => $label)
                        <label class="flex items-center gap-1.5 text-sm text-zinc-700">
                            <x-ui.checkbox name="channels[]" value="{{ $ch }}" />
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-2">Recipients</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach(\App\Models\NotificationRule::TARGETS as $key => $label)
                        <label class="flex items-center gap-1.5 text-sm text-zinc-700">
                            <x-ui.checkbox name="targets[]" value="{{ $key }}" />
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <x-ui.button type="submit" variant="primary" size="sm">Create Rule</x-ui.button>
        </form>
    </div>

    {{-- Rules List --}}
    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
        @if($rules->isEmpty())
        <x-ui.empty-state
            title="No notification rules"
            description="Create your first rule to start receiving notifications."
        />
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-zinc-50 border-b border-zinc-100">
                        <th class="px-4 sm:px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden sm:table-cell">Event</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden md:table-cell">Channels</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden lg:table-cell">Targets</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Status</th>
                        <th class="px-4 sm:px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @foreach($rules as $rule)
                    <tr class="hover:bg-zinc-50 transition-colors">
                        <td class="px-4 sm:px-5 py-3.5 text-sm font-medium text-zinc-900">{{ $rule->name }}</td>
                        <td class="px-4 py-3.5 text-sm text-zinc-600 hidden sm:table-cell">{{ $events[$rule->event] ?? $rule->event }}</td>
                        <td class="px-4 py-3.5 hidden md:table-cell">
                            <div class="flex flex-wrap gap-1">
                                @foreach($rule->channels as $ch)
                                <x-ui.badge color="zinc">{{ ucfirst($ch) }}</x-ui.badge>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3.5 hidden lg:table-cell">
                            <div class="flex flex-wrap gap-1">
                                @foreach($rule->targets as $t)
                                <x-ui.badge color="indigo">{{ \App\Models\NotificationRule::TARGETS[$t] ?? $t }}</x-ui.badge>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3.5">
                            <x-ui.badge :color="$rule->is_active ? 'green' : 'zinc'">{{ $rule->is_active ? 'Active' : 'Inactive' }}</x-ui.badge>
                        </td>
                        <td class="px-4 sm:px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('notifications.rules.toggle', $rule) }}">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium {{ $rule->is_active ? 'text-yellow-600 hover:text-yellow-800' : 'text-green-600 hover:text-green-800' }}">
                                        {{ $rule->is_active ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('notifications.rules.destroy', $rule) }}" onsubmit="return confirm('Delete this rule?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-zinc-100">
            {{ $rules->links() }}
        </div>
        @endif
    </div>

</x-layouts.app>

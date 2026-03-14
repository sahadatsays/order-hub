<x-layouts.app title="Notification Templates">

    <x-app.page-header
        title="Notification Templates"
        description="Manage templates used for notifications."
        backHref="{{ route('notifications.index') }}"
        backLabel="Back to Notifications"
    />

    {{-- Create Template Form --}}
    <div class="bg-white border border-zinc-200 rounded-xl p-4 sm:p-6 mb-4">
        <h3 class="text-sm font-semibold text-zinc-900 mb-4">Create New Template</h3>

        <div class="mb-4 p-3 bg-zinc-50 border border-zinc-200 rounded-lg">
            <p class="text-xs font-medium text-zinc-600 mb-1">Available Variables</p>
            <div class="flex flex-wrap gap-1.5">
                @foreach(\App\Models\NotificationTemplate::VARIABLES as $var)
                <code class="text-xs bg-white border border-zinc-200 px-1.5 py-0.5 rounded text-indigo-600">@{{ '{{' . $var . '}}' }}</code>
                @endforeach
            </div>
        </div>

        <form method="POST" action="{{ route('notifications.templates.store') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Template Name</label>
                    <x-ui.input name="name" placeholder="e.g. Order Created - Email" required />
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
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Channel</label>
                    <x-ui.select name="channel" required>
                        <option value="">Select channel...</option>
                        @foreach($channels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </x-ui.select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Subject (for email)</label>
                    <x-ui.input name="subject" :placeholder="'e.g. Your order {{order_no}} has been placed'" />
                </div>
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Body</label>
                    <x-ui.textarea name="body" rows="4" :placeholder="'Hi {{customer_name}}, your order #{{order_no}} has been received.'" required />
                </div>
            </div>

            <x-ui.button type="submit" variant="primary" size="sm">Create Template</x-ui.button>
        </form>
    </div>

    {{-- Templates List --}}
    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
        @if($templates->isEmpty())
        <x-ui.empty-state
            title="No templates"
            description="Create templates to customize how your notifications look."
        />
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-zinc-50 border-b border-zinc-100">
                        <th class="px-4 sm:px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden sm:table-cell">Event</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Channel</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden md:table-cell">Type</th>
                        <th class="px-4 sm:px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @foreach($templates as $tpl)
                    <tr class="hover:bg-zinc-50 transition-colors">
                        <td class="px-4 sm:px-5 py-3.5 text-sm font-medium text-zinc-900">{{ $tpl->name }}</td>
                        <td class="px-4 py-3.5 text-sm text-zinc-600 hidden sm:table-cell">{{ $events[$tpl->event] ?? $tpl->event }}</td>
                        <td class="px-4 py-3.5">
                            @php
                                $channelColor = match($tpl->channel) {
                                    'database' => 'indigo',
                                    'email'    => 'blue',
                                    'sms'      => 'green',
                                    default    => 'zinc',
                                };
                            @endphp
                            <x-ui.badge :color="$channelColor">{{ $channels[$tpl->channel] ?? ucfirst($tpl->channel) }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-3.5 hidden md:table-cell">
                            <x-ui.badge :color="$tpl->is_system ? 'purple' : 'zinc'">{{ $tpl->is_system ? 'System' : 'Custom' }}</x-ui.badge>
                        </td>
                        <td class="px-4 sm:px-5 py-3.5">
                            @unless($tpl->is_system)
                            <form method="POST" action="{{ route('notifications.templates.destroy', $tpl) }}" onsubmit="return confirm('Delete this template?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Delete</button>
                            </form>
                            @else
                            <span class="text-xs text-zinc-400">System default</span>
                            @endunless
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-zinc-100">
            {{ $templates->links() }}
        </div>
        @endif
    </div>

</x-layouts.app>

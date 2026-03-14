<x-layouts.app title="Settings — Webhooks">
<div class="max-w-5xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Settings</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account and organisation settings.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- LEFT: Settings sidebar nav --}}
        <x-settings.sidebar />

        {{-- RIGHT: Main content --}}
        <div class="flex-1 min-w-0 space-y-6">

            @if(session('success'))
                <div class="px-4 py-3 bg-green-50 border border-green-200 rounded-md text-sm text-green-800">{{ session('success') }}</div>
            @endif

            {{-- Existing Webhooks --}}
            <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-zinc-100">
                    <h2 class="text-sm font-semibold text-zinc-900">Webhooks</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Receive real-time notifications when events happen in your account.</p>
                </div>

                @forelse($webhooks as $webhook)
                    <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-50 last:border-0">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-medium text-zinc-900 truncate">{{ $webhook->url }}</p>
                                @if($webhook->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-200">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-50 text-zinc-500 ring-1 ring-zinc-200">Inactive</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-xs text-zinc-500">{{ count($webhook->events ?? []) }} event(s)</span>
                                @if($webhook->description)
                                    <span class="text-xs text-zinc-400">{{ $webhook->description }}</span>
                                @endif
                                <span class="text-xs text-zinc-400">{{ $webhook->logs_count ?? $webhook->logs()->count() }} log(s)</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0 ml-4">
                            {{-- Toggle active/inactive --}}
                            <form method="POST" action="{{ route('settings.webhooks.toggle', $webhook) }}">
                                @csrf
                                <button type="submit" class="text-xs font-medium {{ $webhook->is_active ? 'text-zinc-500 hover:text-zinc-700' : 'text-indigo-600 hover:text-indigo-800' }}">
                                    {{ $webhook->is_active ? 'Disable' : 'Enable' }}
                                </button>
                            </form>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('settings.webhooks.destroy', $webhook) }}" onsubmit="return confirm('Are you sure you want to delete this webhook?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-sm text-zinc-500">No webhooks configured yet.</div>
                @endforelse
            </div>

            {{-- Add New Webhook --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Add Webhook</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Configure a new webhook endpoint to receive event notifications.</p>
                </div>

                <form method="POST" action="{{ route('settings.webhooks.store') }}" class="space-y-4">
                    @csrf

                    <x-ui.input label="Endpoint URL" name="url" type="url" :value="old('url')" placeholder="https://example.com/webhook" required :error="$errors->first('url')" />

                    <x-ui.input label="Description" name="description" :value="old('description')" placeholder="Optional description for this webhook" :error="$errors->first('description')" />

                    {{-- Events --}}
                    <div>
                        <label class="text-sm font-medium text-zinc-700">Events</label>
                        <p class="text-xs text-zinc-500 mb-2">Select which events should trigger this webhook.</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach(\App\Models\Webhook::SUPPORTED_EVENTS as $event)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="events[]" value="{{ $event }}" @checked(in_array($event, old('events', []))) class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-zinc-700">{{ $event }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('events')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                            Add Webhook
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</x-layouts.app>

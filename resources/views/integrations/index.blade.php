<x-layouts.app title="Integrations">
<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Integrations</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Connect your sales channels and courier services to sync orders automatically.</p>
    </div>

    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-md text-sm text-green-800">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-md text-sm text-red-800">{{ session('error') }}</div>
    @endif

    {{-- Sales Channels --}}
    <div class="mb-6">
        <h2 class="text-sm font-medium text-zinc-500 uppercase tracking-wider mb-3">Sales Channels</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach(\App\Models\Integration::CATEGORIES['sales_channel'] as $type)
            @php
                $label = \App\Models\Integration::TYPES[$type];
                $integration = $integrations->get($type);
                $connected = $integration && $integration->is_active;
            @endphp
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-zinc-50 border border-zinc-100">
                        @include('integrations.partials.type-icon', ['type' => $type])
                    </div>
                    @if($connected)
                        <x-ui.badge color="green">Connected</x-ui.badge>
                    @else
                        <x-ui.badge color="zinc">Not Connected</x-ui.badge>
                    @endif
                </div>

                <h3 class="font-semibold text-zinc-900 mb-1">{{ $label }}</h3>

                <p class="text-xs text-zinc-500 mb-4">
                    @include('integrations.partials.type-description', ['type' => $type])
                </p>

                @if($connected && $integration->last_synced_at)
                <p class="text-xs text-zinc-400 mb-3">Last synced: {{ $integration->last_synced_at->diffForHumans() }}</p>
                @endif

                <div class="flex gap-2">
                    @if($connected)
                        @if($integration->hasCredentialFields())
                        <a href="{{ route('settings.integrations.show', $integration) }}" class="flex-1 px-4 py-2 text-sm text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">Settings</a>
                        @endif
                        <form action="{{ route('integrations.disconnect', $integration) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 text-sm border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 font-medium rounded-md transition-colors">Disconnect</button>
                        </form>
                    @else
                        <form action="{{ route('integrations.connect', $type) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">Connect</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Courier Integrations --}}
    <div>
        <h2 class="text-sm font-medium text-zinc-500 uppercase tracking-wider mb-3">Courier Services</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach(\App\Models\Integration::CATEGORIES['courier'] as $type)
            @php
                $label = \App\Models\Integration::TYPES[$type];
                $integration = $integrations->get($type);
                $connected = $integration && $integration->is_active;
            @endphp
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-zinc-50 border border-zinc-100">
                        @include('integrations.partials.type-icon', ['type' => $type])
                    </div>
                    @if($connected)
                        <x-ui.badge color="green">Connected</x-ui.badge>
                    @else
                        <x-ui.badge color="zinc">Not Connected</x-ui.badge>
                    @endif
                </div>

                <h3 class="font-semibold text-zinc-900 mb-1">{{ $label }}</h3>

                <p class="text-xs text-zinc-500 mb-4">
                    @include('integrations.partials.type-description', ['type' => $type])
                </p>

                @if($connected && $integration->last_synced_at)
                <p class="text-xs text-zinc-400 mb-3">Last synced: {{ $integration->last_synced_at->diffForHumans() }}</p>
                @endif

                <div class="flex gap-2">
                    @if($connected)
                        @if($integration->hasCredentialFields())
                        <a href="{{ route('settings.integrations.show', $integration) }}" class="flex-1 px-4 py-2 text-sm text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">Settings</a>
                        @endif
                        <form action="{{ route('integrations.disconnect', $integration) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 text-sm border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 font-medium rounded-md transition-colors">Disconnect</button>
                        </form>
                    @else
                        <form action="{{ route('integrations.connect', $type) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">Connect</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</x-layouts.app>

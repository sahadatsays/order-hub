<x-layouts.app title="Settings — API Keys">
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

            {{-- Newly created key (shown once) --}}
            @if(session('new_api_key'))
                <div class="px-4 py-3 bg-indigo-50 border border-indigo-200 rounded-md">
                    <p class="text-sm font-medium text-indigo-800 mb-1">Your new API key has been created. Copy it now — it won't be shown again.</p>
                    <code class="block bg-white border border-indigo-200 rounded px-3 py-2 text-sm text-zinc-800 font-mono select-all break-all">{{ session('new_api_key') }}</code>
                </div>
            @endif

            {{-- Existing API Keys --}}
            <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-zinc-100">
                    <h2 class="text-sm font-semibold text-zinc-900">API Keys</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Manage your API keys for external integrations.</p>
                </div>

                @forelse($apiKeys as $key)
                    <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-50 last:border-0">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-zinc-900">{{ $key->name }}</p>
                            <div class="flex items-center gap-3 mt-0.5">
                                <code class="text-xs text-zinc-500 font-mono">{{ $key->prefix ?? ($key->key ? Str::mask($key->key, '*', 4) : '••••') }}••••••••</code>
                                <span class="text-xs text-zinc-400">Created {{ $key->created_at->format('M d, Y') }}</span>
                                @if($key->last_used_at)
                                    <span class="text-xs text-zinc-400">Last used {{ $key->last_used_at->diffForHumans() }}</span>
                                @else
                                    <span class="text-xs text-zinc-400">Never used</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            @if($key->is_active ?? true)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-200">Active</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-50 text-zinc-500 ring-1 ring-zinc-200">Revoked</span>
                            @endif

                            @if($key->is_active ?? true)
                                <form method="POST" action="{{ route('settings.api-keys.revoke', $key) }}" onsubmit="return confirm('Are you sure you want to revoke this API key?')">
                                    @csrf
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Revoke</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-sm text-zinc-500">No API keys created yet.</div>
                @endforelse
            </div>

            {{-- Create New API Key --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Create New API Key</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Generate a new key for API access.</p>
                </div>

                <form method="POST" action="{{ route('settings.api-keys.store') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ui.input label="Key Name" name="name" :value="old('name')" placeholder="e.g. Production API" required :error="$errors->first('name')" />
                        <x-ui.input label="Expiry Date" name="expires_at" type="date" :value="old('expires_at')" helper="Leave blank for no expiry." :error="$errors->first('expires_at')" />
                    </div>

                    {{-- Scopes --}}
                    <div>
                        <label class="text-sm font-medium text-zinc-700">Scopes</label>
                        <p class="text-xs text-zinc-500 mb-2">Select what this key can access.</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach(['orders:read', 'orders:write', 'products:read', 'products:write', 'customers:read', 'customers:write', 'webhooks:manage', 'settings:read'] as $scope)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="scopes[]" value="{{ $scope }}" @checked(in_array($scope, old('scopes', []))) class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-zinc-700">{{ $scope }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('scopes')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                            Create API Key
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</x-layouts.app>

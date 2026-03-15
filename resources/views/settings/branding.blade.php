<x-layouts.app title="Settings — Branding">
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

            {{-- Branding Settings --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Branding</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Customize the look and feel of your application.</p>
                </div>

                <form method="POST" action="{{ route('settings.branding.update') }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ui.input label="App Name" name="app_name" :value="old('app_name', $brandingSettings['app_name'] ?? '')" :error="$errors->first('app_name')" />
                        <x-ui.input label="Short Name" name="short_name" :value="old('short_name', $brandingSettings['short_name'] ?? '')" helper="Used in compact UI areas and browser tabs." :error="$errors->first('short_name')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="primary_color" class="text-sm font-medium text-zinc-700">Primary Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', $brandingSettings['primary_color'] ?? '#4f46e5') }}" class="h-10 w-14 rounded border border-zinc-300 cursor-pointer p-0.5" oninput="document.getElementById('primary_color_text').value = this.value">
                                <input type="text" id="primary_color_text" value="{{ old('primary_color', $brandingSettings['primary_color'] ?? '#4f46e5') }}" class="border border-zinc-300 rounded-md px-3 py-2 text-sm text-zinc-800 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" oninput="document.getElementById('primary_color').value = this.value" onchange="document.getElementById('primary_color').value = this.value">
                            </div>
                            @error('primary_color')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="secondary_color" class="text-sm font-medium text-zinc-700">Secondary Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', $brandingSettings['secondary_color'] ?? '#6366f1') }}" class="h-10 w-14 rounded border border-zinc-300 cursor-pointer p-0.5" oninput="document.getElementById('secondary_color_text').value = this.value">
                                <input type="text" id="secondary_color_text" value="{{ old('secondary_color', $brandingSettings['secondary_color'] ?? '#6366f1') }}" class="border border-zinc-300 rounded-md px-3 py-2 text-sm text-zinc-800 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" oninput="document.getElementById('secondary_color').value = this.value" onchange="document.getElementById('secondary_color').value = this.value">
                            </div>
                            @error('secondary_color')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</x-layouts.app>

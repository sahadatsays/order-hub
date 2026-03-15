<x-layouts.app title="Settings — General">
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

            {{-- Organization Details --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Organization Details</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Update your company information and preferences.</p>
                </div>

                <form method="POST" action="{{ route('settings.general.update') }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ui.input label="Company Name" name="name" :value="old('name', $tenant->name)" required :error="$errors->first('name')" />
                        <x-ui.input label="Email" name="email" type="email" :value="old('email', $tenant->email)" :error="$errors->first('email')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ui.input label="Phone" name="phone" type="tel" :value="old('phone', $tenant->phone)" :error="$errors->first('phone')" />
                        <x-ui.input label="Website" name="website" type="url" :value="old('website', $tenant->website)" placeholder="https://" :error="$errors->first('website')" />
                    </div>

                    <x-ui.input label="Address" name="address" :value="old('address', $tenant->address)" :error="$errors->first('address')" />

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-ui.input label="City" name="city" :value="old('city', $tenant->city)" :error="$errors->first('city')" />
                        <x-ui.input label="State / Province" name="state" :value="old('state', $tenant->state)" :error="$errors->first('state')" />
                        <x-ui.input label="Country" name="country" :value="old('country', $tenant->country)" :error="$errors->first('country')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="timezone" class="text-sm font-medium text-zinc-700">Timezone</label>
                            <select id="timezone" name="timezone" class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach(timezone_identifiers_list() as $tz)
                                    <option value="{{ $tz }}" @selected(old('timezone', $tenant->timezone) === $tz)>{{ $tz }}</option>
                                @endforeach
                            </select>
                            @error('timezone')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-ui.input label="Currency" name="currency" :value="old('currency', $tenant->currency)" placeholder="BDT" :error="$errors->first('currency')" />
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

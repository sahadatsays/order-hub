<x-layouts.app title="Settings — Couriers">
<div class="max-w-3xl mx-auto">
    <x-app.page-header title="Couriers" description="Manage courier services for order shipments." />

    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-md text-sm text-green-800">{{ session('success') }}</div>
    @endif

    {{-- Existing couriers --}}
    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-zinc-100 font-medium text-zinc-900 text-sm">Configured Couriers</div>
        @forelse($couriers as $courier)
        <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-50 last:border-0">
            <div class="flex items-center gap-3">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-zinc-900 text-sm">{{ $courier->name }}</span>
                        @if($courier->is_default)<x-ui.badge color="indigo" class="text-xs">Default</x-ui.badge>@endif
                        @if(!$courier->is_active)<x-ui.badge color="zinc" class="text-xs">Inactive</x-ui.badge>@endif
                    </div>
                    @if($courier->code)<p class="text-xs text-zinc-400 font-mono">{{ $courier->code }}</p>@endif
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm text-zinc-600">
                <span class="tabular-nums">৳{{ number_format($courier->base_rate, 2) }} base rate</span>
                <form action="{{ route('settings.couriers.destroy', $courier) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs text-red-500 hover:underline" onclick="return confirm('Remove this courier?')">Remove</button>
                </form>
            </div>
        </div>
        @empty
        <div class="px-5 py-8 text-center text-sm text-zinc-400">No couriers yet.</div>
        @endforelse
    </div>

    {{-- Add new courier --}}
    <div class="bg-white border border-zinc-200 rounded-xl p-6">
        <h3 class="text-sm font-semibold text-zinc-900 mb-4">Add Courier</h3>
        <form action="{{ route('settings.couriers.store') }}" method="POST" class="space-y-4">
            @csrf
            @if($errors->any())
            <div class="px-4 py-3 bg-red-50 border border-red-200 rounded-md text-sm text-red-800">
                <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="grid grid-cols-2 gap-4">
                <x-ui.input label="Name" name="name" :value="old('name')" required placeholder="e.g. Pathao" />
                <x-ui.input label="Code" name="code" :value="old('code')" placeholder="e.g. pathao" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <x-ui.input label="Tracking URL" name="tracking_url" :value="old('tracking_url')" placeholder="https://pathao.com/track/" />
                <x-ui.input label="Base Rate" name="base_rate" type="number" step="0.01" :value="old('base_rate', 0)" prefix="৳" />
            </div>
            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 text-sm text-zinc-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-zinc-300 text-indigo-600" @checked(old('is_active', true))>
                    Active
                </label>
                <label class="flex items-center gap-2 text-sm text-zinc-700">
                    <input type="checkbox" name="is_default" value="1" class="rounded border-zinc-300 text-indigo-600" @checked(old('is_default'))>
                    Set as Default
                </label>
            </div>
            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">Add Courier</button>
        </form>
    </div>
</div>
</x-layouts.app>

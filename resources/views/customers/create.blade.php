<x-layouts.app title="New Customer">
<div class="max-w-2xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('customers.index') }}" class="text-sm text-zinc-500 hover:text-zinc-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back to Customers
        </a>
        <h1 class="text-xl font-semibold text-zinc-900 mt-3">New Customer</h1>
    </div>

    <form action="{{ route('customers.store') }}" method="POST" class="space-y-5 bg-white border border-zinc-200 rounded-xl p-6">
        @csrf

        @if($errors->any())
        <div class="px-4 py-3 bg-red-50 border border-red-200 rounded-md text-sm text-red-800">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-ui.input label="Full Name" name="name" :value="old('name')" required placeholder="e.g. Rahim Uddin" />
            <x-ui.input label="Phone" name="phone" :value="old('phone')" placeholder="e.g. 01712345678" />
        </div>

        <x-ui.input label="Email" name="email" type="email" :value="old('email')" placeholder="customer@example.com" />

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="flex flex-col gap-1">
                <label class="text-sm font-medium text-zinc-700">Source</label>
                <select name="source" class="px-3 py-2 border border-zinc-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white text-zinc-700">
                    <option value="">Select source...</option>
                    @foreach(\App\Models\Order::SOURCES as $key => $label)
                    <option value="{{ $key }}" @selected(old('source') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <x-ui.input label="City" name="city" :value="old('city')" placeholder="e.g. Dhaka" />
        </div>

        <x-ui.input label="Address" name="address" :value="old('address')" placeholder="Street address" />

        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-zinc-700">Notes</label>
            <textarea name="notes" rows="3" placeholder="Any notes about this customer..." class="px-3 py-2 border border-zinc-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white text-zinc-700 resize-none">{{ old('notes') }}</textarea>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">Save Customer</button>
            <a href="{{ route('customers.index') }}" class="px-5 py-2 border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 text-sm font-medium rounded-md transition-colors">Cancel</a>
        </div>
    </form>

</div>
</x-layouts.app>

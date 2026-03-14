<x-layouts.app title="Customers">
<div class="max-w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-zinc-900">Customers</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Manage your customer base.</p>
        </div>
        <a href="{{ route('customers.create') }}" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            New Customer
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-3 mb-5">
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Total</p>
            <p class="text-lg font-semibold text-zinc-900 mt-0.5">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">New This Month</p>
            <p class="text-lg font-semibold text-indigo-600 mt-0.5">{{ number_format($stats['this_month']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Repeat Buyers</p>
            <p class="text-lg font-semibold text-green-600 mt-0.5">{{ number_format($stats['repeat']) }}</p>
        </div>
    </div>

    {{-- Search --}}
    <form method="GET" class="flex gap-2 mb-4">
        <div class="relative flex-1 max-w-xs">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, phone or email..." class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white placeholder:text-zinc-400">
        </div>
        <select name="source" class="px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white text-zinc-600">
            <option value="">All Sources</option>
            @foreach(\App\Models\Order::SOURCES as $key => $label)
            <option value="{{ $key }}" @selected(request('source') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-700 transition-colors">Filter</button>
    </form>

    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-md text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 border-b border-zinc-100">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Phone</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">City</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Source</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Orders</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Total Spent</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Joined</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($customers as $customer)
                <tr class="hover:bg-zinc-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <a href="{{ route('customers.show', $customer) }}" class="font-medium text-zinc-900 hover:text-indigo-600 transition-colors">{{ $customer->name }}</a>
                        @if($customer->email)
                        <p class="text-xs text-zinc-400">{{ $customer->email }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-zinc-600">{{ $customer->phone ?? '—' }}</td>
                    <td class="px-4 py-3.5 text-zinc-600">{{ $customer->city ?? '—' }}</td>
                    <td class="px-4 py-3.5">
                        @if($customer->source)
                        <x-ui.badge color="indigo">{{ \App\Models\Order::SOURCES[$customer->source] ?? $customer->source }}</x-ui.badge>
                        @else
                        <span class="text-zinc-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-zinc-700 tabular-nums">{{ $customer->orders_count }}</td>
                    <td class="px-4 py-3.5 text-zinc-700 tabular-nums">{{ number_format($customer->total_spent, 2) }}</td>
                    <td class="px-4 py-3.5 text-xs text-zinc-400">{{ $customer->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3.5">
                        <a href="{{ route('customers.show', $customer) }}" class="text-xs text-indigo-600 hover:underline">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-sm text-zinc-400">No customers found. <a href="{{ route('customers.create') }}" class="text-indigo-600 hover:underline">Add your first customer</a>.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $customers->links() }}
    </div>

</div>
</x-layouts.app>

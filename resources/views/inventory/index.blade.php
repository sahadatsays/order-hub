<x-layouts.app title="Inventory">
<div class="max-w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-zinc-900">Inventory</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Track stock levels across all products.</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Total Products</p>
            <p class="text-lg font-semibold text-zinc-900 mt-0.5">{{ number_format($stats['total_products']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Low Stock</p>
            <p class="text-lg font-semibold text-yellow-600 mt-0.5">{{ number_format($stats['low_stock']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Out of Stock</p>
            <p class="text-lg font-semibold text-red-600 mt-0.5">{{ number_format($stats['out_of_stock']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Stock Value</p>
            <p class="text-lg font-semibold text-green-600 mt-0.5">{{ number_format($stats['total_value'], 2) }}</p>
        </div>
    </div>

    {{-- Filter bar --}}
    <form method="GET" class="flex gap-2 mb-4">
        <div class="relative flex-1 max-w-xs">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white placeholder:text-zinc-400">
        </div>
        <select name="filter" class="px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white text-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Stock</option>
            <option value="low_stock" @selected(request('filter') === 'low_stock')>Low Stock</option>
            <option value="out_of_stock" @selected(request('filter') === 'out_of_stock')>Out of Stock</option>
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
                    <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Product</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">SKU</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wide">On Hand</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wide">Reserved</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wide">Available</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wide">Reorder At</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($items as $item)
                @php
                    $isOut = $item->quantity_on_hand <= 0;
                    $isLow = !$isOut && $item->quantity_on_hand <= $item->reorder_point;
                @endphp
                <tr class="hover:bg-zinc-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <a href="{{ route('products.show', $item->product) }}" class="font-medium text-zinc-900 hover:text-indigo-600 transition-colors">{{ $item->product->name }}</a>
                    </td>
                    <td class="px-4 py-3.5 font-mono text-xs text-zinc-500">{{ $item->product->sku ?? '—' }}</td>
                    <td class="px-4 py-3.5 text-right font-medium {{ $isOut ? 'text-red-600' : ($isLow ? 'text-yellow-600' : 'text-zinc-900') }}">{{ $item->quantity_on_hand }}</td>
                    <td class="px-4 py-3.5 text-right text-zinc-500">{{ $item->quantity_reserved }}</td>
                    <td class="px-4 py-3.5 text-right font-medium text-green-600">{{ $item->quantity_available }}</td>
                    <td class="px-4 py-3.5 text-right text-zinc-500">{{ $item->reorder_point }}</td>
                    <td class="px-4 py-3.5">
                        @if($isOut)
                            <x-ui.badge color="red">Out of Stock</x-ui.badge>
                        @elseif($isLow)
                            <x-ui.badge color="yellow">Low Stock</x-ui.badge>
                        @else
                            <x-ui.badge color="green">In Stock</x-ui.badge>
                        @endif
                    </td>
                    <td class="px-4 py-3.5">
                        <form action="{{ route('inventory.update', $item) }}" method="POST" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity_on_hand" value="{{ $item->quantity_on_hand }}" min="0" class="w-20 px-2 py-1 text-sm border border-zinc-300 rounded text-center focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <button type="submit" class="px-2 py-1 text-xs border border-zinc-300 rounded bg-white hover:bg-zinc-50 text-zinc-600 transition-colors">Update</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-sm text-zinc-400">No inventory data. <a href="{{ route('products.create') }}" class="text-indigo-600 hover:underline">Add products first</a>.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>

</div>
</x-layouts.app>

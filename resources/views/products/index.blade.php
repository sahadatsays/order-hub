<x-layouts.app title="Products">
<div class="max-w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-zinc-900">Products</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Manage your product catalog.</p>
        </div>
        <a href="{{ route('products.create') }}" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add Product
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Total</p>
            <p class="text-lg font-semibold text-zinc-900 mt-0.5">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Active</p>
            <p class="text-lg font-semibold text-green-600 mt-0.5">{{ number_format($stats['active']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Low Stock</p>
            <p class="text-lg font-semibold text-yellow-600 mt-0.5">{{ number_format($stats['low_stock']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Out of Stock</p>
            <p class="text-lg font-semibold text-red-600 mt-0.5">{{ number_format($stats['out_of_stock']) }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" class="flex flex-col sm:flex-row gap-2 mb-4">
        <div class="relative flex-1 max-w-xs">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white placeholder:text-zinc-400">
        </div>
        <select name="category" class="px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white text-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
            @endforeach
        </select>
        <select name="status" class="px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white text-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Status</option>
            <option value="active" @selected(request('status') === 'active')>Active</option>
            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
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
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Price</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Stock</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($products as $product)
                <tr class="hover:bg-zinc-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <a href="{{ route('products.show', $product) }}" class="font-medium text-zinc-900 hover:text-indigo-600 transition-colors">{{ $product->name }}</a>
                        @if($product->brand)<p class="text-xs text-zinc-400">{{ $product->brand }}</p>@endif
                    </td>
                    <td class="px-4 py-3.5 font-mono text-xs text-zinc-500">{{ $product->sku ?? '—' }}</td>
                    <td class="px-4 py-3.5 text-zinc-600">{{ $product->category ?? '—' }}</td>
                    <td class="px-4 py-3.5 font-medium text-zinc-900 tabular-nums">{{ number_format($product->price, 2) }}</td>
                    <td class="px-4 py-3.5">
                        @if($product->inventoryItem)
                            @php $stock = $product->inventoryItem->quantity_on_hand; @endphp
                            @if($stock <= 0)
                                <span class="text-xs font-medium text-red-600">Out of stock</span>
                            @elseif($stock <= $product->inventoryItem->reorder_point)
                                <span class="text-xs font-medium text-yellow-600">{{ $stock }} (low)</span>
                            @else
                                <span class="text-xs text-zinc-600">{{ $stock }}</span>
                            @endif
                        @else
                            <span class="text-xs text-zinc-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5">
                        <x-ui.badge :color="$product->is_active ? 'green' : 'zinc'">{{ $product->is_active ? 'Active' : 'Inactive' }}</x-ui.badge>
                    </td>
                    <td class="px-4 py-3.5 text-right">
                        <a href="{{ route('products.edit', $product) }}" class="text-xs text-indigo-600 hover:underline mr-3">Edit</a>
                        <a href="{{ route('products.show', $product) }}" class="text-xs text-zinc-500 hover:underline">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-10 text-center text-sm text-zinc-400">No products found. <a href="{{ route('products.create') }}" class="text-indigo-600 hover:underline">Add your first product</a>.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>

</div>
</x-layouts.app>

<x-layouts.app :title="$product->name">
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('products.index') }}" class="text-sm text-zinc-500 hover:text-zinc-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>
        <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 text-sm font-medium rounded-md transition-colors">Edit</a>
    </div>

    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-md text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-lg font-semibold text-zinc-900">{{ $product->name }}</h1>
                        @if($product->brand)<p class="text-sm text-zinc-500">{{ $product->brand }}</p>@endif
                    </div>
                    <x-ui.badge :color="$product->is_active ? 'green' : 'zinc'">{{ $product->is_active ? 'Active' : 'Inactive' }}</x-ui.badge>
                </div>
                @if($product->description)
                <p class="text-sm text-zinc-600">{{ $product->description }}</p>
                @endif
            </div>

            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-zinc-900 mb-4">Pricing</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-zinc-500">Selling Price</p>
                        <p class="text-base font-semibold text-zinc-900 mt-1">{{ number_format($product->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-500">Cost Price</p>
                        <p class="text-base font-medium text-zinc-700 mt-1">{{ number_format($product->cost_price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-500">Margin</p>
                        <p class="text-base font-medium text-green-600 mt-1">{{ $product->margin }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <h3 class="text-sm font-semibold text-zinc-900 mb-3">Details</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-zinc-500">SKU</span><span class="font-mono text-zinc-700">{{ $product->sku ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-zinc-500">Category</span><span class="text-zinc-700">{{ $product->category ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-zinc-500">Weight</span><span class="text-zinc-700">{{ $product->weight ? $product->weight . ' kg' : '—' }}</span></div>
                </div>
            </div>

            @if($product->inventoryItem)
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <h3 class="text-sm font-semibold text-zinc-900 mb-3">Inventory</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-zinc-500">On Hand</span><span class="font-medium text-zinc-900">{{ $product->inventoryItem->quantity_on_hand }}</span></div>
                    <div class="flex justify-between"><span class="text-zinc-500">Reserved</span><span class="text-zinc-700">{{ $product->inventoryItem->quantity_reserved }}</span></div>
                    <div class="flex justify-between"><span class="text-zinc-500">Available</span><span class="font-medium text-green-600">{{ $product->inventoryItem->quantity_available }}</span></div>
                    <div class="flex justify-between"><span class="text-zinc-500">Reorder Point</span><span class="text-zinc-700">{{ $product->inventoryItem->reorder_point }}</span></div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</x-layouts.app>

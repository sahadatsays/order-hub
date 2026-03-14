<x-layouts.app :title="'Edit — ' . $product->name">
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('products.show', $product) }}" class="text-sm text-zinc-500 hover:text-zinc-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>
        <h1 class="text-xl font-semibold text-zinc-900 mt-3">Edit Product</h1>
    </div>

    <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-5 bg-white border border-zinc-200 rounded-xl p-6">
        @csrf @method('PATCH')

        @if($errors->any())
        <div class="px-4 py-3 bg-red-50 border border-red-200 rounded-md text-sm text-red-800">
            <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <x-ui.input label="Product Name" name="name" :value="old('name', $product->name)" required />
        <div class="grid grid-cols-2 gap-4">
            <x-ui.input label="SKU" name="sku" :value="old('sku', $product->sku)" />
            <x-ui.input label="Category" name="category" :value="old('category', $product->category)" />
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-ui.input label="Selling Price" name="price" type="number" step="0.01" :value="old('price', $product->price)" required prefix="৳" />
            <x-ui.input label="Cost Price" name="cost_price" type="number" step="0.01" :value="old('cost_price', $product->cost_price)" prefix="৳" />
            <x-ui.input label="Compare Price" name="compare_price" type="number" step="0.01" :value="old('compare_price', $product->compare_price)" prefix="৳" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-ui.input label="Brand" name="brand" :value="old('brand', $product->brand)" />
            <x-ui.input label="Weight (kg)" name="weight" type="number" step="0.001" :value="old('weight', $product->weight)" />
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-zinc-700">Description</label>
            <textarea name="description" rows="3" class="px-3 py-2 border border-zinc-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white text-zinc-700 resize-none">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 text-sm text-zinc-700">
                <input type="checkbox" name="is_active" value="1" class="rounded border-zinc-300 text-indigo-600" @checked(old('is_active', $product->is_active))>
                Active
            </label>
            <label class="flex items-center gap-2 text-sm text-zinc-700">
                <input type="checkbox" name="track_inventory" value="1" class="rounded border-zinc-300 text-indigo-600" @checked(old('track_inventory', $product->track_inventory))>
                Track Inventory
            </label>
        </div>
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">Save Changes</button>
            <a href="{{ route('products.show', $product) }}" class="px-5 py-2 border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 text-sm font-medium rounded-md transition-colors">Cancel</a>
        </div>
    </form>
</div>
</x-layouts.app>

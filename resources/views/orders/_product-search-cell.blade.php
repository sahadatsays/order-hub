<div class="product-search-cell" data-product-search="{{ route('products.search') }}">
    <input type="hidden" name="items[{{ $index }}][product_id]" class="product-id-input" value="{{ $productId ?? '' }}">
    <div class="relative">
        <input type="text" name="items[{{ $index }}][product_name]"
            value="{{ $productName ?? '' }}"
            placeholder="Search product or SKU..."
            class="product-search-input w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all"
            autocomplete="off">
        <div class="product-search-dropdown absolute z-50 top-full left-0 right-0 mt-1 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden" style="display:none"></div>
    </div>
</div>

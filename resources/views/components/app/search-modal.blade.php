{{-- Global Search Modal --}}
<div
    id="global-search-modal"
    class="hidden fixed inset-0 z-50"
    data-search-modal
>
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-zinc-900/50 backdrop-blur-sm" data-search-backdrop></div>

    {{-- Modal --}}
    <div class="relative flex items-start justify-center pt-[15vh] sm:pt-[20vh] px-4">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-zinc-200 overflow-hidden">

            {{-- Search input --}}
            <div class="flex items-center gap-3 px-4 py-3 border-b border-zinc-100">
                <svg class="w-5 h-5 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    data-search-input
                    placeholder="Search orders, customers, products..."
                    class="flex-1 text-sm text-zinc-800 placeholder:text-zinc-400 outline-none bg-transparent"
                    autocomplete="off"
                >
                <kbd class="text-xs text-zinc-400 font-sans border border-zinc-200 rounded px-1.5 py-0.5 bg-zinc-50">Esc</kbd>
            </div>

            {{-- Results --}}
            <div data-search-results class="max-h-80 overflow-y-auto">
                {{-- Default quick links --}}
                <div data-search-default>
                    <div class="px-4 py-2">
                        <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider">Quick Links</p>
                    </div>
                    <a href="{{ route('pos.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition-colors">
                        <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-zinc-700">POS Terminal</span>
                    </a>
                    <a href="{{ route('orders.create') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition-colors">
                        <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="text-sm text-zinc-700">Create Order</span>
                    </a>
                    <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition-colors">
                        <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="text-sm text-zinc-700">All Orders</span>
                    </a>
                    <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition-colors">
                        <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm text-zinc-700">All Customers</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition-colors">
                        <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="text-sm text-zinc-700">All Products</span>
                    </a>
                    @if (Route::has('settings.index'))
                        <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition-colors">
                            <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-sm text-zinc-700">Settings</span>
                        </a>
                    @endif
                </div>

                {{-- Dynamic results (populated by JS) --}}
                <div data-search-dynamic class="hidden"></div>

                {{-- Loading state --}}
                <div data-search-loading class="hidden px-4 py-8 text-center">
                    <svg class="w-5 h-5 text-zinc-400 animate-spin mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <p class="text-xs text-zinc-400 mt-2">Searching...</p>
                </div>

                {{-- Empty state --}}
                <div data-search-empty class="hidden px-4 py-8 text-center">
                    <svg class="w-8 h-8 text-zinc-300 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="text-sm text-zinc-500">No results found</p>
                    <p class="text-xs text-zinc-400 mt-0.5">Try a different search term</p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-4 py-2 border-t border-zinc-100 bg-zinc-50/50 flex items-center gap-4 text-xs text-zinc-400">
                <span class="flex items-center gap-1">
                    <kbd class="border border-zinc-200 rounded px-1 py-0.5 bg-white text-zinc-500">↵</kbd>
                    to select
                </span>
                <span class="flex items-center gap-1">
                    <kbd class="border border-zinc-200 rounded px-1 py-0.5 bg-white text-zinc-500">↑↓</kbd>
                    to navigate
                </span>
                <span class="flex items-center gap-1">
                    <kbd class="border border-zinc-200 rounded px-1 py-0.5 bg-white text-zinc-500">Esc</kbd>
                    to close
                </span>
            </div>
        </div>
    </div>
</div>

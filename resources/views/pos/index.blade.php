<x-layouts.app title="POS — Point of Sale">
<div class="fixed inset-0 flex flex-col bg-slate-100" style="top: 0; z-index: 40;">

    {{-- Top Bar --}}
    <header class="flex items-center justify-between px-5 py-3 bg-slate-900 shadow-lg shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white/70 hover:text-white transition-all" title="Back to Dashboard">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center shadow-sm">
                    <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white leading-none">POS Terminal</p>
                    <p class="text-xs text-slate-400 mt-0.5">Point of Sale</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-5">
            <div class="flex items-center gap-1.5 text-slate-400">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-xs font-mono" id="pos-clock"></span>
            </div>
            <a href="{{ route('orders.create') }}" class="flex items-center gap-1.5 text-xs font-medium text-indigo-400 hover:text-indigo-300 transition-colors">
                Standard Order
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </header>

    {{-- Main Content --}}
    <div class="flex flex-1 min-h-0 gap-0">

        {{-- LEFT PANEL: Products --}}
        <div class="flex-1 flex flex-col min-w-0 bg-slate-50">

            {{-- Customer + Barcode Row --}}
            <div class="flex items-center gap-3 px-5 py-3.5 bg-white border-b border-slate-200">
                {{-- Customer Search --}}
                <div class="relative flex-1" id="customer-search-wrapper">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <input type="text" id="customer-search" placeholder="Search customer by name, phone, email..."
                        class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder:text-slate-400 transition-all">
                    <div id="customer-results" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl z-30 max-h-52 overflow-y-auto divide-y divide-slate-50"></div>
                </div>

                <button type="button" id="walk-in-btn"
                    class="flex items-center gap-2 px-4 py-2.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl whitespace-nowrap transition-all border border-slate-200">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Walk-in
                </button>

                {{-- Barcode Input --}}
                <div class="relative w-52">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <input type="text" id="barcode-input" placeholder="Scan barcode..."
                        class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder:text-slate-400 transition-all">
                </div>
            </div>

            {{-- Selected Customer Bar --}}
            <div id="selected-customer" class="hidden items-center gap-3 px-5 py-2.5 bg-indigo-600 border-b border-indigo-700">
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="flex items-center gap-2 flex-1 min-w-0">
                    <span id="customer-name-display" class="text-sm font-semibold text-white truncate"></span>
                    <span id="customer-phone-display" class="text-xs text-indigo-200 shrink-0"></span>
                </div>
                <button type="button" id="clear-customer" class="flex items-center gap-1 text-xs text-indigo-200 hover:text-white transition-colors shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    Change
                </button>
            </div>

            {{-- Product Search --}}
            <div class="px-5 py-3.5 bg-slate-50 border-b border-slate-200">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" id="product-search" placeholder="Search products by name or SKU..."
                        class="w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder:text-slate-400 transition-all shadow-sm">
                </div>
            </div>

            {{-- Product Grid --}}
            <div class="flex-1 overflow-y-auto p-5">
                <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                    @foreach($products as $product)
                    <button type="button"
                        class="pos-product-card group relative flex flex-col bg-white border border-slate-200 rounded-2xl hover:border-indigo-300 hover:shadow-lg hover:shadow-indigo-100 active:scale-95 transition-all duration-150 cursor-pointer overflow-hidden text-left"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-sku="{{ $product->sku }}"
                        data-price="{{ $product->price }}">
                        {{-- Product image area --}}
                        <div class="w-full aspect-square bg-slate-100 flex items-center justify-center overflow-hidden relative">
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                            @else
                                <div class="flex flex-col items-center gap-1">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                            @endif
                            {{-- Add overlay on hover --}}
                            <div class="absolute inset-0 bg-indigo-600/0 group-hover:bg-indigo-600/5 transition-colors duration-150"></div>
                            {{-- Add to cart indicator --}}
                            <div class="absolute top-2 right-2 w-6 h-6 bg-indigo-600 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-150 shadow-md">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            </div>
                        </div>
                        {{-- Product info --}}
                        <div class="px-2.5 py-2.5">
                            <p class="text-xs font-semibold text-slate-800 line-clamp-2 leading-snug mb-1.5">{{ $product->name }}</p>
                            <p class="text-sm font-bold text-indigo-600">{{ number_format($product->price, 2) }}</p>
                        </div>
                    </button>
                    @endforeach
                </div>
                <div id="no-products-found" class="hidden text-center py-16 text-slate-400">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <p class="text-sm font-medium text-slate-500">No products found</p>
                    <p class="text-xs mt-1 text-slate-400">Try a different search term</p>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL: Cart --}}
        <div class="w-[400px] flex flex-col bg-white border-l border-slate-200 shrink-0">

            {{-- Cart Header --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Order Cart</h3>
                        <p class="text-xs text-slate-400"><span id="cart-count">0</span> items</p>
                    </div>
                </div>
                <button type="button" id="clear-cart" class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Clear
                </button>
            </div>

            {{-- Cart Items --}}
            <div id="cart-items" class="flex-1 overflow-y-auto px-4 py-3 space-y-1.5">
                <div id="empty-cart" class="flex flex-col items-center justify-center h-full py-16 text-slate-400">
                    <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border-2 border-dashed border-slate-200">
                        <svg class="w-9 h-9 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-500">Cart is empty</p>
                    <p class="text-xs mt-1 text-center text-slate-400">Click products or scan barcodes<br>to add items</p>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="border-t border-slate-100 bg-slate-50 px-5 py-4 space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">Subtotal</span>
                    <span id="cart-subtotal" class="font-semibold text-slate-900">0.00</span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-sm text-slate-500 shrink-0">Discount</span>
                    <div class="relative">
                        <input type="number" id="cart-discount" value="0" min="0" step="0.01"
                            class="w-36 text-right text-sm border border-slate-200 rounded-lg px-3 py-1.5 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    </div>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-slate-200">
                    <span class="text-base font-bold text-slate-900">Total</span>
                    <span id="cart-total" class="text-xl font-bold text-indigo-600">0.00</span>
                </div>
            </div>

            {{-- Payment Section --}}
            <div class="border-t border-slate-100 px-5 py-4 space-y-4">
                {{-- Payment Method --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Payment Method</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button"
                            class="payment-method-btn active flex flex-col items-center gap-1.5 px-2 py-2.5 rounded-xl border-2 border-indigo-500 bg-indigo-50 text-indigo-700 transition-all"
                            data-method="cash">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span class="text-xs font-semibold">Cash</span>
                        </button>
                        <button type="button"
                            class="payment-method-btn flex flex-col items-center gap-1.5 px-2 py-2.5 rounded-xl border-2 border-slate-200 bg-white text-slate-500 hover:border-slate-300 transition-all"
                            data-method="card">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            <span class="text-xs font-semibold">Card</span>
                        </button>
                        <button type="button"
                            class="payment-method-btn flex flex-col items-center gap-1.5 px-2 py-2.5 rounded-xl border-2 border-slate-200 bg-white text-slate-500 hover:border-slate-300 transition-all"
                            data-method="mobile_banking">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <span class="text-xs font-semibold">Mobile</span>
                        </button>
                    </div>
                </div>

                {{-- Cash Tender --}}
                <div id="cash-tender-section">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Cash Received</label>
                    <input type="number" id="cash-tendered" min="0" step="0.01" placeholder="0.00"
                        class="w-full text-sm border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all focus:bg-white">
                    <div id="change-display" class="hidden mt-2 flex items-center justify-between bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-2.5">
                        <span class="text-xs font-semibold text-emerald-700">Change Due</span>
                        <span id="change-amount" class="text-base font-bold text-emerald-700">0.00</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-2 pt-1">
                    <button type="button" id="pay-and-create"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3.5 text-sm font-bold bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-2xl transition-all shadow-lg shadow-indigo-200 disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none" disabled>
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Pay & Create Order
                    </button>
                    <button type="button" id="create-unpaid"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Create Order (Unpaid)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Toast Notification --}}
<div id="pos-toast" class="fixed top-5 right-5 z-50 hidden">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-2xl shadow-slate-200/60 px-4 py-3 flex items-center gap-3 min-w-64">
        <div id="toast-icon" class="w-9 h-9 rounded-xl flex items-center justify-center bg-emerald-100 shrink-0">
            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="min-w-0">
            <p id="toast-title" class="text-sm font-semibold text-slate-900"></p>
            <p id="toast-message" class="text-xs text-slate-500 truncate"></p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── State ──
    let cart = [];
    let selectedCustomer = null;
    let paymentMethod = 'cash';

    // ── DOM References ──
    const cartItemsEl = document.getElementById('cart-items');
    const emptyCartEl = document.getElementById('empty-cart');
    const cartCountEl = document.getElementById('cart-count');
    const cartSubtotalEl = document.getElementById('cart-subtotal');
    const cartTotalEl = document.getElementById('cart-total');
    const cartDiscountEl = document.getElementById('cart-discount');
    const payBtn = document.getElementById('pay-and-create');
    const createUnpaidBtn = document.getElementById('create-unpaid');
    const barcodeInput = document.getElementById('barcode-input');
    const customerSearch = document.getElementById('customer-search');
    const customerResults = document.getElementById('customer-results');
    const selectedCustomerEl = document.getElementById('selected-customer');
    const cashTenderedEl = document.getElementById('cash-tendered');
    const changeDisplayEl = document.getElementById('change-display');
    const changeAmountEl = document.getElementById('change-amount');
    const cashTenderSection = document.getElementById('cash-tender-section');
    const productSearch = document.getElementById('product-search');

    // ── Clock ──
    function updateClock() {
        const now = new Date();
        document.getElementById('pos-clock').textContent = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }
    updateClock();
    setInterval(updateClock, 30000);

    // ── Product click ──
    document.querySelectorAll('.pos-product-card').forEach(card => {
        card.addEventListener('click', () => {
            addToCart({
                product_id: parseInt(card.dataset.id),
                product_name: card.dataset.name,
                product_sku: card.dataset.sku || null,
                unit_price: parseFloat(card.dataset.price),
                quantity: 1,
                discount_amount: 0,
            });
        });
    });

    // ── Product search/filter ──
    productSearch.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.pos-product-card').forEach(card => {
            const name = card.dataset.name.toLowerCase();
            const sku = (card.dataset.sku || '').toLowerCase();
            card.style.display = (!q || name.includes(q) || sku.includes(q)) ? '' : 'none';
        });
        const visible = document.querySelectorAll('.pos-product-card:not([style*="display: none"])');
        document.getElementById('no-products-found').classList.toggle('hidden', visible.length > 0);
    });

    // ── Barcode scan ──
    barcodeInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const barcode = this.value.trim();
            if (!barcode) return;

            fetch(`{{ route('pos.barcode') }}?barcode=${encodeURIComponent(barcode)}`, {
                headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}
            })
            .then(r => {
                if (!r.ok) throw new Error('Not found');
                return r.json();
            })
            .then(product => {
                addToCart({
                    product_id: product.id,
                    product_name: product.name,
                    product_sku: product.sku || null,
                    unit_price: parseFloat(product.price),
                    quantity: 1,
                    discount_amount: 0,
                });
                this.value = '';
            })
            .catch(() => {
                showToast('Product Not Found', `No product matches barcode "${barcode}"`, 'error');
                this.value = '';
            });
        }
    });

    // ── Customer search ──
    let customerDebounce = null;
    customerSearch.addEventListener('input', function() {
        clearTimeout(customerDebounce);
        const q = this.value.trim();
        if (q.length < 2) { customerResults.classList.add('hidden'); return; }

        customerDebounce = setTimeout(() => {
            fetch(`{{ route('pos.customers.search') }}?q=${encodeURIComponent(q)}`, {
                headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}
            })
            .then(r => r.json())
            .then(customers => {
                if (customers.length === 0) {
                    customerResults.innerHTML = '<div class="px-4 py-4 text-xs text-slate-400 text-center">No customers found</div>';
                } else {
                    customerResults.innerHTML = customers.map(c =>
                        `<button type="button" class="customer-result w-full text-left px-4 py-3 hover:bg-slate-50 transition-colors" data-id="${c.id}" data-name="${c.name}" data-phone="${c.phone || ''}" data-email="${c.email || ''}">
                            <p class="text-sm font-semibold text-slate-900">${c.name}</p>
                            <p class="text-xs text-slate-400 mt-0.5">${c.phone || ''} ${c.email ? '· ' + c.email : ''}</p>
                        </button>`
                    ).join('');
                }
                customerResults.classList.remove('hidden');

                customerResults.querySelectorAll('.customer-result').forEach(btn => {
                    btn.addEventListener('click', () => selectCustomer({
                        id: parseInt(btn.dataset.id),
                        name: btn.dataset.name,
                        phone: btn.dataset.phone,
                        email: btn.dataset.email,
                    }));
                });
            });
        }, 300);
    });

    document.getElementById('walk-in-btn').addEventListener('click', () => {
        selectCustomer({ id: null, name: 'Walk-in Customer', phone: '', email: '' });
    });

    document.getElementById('clear-customer').addEventListener('click', () => {
        selectedCustomer = null;
        selectedCustomerEl.classList.add('hidden');
        selectedCustomerEl.classList.remove('flex');
        customerSearch.value = '';
    });

    function selectCustomer(customer) {
        selectedCustomer = customer;
        document.getElementById('customer-name-display').textContent = customer.name;
        document.getElementById('customer-phone-display').textContent = customer.phone || '';
        selectedCustomerEl.classList.remove('hidden');
        selectedCustomerEl.classList.add('flex');
        customerResults.classList.add('hidden');
        customerSearch.value = '';
    }

    // Close customer results on outside click
    document.addEventListener('click', function(e) {
        if (!document.getElementById('customer-search-wrapper').contains(e.target)) {
            customerResults.classList.add('hidden');
        }
    });

    // ── Cart functions ──
    function addToCart(item) {
        const existing = cart.find(i => i.product_id === item.product_id && item.product_id !== null);
        if (existing) {
            existing.quantity++;
        } else {
            cart.push({...item});
        }
        renderCart();
        showToast('Added to cart', item.product_name, 'success');
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function updateQuantity(index, qty) {
        if (qty < 1) {
            removeFromCart(index);
            return;
        }
        cart[index].quantity = qty;
        renderCart();
    }

    function renderCart() {
        if (cart.length === 0) {
            emptyCartEl.classList.remove('hidden');
            cartItemsEl.querySelectorAll('.cart-item').forEach(el => el.remove());
            cartCountEl.textContent = '0';
            updateTotals();
            return;
        }

        emptyCartEl.classList.add('hidden');
        cartItemsEl.querySelectorAll('.cart-item').forEach(el => el.remove());

        cart.forEach((item, index) => {
            const lineTotal = (item.quantity * item.unit_price) - (item.discount_amount || 0);
            const el = document.createElement('div');
            el.className = 'cart-item flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100';
            el.innerHTML = `
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">${item.product_name}</p>
                    <p class="text-xs text-slate-400 mt-0.5">${item.unit_price.toFixed(2)} each</p>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                    <button type="button" class="qty-dec w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 text-sm font-bold transition-colors shadow-sm">−</button>
                    <span class="w-8 text-center text-sm font-bold text-slate-900">${item.quantity}</span>
                    <button type="button" class="qty-inc w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 text-sm font-bold transition-colors shadow-sm">+</button>
                </div>
                <span class="text-sm font-bold text-slate-900 w-16 text-right shrink-0">${lineTotal.toFixed(2)}</span>
                <button type="button" class="remove-item w-6 h-6 flex items-center justify-center rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            `;
            el.querySelector('.qty-dec').addEventListener('click', () => updateQuantity(index, item.quantity - 1));
            el.querySelector('.qty-inc').addEventListener('click', () => updateQuantity(index, item.quantity + 1));
            el.querySelector('.remove-item').addEventListener('click', () => removeFromCart(index));
            cartItemsEl.insertBefore(el, emptyCartEl);
        });

        cartCountEl.textContent = cart.reduce((s, i) => s + i.quantity, 0);
        updateTotals();
    }

    function getSubtotal() {
        return cart.reduce((s, i) => s + (i.quantity * i.unit_price) - (i.discount_amount || 0), 0);
    }

    function getTotal() {
        const discount = parseFloat(cartDiscountEl.value) || 0;
        return Math.max(0, getSubtotal() - discount);
    }

    function updateTotals() {
        const subtotal = getSubtotal();
        const total = getTotal();
        cartSubtotalEl.textContent = subtotal.toFixed(2);
        cartTotalEl.textContent = total.toFixed(2);
        payBtn.disabled = cart.length === 0;
        createUnpaidBtn.disabled = cart.length === 0;
        updateChange();
    }

    cartDiscountEl.addEventListener('input', updateTotals);

    // ── Payment method toggle ──
    document.querySelectorAll('.payment-method-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.payment-method-btn').forEach(b => {
                b.classList.remove('active', 'border-indigo-500', 'bg-indigo-50', 'text-indigo-700');
                b.classList.add('border-slate-200', 'bg-white', 'text-slate-500');
            });
            this.classList.add('active', 'border-indigo-500', 'bg-indigo-50', 'text-indigo-700');
            this.classList.remove('border-slate-200', 'bg-white', 'text-slate-500');
            paymentMethod = this.dataset.method;
            cashTenderSection.style.display = paymentMethod === 'cash' ? '' : 'none';
        });
    });

    // ── Cash tender / change ──
    cashTenderedEl.addEventListener('input', updateChange);

    function updateChange() {
        const total = getTotal();
        const tendered = parseFloat(cashTenderedEl.value) || 0;
        if (paymentMethod === 'cash' && tendered > 0 && tendered >= total) {
            const change = tendered - total;
            changeAmountEl.textContent = change.toFixed(2);
            changeDisplayEl.classList.remove('hidden');
        } else {
            changeDisplayEl.classList.add('hidden');
        }
    }

    // ── Clear cart ──
    document.getElementById('clear-cart').addEventListener('click', () => {
        if (cart.length === 0) return;
        cart = [];
        renderCart();
    });

    // ── Submit order ──
    function submitOrder(isPaid) {
        if (cart.length === 0) return;

        const total = getTotal();
        const customerName = selectedCustomer ? selectedCustomer.name : 'Walk-in Customer';
        const discount = parseFloat(cartDiscountEl.value) || 0;

        const payload = {
            customer_id: selectedCustomer?.id || null,
            customer_name: customerName,
            customer_phone: selectedCustomer?.phone || null,
            customer_email: selectedCustomer?.email || null,
            items: cart.map(i => ({
                product_id: i.product_id,
                product_name: i.product_name,
                product_sku: i.product_sku,
                quantity: i.quantity,
                unit_price: i.unit_price,
                discount_amount: i.discount_amount || 0,
            })),
            discount_amount: discount,
            payment_method: isPaid ? paymentMethod : null,
            paid_amount: isPaid ? total : 0,
            tendered: (isPaid && paymentMethod === 'cash') ? (parseFloat(cashTenderedEl.value) || total) : null,
        };

        payBtn.disabled = true;
        createUnpaidBtn.disabled = true;

        fetch('{{ route("pos.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(payload),
        })
        .then(r => {
            if (!r.ok) throw r;
            return r.json();
        })
        .then(data => {
            showToast('Order Created', `#${data.order.order_number} — ${data.order.payment_status}`, 'success');
            cart = [];
            selectedCustomer = null;
            selectedCustomerEl.classList.add('hidden');
            selectedCustomerEl.classList.remove('flex');
            customerSearch.value = '';
            cashTenderedEl.value = '';
            cartDiscountEl.value = '0';
            renderCart();
        })
        .catch(async err => {
            let msg = 'Failed to create order';
            try { const d = await err.json(); msg = d.message || msg; } catch {}
            showToast('Error', msg, 'error');
            payBtn.disabled = false;
            createUnpaidBtn.disabled = false;
        });
    }

    payBtn.addEventListener('click', () => submitOrder(true));
    createUnpaidBtn.addEventListener('click', () => submitOrder(false));

    // ── Toast ──
    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('pos-toast');
        const icon = document.getElementById('toast-icon');
        document.getElementById('toast-title').textContent = title;
        document.getElementById('toast-message').textContent = message;

        if (type === 'error') {
            icon.className = 'w-9 h-9 rounded-xl flex items-center justify-center bg-red-100 shrink-0';
            icon.innerHTML = '<svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
        } else {
            icon.className = 'w-9 h-9 rounded-xl flex items-center justify-center bg-emerald-100 shrink-0';
            icon.innerHTML = '<svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
        }

        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    }
});
</script>
@endpush
</x-layouts.app>

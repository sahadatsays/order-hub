<x-layouts.app title="POS — Point of Sale">
<div class="fixed inset-0 flex flex-col bg-zinc-50" style="top: 0; z-index: 40;">

    {{-- POS Top Bar --}}
    <div class="flex items-center justify-between px-4 py-2.5 bg-white border-b border-zinc-200 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-500 transition-colors" title="Back to Dashboard">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-sm font-semibold text-zinc-900">POS Terminal</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-zinc-500" id="pos-clock"></span>
            <a href="{{ route('orders.create') }}" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">Standard Order →</a>
        </div>
    </div>

    {{-- POS Main Content --}}
    <div class="flex flex-1 min-h-0">

        {{-- LEFT PANEL: Products --}}
        <div class="flex-1 flex flex-col min-w-0 border-r border-zinc-200 bg-white">

            {{-- Customer + Barcode Row --}}
            <div class="flex items-center gap-3 px-4 py-3 border-b border-zinc-100 bg-zinc-50/50">
                {{-- Customer Search --}}
                <div class="relative flex-1" id="customer-search-wrapper">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <input type="text" id="customer-search" placeholder="Search customer by name, phone, email..." class="w-full pl-10 pr-3 py-2 text-sm border border-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white placeholder:text-zinc-400">
                    <div id="customer-results" class="hidden absolute left-0 right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg z-30 max-h-48 overflow-y-auto"></div>
                </div>
                <button type="button" id="walk-in-btn" class="flex items-center gap-1.5 px-3 py-2 text-xs font-medium bg-zinc-100 hover:bg-zinc-200 text-zinc-700 rounded-lg whitespace-nowrap transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Walk-in
                </button>

                {{-- Barcode Input --}}
                <div class="relative w-48">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <input type="text" id="barcode-input" placeholder="Scan barcode..." class="w-full pl-10 pr-3 py-2 text-sm border border-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white placeholder:text-zinc-400">
                </div>
            </div>

            {{-- Selected Customer Bar --}}
            <div id="selected-customer" class="hidden items-center gap-2 px-4 py-2 bg-indigo-50 border-b border-indigo-100">
                <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span id="customer-name-display" class="text-sm font-medium text-indigo-900"></span>
                <span id="customer-phone-display" class="text-xs text-indigo-600"></span>
                <button type="button" id="clear-customer" class="ml-auto text-indigo-400 hover:text-indigo-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Product Search --}}
            <div class="px-4 py-3 border-b border-zinc-100">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" id="product-search" placeholder="Search products..." class="w-full pl-10 pr-3 py-2 text-sm border border-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white placeholder:text-zinc-400">
                </div>
            </div>

            {{-- Product Grid --}}
            <div class="flex-1 overflow-y-auto p-4">
                <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach($products as $product)
                    <button type="button" class="pos-product-card group flex flex-col items-center p-3 bg-white border border-zinc-200 rounded-xl hover:border-indigo-300 hover:shadow-md transition-all text-center cursor-pointer"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-sku="{{ $product->sku }}"
                            data-price="{{ $product->price }}">
                        <div class="w-full aspect-square bg-zinc-100 rounded-lg mb-2 flex items-center justify-center overflow-hidden">
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <svg class="w-8 h-8 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            @endif
                        </div>
                        <p class="text-xs font-medium text-zinc-800 line-clamp-2 mb-1">{{ $product->name }}</p>
                        <p class="text-xs font-bold text-indigo-600">{{ number_format($product->price, 2) }}</p>
                    </button>
                    @endforeach
                </div>
                <div id="no-products-found" class="hidden text-center py-12 text-zinc-400">
                    <svg class="w-10 h-10 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <p class="text-sm">No products found</p>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL: Cart --}}
        <div class="w-96 flex flex-col bg-white">

            {{-- Cart Header --}}
            <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-200 bg-zinc-50">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <h3 class="text-sm font-semibold text-zinc-900">Cart</h3>
                    <span id="cart-count" class="text-xs bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded-full font-medium">0</span>
                </div>
                <button type="button" id="clear-cart" class="text-xs text-red-500 hover:text-red-600 font-medium">Clear</button>
            </div>

            {{-- Cart Items --}}
            <div id="cart-items" class="flex-1 overflow-y-auto px-4 py-2 space-y-2">
                <div id="empty-cart" class="text-center py-12 text-zinc-400">
                    <svg class="w-10 h-10 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <p class="text-sm">Cart is empty</p>
                    <p class="text-xs mt-1">Click products or scan barcodes to add items</p>
                </div>
            </div>

            {{-- Cart Summary --}}
            <div class="border-t border-zinc-200 bg-zinc-50 px-4 py-3 space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-zinc-500">Subtotal</span>
                    <span id="cart-subtotal" class="font-medium text-zinc-900">0.00</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-zinc-500">Discount</span>
                    <input type="number" id="cart-discount" value="0" min="0" step="0.01" class="flex-1 text-right text-sm border border-zinc-300 rounded-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-indigo-500 w-20">
                </div>
                <div class="flex items-center justify-between text-base font-bold border-t border-zinc-200 pt-2">
                    <span class="text-zinc-900">Total</span>
                    <span id="cart-total" class="text-indigo-600">0.00</span>
                </div>
            </div>

            {{-- Payment Section --}}
            <div class="border-t border-zinc-200 px-4 py-3 space-y-3">
                <div>
                    <label class="block text-xs font-medium text-zinc-600 mb-1.5">Payment Method</label>
                    <div class="grid grid-cols-3 gap-1.5">
                        <button type="button" class="payment-method-btn active px-2 py-1.5 text-xs font-medium rounded-md border transition-colors bg-indigo-50 border-indigo-300 text-indigo-700" data-method="cash">Cash</button>
                        <button type="button" class="payment-method-btn px-2 py-1.5 text-xs font-medium rounded-md border border-zinc-200 text-zinc-600 hover:bg-zinc-50 transition-colors" data-method="card">Card</button>
                        <button type="button" class="payment-method-btn px-2 py-1.5 text-xs font-medium rounded-md border border-zinc-200 text-zinc-600 hover:bg-zinc-50 transition-colors" data-method="mobile_banking">Mobile</button>
                    </div>
                </div>

                <div id="cash-tender-section">
                    <label class="block text-xs font-medium text-zinc-600 mb-1">Cash Received</label>
                    <input type="number" id="cash-tendered" min="0" step="0.01" placeholder="0.00" class="w-full text-sm border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    <div id="change-display" class="hidden mt-1.5 flex items-center justify-between bg-green-50 border border-green-200 rounded-md px-3 py-1.5">
                        <span class="text-xs text-green-700">Change</span>
                        <span id="change-amount" class="text-sm font-bold text-green-700">0.00</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="button" id="pay-and-create" class="flex-1 px-4 py-2.5 text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Pay & Create Order
                    </button>
                </div>
                <button type="button" id="create-unpaid" class="w-full px-4 py-2 text-xs font-medium text-zinc-600 hover:text-zinc-800 hover:bg-zinc-100 rounded-md transition-colors">
                    Create Order (Unpaid)
                </button>
            </div>
        </div>
    </div>
</div>

{{-- POS Notification Toast --}}
<div id="pos-toast" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-white border border-zinc-200 rounded-xl shadow-lg px-4 py-3 flex items-center gap-3">
        <div id="toast-icon" class="w-8 h-8 rounded-full flex items-center justify-center bg-green-100">
            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
            <p id="toast-title" class="text-sm font-medium text-zinc-900"></p>
            <p id="toast-message" class="text-xs text-zinc-500"></p>
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
                    customerResults.innerHTML = '<div class="px-4 py-3 text-xs text-zinc-400">No customers found</div>';
                } else {
                    customerResults.innerHTML = customers.map(c =>
                        `<button type="button" class="customer-result w-full text-left px-4 py-2.5 hover:bg-zinc-50 border-b border-zinc-100 last:border-0 transition-colors" data-id="${c.id}" data-name="${c.name}" data-phone="${c.phone || ''}" data-email="${c.email || ''}">
                            <p class="text-sm font-medium text-zinc-900">${c.name}</p>
                            <p class="text-xs text-zinc-500">${c.phone || ''} ${c.email ? '· ' + c.email : ''}</p>
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
        showToast('Added', item.product_name, 'success');
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

        // Remove old items
        cartItemsEl.querySelectorAll('.cart-item').forEach(el => el.remove());

        cart.forEach((item, index) => {
            const lineTotal = (item.quantity * item.unit_price) - (item.discount_amount || 0);
            const el = document.createElement('div');
            el.className = 'cart-item flex items-center gap-3 py-2 border-b border-zinc-100';
            el.innerHTML = `
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-zinc-900 truncate">${item.product_name}</p>
                    <p class="text-xs text-zinc-500">${item.unit_price.toFixed(2)} each</p>
                </div>
                <div class="flex items-center gap-1">
                    <button type="button" class="qty-dec w-6 h-6 flex items-center justify-center rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-600 text-xs font-bold transition-colors">−</button>
                    <span class="w-7 text-center text-sm font-medium">${item.quantity}</span>
                    <button type="button" class="qty-inc w-6 h-6 flex items-center justify-center rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-600 text-xs font-bold transition-colors">+</button>
                </div>
                <span class="text-sm font-semibold text-zinc-900 w-16 text-right">${lineTotal.toFixed(2)}</span>
                <button type="button" class="remove-item text-zinc-300 hover:text-red-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
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
                b.classList.remove('active', 'bg-indigo-50', 'border-indigo-300', 'text-indigo-700');
                b.classList.add('border-zinc-200', 'text-zinc-600');
            });
            this.classList.add('active', 'bg-indigo-50', 'border-indigo-300', 'text-indigo-700');
            this.classList.remove('border-zinc-200', 'text-zinc-600');
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
            // Reset state
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
            icon.className = 'w-8 h-8 rounded-full flex items-center justify-center bg-red-100';
            icon.innerHTML = '<svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
        } else {
            icon.className = 'w-8 h-8 rounded-full flex items-center justify-center bg-green-100';
            icon.innerHTML = '<svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
        }

        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    }
});
</script>
@endpush
</x-layouts.app>

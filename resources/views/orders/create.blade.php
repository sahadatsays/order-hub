<x-layouts.app title="New Order">
<div class="max-w-full">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('orders.index') }}" class="flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <p class="text-xs text-slate-400 mb-0.5 flex items-center gap-1.5">
                    <a href="{{ route('orders.index') }}" class="hover:text-slate-600 transition-colors">Orders</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-slate-600">New Order</span>
                </p>
                <h1 class="text-2xl font-bold text-slate-900">New Order</h1>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" class="px-4 py-2.5 text-sm font-semibold border border-slate-200 rounded-xl bg-white hover:bg-slate-50 text-slate-700 transition-all shadow-sm">
                Save Draft
            </button>
            <button type="submit" form="create-order-form" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all shadow-lg shadow-indigo-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Create Order
            </button>
        </div>
    </div>

    <form id="create-order-form" action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT: 2/3 --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Customer Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">Customer</h3>
                    </div>
                    <div class="p-6">
                        <x-ui.customer-search
                            field-name="customer"
                            placeholder="Search by name, phone, or email..."
                            label="Select or create customer"
                        />
                    </div>
                </div>

                {{-- Order Items Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">Order Items</h3>
                    </div>

                    <div id="order-items-table-wrapper" class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Product</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider w-24">Qty</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider w-32">Unit Price</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider w-32">Total</th>
                                    <th class="px-5 py-3 w-12"></th>
                                </tr>
                            </thead>
                            <tbody id="order-items-body" class="divide-y divide-slate-50">

                                {{-- Pre-filled row 1 --}}
                                <tr class="order-item-row hover:bg-slate-50/50 transition-colors">
                                    <td class="px-5 py-3.5">
                                        <input type="text" name="items[0][product]" value="Enterprise Suite License" placeholder="Product name or SKU"
                                            class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <input type="number" name="items[0][qty]" value="1" min="1"
                                            class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-right bg-slate-50 focus:bg-white item-qty transition-all"
                                            oninput="recalcRow(this)">
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-xs pointer-events-none font-medium">$</span>
                                            <input type="number" name="items[0][unit_price]" value="350.00" min="0" step="0.01"
                                                class="w-full pl-7 pr-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-right bg-slate-50 focus:bg-white item-price transition-all"
                                                oninput="recalcRow(this)">
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <span class="text-sm font-bold text-slate-900 item-total">$350.00</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <button type="button" onclick="removeOrderRow(this)" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all mx-auto">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Pre-filled row 2 --}}
                                <tr class="order-item-row hover:bg-slate-50/50 transition-colors">
                                    <td class="px-5 py-3.5">
                                        <input type="text" name="items[1][product]" value="Pro Add-on Bundle" placeholder="Product name or SKU"
                                            class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <input type="number" name="items[1][qty]" value="2" min="1"
                                            class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-right bg-slate-50 focus:bg-white item-qty transition-all"
                                            oninput="recalcRow(this)">
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-xs pointer-events-none font-medium">$</span>
                                            <input type="number" name="items[1][unit_price]" value="220.00" min="0" step="0.01"
                                                class="w-full pl-7 pr-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-right bg-slate-50 focus:bg-white item-price transition-all"
                                                oninput="recalcRow(this)">
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <span class="text-sm font-bold text-slate-900 item-total">$440.00</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <button type="button" onclick="removeOrderRow(this)" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all mx-auto">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    {{-- Add item --}}
                    <div class="px-5 py-3.5 border-t border-slate-100">
                        <button type="button" id="add-item-btn" onclick="addOrderRow()"
                            class="flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 px-3 py-2 rounded-xl transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Add item
                        </button>
                    </div>

                    {{-- Totals --}}
                    <div class="border-t border-slate-100 bg-slate-50/80 px-6 py-5 space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500 font-medium">Subtotal</span>
                            <span id="subtotal-display" class="font-bold text-slate-900">$790.00</span>
                        </div>
                        <div class="flex items-center justify-between text-sm gap-4">
                            <label for="discount_amount" class="text-slate-500 font-medium shrink-0">Discount</label>
                            <div class="relative w-36">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-xs pointer-events-none font-medium">$</span>
                                <input type="number" id="discount_amount" name="discount_amount" value="0" min="0" step="0.01" placeholder="0.00"
                                    class="w-full pl-7 pr-3.5 py-1.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-right bg-white transition-all"
                                    oninput="recalcTotals()">
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-sm gap-4">
                            <label for="tax_rate" class="text-slate-500 font-medium shrink-0">Tax</label>
                            <select id="tax_rate" name="tax_rate"
                                class="w-36 border border-slate-200 rounded-xl px-3.5 py-1.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-slate-700 transition-all"
                                onchange="recalcTotals()">
                                <option value="0">0%</option>
                                <option value="5">5%</option>
                                <option value="8">8%</option>
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                                <option value="20">20%</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between text-sm gap-4">
                            <label for="shipping_cost" class="text-slate-500 font-medium shrink-0">Shipping</label>
                            <div class="relative w-36">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-xs pointer-events-none font-medium">$</span>
                                <input type="number" id="shipping_cost" name="shipping_cost" value="0" min="0" step="0.01" placeholder="0.00"
                                    class="w-full pl-7 pr-3.5 py-1.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-right bg-white transition-all"
                                    oninput="recalcTotals()">
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-4 pt-3 border-t border-slate-200">
                            <span class="text-base font-bold text-slate-900">Total</span>
                            <span id="total-display" class="text-xl font-bold text-indigo-600">$790.00</span>
                        </div>
                    </div>
                </div>

                {{-- Shipping Address Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">Shipping Address</h3>
                    </div>
                    <div class="p-6 space-y-5">

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">First name</label>
                                <input type="text" id="first_name" name="first_name" placeholder="Jane"
                                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
                            </div>
                            <div>
                                <label for="last_name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Last name</label>
                                <input type="text" id="last_name" name="last_name" placeholder="Smith"
                                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
                            </div>
                        </div>

                        <div>
                            <label for="company" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                Company <span class="text-slate-400 normal-case font-normal tracking-normal">(optional)</span>
                            </label>
                            <input type="text" id="company" name="company" placeholder="Acme Corp"
                                class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
                        </div>

                        <div>
                            <label for="address_line1" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Address line 1</label>
                            <input type="text" id="address_line1" name="address_line1" placeholder="123 Business Ave, Suite 400"
                                class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
                        </div>

                        <div>
                            <label for="address_line2" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                Address line 2 <span class="text-slate-400 normal-case font-normal tracking-normal">(optional)</span>
                            </label>
                            <input type="text" id="address_line2" name="address_line2" placeholder="Floor, unit, building..."
                                class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">City</label>
                                <input type="text" id="city" name="city" placeholder="San Francisco"
                                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
                            </div>
                            <div>
                                <label for="state" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">State</label>
                                <input type="text" id="state" name="state" placeholder="CA"
                                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
                            </div>
                            <div>
                                <label for="postal_code" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">ZIP Code</label>
                                <input type="text" id="postal_code" name="postal_code" placeholder="94105"
                                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
                            </div>
                        </div>

                        <div>
                            <label for="country" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Country</label>
                            <select id="country" name="country"
                                class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white text-slate-700 transition-all">
                                <option value="">Select country...</option>
                                <option value="US" selected>United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                                <option value="DE">Germany</option>
                                <option value="FR">France</option>
                                <option value="JP">Japan</option>
                                <option value="SG">Singapore</option>
                                <option value="IN">India</option>
                                <option value="BR">Brazil</option>
                            </select>
                        </div>

                    </div>
                </div>

                {{-- Notes Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">Notes</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <label for="internal_notes" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                Internal notes
                                <span class="text-slate-400 normal-case font-normal tracking-normal ml-1">— not visible to customer</span>
                            </label>
                            <textarea id="internal_notes" name="internal_notes" rows="3"
                                placeholder="Add internal notes about this order (warehouse instructions, special handling, etc.)..."
                                class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none placeholder:text-slate-400 transition-all"></textarea>
                        </div>
                        <div>
                            <label for="customer_note" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                Note to customer
                                <span class="text-slate-400 normal-case font-normal tracking-normal ml-1">— included in confirmation email</span>
                            </label>
                            <textarea id="customer_note" name="customer_note" rows="3"
                                placeholder="Thank you for your order! We'll process it within 1-2 business days..."
                                class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none placeholder:text-slate-400 transition-all"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT SIDEBAR: 1/3 --}}
            <div class="space-y-5">

                {{-- Status Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Status</h3>
                    <select name="status"
                        class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-slate-700 font-medium transition-all">
                        <option value="pending" selected>Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                {{-- Payment Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Payment</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="payment_method" class="block text-xs font-semibold text-slate-500 mb-1.5">Payment method</label>
                            <select id="payment_method" name="payment_method"
                                class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-slate-700 transition-all">
                                <option value="invoice">Invoice</option>
                                <option value="stripe">Stripe</option>
                                <option value="bank_transfer">Bank transfer</option>
                                <option value="cash">Cash</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="payment_terms" class="block text-xs font-semibold text-slate-500 mb-1.5">Payment terms</label>
                            <select id="payment_terms" name="payment_terms"
                                class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-slate-700 transition-all">
                                <option value="immediate">Due immediately</option>
                                <option value="net15">Net 15</option>
                                <option value="net30" selected>Net 30</option>
                                <option value="net60">Net 60</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between pt-1 border-t border-slate-100">
                            <label for="mark_as_paid" class="text-sm font-semibold text-slate-700 cursor-pointer">Mark as paid</label>
                            <button type="button" id="mark-paid-toggle" role="switch" aria-checked="false"
                                onclick="toggleMarkPaid(this)"
                                class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-slate-200 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <span class="pointer-events-none inline-block h-5 w-5 translate-x-0 rounded-full bg-white shadow-sm transition-transform duration-200 ring-0"></span>
                            </button>
                            <input type="hidden" id="mark_as_paid" name="mark_as_paid" value="0">
                        </div>
                    </div>
                </div>

                {{-- Tags Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Tags</h3>
                    <div id="tags-container" class="flex flex-wrap gap-1.5 mb-3"></div>
                    <div class="flex items-center gap-2">
                        <input type="text" id="tag-input" placeholder="Add a tag..."
                            class="flex-1 min-w-0 px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all"
                            onkeydown="handleTagInput(event)">
                        <button type="button" onclick="addTag(document.getElementById('tag-input').value)"
                            class="px-3.5 py-2 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition-all">
                            Add
                        </button>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Press Enter to add a tag</p>
                    <input type="hidden" name="tags" id="tags-hidden" value="">
                </div>

                {{-- Assign To Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Assign to</h3>
                    <select name="assigned_to"
                        class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-slate-700 transition-all">
                        <option value="">Unassigned</option>
                        <option value="1">John Doe</option>
                        <option value="2">Sarah Kim</option>
                        <option value="3">Marcus Lee</option>
                        <option value="4">Emily Chen</option>
                        <option value="5">David Park</option>
                    </select>
                    <p class="text-xs text-slate-400 mt-2.5 flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        The assigned team member will be notified.
                    </p>
                </div>

            </div>

        </div>

    </form>

</div>

<script>
    // ─────────────────────────────────────────
    // Order items: add / remove rows, recalc
    // ─────────────────────────────────────────
    let rowIndex = 2;

    function addOrderRow() {
        const tbody = document.getElementById('order-items-body');
        const row = document.createElement('tr');
        row.className = 'order-item-row hover:bg-slate-50/50 transition-colors';
        row.innerHTML = `
            <td class="px-5 py-3.5">
                <input type="text" name="items[${rowIndex}][product]" placeholder="Product name or SKU"
                    class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all">
            </td>
            <td class="px-5 py-3.5">
                <input type="number" name="items[${rowIndex}][qty]" value="1" min="1"
                    class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-right bg-slate-50 focus:bg-white item-qty transition-all"
                    oninput="recalcRow(this)">
            </td>
            <td class="px-5 py-3.5">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-xs pointer-events-none font-medium">$</span>
                    <input type="number" name="items[${rowIndex}][unit_price]" value="0.00" min="0" step="0.01"
                        class="w-full pl-7 pr-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-right bg-slate-50 focus:bg-white item-price transition-all"
                        oninput="recalcRow(this)">
                </div>
            </td>
            <td class="px-5 py-3.5 text-right">
                <span class="text-sm font-bold text-slate-900 item-total">$0.00</span>
            </td>
            <td class="px-5 py-3.5 text-center">
                <button type="button" onclick="removeOrderRow(this)" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all mx-auto">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </td>
        `;
        tbody.appendChild(row);
        rowIndex++;
        recalcTotals();
    }

    function removeOrderRow(btn) {
        const row = btn.closest('tr.order-item-row');
        if (document.querySelectorAll('tr.order-item-row').length > 1) {
            row.remove();
            recalcTotals();
        }
    }

    function recalcRow(input) {
        const row = input.closest('tr.order-item-row');
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        const total = qty * price;
        row.querySelector('.item-total').textContent = '$' + total.toFixed(2);
        recalcTotals();
    }

    function recalcTotals() {
        let subtotal = 0;
        document.querySelectorAll('tr.order-item-row').forEach(function(row) {
            const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            subtotal += qty * price;
        });

        document.getElementById('subtotal-display').textContent = '$' + subtotal.toFixed(2);

        const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
        const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
        const shipping = parseFloat(document.getElementById('shipping_cost').value) || 0;

        const afterDiscount = Math.max(0, subtotal - discount);
        const tax = afterDiscount * (taxRate / 100);
        const total = afterDiscount + tax + shipping;

        document.getElementById('total-display').textContent = '$' + total.toFixed(2);
    }

    // ─────────────────────────────────────────
    // Mark as paid toggle
    // ─────────────────────────────────────────
    function toggleMarkPaid(btn) {
        const isActive = btn.getAttribute('aria-checked') === 'true';
        btn.setAttribute('aria-checked', !isActive);
        const span = btn.querySelector('span');
        if (!isActive) {
            btn.classList.remove('bg-slate-200');
            btn.classList.add('bg-indigo-600');
            span.classList.remove('translate-x-0');
            span.classList.add('translate-x-5');
            document.getElementById('mark_as_paid').value = '1';
        } else {
            btn.classList.add('bg-slate-200');
            btn.classList.remove('bg-indigo-600');
            span.classList.add('translate-x-0');
            span.classList.remove('translate-x-5');
            document.getElementById('mark_as_paid').value = '0';
        }
    }

    // ─────────────────────────────────────────
    // Tags
    // ─────────────────────────────────────────
    const tags = [];

    function handleTagInput(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            addTag(event.target.value);
        }
    }

    function addTag(value) {
        const tagValue = value.trim().toLowerCase().replace(/\s+/g, '-');
        if (!tagValue || tags.includes(tagValue)) {
            return;
        }
        tags.push(tagValue);
        renderTags();
        document.getElementById('tag-input').value = '';
    }

    function removeTag(index) {
        tags.splice(index, 1);
        renderTags();
    }

    function renderTags() {
        const container = document.getElementById('tags-container');
        container.innerHTML = '';
        tags.forEach(function(tag, index) {
            const span = document.createElement('span');
            span.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100';
            span.innerHTML = tag + ' <button type="button" onclick="removeTag(' + index + ')" class="text-indigo-400 hover:text-indigo-700 leading-none transition-colors">×</button>';
            container.appendChild(span);
        });
        document.getElementById('tags-hidden').value = tags.join(',');
    }
</script>
</x-layouts.app>

<x-layouts.app title="New Order">
<div class="max-w-full">

    <!-- Page header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="#" class="p-2 rounded-md hover:bg-zinc-100 text-zinc-500 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <p class="text-xs text-zinc-400 mb-0.5">
                    <a href="#" class="hover:text-zinc-600 transition-colors">Orders</a>
                    <span class="mx-1.5">›</span>
                    <span class="text-zinc-600">New Order</span>
                </p>
                <h1 class="text-xl font-semibold text-zinc-900">New Order</h1>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" class="px-4 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-700 font-medium transition-colors">
                Save Draft
            </button>
            <button type="submit" form="create-order-form" class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                Create Order
            </button>
        </div>
    </div>

    <form id="create-order-form" action="#" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT: 2/3 -->
            <div class="lg:col-span-2 space-y-5">

                <!-- Customer card -->
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-zinc-900 mb-4">Customer</h3>
                    <div class="space-y-3">
                        <div>
                            <label for="customer_search" class="block text-xs font-medium text-zinc-700 mb-1.5">Select or create customer</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="customer_search"
                                    name="customer_search"
                                    placeholder="Search by name, email, or company..."
                                    class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white placeholder:text-zinc-400"
                                >
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex-1 h-px bg-zinc-200"></div>
                            <span class="text-xs text-zinc-400">or</span>
                            <div class="flex-1 h-px bg-zinc-200"></div>
                        </div>
                        <button type="button" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm border border-dashed border-zinc-300 rounded-md text-zinc-600 hover:bg-zinc-50 hover:border-zinc-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Create new customer
                        </button>
                    </div>
                </div>

                <!-- Order Items card -->
                <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-100">
                        <h3 class="text-sm font-semibold text-zinc-900">Order Items</h3>
                    </div>

                    <div id="order-items-table-wrapper" class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-zinc-50 border-b border-zinc-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Product</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider w-20">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider w-28">Unit Price</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider w-28">Total</th>
                                    <th class="px-4 py-3 w-10"></th>
                                </tr>
                            </thead>
                            <tbody id="order-items-body" class="divide-y divide-zinc-100">

                                <!-- Pre-filled row 1 -->
                                <tr class="order-item-row">
                                    <td class="px-4 py-3">
                                        <input
                                            type="text"
                                            name="items[0][product]"
                                            value="Enterprise Suite License"
                                            placeholder="Product name or SKU"
                                            class="w-full px-3 py-1.5 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <input
                                            type="number"
                                            name="items[0][qty]"
                                            value="1"
                                            min="1"
                                            class="w-full px-3 py-1.5 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-right item-qty"
                                            oninput="recalcRow(this)"
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400 text-sm pointer-events-none">$</span>
                                            <input
                                                type="number"
                                                name="items[0][unit_price]"
                                                value="350.00"
                                                min="0"
                                                step="0.01"
                                                class="w-full pl-6 pr-3 py-1.5 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-right item-price"
                                                oninput="recalcRow(this)"
                                            >
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <span class="text-sm font-medium text-zinc-900 item-total">$350.00</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button" onclick="removeOrderRow(this)" class="p-1 rounded text-zinc-300 hover:text-red-500 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Pre-filled row 2 -->
                                <tr class="order-item-row">
                                    <td class="px-4 py-3">
                                        <input
                                            type="text"
                                            name="items[1][product]"
                                            value="Pro Add-on Bundle"
                                            placeholder="Product name or SKU"
                                            class="w-full px-3 py-1.5 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <input
                                            type="number"
                                            name="items[1][qty]"
                                            value="2"
                                            min="1"
                                            class="w-full px-3 py-1.5 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-right item-qty"
                                            oninput="recalcRow(this)"
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400 text-sm pointer-events-none">$</span>
                                            <input
                                                type="number"
                                                name="items[1][unit_price]"
                                                value="220.00"
                                                min="0"
                                                step="0.01"
                                                class="w-full pl-6 pr-3 py-1.5 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-right item-price"
                                                oninput="recalcRow(this)"
                                            >
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <span class="text-sm font-medium text-zinc-900 item-total">$440.00</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button" onclick="removeOrderRow(this)" class="p-1 rounded text-zinc-300 hover:text-red-500 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Add item button -->
                    <div class="px-4 py-3 border-t border-zinc-100">
                        <button type="button" id="add-item-btn" onclick="addOrderRow()" class="flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add item
                        </button>
                    </div>

                    <!-- Totals -->
                    <div class="px-6 py-4 border-t border-zinc-200 bg-zinc-50 space-y-2">
                        <div class="flex items-center justify-between gap-4 text-sm">
                            <span class="text-zinc-600">Subtotal</span>
                            <span id="subtotal-display" class="font-medium text-zinc-900">$790.00</span>
                        </div>
                        <div class="flex items-center justify-between gap-4 text-sm">
                            <label for="discount_amount" class="text-zinc-600">Discount</label>
                            <div class="flex items-center gap-2">
                                <div class="relative w-28">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400 text-xs pointer-events-none">$</span>
                                    <input
                                        type="number"
                                        id="discount_amount"
                                        name="discount_amount"
                                        value="0"
                                        min="0"
                                        step="0.01"
                                        placeholder="0.00"
                                        class="w-full pl-6 pr-3 py-1 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-right bg-white"
                                        oninput="recalcTotals()"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-4 text-sm">
                            <label for="tax_rate" class="text-zinc-600">Tax</label>
                            <select
                                id="tax_rate"
                                name="tax_rate"
                                class="w-28 border border-zinc-300 rounded-md px-3 py-1 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                onchange="recalcTotals()"
                            >
                                <option value="0">0%</option>
                                <option value="5">5%</option>
                                <option value="8">8%</option>
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                                <option value="20">20%</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between gap-4 text-sm">
                            <label for="shipping_cost" class="text-zinc-600">Shipping</label>
                            <div class="relative w-28">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400 text-xs pointer-events-none">$</span>
                                <input
                                    type="number"
                                    id="shipping_cost"
                                    name="shipping_cost"
                                    value="0"
                                    min="0"
                                    step="0.01"
                                    placeholder="0.00"
                                    class="w-full pl-6 pr-3 py-1 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-right bg-white"
                                    oninput="recalcTotals()"
                                >
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-4 pt-2 border-t border-zinc-200 text-sm font-semibold">
                            <span class="text-zinc-900">Total</span>
                            <span id="total-display" class="text-zinc-900">$790.00</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address card -->
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-zinc-900 mb-4">Shipping Address</h3>
                    <div class="space-y-4">

                        <!-- First name / Last name -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-xs font-medium text-zinc-700 mb-1.5">First name</label>
                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    placeholder="Jane"
                                    class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                                >
                            </div>
                            <div>
                                <label for="last_name" class="block text-xs font-medium text-zinc-700 mb-1.5">Last name</label>
                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    placeholder="Smith"
                                    class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                                >
                            </div>
                        </div>

                        <!-- Company -->
                        <div>
                            <label for="company" class="block text-xs font-medium text-zinc-700 mb-1.5">
                                Company
                                <span class="text-zinc-400 font-normal">(optional)</span>
                            </label>
                            <input
                                type="text"
                                id="company"
                                name="company"
                                placeholder="Acme Corp"
                                class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                            >
                        </div>

                        <!-- Address line 1 -->
                        <div>
                            <label for="address_line1" class="block text-xs font-medium text-zinc-700 mb-1.5">Address line 1</label>
                            <input
                                type="text"
                                id="address_line1"
                                name="address_line1"
                                placeholder="123 Business Ave, Suite 400"
                                class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                            >
                        </div>

                        <!-- Address line 2 -->
                        <div>
                            <label for="address_line2" class="block text-xs font-medium text-zinc-700 mb-1.5">
                                Address line 2
                                <span class="text-zinc-400 font-normal">(optional)</span>
                            </label>
                            <input
                                type="text"
                                id="address_line2"
                                name="address_line2"
                                placeholder="Floor, unit, building..."
                                class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                            >
                        </div>

                        <!-- City / State / ZIP -->
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-xs font-medium text-zinc-700 mb-1.5">City</label>
                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    placeholder="San Francisco"
                                    class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                                >
                            </div>
                            <div>
                                <label for="state" class="block text-xs font-medium text-zinc-700 mb-1.5">State / Province</label>
                                <input
                                    type="text"
                                    id="state"
                                    name="state"
                                    placeholder="CA"
                                    class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                                >
                            </div>
                            <div>
                                <label for="postal_code" class="block text-xs font-medium text-zinc-700 mb-1.5">ZIP / Postal code</label>
                                <input
                                    type="text"
                                    id="postal_code"
                                    name="postal_code"
                                    placeholder="94105"
                                    class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                                >
                            </div>
                        </div>

                        <!-- Country -->
                        <div>
                            <label for="country" class="block text-xs font-medium text-zinc-700 mb-1.5">Country</label>
                            <select
                                id="country"
                                name="country"
                                class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white text-zinc-700"
                            >
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

                <!-- Notes card -->
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-zinc-900 mb-4">Notes</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="internal_notes" class="block text-xs font-medium text-zinc-700 mb-1.5">
                                Internal notes
                                <span class="text-zinc-400 font-normal">— not visible to customer</span>
                            </label>
                            <textarea
                                id="internal_notes"
                                name="internal_notes"
                                rows="3"
                                placeholder="Add internal notes about this order (warehouse instructions, special handling, etc.)..."
                                class="w-full border border-zinc-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none placeholder:text-zinc-400"
                            ></textarea>
                        </div>
                        <div>
                            <label for="customer_note" class="block text-xs font-medium text-zinc-700 mb-1.5">
                                Note to customer
                                <span class="text-zinc-400 font-normal">— included in confirmation email</span>
                            </label>
                            <textarea
                                id="customer_note"
                                name="customer_note"
                                rows="3"
                                placeholder="Thank you for your order! We'll process it within 1-2 business days..."
                                class="w-full border border-zinc-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none placeholder:text-zinc-400"
                            ></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDEBAR: 1/3 -->
            <div class="space-y-5">

                <!-- Status card -->
                <div class="bg-white border border-zinc-200 rounded-xl p-5">
                    <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Status</h3>
                    <select
                        name="status"
                        class="w-full border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-zinc-700"
                    >
                        <option value="pending" selected>Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Payment card -->
                <div class="bg-white border border-zinc-200 rounded-xl p-5">
                    <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Payment</h3>
                    <div class="space-y-3">
                        <div>
                            <label for="payment_method" class="block text-xs font-medium text-zinc-700 mb-1.5">Payment method</label>
                            <select
                                id="payment_method"
                                name="payment_method"
                                class="w-full border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-zinc-700"
                            >
                                <option value="invoice">Invoice</option>
                                <option value="stripe">Stripe</option>
                                <option value="bank_transfer">Bank transfer</option>
                                <option value="cash">Cash</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="payment_terms" class="block text-xs font-medium text-zinc-700 mb-1.5">Payment terms</label>
                            <select
                                id="payment_terms"
                                name="payment_terms"
                                class="w-full border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-zinc-700"
                            >
                                <option value="immediate">Due immediately</option>
                                <option value="net15">Net 15</option>
                                <option value="net30" selected>Net 30</option>
                                <option value="net60">Net 60</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <label for="mark_as_paid" class="text-sm font-medium text-zinc-700 cursor-pointer">Mark as paid</label>
                            <button
                                type="button"
                                id="mark-paid-toggle"
                                role="switch"
                                aria-checked="false"
                                onclick="toggleMarkPaid(this)"
                                class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-zinc-200 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                            >
                                <span class="pointer-events-none inline-block h-4 w-4 translate-x-0 rounded-full bg-white shadow-sm transition-transform duration-200"></span>
                            </button>
                            <input type="hidden" id="mark_as_paid" name="mark_as_paid" value="0">
                        </div>
                    </div>
                </div>

                <!-- Tags card -->
                <div class="bg-white border border-zinc-200 rounded-xl p-5">
                    <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Tags</h3>
                    <div id="tags-container" class="flex flex-wrap gap-1.5 mb-2"></div>
                    <div class="flex items-center gap-2">
                        <input
                            type="text"
                            id="tag-input"
                            placeholder="Add a tag..."
                            class="flex-1 min-w-0 px-3 py-1.5 text-xs border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                            onkeydown="handleTagInput(event)"
                        >
                        <button
                            type="button"
                            onclick="addTag(document.getElementById('tag-input').value)"
                            class="px-3 py-1.5 text-xs bg-zinc-100 hover:bg-zinc-200 text-zinc-700 rounded-md font-medium transition-colors"
                        >
                            Add
                        </button>
                    </div>
                    <p class="text-xs text-zinc-400 mt-1.5">Press Enter to add a tag</p>
                    <input type="hidden" name="tags" id="tags-hidden" value="">
                </div>

                <!-- Assign to card -->
                <div class="bg-white border border-zinc-200 rounded-xl p-5">
                    <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Assign to</h3>
                    <select
                        name="assigned_to"
                        class="w-full border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-zinc-700"
                    >
                        <option value="">Unassigned</option>
                        <option value="1">John Doe</option>
                        <option value="2">Sarah Kim</option>
                        <option value="3">Marcus Lee</option>
                        <option value="4">Emily Chen</option>
                        <option value="5">David Park</option>
                    </select>
                    <p class="text-xs text-zinc-400 mt-2">The assigned team member will be notified.</p>
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
        row.className = 'order-item-row';
        row.innerHTML = `
            <td class="px-4 py-3">
                <input
                    type="text"
                    name="items[${rowIndex}][product]"
                    placeholder="Product name or SKU"
                    class="w-full px-3 py-1.5 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder:text-zinc-400"
                >
            </td>
            <td class="px-4 py-3">
                <input
                    type="number"
                    name="items[${rowIndex}][qty]"
                    value="1"
                    min="1"
                    class="w-full px-3 py-1.5 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-right item-qty"
                    oninput="recalcRow(this)"
                >
            </td>
            <td class="px-4 py-3">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400 text-sm pointer-events-none">$</span>
                    <input
                        type="number"
                        name="items[${rowIndex}][unit_price]"
                        value="0.00"
                        min="0"
                        step="0.01"
                        class="w-full pl-6 pr-3 py-1.5 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-right item-price"
                        oninput="recalcRow(this)"
                    >
                </div>
            </td>
            <td class="px-4 py-3 text-right">
                <span class="text-sm font-medium text-zinc-900 item-total">$0.00</span>
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" onclick="removeOrderRow(this)" class="p-1 rounded text-zinc-300 hover:text-red-500 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
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
            btn.classList.remove('bg-zinc-200');
            btn.classList.add('bg-indigo-600');
            span.classList.remove('translate-x-0');
            span.classList.add('translate-x-4');
            document.getElementById('mark_as_paid').value = '1';
        } else {
            btn.classList.add('bg-zinc-200');
            btn.classList.remove('bg-indigo-600');
            span.classList.add('translate-x-0');
            span.classList.remove('translate-x-4');
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
            span.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-indigo-50 text-indigo-700 border border-indigo-100';
            span.innerHTML = tag + ' <button type="button" onclick="removeTag(' + index + ')" class="text-indigo-400 hover:text-indigo-600 leading-none">×</button>';
            container.appendChild(span);
        });
        document.getElementById('tags-hidden').value = tags.join(',');
    }
</script>
</x-layouts.app>

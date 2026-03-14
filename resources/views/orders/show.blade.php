<x-layouts.app title="Order #ORD-0284">
<div class="max-w-full">

    <!-- Page header -->
    <div class="flex items-start justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="#" class="p-2 rounded-md hover:bg-zinc-100 text-zinc-500 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-xl font-semibold text-zinc-900">#ORD-0284</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-50 text-green-700">Delivered</span>
                </div>
                <p class="text-sm text-zinc-500 mt-0.5">Placed March 14, 2026 at 9:42 AM</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button class="flex items-center gap-2 px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print
            </button>
            <button class="flex items-center gap-2 px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Email customer
            </button>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-700 transition-colors">
                    More
                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate order</a>
                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Edit order</a>
                    <div class="border-t border-zinc-100 my-1"></div>
                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Two-column layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT: 2/3 -->
        <div class="lg:col-span-2 space-y-5">

            <!-- Order Items card -->
            <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-100">
                    <h3 class="text-sm font-semibold text-zinc-900">Order Items</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 border-b border-zinc-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">Unit price</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-zinc-100 flex items-center justify-center text-zinc-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-zinc-900">Enterprise Suite License</p>
                                        <p class="text-xs text-zinc-400 mt-0.5">SKU: ENT-LIC-001</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-zinc-700">$350.00</td>
                            <td class="px-6 py-4 text-right text-zinc-700">2</td>
                            <td class="px-6 py-4 text-right font-medium text-zinc-900">$700.00</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-zinc-100 flex items-center justify-center text-zinc-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-zinc-900">Pro Add-on Bundle</p>
                                        <p class="text-xs text-zinc-400 mt-0.5">SKU: PRO-ADD-003</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-zinc-700">$440.00</td>
                            <td class="px-6 py-4 text-right text-zinc-700">1</td>
                            <td class="px-6 py-4 text-right font-medium text-zinc-900">$440.00</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-zinc-100 flex items-center justify-center text-zinc-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-zinc-900">Priority Support (10hrs)</p>
                                        <p class="text-xs text-zinc-400 mt-0.5">SKU: SUP-PRI-010</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-zinc-700">$100.00</td>
                            <td class="px-6 py-4 text-right text-zinc-700">1</td>
                            <td class="px-6 py-4 text-right font-medium text-zinc-900">$100.00</td>
                        </tr>
                    </tbody>
                </table>
                <!-- Order totals -->
                <div class="px-6 py-4 border-t border-zinc-100 space-y-1.5">
                    <div class="flex justify-between text-sm text-zinc-600"><span>Subtotal</span><span>$1,240.00</span></div>
                    <div class="flex justify-between text-sm text-zinc-600"><span>Shipping</span><span>Free</span></div>
                    <div class="flex justify-between text-sm text-zinc-600"><span>Tax (0%)</span><span>$0.00</span></div>
                    <div class="flex justify-between text-sm font-semibold text-zinc-900 pt-1.5 border-t border-zinc-100"><span>Total</span><span>$1,240.00</span></div>
                </div>
            </div>

            <!-- Shipping details card -->
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-zinc-900 mb-4">Shipping Details</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-2">Ship to</p>
                        <p class="text-sm text-zinc-800">Sarah Kim</p>
                        <p class="text-sm text-zinc-600">Acme Corp</p>
                        <p class="text-sm text-zinc-600">123 Business Ave, Suite 400</p>
                        <p class="text-sm text-zinc-600">San Francisco, CA 94105</p>
                        <p class="text-sm text-zinc-600">United States</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-2">Shipping method</p>
                        <p class="text-sm text-zinc-800 font-medium">FedEx Express</p>
                        <p class="text-sm text-zinc-600">Estimated 2-3 business days</p>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-2 mt-4">Tracking</p>
                        <a href="#" class="text-sm text-indigo-600 hover:text-indigo-700 font-mono">794644782798</a>
                    </div>
                </div>
            </div>

            <!-- Fulfillment timeline -->
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-zinc-900 mb-4">Fulfillment Timeline</h3>
                <div class="relative">
                    <div class="absolute left-3.5 top-0 h-full w-px bg-zinc-100"></div>
                    <div class="space-y-4">
                        <div class="relative flex gap-4">
                            <div class="relative z-10 w-7 h-7 rounded-full bg-green-500 border-2 border-white flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="flex-1 pb-4">
                                <p class="text-sm font-medium text-zinc-900">Order delivered</p>
                                <p class="text-xs text-zinc-500 mt-0.5">Mar 14, 2026 at 2:15 PM · Signed by Sarah Kim</p>
                            </div>
                        </div>
                        <div class="relative flex gap-4">
                            <div class="relative z-10 w-7 h-7 rounded-full bg-purple-500 border-2 border-white flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                            </div>
                            <div class="flex-1 pb-4">
                                <p class="text-sm font-medium text-zinc-900">Order shipped</p>
                                <p class="text-xs text-zinc-500 mt-0.5">Mar 13, 2026 at 10:30 AM · FedEx tracking: 794644782798</p>
                            </div>
                        </div>
                        <div class="relative flex gap-4">
                            <div class="relative z-10 w-7 h-7 rounded-full bg-blue-500 border-2 border-white flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div class="flex-1 pb-4">
                                <p class="text-sm font-medium text-zinc-900">Order confirmed</p>
                                <p class="text-xs text-zinc-500 mt-0.5">Mar 12, 2026 at 3:00 PM · Auto-confirmed after payment</p>
                            </div>
                        </div>
                        <div class="relative flex gap-4">
                            <div class="relative z-10 w-7 h-7 rounded-full bg-zinc-400 border-2 border-white flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-zinc-900">Order created</p>
                                <p class="text-xs text-zinc-500 mt-0.5">Mar 12, 2026 at 9:42 AM · Created by Sarah Kim</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes / Internal comments -->
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-zinc-900 mb-4">Notes</h3>
                <div class="space-y-3 mb-4">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600 shrink-0">JD</div>
                        <div class="flex-1 bg-zinc-50 rounded-lg p-3">
                            <p class="text-xs font-medium text-zinc-700">John Doe <span class="font-normal text-zinc-400">· Mar 12, 2026</span></p>
                            <p class="text-sm text-zinc-600 mt-1">Customer requested expedited shipping. FedEx Express selected.</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="w-7 h-7 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-bold text-white shrink-0">JD</div>
                    <div class="flex-1">
                        <textarea placeholder="Add an internal note..." rows="2" class="w-full border border-zinc-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none placeholder:text-zinc-400"></textarea>
                        <button class="mt-2 px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-md hover:bg-indigo-700 transition-colors">Add note</button>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT SIDEBAR: 1/3 -->
        <div class="space-y-5">

            <!-- Status card -->
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Order Status</h3>
                <select class="w-full border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option>Pending</option>
                    <option>Confirmed</option>
                    <option>Processing</option>
                    <option>Shipped</option>
                    <option selected>Delivered</option>
                    <option>Cancelled</option>
                    <option>Refunded</option>
                </select>
                <button class="w-full mt-2 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">Update status</button>
            </div>

            <!-- Customer card -->
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Customer</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-sm font-bold text-blue-600 shrink-0">AC</div>
                    <div>
                        <p class="text-sm font-semibold text-zinc-900">Acme Corp</p>
                        <p class="text-xs text-zinc-500">Customer since Jan 2024</p>
                    </div>
                </div>
                <div class="mt-3 space-y-1.5 text-sm">
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Contact</span>
                        <span class="text-zinc-800">Sarah Kim</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Email</span>
                        <a href="#" class="text-indigo-600 hover:text-indigo-700">sarah@acmecorp.com</a>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Orders</span>
                        <span class="text-zinc-800">14 total</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Spent</span>
                        <span class="text-zinc-800">$18,420</span>
                    </div>
                </div>
                <a href="#" class="mt-3 block text-center text-xs text-indigo-600 hover:text-indigo-700 font-medium">View customer profile →</a>
            </div>

            <!-- Payment card -->
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Payment</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Status</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Paid</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Method</span>
                        <span class="text-zinc-800">Visa •••• 4242</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Amount</span>
                        <span class="font-semibold text-zinc-900">$1,240.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Paid on</span>
                        <span class="text-zinc-800">Mar 12, 2026</span>
                    </div>
                </div>
                <button class="mt-3 w-full py-1.5 text-xs text-zinc-600 border border-zinc-300 rounded-md hover:bg-zinc-50 transition-colors">Issue refund</button>
            </div>

            <!-- Tags card -->
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Tags</h3>
                    <button class="text-xs text-indigo-600 hover:text-indigo-700">+ Add</button>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-indigo-50 text-indigo-700 border border-indigo-100">
                        enterprise
                        <button class="text-indigo-400 hover:text-indigo-600 leading-none">×</button>
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-zinc-100 text-zinc-600">
                        expedited
                        <button class="text-zinc-400 hover:text-zinc-600 leading-none">×</button>
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-zinc-100 text-zinc-600">
                        q1-2026
                        <button class="text-zinc-400 hover:text-zinc-600 leading-none">×</button>
                    </span>
                </div>
            </div>

        </div>
    </div>

</div>
</x-layouts.app>

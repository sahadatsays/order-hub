<x-layouts.app title="Settings — Billing">
<div class="max-w-5xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Settings</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account and organisation settings.</p>
    </div>

    <div class="flex gap-8">

        {{-- LEFT: Settings sidebar nav --}}
        @include('settings.partials.sidebar')

        {{-- RIGHT: Billing content --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- SECTION: Current Plan --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Current Plan</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Your subscription details and usage.</p>
                </div>

                {{-- Plan hero row --}}
                <div class="flex items-start justify-between gap-4 p-4 rounded-xl bg-indigo-50 border border-indigo-100 mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-600 text-white">
                                Growth Plan
                            </span>
                        </div>
                        <p class="text-2xl font-bold text-zinc-900 mt-2">$79<span class="text-base font-normal text-zinc-500">/month</span></p>
                        <p class="text-xs text-zinc-500 mt-1">Renews March 14, 2027 &middot; Billed monthly</p>
                    </div>
                    <button type="button" class="shrink-0 px-3 py-1.5 text-sm border border-indigo-200 text-indigo-700 font-medium rounded-md hover:bg-indigo-100 transition-colors bg-white">
                        Upgrade to Enterprise
                    </button>
                </div>

                {{-- Feature list --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-6">
                    @foreach(['5,000 orders / month', '10 team members', 'Advanced analytics', 'All integrations', 'Priority support'] as $feature)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <span class="text-sm text-zinc-700">{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Usage bars --}}
                <div class="border-t border-zinc-100 pt-5 space-y-4">
                    <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Usage this month</h3>

                    {{-- Orders usage --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm text-zinc-700">Orders</span>
                            <span class="text-xs text-zinc-500">1,284 / 5,000</span>
                        </div>
                        <div class="h-2 bg-zinc-100 rounded-full overflow-hidden">
                            <div class="h-2 rounded-full bg-green-500 transition-all" style="width: 25.68%"></div>
                        </div>
                        <p class="text-xs text-zinc-400 mt-1">25% used &middot; 3,716 remaining</p>
                    </div>

                    {{-- Team members usage --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm text-zinc-700">Team members</span>
                            <span class="text-xs text-zinc-500">4 / 10</span>
                        </div>
                        <div class="h-2 bg-zinc-100 rounded-full overflow-hidden">
                            <div class="h-2 rounded-full bg-green-500 transition-all" style="width: 40%"></div>
                        </div>
                        <p class="text-xs text-zinc-400 mt-1">40% used &middot; 6 seats remaining</p>
                    </div>
                </div>

                <div class="mt-5 pt-5 border-t border-zinc-100 flex items-center justify-between">
                    <button type="button" class="text-sm text-red-600 hover:text-red-700 font-medium">
                        Cancel subscription
                    </button>
                    <button type="button" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                        Upgrade plan
                    </button>
                </div>
            </div>

            {{-- SECTION: Payment Method --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Payment Method</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Your default card used for subscription payments.</p>
                </div>

                {{-- Card display --}}
                <div class="flex items-center gap-4 p-4 rounded-lg border border-zinc-200 bg-zinc-50">
                    {{-- Card brand icon --}}
                    <div class="w-12 h-8 bg-white border border-zinc-200 rounded-md flex items-center justify-center shrink-0">
                        <span class="text-xs font-bold text-blue-700 tracking-tight">VISA</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-zinc-800">Visa ending in 4242</p>
                        <p class="text-xs text-zinc-400 mt-0.5">Expires 12/27 &middot; Default card</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-200 shrink-0">
                        Active
                    </span>
                </div>

                <div class="mt-4 flex items-center gap-3">
                    <button type="button" class="px-3 py-1.5 text-sm border border-zinc-300 rounded-md hover:bg-zinc-50 text-zinc-700 font-medium transition-colors">
                        Update payment method
                    </button>
                    <button type="button" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        + Add backup card
                    </button>
                </div>
            </div>

            {{-- SECTION: Billing History --}}
            <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-zinc-100">
                    <h2 class="text-sm font-semibold text-zinc-900">Billing History</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">All your past invoices and receipts.</p>
                </div>

                <table class="w-full">
                    <thead>
                        <tr class="bg-zinc-50 border-b border-zinc-100">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Invoice</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Date</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Amount</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach([
                            ['INV-006', 'Mar 14, 2026', '$79.00'],
                            ['INV-005', 'Feb 14, 2026', '$79.00'],
                            ['INV-004', 'Jan 14, 2026', '$79.00'],
                            ['INV-003', 'Dec 14, 2025', '$79.00'],
                            ['INV-002', 'Nov 14, 2025', '$79.00'],
                        ] as $invoice)
                            <tr class="hover:bg-zinc-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-zinc-800">{{ $invoice[0] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-zinc-600">{{ $invoice[1] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-zinc-800">{{ $invoice[2] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-200">
                                        Paid
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" class="flex items-center gap-1.5 text-xs text-indigo-600 hover:text-indigo-700 font-medium ml-auto">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Download PDF
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- SECTION: Billing Information --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Billing Information</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">This information appears on your invoices.</p>
                </div>

                <form method="POST" action="{{ route('settings.billing') }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="billing_company">Company name</label>
                        <input
                            type="text"
                            id="billing_company"
                            name="company_name"
                            value="Acme Corporation"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="billing_email">Billing email</label>
                        <input
                            type="email"
                            id="billing_email"
                            name="billing_email"
                            value="billing@acmecorp.com"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                        >
                        <p class="text-xs text-zinc-500 mt-1">Invoices will be sent to this address.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="billing_tax_id">
                            VAT / Tax ID
                            <span class="text-zinc-400 font-normal">(optional)</span>
                        </label>
                        <input
                            type="text"
                            id="billing_tax_id"
                            name="tax_id"
                            placeholder="e.g. GB123456789"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                        >
                        <p class="text-xs text-zinc-500 mt-1">Will appear on your invoices if provided.</p>
                    </div>

                    <div class="border-t border-zinc-100 pt-4">
                        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Billing Address</p>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1" for="billing_address_line1">Address line 1</label>
                                <input
                                    type="text"
                                    id="billing_address_line1"
                                    name="address_line1"
                                    placeholder="123 Main Street"
                                    class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1" for="billing_address_line2">
                                    Address line 2
                                    <span class="text-zinc-400 font-normal">(optional)</span>
                                </label>
                                <input
                                    type="text"
                                    id="billing_address_line2"
                                    name="address_line2"
                                    placeholder="Suite 100"
                                    class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                                >
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 mb-1" for="billing_city">City</label>
                                    <input
                                        type="text"
                                        id="billing_city"
                                        name="city"
                                        placeholder="New York"
                                        class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 mb-1" for="billing_postal">Postal code</label>
                                    <input
                                        type="text"
                                        id="billing_postal"
                                        name="postal_code"
                                        placeholder="10001"
                                        class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1" for="billing_country">Country</label>
                                <select
                                    id="billing_country"
                                    name="country"
                                    class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full bg-white"
                                >
                                    <option value="">Select a country</option>
                                    <option value="BD" selected>Bangladesh</option>
                                    <option value="US">United States</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="CA">Canada</option>
                                    <option value="AU">Australia</option>
                                    <option value="DE">Germany</option>
                                    <option value="FR">France</option>
                                    <option value="SG">Singapore</option>
                                    <option value="IN">India</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                            Save billing info
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</x-layouts.app>

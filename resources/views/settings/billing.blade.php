<x-layouts.app title="Settings — Billing">
<div class="max-w-5xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Settings</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account and organisation settings.</p>
    </div>

    <div class="flex gap-8">

        {{-- LEFT: Settings sidebar nav --}}
        <aside class="w-56 shrink-0">
            <nav class="flex flex-col gap-0.5">
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider px-3 mb-1">Account</p>

                <a href="{{ route('settings.profile') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Profile
                </a>

                <a href="{{ route('settings.security') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Password &amp; Security
                </a>

                <a href="{{ route('settings.notifications') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    Notifications
                </a>

                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider px-3 mb-1 mt-4">Organization</p>

                <a href="{{ route('settings.general') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    General
                </a>

                <a href="{{ route('settings.branding') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                    </svg>
                    Branding
                </a>

                <a href="{{ route('settings.billing') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm bg-zinc-100 text-zinc-900 font-medium">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                    Billing
                </a>

                <a href="{{ route('settings.team') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Team Members
                </a>

                <a href="{{ route('settings.roles') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    Roles &amp; Permissions
                </a>

                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider px-3 mb-1 mt-4">Operations</p>

                <a href="{{ route('settings.orders') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    Order Settings
                </a>

                <a href="{{ route('settings.payment-methods') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Payment Methods
                </a>

                <a href="{{ route('settings.shipping') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    Shipping
                </a>

                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider px-3 mb-1 mt-4">Integrations</p>

                <a href="{{ route('settings.connected-apps') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Connected Apps
                </a>

                <a href="{{ route('settings.api-keys') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                    API Keys
                </a>

                <a href="{{ route('settings.webhooks') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                    </svg>
                    Webhooks
                </a>
            </nav>
        </aside>

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

                <form method="POST" action="{{ route('settings.billing.update') }}" class="space-y-4">
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

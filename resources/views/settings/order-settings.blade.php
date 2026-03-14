<x-layouts.app title="Settings — Order Settings">
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

                <a href="{{ route('settings.billing') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
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

                <a href="{{ route('settings.orders') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm bg-zinc-100 text-zinc-900 font-medium">
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

        {{-- RIGHT: Order Settings content --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- SECTION 1: Order Numbering --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Order Numbering</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Configure how order numbers are generated.</p>
                </div>

                <form method="POST" action="{{ route('settings.orders.update') }}" id="numbering-form" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1" for="order_prefix">Prefix</label>
                            <input
                                type="text"
                                id="order_prefix"
                                name="order_prefix"
                                value="ORD-"
                                maxlength="10"
                                class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full font-mono"
                                oninput="updateOrderPreview()"
                            >
                            <p class="text-xs text-zinc-500 mt-1">Appears before the order number.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1" for="order_starting_number">Starting number</label>
                            <input
                                type="number"
                                id="order_starting_number"
                                name="starting_number"
                                value="1"
                                min="1"
                                class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full font-mono"
                                oninput="updateOrderPreview()"
                            >
                            <p class="text-xs text-zinc-500 mt-1">The number assigned to the next new order.</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="order_padding">Number padding</label>
                        <select
                            id="order_padding"
                            name="number_padding"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full bg-white sm:w-1/2"
                            onchange="updateOrderPreview()"
                        >
                            <option value="4" selected>4 digits (e.g. 0001)</option>
                            <option value="5">5 digits (e.g. 00001)</option>
                            <option value="6">6 digits (e.g. 000001)</option>
                        </select>
                        <p class="text-xs text-zinc-500 mt-1">Zero-pads the number to the selected length.</p>
                    </div>

                    {{-- Live preview --}}
                    <div class="p-4 rounded-lg bg-zinc-50 border border-zinc-200">
                        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-2">Preview</p>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-zinc-500">Next order will be:</span>
                            <span id="order-preview" class="text-sm font-semibold text-indigo-600 font-mono">#ORD-0285</span>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                            Save numbering
                        </button>
                    </div>
                </form>
            </div>

            {{-- SECTION 2: Default Order Status --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Default Order Status</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Control the initial state of new orders.</p>
                </div>

                <form method="POST" action="{{ route('settings.orders.update') }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="default_status">New orders start as</label>
                        <select
                            id="default_status"
                            name="default_status"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-1/2 bg-white"
                        >
                            <option value="pending" selected>Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="processing">Processing</option>
                        </select>
                        <p class="text-xs text-zinc-500 mt-1">This status is applied when an order is first created.</p>
                    </div>

                    <div class="border-t border-zinc-100 pt-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-zinc-800">Automatically confirm orders after payment</p>
                                <p class="text-xs text-zinc-500 mt-0.5">When enabled, orders will automatically move to "Confirmed" once payment is received.</p>
                            </div>
                            <div data-toggle-wrapper class="shrink-0 mt-0.5">
                                <button
                                    type="button"
                                    role="switch"
                                    aria-checked="true"
                                    data-checked="true"
                                    class="relative inline-flex shrink-0 cursor-pointer rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-10 h-6 bg-indigo-600"
                                    onclick="
                                        this.dataset.checked = this.dataset.checked === 'true' ? 'false' : 'true';
                                        this.setAttribute('aria-checked', this.dataset.checked);
                                        this.classList.toggle('bg-indigo-600', this.dataset.checked === 'true');
                                        this.classList.toggle('bg-zinc-300', this.dataset.checked !== 'true');
                                        this.querySelector('.toggle-thumb').classList.toggle('translate-x-4', this.dataset.checked === 'true');
                                        this.querySelector('.toggle-thumb').classList.toggle('translate-x-0.5', this.dataset.checked !== 'true');
                                        var hiddenInput = this.closest('[data-toggle-wrapper]') ? this.closest('[data-toggle-wrapper]').querySelector('input[type=hidden]') : null;
                                        if (hiddenInput) { hiddenInput.value = this.dataset.checked === 'true' ? '1' : '0'; }
                                    "
                                >
                                    <span class="toggle-thumb pointer-events-none inline-block w-4 h-4 rounded-full bg-white shadow-sm transition-transform translate-x-4" aria-hidden="true"></span>
                                </button>
                                <input type="hidden" name="auto_confirm_after_payment" value="1" />
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-zinc-100 pt-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-zinc-800">Require manual approval for large orders</p>
                                <p class="text-xs text-zinc-500 mt-0.5">Orders over a set value threshold will remain pending until manually approved.</p>
                            </div>
                            <div data-toggle-wrapper class="shrink-0 mt-0.5">
                                <button
                                    type="button"
                                    role="switch"
                                    aria-checked="false"
                                    data-checked="false"
                                    class="relative inline-flex shrink-0 cursor-pointer rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-10 h-6 bg-zinc-300"
                                    onclick="
                                        this.dataset.checked = this.dataset.checked === 'true' ? 'false' : 'true';
                                        this.setAttribute('aria-checked', this.dataset.checked);
                                        this.classList.toggle('bg-indigo-600', this.dataset.checked === 'true');
                                        this.classList.toggle('bg-zinc-300', this.dataset.checked !== 'true');
                                        this.querySelector('.toggle-thumb').classList.toggle('translate-x-4', this.dataset.checked === 'true');
                                        this.querySelector('.toggle-thumb').classList.toggle('translate-x-0.5', this.dataset.checked !== 'true');
                                        var hiddenInput = this.closest('[data-toggle-wrapper]') ? this.closest('[data-toggle-wrapper]').querySelector('input[type=hidden]') : null;
                                        if (hiddenInput) { hiddenInput.value = this.dataset.checked === 'true' ? '1' : '0'; }
                                    "
                                >
                                    <span class="toggle-thumb pointer-events-none inline-block w-4 h-4 rounded-full bg-white shadow-sm transition-transform translate-x-0.5" aria-hidden="true"></span>
                                </button>
                                <input type="hidden" name="require_approval_large_orders" value="0" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                            Save defaults
                        </button>
                    </div>
                </form>
            </div>

            {{-- SECTION 3: Order Statuses --}}
            <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-5 border-b border-zinc-100">
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900">Order Statuses</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Define the lifecycle stages of your orders.</p>
                    </div>
                </div>

                <div class="divide-y divide-zinc-100">

                    {{-- Pending --}}
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-zinc-50/50 group">
                        <div class="text-zinc-300 cursor-grab group-hover:text-zinc-400 transition-colors shrink-0" title="Drag to reorder">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="9" cy="5" r="1.5"/><circle cx="15" cy="5" r="1.5"/>
                                <circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/>
                                <circle cx="9" cy="19" r="1.5"/><circle cx="15" cy="19" r="1.5"/>
                            </svg>
                        </div>
                        <div class="w-2.5 h-2.5 rounded-full bg-yellow-400 shrink-0"></div>
                        <span class="flex-1 text-sm font-medium text-zinc-800">Pending</span>
                        <span class="text-xs text-zinc-400">Default starting status</span>
                        <button type="button" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 opacity-0 group-hover:opacity-100 transition-all" aria-label="Edit Pending status">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                    </div>

                    {{-- Confirmed --}}
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-zinc-50/50 group">
                        <div class="text-zinc-300 cursor-grab group-hover:text-zinc-400 transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="9" cy="5" r="1.5"/><circle cx="15" cy="5" r="1.5"/>
                                <circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/>
                                <circle cx="9" cy="19" r="1.5"/><circle cx="15" cy="19" r="1.5"/>
                            </svg>
                        </div>
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-500 shrink-0"></div>
                        <span class="flex-1 text-sm font-medium text-zinc-800">Confirmed</span>
                        <span class="text-xs text-zinc-400"></span>
                        <button type="button" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 opacity-0 group-hover:opacity-100 transition-all" aria-label="Edit Confirmed status">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                    </div>

                    {{-- Processing --}}
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-zinc-50/50 group">
                        <div class="text-zinc-300 cursor-grab group-hover:text-zinc-400 transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="9" cy="5" r="1.5"/><circle cx="15" cy="5" r="1.5"/>
                                <circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/>
                                <circle cx="9" cy="19" r="1.5"/><circle cx="15" cy="19" r="1.5"/>
                            </svg>
                        </div>
                        <div class="w-2.5 h-2.5 rounded-full bg-indigo-500 shrink-0"></div>
                        <span class="flex-1 text-sm font-medium text-zinc-800">Processing</span>
                        <span class="text-xs text-zinc-400"></span>
                        <button type="button" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 opacity-0 group-hover:opacity-100 transition-all" aria-label="Edit Processing status">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                    </div>

                    {{-- Shipped --}}
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-zinc-50/50 group">
                        <div class="text-zinc-300 cursor-grab group-hover:text-zinc-400 transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="9" cy="5" r="1.5"/><circle cx="15" cy="5" r="1.5"/>
                                <circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/>
                                <circle cx="9" cy="19" r="1.5"/><circle cx="15" cy="19" r="1.5"/>
                            </svg>
                        </div>
                        <div class="w-2.5 h-2.5 rounded-full bg-purple-500 shrink-0"></div>
                        <span class="flex-1 text-sm font-medium text-zinc-800">Shipped</span>
                        <span class="text-xs text-zinc-400"></span>
                        <button type="button" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 opacity-0 group-hover:opacity-100 transition-all" aria-label="Edit Shipped status">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                    </div>

                    {{-- Delivered --}}
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-zinc-50/50 group">
                        <div class="text-zinc-300 cursor-grab group-hover:text-zinc-400 transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="9" cy="5" r="1.5"/><circle cx="15" cy="5" r="1.5"/>
                                <circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/>
                                <circle cx="9" cy="19" r="1.5"/><circle cx="15" cy="19" r="1.5"/>
                            </svg>
                        </div>
                        <div class="w-2.5 h-2.5 rounded-full bg-green-500 shrink-0"></div>
                        <span class="flex-1 text-sm font-medium text-zinc-800">Delivered</span>
                        <span class="text-xs text-zinc-400">Terminal status</span>
                        <button type="button" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 opacity-0 group-hover:opacity-100 transition-all" aria-label="Edit Delivered status">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                    </div>

                    {{-- Cancelled --}}
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-zinc-50/50 group">
                        <div class="text-zinc-300 cursor-grab group-hover:text-zinc-400 transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="9" cy="5" r="1.5"/><circle cx="15" cy="5" r="1.5"/>
                                <circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/>
                                <circle cx="9" cy="19" r="1.5"/><circle cx="15" cy="19" r="1.5"/>
                            </svg>
                        </div>
                        <div class="w-2.5 h-2.5 rounded-full bg-red-500 shrink-0"></div>
                        <span class="flex-1 text-sm font-medium text-zinc-800">Cancelled</span>
                        <span class="text-xs text-zinc-400">Terminal status</span>
                        <button type="button" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 opacity-0 group-hover:opacity-100 transition-all" aria-label="Edit Cancelled status">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                    </div>

                    {{-- Refunded --}}
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-zinc-50/50 group">
                        <div class="text-zinc-300 cursor-grab group-hover:text-zinc-400 transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="9" cy="5" r="1.5"/><circle cx="15" cy="5" r="1.5"/>
                                <circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/>
                                <circle cx="9" cy="19" r="1.5"/><circle cx="15" cy="19" r="1.5"/>
                            </svg>
                        </div>
                        <div class="w-2.5 h-2.5 rounded-full bg-zinc-400 shrink-0"></div>
                        <span class="flex-1 text-sm font-medium text-zinc-800">Refunded</span>
                        <span class="text-xs text-zinc-400">Terminal status</span>
                        <button type="button" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 opacity-0 group-hover:opacity-100 transition-all" aria-label="Edit Refunded status">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Add custom status --}}
                <div class="px-6 py-4 border-t border-zinc-100">
                    <button type="button" class="flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add custom status
                    </button>
                </div>
            </div>

            {{-- SECTION 4: Order Notifications --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Order Notifications</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Control which events trigger email notifications.</p>
                </div>

                <form method="POST" action="{{ route('settings.orders.update') }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    {{-- Toggle: email customer on confirm --}}
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-zinc-800">Email customer when order is confirmed</p>
                            <p class="text-xs text-zinc-500 mt-0.5">Sends an order confirmation email with details and summary.</p>
                        </div>
                        <div data-toggle-wrapper class="shrink-0 mt-0.5">
                            <button
                                type="button"
                                role="switch"
                                aria-checked="true"
                                data-checked="true"
                                class="relative inline-flex shrink-0 cursor-pointer rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-10 h-6 bg-indigo-600"
                                onclick="
                                    this.dataset.checked = this.dataset.checked === 'true' ? 'false' : 'true';
                                    this.setAttribute('aria-checked', this.dataset.checked);
                                    this.classList.toggle('bg-indigo-600', this.dataset.checked === 'true');
                                    this.classList.toggle('bg-zinc-300', this.dataset.checked !== 'true');
                                    this.querySelector('.toggle-thumb').classList.toggle('translate-x-4', this.dataset.checked === 'true');
                                    this.querySelector('.toggle-thumb').classList.toggle('translate-x-0.5', this.dataset.checked !== 'true');
                                    var hiddenInput = this.closest('[data-toggle-wrapper]') ? this.closest('[data-toggle-wrapper]').querySelector('input[type=hidden]') : null;
                                    if (hiddenInput) { hiddenInput.value = this.dataset.checked === 'true' ? '1' : '0'; }
                                "
                            >
                                <span class="toggle-thumb pointer-events-none inline-block w-4 h-4 rounded-full bg-white shadow-sm transition-transform translate-x-4" aria-hidden="true"></span>
                            </button>
                            <input type="hidden" name="notify_customer_on_confirm" value="1" />
                        </div>
                    </div>

                    <div class="border-t border-zinc-100 pt-5 flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-zinc-800">Email customer when order is shipped</p>
                            <p class="text-xs text-zinc-500 mt-0.5">Sends a shipping notification with tracking information if available.</p>
                        </div>
                        <div data-toggle-wrapper class="shrink-0 mt-0.5">
                            <button
                                type="button"
                                role="switch"
                                aria-checked="true"
                                data-checked="true"
                                class="relative inline-flex shrink-0 cursor-pointer rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-10 h-6 bg-indigo-600"
                                onclick="
                                    this.dataset.checked = this.dataset.checked === 'true' ? 'false' : 'true';
                                    this.setAttribute('aria-checked', this.dataset.checked);
                                    this.classList.toggle('bg-indigo-600', this.dataset.checked === 'true');
                                    this.classList.toggle('bg-zinc-300', this.dataset.checked !== 'true');
                                    this.querySelector('.toggle-thumb').classList.toggle('translate-x-4', this.dataset.checked === 'true');
                                    this.querySelector('.toggle-thumb').classList.toggle('translate-x-0.5', this.dataset.checked !== 'true');
                                    var hiddenInput = this.closest('[data-toggle-wrapper]') ? this.closest('[data-toggle-wrapper]').querySelector('input[type=hidden]') : null;
                                    if (hiddenInput) { hiddenInput.value = this.dataset.checked === 'true' ? '1' : '0'; }
                                "
                            >
                                <span class="toggle-thumb pointer-events-none inline-block w-4 h-4 rounded-full bg-white shadow-sm transition-transform translate-x-4" aria-hidden="true"></span>
                            </button>
                            <input type="hidden" name="notify_customer_on_shipped" value="1" />
                        </div>
                    </div>

                    <div class="border-t border-zinc-100 pt-5 flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-zinc-800">Email customer when order is delivered</p>
                            <p class="text-xs text-zinc-500 mt-0.5">Sends a delivery confirmation and optionally prompts for a review.</p>
                        </div>
                        <div data-toggle-wrapper class="shrink-0 mt-0.5">
                            <button
                                type="button"
                                role="switch"
                                aria-checked="true"
                                data-checked="true"
                                class="relative inline-flex shrink-0 cursor-pointer rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-10 h-6 bg-indigo-600"
                                onclick="
                                    this.dataset.checked = this.dataset.checked === 'true' ? 'false' : 'true';
                                    this.setAttribute('aria-checked', this.dataset.checked);
                                    this.classList.toggle('bg-indigo-600', this.dataset.checked === 'true');
                                    this.classList.toggle('bg-zinc-300', this.dataset.checked !== 'true');
                                    this.querySelector('.toggle-thumb').classList.toggle('translate-x-4', this.dataset.checked === 'true');
                                    this.querySelector('.toggle-thumb').classList.toggle('translate-x-0.5', this.dataset.checked !== 'true');
                                    var hiddenInput = this.closest('[data-toggle-wrapper]') ? this.closest('[data-toggle-wrapper]').querySelector('input[type=hidden]') : null;
                                    if (hiddenInput) { hiddenInput.value = this.dataset.checked === 'true' ? '1' : '0'; }
                                "
                            >
                                <span class="toggle-thumb pointer-events-none inline-block w-4 h-4 rounded-full bg-white shadow-sm transition-transform translate-x-4" aria-hidden="true"></span>
                            </button>
                            <input type="hidden" name="notify_customer_on_delivered" value="1" />
                        </div>
                    </div>

                    <div class="border-t border-zinc-100 pt-5 flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-zinc-800">Notify team when new order is received</p>
                            <p class="text-xs text-zinc-500 mt-0.5">Sends an internal notification to team members with the Order Manager role.</p>
                        </div>
                        <div data-toggle-wrapper class="shrink-0 mt-0.5">
                            <button
                                type="button"
                                role="switch"
                                aria-checked="true"
                                data-checked="true"
                                class="relative inline-flex shrink-0 cursor-pointer rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-10 h-6 bg-indigo-600"
                                onclick="
                                    this.dataset.checked = this.dataset.checked === 'true' ? 'false' : 'true';
                                    this.setAttribute('aria-checked', this.dataset.checked);
                                    this.classList.toggle('bg-indigo-600', this.dataset.checked === 'true');
                                    this.classList.toggle('bg-zinc-300', this.dataset.checked !== 'true');
                                    this.querySelector('.toggle-thumb').classList.toggle('translate-x-4', this.dataset.checked === 'true');
                                    this.querySelector('.toggle-thumb').classList.toggle('translate-x-0.5', this.dataset.checked !== 'true');
                                    var hiddenInput = this.closest('[data-toggle-wrapper]') ? this.closest('[data-toggle-wrapper]').querySelector('input[type=hidden]') : null;
                                    if (hiddenInput) { hiddenInput.value = this.dataset.checked === 'true' ? '1' : '0'; }
                                "
                            >
                                <span class="toggle-thumb pointer-events-none inline-block w-4 h-4 rounded-full bg-white shadow-sm transition-transform translate-x-4" aria-hidden="true"></span>
                            </button>
                            <input type="hidden" name="notify_team_on_new_order" value="1" />
                        </div>
                    </div>

                    <div class="border-t border-zinc-100 pt-5 flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-zinc-800">Alert when order is cancelled</p>
                            <p class="text-xs text-zinc-500 mt-0.5">Sends an alert to the assigned team member when any order is cancelled.</p>
                        </div>
                        <div data-toggle-wrapper class="shrink-0 mt-0.5">
                            <button
                                type="button"
                                role="switch"
                                aria-checked="false"
                                data-checked="false"
                                class="relative inline-flex shrink-0 cursor-pointer rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-10 h-6 bg-zinc-300"
                                onclick="
                                    this.dataset.checked = this.dataset.checked === 'true' ? 'false' : 'true';
                                    this.setAttribute('aria-checked', this.dataset.checked);
                                    this.classList.toggle('bg-indigo-600', this.dataset.checked === 'true');
                                    this.classList.toggle('bg-zinc-300', this.dataset.checked !== 'true');
                                    this.querySelector('.toggle-thumb').classList.toggle('translate-x-4', this.dataset.checked === 'true');
                                    this.querySelector('.toggle-thumb').classList.toggle('translate-x-0.5', this.dataset.checked !== 'true');
                                    var hiddenInput = this.closest('[data-toggle-wrapper]') ? this.closest('[data-toggle-wrapper]').querySelector('input[type=hidden]') : null;
                                    if (hiddenInput) { hiddenInput.value = this.dataset.checked === 'true' ? '1' : '0'; }
                                "
                            >
                                <span class="toggle-thumb pointer-events-none inline-block w-4 h-4 rounded-full bg-white shadow-sm transition-transform translate-x-0.5" aria-hidden="true"></span>
                            </button>
                            <input type="hidden" name="alert_on_cancellation" value="0" />
                        </div>
                    </div>

                    <div class="border-t border-zinc-100 pt-5 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                            Save notification settings
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    function updateOrderPreview() {
        var prefix = document.getElementById('order_prefix').value || '';
        var startingNumber = parseInt(document.getElementById('order_starting_number').value) || 1;
        var padding = parseInt(document.getElementById('order_padding').value) || 4;

        // Simulate showing a realistic next order number (starting + some existing orders)
        var nextNumber = startingNumber + 284;
        var paddedNumber = String(nextNumber).padStart(padding, '0');

        document.getElementById('order-preview').textContent = '#' + prefix + paddedNumber;
    }

    // Initialise preview on load
    document.addEventListener('DOMContentLoaded', function () {
        updateOrderPreview();
    });
</script>
</x-layouts.app>

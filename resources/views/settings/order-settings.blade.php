<x-layouts.app title="Settings — Order Settings">
<div class="max-w-5xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Settings</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account and organisation settings.</p>
    </div>

    <div class="flex gap-8">

        {{-- LEFT: Settings sidebar nav --}}
        @include('settings.partials.sidebar')

        {{-- RIGHT: Order Settings content --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- SECTION 1: Order Numbering --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Order Numbering</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Configure how order numbers are generated.</p>
                </div>

                <form method="POST" action="{{ route('settings.order-settings.update') }}" id="numbering-form" class="space-y-4">
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

                <form method="POST" action="{{ route('settings.order-settings.update') }}" class="space-y-5">
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

                <form method="POST" action="{{ route('settings.order-settings.update') }}" class="space-y-5">
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

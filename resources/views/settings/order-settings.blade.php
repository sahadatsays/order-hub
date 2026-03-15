<x-layouts.app title="Settings — Order Settings">
<div class="max-w-5xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Settings</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account and organisation settings.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- LEFT: Settings sidebar nav --}}
        <x-settings.sidebar />

        {{-- RIGHT: Main content --}}
        <div class="flex-1 min-w-0 space-y-6">

            @if(session('success'))
                <div class="px-4 py-3 bg-green-50 border border-green-200 rounded-md text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('settings.order-settings.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Order Numbering --}}
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <div class="mb-5">
                        <h2 class="text-sm font-semibold text-zinc-900">Order Numbering</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Configure how order numbers are generated.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-ui.input label="Order Prefix" name="order_prefix" :value="old('order_prefix', $orderSettings['order_prefix'])" placeholder="ORD-" :error="$errors->first('order_prefix')" />
                        <x-ui.input label="Sequence Start" name="order_sequence_start" type="number" :value="old('order_sequence_start', $orderSettings['order_sequence_start'])" :error="$errors->first('order_sequence_start')" />
                        <x-ui.input label="Number Padding" name="order_number_padding" type="number" :value="old('order_number_padding', $orderSettings['order_number_padding'])" helper="e.g. 5 → 00001" :error="$errors->first('order_number_padding')" />
                    </div>
                </div>

                {{-- Default Status & Automation --}}
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <div class="mb-5">
                        <h2 class="text-sm font-semibold text-zinc-900">Order Defaults</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Set defaults for new orders and automation rules.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="default_order_status" class="text-sm font-medium text-zinc-700">Default Order Status</label>
                            <select id="default_order_status" name="default_order_status" class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="pending" @selected(old('default_order_status', $orderSettings['default_order_status']) === 'pending')>Pending</option>
                                <option value="confirmed" @selected(old('default_order_status', $orderSettings['default_order_status']) === 'confirmed')>Confirmed</option>
                                <option value="processing" @selected(old('default_order_status', $orderSettings['default_order_status']) === 'processing')>Processing</option>
                            </select>
                            @error('default_order_status')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-3 pt-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="auto_confirm_manual" value="0">
                                <input type="checkbox" name="auto_confirm_manual" value="1" @checked(old('auto_confirm_manual', $orderSettings['auto_confirm_manual'])) class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="text-sm font-medium text-zinc-700">Auto-confirm manual orders</span>
                                    <p class="text-xs text-zinc-500">Automatically confirm orders created manually.</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="auto_confirm_api" value="0">
                                <input type="checkbox" name="auto_confirm_api" value="1" @checked(old('auto_confirm_api', $orderSettings['auto_confirm_api'] ?? false)) class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="text-sm font-medium text-zinc-700">Auto-confirm API orders</span>
                                    <p class="text-xs text-zinc-500">Automatically confirm orders received via API.</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="require_phone" value="0">
                                <input type="checkbox" name="require_phone" value="1" @checked(old('require_phone', $orderSettings['require_phone'] ?? false)) class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="text-sm font-medium text-zinc-700">Require phone number</span>
                                    <p class="text-xs text-zinc-500">Make phone number mandatory on all orders.</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="require_address" value="0">
                                <input type="checkbox" name="require_address" value="1" @checked(old('require_address', $orderSettings['require_address'] ?? false)) class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="text-sm font-medium text-zinc-700">Require address</span>
                                    <p class="text-xs text-zinc-500">Make delivery address mandatory on all orders.</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="allow_partial_delivery" value="0">
                                <input type="checkbox" name="allow_partial_delivery" value="1" @checked(old('allow_partial_delivery', $orderSettings['allow_partial_delivery'] ?? false)) class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="text-sm font-medium text-zinc-700">Allow partial delivery</span>
                                    <p class="text-xs text-zinc-500">Allow orders to be delivered in multiple shipments.</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="track_inventory" value="0">
                                <input type="checkbox" name="track_inventory" value="1" @checked(old('track_inventory', $orderSettings['track_inventory'] ?? false)) class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="text-sm font-medium text-zinc-700">Track inventory</span>
                                    <p class="text-xs text-zinc-500">Automatically adjust stock levels when orders are placed.</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="notify_customer_on_status_change" value="0">
                                <input type="checkbox" name="notify_customer_on_status_change" value="1" @checked(old('notify_customer_on_status_change', $orderSettings['notify_customer_on_status_change'] ?? false)) class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="text-sm font-medium text-zinc-700">Notify customers on status change</span>
                                    <p class="text-xs text-zinc-500">Send email notifications when order status changes.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        Save Order Settings
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
</x-layouts.app>

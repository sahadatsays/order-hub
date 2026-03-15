<x-layouts.app title="Edit Order #{{ $order->order_number }}">
<div class="max-w-5xl mx-auto">

    {{-- Page header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('orders.show', $order) }}" class="p-2 rounded-md hover:bg-zinc-100 text-zinc-500 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <p class="text-xs text-zinc-400 mb-0.5">
                    <a href="{{ route('orders.index') }}" class="hover:text-zinc-600 transition-colors">Orders</a>
                    <span class="mx-1.5">›</span>
                    <a href="{{ route('orders.show', $order) }}" class="hover:text-zinc-600 transition-colors">#{{ $order->order_number }}</a>
                    <span class="mx-1.5">›</span>
                    <span class="text-zinc-600">Edit</span>
                </p>
                <h1 class="text-xl font-semibold text-zinc-900">Edit Order #{{ $order->order_number }}</h1>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('orders.show', $order) }}" class="px-4 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-700 font-medium transition-colors">
                Cancel
            </a>
            <button type="submit" form="edit-order-form" class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                Save Changes
            </button>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <form id="edit-order-form" action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT: 2/3 --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Customer Info --}}
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-zinc-900 mb-4">Customer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="customer_name" class="block text-xs font-medium text-zinc-700 mb-1">Customer Name *</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required
                                   class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('customer_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="customer_phone" class="block text-xs font-medium text-zinc-700 mb-1">Phone</label>
                            <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}"
                                   class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                {{-- Shipping --}}
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-zinc-900 mb-4">Shipping Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label for="shipping_address" class="block text-xs font-medium text-zinc-700 mb-1">Shipping Address</label>
                            <textarea name="shipping_address" id="shipping_address" rows="2"
                                      class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                        </div>
                        <div>
                            <label for="shipping_city" class="block text-xs font-medium text-zinc-700 mb-1">City</label>
                            <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city', $order->shipping_city) }}"
                                   class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                {{-- Order Items (read-only in edit for now) --}}
                <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-100">
                        <h3 class="text-sm font-semibold text-zinc-900">Order Items</h3>
                        <p class="text-xs text-zinc-400 mt-0.5">Line items are displayed for reference. Modify them from the order detail page.</p>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="bg-zinc-50">
                            <tr>
                                <th class="text-left px-6 py-2 text-xs font-medium text-zinc-500">Product</th>
                                <th class="text-center px-3 py-2 text-xs font-medium text-zinc-500">Qty</th>
                                <th class="text-right px-3 py-2 text-xs font-medium text-zinc-500">Price</th>
                                <th class="text-right px-6 py-2 text-xs font-medium text-zinc-500">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr class="border-t border-zinc-100">
                                <td class="px-6 py-3 text-zinc-900 font-medium">{{ $item->product_name }}</td>
                                <td class="text-center px-3 py-3 text-zinc-600">{{ $item->quantity }}</td>
                                <td class="text-right px-3 py-3 text-zinc-600">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-right px-6 py-3 text-zinc-900 font-medium">{{ number_format($item->line_total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Notes --}}
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-zinc-900 mb-4">Notes</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="notes" class="block text-xs font-medium text-zinc-700 mb-1">Customer Notes</label>
                            <textarea name="notes" id="notes" rows="2"
                                      class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('notes', $order->notes) }}</textarea>
                        </div>
                        <div>
                            <label for="internal_notes" class="block text-xs font-medium text-zinc-700 mb-1">Internal Notes</label>
                            <textarea name="internal_notes" id="internal_notes" rows="2"
                                      class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('internal_notes', $order->internal_notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: 1/3 --}}
            <div class="space-y-5">

                {{-- Order Summary --}}
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-zinc-900 mb-4">Order Summary</h3>
                    <div class="space-y-3">
                        <div>
                            <label for="discount_amount" class="block text-xs font-medium text-zinc-700 mb-1">Discount</label>
                            <input type="number" name="discount_amount" id="discount_amount" value="{{ old('discount_amount', $order->discount_amount) }}" min="0" step="0.01"
                                   class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="shipping_charge" class="block text-xs font-medium text-zinc-700 mb-1">Shipping Charge</label>
                            <input type="number" name="shipping_charge" id="shipping_charge" value="{{ old('shipping_charge', $order->shipping_charge) }}" min="0" step="0.01"
                                   class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="border-t border-zinc-100 pt-3 space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-500">Subtotal</span>
                                <span class="font-medium">{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-500">Total</span>
                                <span class="font-bold text-zinc-900">{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-500">Paid</span>
                                <span class="font-medium text-green-600">{{ number_format($order->paid_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-500">Due</span>
                                <span class="font-medium text-red-600">{{ number_format($order->due_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-zinc-900 mb-4">Payment</h3>
                    <div>
                        <label for="payment_method" class="block text-xs font-medium text-zinc-700 mb-1">Payment Method</label>
                        <select name="payment_method" id="payment_method"
                                class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                            <option value="">Select method</option>
                            @foreach(\App\Models\OrderPayment::METHODS as $key => $label)
                                <option value="{{ $key }}" @selected(old('payment_method', $order->payment_method) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    @php
                        $statusColor = match($order->payment_status) {
                            'paid' => 'bg-green-100 text-green-800',
                            'partial' => 'bg-yellow-100 text-yellow-800',
                            'unpaid' => 'bg-red-100 text-red-800',
                            default => 'bg-zinc-100 text-zinc-800',
                        };
                    @endphp
                    <div class="mt-3 flex items-center gap-2">
                        <span class="text-xs font-medium text-zinc-500">Status:</span>
                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                {{-- Status Info --}}
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-zinc-900 mb-3">Status</h3>
                    @php
                        $orderStatusColor = match($order->status) {
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-blue-100 text-blue-800',
                            'processing' => 'bg-indigo-100 text-indigo-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            default => 'bg-zinc-100 text-zinc-800',
                        };
                    @endphp
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $orderStatusColor }}">
                        {{ $order->status_label }}
                    </span>
                    <p class="mt-2 text-xs text-zinc-400">Order status can be changed from the order detail page.</p>
                </div>
            </div>
        </div>
    </form>
</div>
</x-layouts.app>

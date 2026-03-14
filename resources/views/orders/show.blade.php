<x-layouts.app :title="'Order ' . $order->order_number">
<div class="max-w-full">

    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-md text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <!-- Page header -->
    <div class="flex items-start justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('orders.index') }}" class="p-2 rounded-md hover:bg-zinc-100 text-zinc-500 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-xl font-semibold text-zinc-900">{{ $order->order_number }}</h1>
                    <x-ui.badge :color="$order->status_color">{{ $order->status_label }}</x-ui.badge>
                    <x-ui.badge color="zinc">{{ $order->source_label }}</x-ui.badge>
                </div>
                <p class="text-sm text-zinc-500 mt-0.5">Placed {{ $order->ordered_at->format('F d, Y \a\t g:i A') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            {{-- Update status dropdown --}}
            <form action="{{ route('orders.status', $order) }}" method="POST" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <select name="status" class="px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white text-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach(\App\Models\Order::STATUSES as $key => $label)
                    <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">Update Status</button>
            </form>
            <a href="{{ route('orders.edit', $order) }}" class="flex items-center gap-2 px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-700 transition-colors">Edit</a>
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
                        @forelse($order->items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-zinc-100 flex items-center justify-center text-zinc-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-zinc-900">{{ $item->product_name }}</p>
                                        @if($item->product_sku)<p class="text-xs text-zinc-400 mt-0.5 font-mono">SKU: {{ $item->product_sku }}</p>@endif
                                        @if($item->variant)<p class="text-xs text-zinc-500">{{ $item->variant }}</p>@endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-zinc-700 tabular-nums">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-6 py-4 text-right text-zinc-700">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-right font-medium text-zinc-900 tabular-nums">{{ number_format($item->line_total, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-6 text-center text-sm text-zinc-400">No items.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Order totals -->
                <div class="px-6 py-4 border-t border-zinc-100 space-y-1.5">
                    <div class="flex justify-between text-sm text-zinc-600"><span>Subtotal</span><span class="tabular-nums">{{ number_format($order->subtotal, 2) }}</span></div>
                    @if($order->discount_amount > 0)
                    <div class="flex justify-between text-sm text-zinc-600"><span>Discount{{ $order->discount_code ? ' (' . $order->discount_code . ')' : '' }}</span><span class="tabular-nums text-red-600">-{{ number_format($order->discount_amount, 2) }}</span></div>
                    @endif
                    <div class="flex justify-between text-sm text-zinc-600"><span>Shipping</span><span class="tabular-nums">{{ $order->shipping_charge > 0 ? number_format($order->shipping_charge, 2) : 'Free' }}</span></div>
                    @if($order->tax_amount > 0)
                    <div class="flex justify-between text-sm text-zinc-600"><span>Tax</span><span class="tabular-nums">{{ number_format($order->tax_amount, 2) }}</span></div>
                    @endif
                    <div class="flex justify-between text-sm font-semibold text-zinc-900 pt-1.5 border-t border-zinc-100"><span>Total</span><span class="tabular-nums">{{ number_format($order->total_amount, 2) }}</span></div>
                    @if($order->paid_amount > 0)
                    <div class="flex justify-between text-sm text-green-600"><span>Paid</span><span class="tabular-nums">{{ number_format($order->paid_amount, 2) }}</span></div>
                    <div class="flex justify-between text-sm font-medium text-zinc-900"><span>Balance Due</span><span class="tabular-nums">{{ number_format($order->due_amount, 2) }}</span></div>
                    @endif
                </div>
            </div>

            <!-- Shipping details card -->
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-zinc-900 mb-4">Shipping Details</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-2">Ship to</p>
                        <p class="text-sm text-zinc-800 font-medium">{{ $order->customer_name }}</p>
                        @if($order->customer_phone)<p class="text-sm text-zinc-600">{{ $order->customer_phone }}</p>@endif
                        @if($order->shipping_address)<p class="text-sm text-zinc-600">{{ $order->shipping_address }}</p>@endif
                        @if($order->shipping_city)<p class="text-sm text-zinc-600">{{ $order->shipping_city }}{{ $order->shipping_country ? ', ' . $order->shipping_country : '' }}</p>@endif
                    </div>
                    <div>
                        @if($order->payment_method)
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-2">Payment</p>
                        <p class="text-sm text-zinc-800 font-medium">{{ $order->payment_method }}</p>
                        <x-ui.badge :color="match($order->payment_status) { 'paid' => 'green', 'partial' => 'yellow', 'refunded' => 'zinc', default => 'red' }">{{ ucfirst($order->payment_status) }}</x-ui.badge>
                        @endif
                        @if($order->shipment?->tracking_number)
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-2 mt-4">Tracking</p>
                        <span class="text-sm text-indigo-600 font-mono">{{ $order->shipment->tracking_number }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Audit Timeline -->
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-zinc-900 mb-4">Order History</h3>
                <div class="relative">
                    <div class="absolute left-3.5 top-0 h-full w-px bg-zinc-100"></div>
                    <div class="space-y-4">
                        {{-- Order created entry --}}
                        <div class="relative flex gap-4">
                            <div class="relative z-10 w-7 h-7 rounded-full bg-zinc-400 border-2 border-white flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div class="flex-1 pb-4">
                                <p class="text-sm font-medium text-zinc-900">Order created</p>
                                <p class="text-xs text-zinc-500 mt-0.5">{{ $order->ordered_at->format('M d, Y \a\t g:i A') }}{{ $order->createdBy ? ' · by ' . $order->createdBy->name : '' }}</p>
                            </div>
                        </div>

                        @foreach($order->auditLogs as $log)
                        <div class="relative flex gap-4">
                            <div class="relative z-10 w-7 h-7 rounded-full bg-indigo-400 border-2 border-white flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <div class="flex-1 pb-4">
                                <p class="text-sm font-medium text-zinc-900">
                                    @if($log->event === 'status_changed')
                                        Status changed: <span class="text-indigo-600">{{ \App\Models\Order::STATUSES[$log->old_value] ?? $log->old_value }}</span> → <span class="text-green-600">{{ \App\Models\Order::STATUSES[$log->new_value] ?? $log->new_value }}</span>
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $log->event)) }}
                                    @endif
                                </p>
                                <p class="text-xs text-zinc-500 mt-0.5">{{ $log->created_at->format('M d, Y \a\t g:i A') }}{{ $log->user ? ' · by ' . $log->user->name : '' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes || $order->internal_notes)
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-zinc-900 mb-4">Notes</h3>
                @if($order->notes)
                <div class="mb-3">
                    <p class="text-xs font-medium text-zinc-500 mb-1">Customer Notes</p>
                    <p class="text-sm text-zinc-700 bg-zinc-50 rounded-lg p-3">{{ $order->notes }}</p>
                </div>
                @endif
                @if($order->internal_notes)
                <div>
                    <p class="text-xs font-medium text-zinc-500 mb-1">Internal Notes</p>
                    <p class="text-sm text-zinc-700 bg-yellow-50 rounded-lg p-3">{{ $order->internal_notes }}</p>
                </div>
                @endif
            </div>
            @endif

        </div>

        <!-- RIGHT SIDEBAR: 1/3 -->
        <div class="space-y-5">

            <!-- Customer card -->
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Customer</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-sm font-bold text-indigo-600 shrink-0">
                        {{ strtoupper(substr($order->customer_name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-zinc-900">{{ $order->customer_name }}</p>
                        @if($order->customer_phone)<p class="text-xs text-zinc-500">{{ $order->customer_phone }}</p>@endif
                    </div>
                </div>
                <div class="mt-3 space-y-1.5 text-sm">
                    @if($order->customer_email)
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Email</span>
                        <span class="text-zinc-800">{{ $order->customer_email }}</span>
                    </div>
                    @endif
                    @if($order->customer)
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Total Orders</span>
                        <span class="text-zinc-800">{{ $order->customer->orders_count }}</span>
                    </div>
                    @endif
                </div>
                @if($order->customer)
                <a href="{{ route('customers.show', $order->customer) }}" class="mt-3 block text-center text-xs text-indigo-600 hover:text-indigo-700 font-medium">View customer profile →</a>
                @endif
            </div>

            <!-- Payment card -->
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Payment</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Status</span>
                        <x-ui.badge :color="match($order->payment_status) { 'paid' => 'green', 'partial' => 'yellow', 'refunded' => 'zinc', default => 'red' }">{{ ucfirst($order->payment_status) }}</x-ui.badge>
                    </div>
                    @if($order->payment_method)
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Method</span>
                        <span class="text-zinc-800">{{ $order->payment_method }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Total</span>
                        <span class="font-semibold text-zinc-900 tabular-nums">{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    @if($order->paid_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Paid</span>
                        <span class="text-green-600 tabular-nums">{{ number_format($order->paid_amount, 2) }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Invoice card -->
            @if($order->invoice)
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Invoice</h3>
                <div class="flex items-center justify-between">
                    <span class="font-mono text-sm text-zinc-900">{{ $order->invoice->invoice_number }}</span>
                    <a href="{{ route('invoices.show', $order->invoice) }}" class="text-xs text-indigo-600 hover:underline">View</a>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
</x-layouts.app>

<x-layouts.app :title="'Customer — ' . $customer->name">
<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('customers.index') }}" class="text-sm text-zinc-500 hover:text-zinc-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back to Customers
        </a>
    </div>

    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-md text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Left: Customer info --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg">
                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                    </div>
                    <a href="{{ route('customers.edit', $customer) }}" class="text-xs text-indigo-600 hover:underline">Edit</a>
                </div>
                <h2 class="text-base font-semibold text-zinc-900">{{ $customer->name }}</h2>
                @if($customer->email)<p class="text-sm text-zinc-500 mt-0.5">{{ $customer->email }}</p>@endif
                @if($customer->phone)<p class="text-sm text-zinc-600 mt-0.5">{{ $customer->phone }}</p>@endif
                @if($customer->city)<p class="text-sm text-zinc-400 mt-1">{{ $customer->city }}{{ $customer->country ? ', ' . $customer->country : '' }}</p>@endif
                @if($customer->source)
                <div class="mt-3"><x-ui.badge color="indigo">{{ \App\Models\Order::SOURCES[$customer->source] ?? $customer->source }}</x-ui.badge></div>
                @endif
            </div>

            <div class="bg-white border border-zinc-200 rounded-xl p-5 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-zinc-500">Total Orders</span>
                    <span class="font-medium text-zinc-900">{{ $customer->orders_count }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-zinc-500">Total Spent</span>
                    <span class="font-medium text-zinc-900">{{ number_format($customer->total_spent, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-zinc-500">Customer Since</span>
                    <span class="font-medium text-zinc-900">{{ $customer->created_at->format('M Y') }}</span>
                </div>
            </div>

            @if($customer->notes)
            <div class="bg-white border border-zinc-200 rounded-xl p-5">
                <p class="text-xs font-medium text-zinc-500 uppercase tracking-wide mb-2">Notes</p>
                <p class="text-sm text-zinc-700">{{ $customer->notes }}</p>
            </div>
            @endif
        </div>

        {{-- Right: Orders --}}
        <div class="lg:col-span-2">
            <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-zinc-100">
                    <h3 class="text-sm font-semibold text-zinc-900">Recent Orders</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 border-b border-zinc-100">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50">
                        @forelse($customer->orders as $order)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('orders.show', $order) }}" class="font-mono text-xs text-indigo-600 hover:underline">{{ $order->order_number }}</a>
                            </td>
                            <td class="px-4 py-3.5 text-zinc-700 tabular-nums">{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3.5"><x-ui.badge :color="$order->status_color">{{ $order->status_label }}</x-ui.badge></td>
                            <td class="px-4 py-3.5 text-xs text-zinc-400">{{ $order->ordered_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-8 text-center text-sm text-zinc-400">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
</x-layouts.app>

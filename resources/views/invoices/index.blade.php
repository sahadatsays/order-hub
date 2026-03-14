<x-layouts.app title="Invoices">
<div class="max-w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-zinc-900">Invoices</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Invoices generated from orders.</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Total</p>
            <p class="text-lg font-semibold text-zinc-900 mt-0.5">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Paid</p>
            <p class="text-lg font-semibold text-green-600 mt-0.5">{{ number_format($stats['paid']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Pending</p>
            <p class="text-lg font-semibold text-indigo-600 mt-0.5">{{ number_format($stats['pending']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Overdue</p>
            <p class="text-lg font-semibold text-red-600 mt-0.5">{{ number_format($stats['overdue']) }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" class="flex gap-2 mb-4">
        <div class="relative flex-1 max-w-xs">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search invoice or customer..." class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white placeholder:text-zinc-400">
        </div>
        <select name="status" class="px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white text-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Status</option>
            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
            <option value="sent" @selected(request('status') === 'sent')>Sent</option>
            <option value="paid" @selected(request('status') === 'paid')>Paid</option>
            <option value="overdue" @selected(request('status') === 'overdue')>Overdue</option>
        </select>
        <button type="submit" class="px-4 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-700 transition-colors">Filter</button>
    </form>

    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 border-b border-zinc-100">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Invoice #</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Order</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Customer</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wide">Total</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wide">Paid</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Issued</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($invoices as $invoice)
                @php
                    $statusColors = ['draft' => 'zinc', 'sent' => 'blue', 'paid' => 'green', 'overdue' => 'red', 'cancelled' => 'zinc'];
                    $color = $statusColors[$invoice->status] ?? 'zinc';
                @endphp
                <tr class="hover:bg-zinc-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <a href="{{ route('invoices.show', $invoice) }}" class="font-mono text-xs text-indigo-600 hover:underline">{{ $invoice->invoice_number }}</a>
                    </td>
                    <td class="px-4 py-3.5">
                        @if($invoice->order)
                        <a href="{{ route('orders.show', $invoice->order) }}" class="font-mono text-xs text-zinc-600 hover:text-indigo-600">{{ $invoice->order->order_number }}</a>
                        @else —
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-zinc-700">{{ $invoice->order?->customer_name ?? '—' }}</td>
                    <td class="px-4 py-3.5 text-right font-medium text-zinc-900 tabular-nums">{{ number_format($invoice->total_amount, 2) }}</td>
                    <td class="px-4 py-3.5 text-right text-zinc-600 tabular-nums">{{ number_format($invoice->paid_amount, 2) }}</td>
                    <td class="px-4 py-3.5"><x-ui.badge :color="$color">{{ ucfirst($invoice->status) }}</x-ui.badge></td>
                    <td class="px-4 py-3.5 text-xs text-zinc-400">{{ $invoice->issued_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3.5">
                        <a href="{{ route('invoices.show', $invoice) }}" class="text-xs text-indigo-600 hover:underline">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-sm text-zinc-400">No invoices yet. Invoices are created automatically when orders are placed.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $invoices->links() }}</div>

</div>
</x-layouts.app>

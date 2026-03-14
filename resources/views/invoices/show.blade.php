<x-layouts.app :title="'Invoice ' . $invoice->invoice_number">
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('invoices.index') }}" class="text-sm text-zinc-500 hover:text-zinc-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back to Invoices
        </a>
        <a href="{{ route('invoices.print', $invoice) }}" target="_blank" class="px-4 py-2 border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 text-sm font-medium rounded-md transition-colors">
            Print / PDF
        </a>
    </div>

    <div class="bg-white border border-zinc-200 rounded-xl p-8">
        {{-- Header --}}
        <div class="flex items-start justify-between mb-8">
            <div>
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-indigo-600 mb-3">
                    <span class="text-white font-bold text-sm">O</span>
                </div>
                <h1 class="text-xl font-bold text-zinc-900">Order Hub</h1>
                <p class="text-sm text-zinc-500 mt-0.5">invoice@orderhub.com</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-zinc-900">INVOICE</p>
                <p class="text-sm font-medium text-indigo-600 mt-1">{{ $invoice->invoice_number }}</p>
                @php
                    $statusColors = ['draft' => 'zinc', 'sent' => 'blue', 'paid' => 'green', 'overdue' => 'red', 'cancelled' => 'zinc'];
                @endphp
                <div class="mt-2"><x-ui.badge :color="$statusColors[$invoice->status] ?? 'zinc'">{{ ucfirst($invoice->status) }}</x-ui.badge></div>
            </div>
        </div>

        {{-- Billing details --}}
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-xs font-medium text-zinc-400 uppercase tracking-wide mb-2">Bill To</p>
                <p class="font-medium text-zinc-900">{{ $invoice->order?->customer_name }}</p>
                @if($invoice->order?->customer_phone)<p class="text-sm text-zinc-600">{{ $invoice->order->customer_phone }}</p>@endif
                @if($invoice->order?->shipping_address)<p class="text-sm text-zinc-600">{{ $invoice->order->shipping_address }}</p>@endif
                @if($invoice->order?->shipping_city)<p class="text-sm text-zinc-600">{{ $invoice->order->shipping_city }}</p>@endif
            </div>
            <div class="text-right">
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between gap-8"><span class="text-zinc-500">Issue Date</span><span class="text-zinc-900">{{ $invoice->issued_at->format('M d, Y') }}</span></div>
                    @if($invoice->due_at)
                    <div class="flex justify-between gap-8"><span class="text-zinc-500">Due Date</span><span class="text-zinc-900">{{ $invoice->due_at->format('M d, Y') }}</span></div>
                    @endif
                    <div class="flex justify-between gap-8"><span class="text-zinc-500">Order #</span>
                        <a href="{{ route('orders.show', $invoice->order) }}" class="text-indigo-600 hover:underline font-mono text-xs">{{ $invoice->order?->order_number }}</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Line items --}}
        <table class="w-full text-sm mb-6">
            <thead>
                <tr class="border-b-2 border-zinc-200">
                    <th class="pb-2 text-left text-xs font-medium text-zinc-500 uppercase">Item</th>
                    <th class="pb-2 text-right text-xs font-medium text-zinc-500 uppercase">Qty</th>
                    <th class="pb-2 text-right text-xs font-medium text-zinc-500 uppercase">Unit Price</th>
                    <th class="pb-2 text-right text-xs font-medium text-zinc-500 uppercase">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->order?->items ?? [] as $item)
                <tr class="border-b border-zinc-50">
                    <td class="py-3">
                        <p class="font-medium text-zinc-900">{{ $item->product_name }}</p>
                        @if($item->product_sku)<p class="text-xs text-zinc-400 font-mono">{{ $item->product_sku }}</p>@endif
                        @if($item->variant)<p class="text-xs text-zinc-500">{{ $item->variant }}</p>@endif
                    </td>
                    <td class="py-3 text-right text-zinc-600">{{ $item->quantity }}</td>
                    <td class="py-3 text-right text-zinc-600 tabular-nums">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="py-3 text-right font-medium text-zinc-900 tabular-nums">{{ number_format($item->line_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="flex justify-end">
            <div class="w-64 space-y-2 text-sm">
                <div class="flex justify-between text-zinc-600"><span>Subtotal</span><span class="tabular-nums">{{ number_format($invoice->subtotal, 2) }}</span></div>
                @if($invoice->discount_amount > 0)
                <div class="flex justify-between text-zinc-600"><span>Discount</span><span class="tabular-nums text-red-600">-{{ number_format($invoice->discount_amount, 2) }}</span></div>
                @endif
                @if($invoice->tax_amount > 0)
                <div class="flex justify-between text-zinc-600"><span>Tax</span><span class="tabular-nums">{{ number_format($invoice->tax_amount, 2) }}</span></div>
                @endif
                <div class="flex justify-between pt-2 border-t border-zinc-200 font-semibold text-zinc-900 text-base"><span>Total</span><span class="tabular-nums">{{ number_format($invoice->total_amount, 2) }}</span></div>
                @if($invoice->paid_amount > 0)
                <div class="flex justify-between text-green-600"><span>Paid</span><span class="tabular-nums">{{ number_format($invoice->paid_amount, 2) }}</span></div>
                <div class="flex justify-between font-medium text-zinc-900"><span>Balance Due</span><span class="tabular-nums">{{ number_format($invoice->due_amount, 2) }}</span></div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-layouts.app>

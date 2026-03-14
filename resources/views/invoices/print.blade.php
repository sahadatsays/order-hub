<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; font-size: 14px; color: #18181b; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; }
        .brand { font-size: 20px; font-weight: 700; }
        .invoice-label { font-size: 24px; font-weight: 700; }
        .inv-number { color: #6366f1; font-size: 13px; }
        .section { margin-bottom: 24px; }
        .label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #71717a; margin-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 11px; text-transform: uppercase; color: #71717a; padding: 8px 0; border-bottom: 2px solid #e4e4e7; }
        th.right { text-align: right; }
        td { padding: 10px 0; border-bottom: 1px solid #f4f4f5; }
        td.right { text-align: right; }
        .totals { width: 250px; margin-left: auto; margin-top: 20px; }
        .totals-row { display: flex; justify-content: space-between; padding: 4px 0; color: #52525b; }
        .totals-total { display: flex; justify-content: space-between; padding: 10px 0; font-weight: 700; font-size: 16px; border-top: 2px solid #e4e4e7; margin-top: 4px; }
        @media print { body { padding: 20px; } }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="brand">Order Hub</div>
            <div style="color:#52525b;font-size:13px;margin-top:4px;">invoice@orderhub.com</div>
        </div>
        <div style="text-align:right;">
            <div class="invoice-label">INVOICE</div>
            <div class="inv-number" style="margin-top:4px;">{{ $invoice->invoice_number }}</div>
            <div style="margin-top:4px;font-size:12px;color:#52525b;">
                Issued: {{ $invoice->issued_at->format('M d, Y') }}
                @if($invoice->due_at) · Due: {{ $invoice->due_at->format('M d, Y') }} @endif
            </div>
        </div>
    </div>

    <div style="display:flex;gap:60px;margin-bottom:32px;">
        <div>
            <div class="label">Bill To</div>
            <div style="font-weight:600;">{{ $invoice->order?->customer_name }}</div>
            <div style="color:#52525b;">{{ $invoice->order?->customer_phone }}</div>
            <div style="color:#52525b;">{{ $invoice->order?->shipping_address }}</div>
            <div style="color:#52525b;">{{ $invoice->order?->shipping_city }}</div>
        </div>
        <div>
            <div class="label">Order Reference</div>
            <div style="font-weight:600;font-family:monospace;">{{ $invoice->order?->order_number }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="right">Qty</th>
                <th class="right">Unit Price</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->order?->items ?? [] as $item)
            <tr>
                <td>
                    <strong>{{ $item->product_name }}</strong>
                    @if($item->product_sku) <span style="color:#71717a;font-family:monospace;font-size:11px;">({{ $item->product_sku }})</span>@endif
                </td>
                <td class="right">{{ $item->quantity }}</td>
                <td class="right">{{ number_format($item->unit_price, 2) }}</td>
                <td class="right">{{ number_format($item->line_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="totals-row"><span>Subtotal</span><span>{{ number_format($invoice->subtotal, 2) }}</span></div>
        @if($invoice->discount_amount > 0)
        <div class="totals-row"><span>Discount</span><span style="color:#dc2626;">-{{ number_format($invoice->discount_amount, 2) }}</span></div>
        @endif
        @if($invoice->tax_amount > 0)
        <div class="totals-row"><span>Tax</span><span>{{ number_format($invoice->tax_amount, 2) }}</span></div>
        @endif
        <div class="totals-total"><span>Total</span><span>{{ number_format($invoice->total_amount, 2) }}</span></div>
        @if($invoice->paid_amount > 0)
        <div class="totals-row" style="color:#16a34a;"><span>Paid</span><span>{{ number_format($invoice->paid_amount, 2) }}</span></div>
        <div class="totals-row" style="font-weight:600;"><span>Balance Due</span><span>{{ number_format($invoice->due_amount, 2) }}</span></div>
        @endif
    </div>

    <script>window.onload = function(){ window.print(); }</script>
</body>
</html>

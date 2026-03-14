<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $tid = $this->tenantId();

        $query = Order::where('tenant_id', $tid)
            ->with(['customer', 'shipment'])
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                    ->orWhere('customer_name', 'like', "%{$request->search}%")
                    ->orWhere('customer_phone', 'like', "%{$request->search}%");
            }))
            ->when($request->status && $request->status !== 'all', fn ($q) => $q->where('status', $request->status))
            ->when($request->source, fn ($q) => $q->where('source', $request->source))
            ->when($request->payment_status, fn ($q) => $q->where('payment_status', $request->payment_status))
            ->when($request->from, fn ($q) => $q->whereDate('ordered_at', '>=', $request->from))
            ->when($request->to, fn ($q) => $q->whereDate('ordered_at', '<=', $request->to))
            ->orderByDesc('ordered_at');

        $orders = $query->paginate(25)->withQueryString();

        $statusCounts = Order::where('tenant_id', $tid)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $stats = [
            'total'      => Order::where('tenant_id', $tid)->count(),
            'pending'    => Order::where('tenant_id', $tid)->where('status', 'pending')->count(),
            'processing' => Order::where('tenant_id', $tid)->where('status', 'processing')->count(),
            'revenue'    => Order::where('tenant_id', $tid)->whereNotIn('status', ['cancelled', 'refunded'])
                ->whereMonth('ordered_at', now()->month)
                ->sum('total_amount'),
        ];

        return view('orders.index', compact('orders', 'stats', 'statusCounts'));
    }

    public function create(): View
    {
        $tid = $this->tenantId();
        $customers = Customer::where('tenant_id', $tid)->orderBy('name')->get();
        $products  = Product::where('tenant_id', $tid)->where('is_active', true)->orderBy('name')->get();
        $couriers  = Courier::where('tenant_id', $tid)->where('is_active', true)->orderBy('name')->get();

        return view('orders.create', compact('customers', 'products', 'couriers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id'         => 'nullable|exists:customers,id',
            'source'              => 'required|in:' . implode(',', array_keys(Order::SOURCES)),
            'customer_name'       => 'required|string|max:255',
            'customer_phone'      => 'nullable|string|max:30',
            'customer_email'      => 'nullable|email|max:255',
            'shipping_address'    => 'nullable|string|max:500',
            'shipping_city'       => 'nullable|string|max:100',
            'payment_method'      => 'nullable|string|max:100',
            'payment_status'      => 'required|in:unpaid,partial,paid',
            'discount_amount'     => 'nullable|numeric|min:0',
            'discount_code'       => 'nullable|string|max:50',
            'shipping_charge'     => 'nullable|numeric|min:0',
            'notes'               => 'nullable|string|max:2000',
            'items'               => 'required|array|min:1',
            'items.*.product_id'  => 'nullable|exists:products,id',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity'    => 'required|integer|min:1',
            'items.*.unit_price'  => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'tenant_id'        => auth()->user()->tenant_id,
            'source'           => $validated['source'],
            'customer_id'      => $validated['customer_id'] ?? null,
            'created_by'       => auth()->id(),
            'customer_name'    => $validated['customer_name'],
            'customer_phone'   => $validated['customer_phone'] ?? null,
            'customer_email'   => $validated['customer_email'] ?? null,
            'shipping_address' => $validated['shipping_address'] ?? null,
            'shipping_city'    => $validated['shipping_city'] ?? null,
            'payment_method'   => $validated['payment_method'] ?? null,
            'payment_status'   => $validated['payment_status'],
            'discount_amount'  => $validated['discount_amount'] ?? 0,
            'discount_code'    => $validated['discount_code'] ?? null,
            'shipping_charge'  => $validated['shipping_charge'] ?? 0,
            'notes'            => $validated['notes'] ?? null,
            'status'           => 'pending',
        ]);

        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $lineTotal = $item['quantity'] * $item['unit_price'];
            $subtotal += $lineTotal;

            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['product_id'] ?? null,
                'product_name' => $item['product_name'],
                'product_sku'  => $item['product_sku'] ?? null,
                'variant'      => $item['variant'] ?? null,
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],
                'line_total'   => $lineTotal,
            ]);
        }

        $order->update([
            'subtotal'     => $subtotal,
            'total_amount' => $subtotal - $order->discount_amount + $order->shipping_charge + $order->tax_amount,
        ]);

        // Auto-create invoice
        Invoice::create([
            'tenant_id'       => auth()->user()->tenant_id,
            'order_id'        => $order->id,
            'subtotal'        => $order->subtotal ?? 0,
            'discount_amount' => $order->discount_amount ?? 0,
            'tax_amount'      => $order->tax_amount ?? 0,
            'total_amount'    => $order->total_amount ?? 0,
            'paid_amount'     => $order->payment_status === 'paid' ? ($order->total_amount ?? 0) : 0,
            'status'          => $order->payment_status === 'paid' ? 'paid' : 'draft',
            'issued_at'       => now(),
        ]);

        AuditLog::record(
            tenantId: auth()->user()->tenant_id ?? 1,
            userId: auth()->id(),
            auditableType: Order::class,
            auditableId: $order->id,
            event: 'created',
            newValue: $order->status
        );

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order #' . $order->order_number . ' created successfully.');
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'customer', 'shipment.courier', 'invoice', 'createdBy', 'auditLogs.user']);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        $tid = $this->tenantId();
        $customers = Customer::where('tenant_id', $tid)->orderBy('name')->get();
        $products  = Product::where('tenant_id', $tid)->where('is_active', true)->orderBy('name')->get();
        $order->load('items');

        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'nullable|string|max:30',
            'shipping_address' => 'nullable|string|max:500',
            'shipping_city'    => 'nullable|string|max:100',
            'payment_method'   => 'nullable|string|max:100',
            'payment_status'   => 'required|in:unpaid,partial,paid',
            'discount_amount'  => 'nullable|numeric|min:0',
            'shipping_charge'  => 'nullable|numeric|min:0',
            'notes'            => 'nullable|string|max:2000',
            'internal_notes'   => 'nullable|string|max:2000',
        ]);

        $order->update($validated);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order updated.');
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Order::STATUSES)),
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $validated['status']]);

        AuditLog::record(
            tenantId: auth()->user()->tenant_id ?? 1,
            userId: auth()->id(),
            auditableType: Order::class,
            auditableId: $order->id,
            event: 'status_changed',
            field: 'status',
            oldValue: $oldStatus,
            newValue: $validated['status']
        );

        return redirect()->back()
            ->with('success', 'Order status updated to ' . Order::STATUSES[$validated['status']] . '.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use App\DTOs\OrderData;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderCalculationService;
use App\Services\OrderCreateService;
use App\Services\OrderPaymentService;
use App\Services\OrderStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected OrderCreateService      $createService,
        protected OrderCalculationService $calculationService,
        protected OrderStatusService      $statusService,
        protected OrderPaymentService     $paymentService,
    ) {}

    public function index(Request $request): View
    {
        $tid = $this->tenantId();

        $query = Order::where('tenant_id', $tid)
            ->with(['customer', 'shipment.courier', 'createdBy'])
            ->withCount('items')
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                    ->orWhere('customer_name', 'like', "%{$request->search}%")
                    ->orWhere('customer_phone', 'like', "%{$request->search}%")
                    ->orWhere('source_order_id', 'like', "%{$request->search}%");
            }))
            ->when($request->status && $request->status !== 'all', fn ($q) => $q->where('status', $request->status))
            ->when($request->source, fn ($q) => $q->where('source', $request->source))
            ->when($request->payment_status, fn ($q) => $q->where('payment_status', $request->payment_status))
            ->when($request->shipment_status, fn ($q) => $q->whereHas('shipment', fn ($sq) => $sq->where('status', $request->shipment_status)))
            ->when($request->courier_id, fn ($q) => $q->whereHas('shipment', fn ($sq) => $sq->where('courier_id', $request->courier_id)))
            ->when($request->created_by, fn ($q) => $q->where('created_by', $request->created_by))
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

        $couriers = Courier::where('tenant_id', $tid)->where('is_active', true)->orderBy('name')->get();
        $users = User::where('tenant_id', $tid)->where('is_active', true)->orderBy('name')->get();

        return view('orders.index', compact('orders', 'stats', 'statusCounts', 'couriers', 'users'));
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
            'customer_id'              => 'nullable|exists:customers,id',
            'source'                   => 'required|in:' . implode(',', array_keys(Order::SOURCES)),
            'customer_name'            => 'required|string|max:255',
            'customer_phone'           => 'nullable|string|max:30',
            'customer_email'           => 'nullable|email|max:255',
            'shipping_address'         => 'nullable|string|max:500',
            'shipping_city'            => 'nullable|string|max:100',
            'payment_method'           => 'nullable|string|max:100',
            'payment_status'           => 'required|in:unpaid,partial,paid',
            'discount_amount'          => 'nullable|numeric|min:0',
            'discount_code'            => 'nullable|string|max:50',
            'shipping_charge'          => 'nullable|numeric|min:0',
            'paid_amount'              => 'nullable|numeric|min:0',
            'notes'                    => 'nullable|string|max:2000',
            'internal_notes'           => 'nullable|string|max:2000',
            'items'                    => 'required|array|min:1',
            'items.*.product_id'       => 'nullable|exists:products,id',
            'items.*.product_name'     => 'required|string|max:255',
            'items.*.product_sku'      => 'nullable|string|max:100',
            'items.*.variant'          => 'nullable|string|max:255',
            'items.*.quantity'         => 'required|integer|min:1',
            'items.*.unit_price'       => 'required|numeric|min:0',
            'items.*.discount_amount'  => 'nullable|numeric|min:0',
        ]);

        $orderData = OrderData::fromRequest(
            $validated,
            auth()->user()->tenant_id,
            auth()->id()
        );

        $order = $this->createService->create($orderData);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order #' . $order->order_number . ' created successfully.');
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'customer', 'shipment.courier', 'invoice', 'createdBy', 'payments', 'auditLogs.user']);

        $allowedTransitions = $this->statusService->allowedTransitions($order->status);

        return view('orders.show', compact('order', 'allowedTransitions'));
    }

    public function edit(Order $order): View|RedirectResponse
    {
        if (! $this->statusService->canEdit($order)) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'This order cannot be edited in its current status.');
        }

        $tid = $this->tenantId();
        $customers = Customer::where('tenant_id', $tid)->orderBy('name')->get();
        $products  = Product::where('tenant_id', $tid)->where('is_active', true)->orderBy('name')->get();
        $order->load('items');

        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        if (! $this->statusService->canEdit($order)) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'This order cannot be edited in its current status.');
        }

        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'nullable|string|max:30',
            'shipping_address' => 'nullable|string|max:500',
            'shipping_city'    => 'nullable|string|max:100',
            'payment_method'   => 'nullable|string|max:100',
            'discount_amount'  => 'nullable|numeric|min:0',
            'shipping_charge'  => 'nullable|numeric|min:0',
            'notes'            => 'nullable|string|max:2000',
            'internal_notes'   => 'nullable|string|max:2000',
        ]);

        $order->update($validated);
        $this->calculationService->recalculateOrder($order);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order updated.');
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Order::STATUSES)),
        ]);

        try {
            $this->statusService->transition($order, $validated['status'], auth()->id());
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Order status updated to ' . Order::STATUSES[$validated['status']] . '.');
    }

    public function addPayment(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'method'    => 'required|in:' . implode(',', array_keys(\App\Models\OrderPayment::METHODS)),
            'amount'    => 'required|numeric|min:0.01',
            'tendered'  => 'nullable|numeric|min:0',
            'reference' => 'nullable|string|max:255',
            'note'      => 'nullable|string|max:500',
        ]);

        try {
            $this->paymentService->recordPayment(
                order: $order,
                method: $validated['method'],
                amount: (float) $validated['amount'],
                collectedBy: auth()->id(),
                tendered: isset($validated['tendered']) ? (float) $validated['tendered'] : null,
                reference: $validated['reference'] ?? null,
                note: $validated['note'] ?? null,
            );
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted.');
    }
}

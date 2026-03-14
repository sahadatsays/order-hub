<?php

namespace App\Http\Controllers;

use App\DTOs\OrderData;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Services\OrderCreateService;
use App\Services\OrderPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PosController extends Controller
{
    public function __construct(
        protected OrderCreateService  $createService,
        protected OrderPaymentService $paymentService,
    ) {}

    /**
     * POS full-page interface.
     */
    public function index(): View
    {
        $tid = $this->tenantId();
        $products = Product::where('tenant_id', $tid)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'sku', 'price', 'image']);

        return view('pos.index', compact('products'));
    }

    /**
     * AJAX: Search customers.
     */
    public function searchCustomers(Request $request): JsonResponse
    {
        $tid = $this->tenantId();
        $q = $request->get('q', '');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $customers = Customer::where('tenant_id', $tid)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'phone', 'email', 'address', 'city']);

        return response()->json($customers);
    }

    /**
     * AJAX: Search products.
     */
    public function searchProducts(Request $request): JsonResponse
    {
        $tid = $this->tenantId();
        $q = $request->get('q', '');

        $products = Product::where('tenant_id', $tid)
            ->where('is_active', true)
            ->when($q, fn ($query) => $query->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%");
            }))
            ->limit(20)
            ->get(['id', 'name', 'sku', 'price', 'image']);

        return response()->json($products);
    }

    /**
     * AJAX: Resolve product by barcode/SKU.
     */
    public function resolveBarcode(Request $request): JsonResponse
    {
        $tid = $this->tenantId();
        $barcode = $request->get('barcode', '');

        if (empty($barcode)) {
            return response()->json(['error' => 'No barcode provided'], 422);
        }

        $product = Product::where('tenant_id', $tid)
            ->where('is_active', true)
            ->where('sku', $barcode)
            ->first(['id', 'name', 'sku', 'price', 'image']);

        if (! $product) {
            return response()->json(['error' => 'Product not found for barcode: ' . $barcode], 404);
        }

        return response()->json($product);
    }

    /**
     * POS: Create order with immediate payment support.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id'              => 'nullable|exists:customers,id',
            'customer_name'            => 'required|string|max:255',
            'customer_phone'           => 'nullable|string|max:30',
            'customer_email'           => 'nullable|email|max:255',
            'items'                    => 'required|array|min:1',
            'items.*.product_id'       => 'nullable|exists:products,id',
            'items.*.product_name'     => 'required|string|max:255',
            'items.*.product_sku'      => 'nullable|string|max:100',
            'items.*.quantity'         => 'required|integer|min:1',
            'items.*.unit_price'       => 'required|numeric|min:0',
            'items.*.discount_amount'  => 'nullable|numeric|min:0',
            'discount_amount'          => 'nullable|numeric|min:0',
            'payment_method'           => 'nullable|in:' . implode(',', array_keys(OrderPayment::METHODS)),
            'paid_amount'              => 'nullable|numeric|min:0',
            'tendered'                 => 'nullable|numeric|min:0',
            'notes'                    => 'nullable|string|max:2000',
        ]);

        $orderData = new OrderData(
            tenant_id: auth()->user()->tenant_id,
            created_by: auth()->id(),
            source: 'pos',
            customer_name: $validated['customer_name'],
            items: array_map(
                fn ($item) => \App\DTOs\OrderItemData::fromArray($item),
                $validated['items']
            ),
            payment_status: 'unpaid',
            customer_id: $validated['customer_id'] ?? null,
            customer_phone: $validated['customer_phone'] ?? null,
            customer_email: $validated['customer_email'] ?? null,
            payment_method: $validated['payment_method'] ?? null,
            discount_amount: (float) ($validated['discount_amount'] ?? 0),
            paid_amount: 0,
            notes: $validated['notes'] ?? null,
        );

        $order = $this->createService->create($orderData);

        // Handle immediate payment for POS
        $paidAmount = (float) ($validated['paid_amount'] ?? 0);
        if ($paidAmount > 0 && ! empty($validated['payment_method'])) {
            $this->paymentService->recordPayment(
                order: $order,
                method: $validated['payment_method'],
                amount: $paidAmount,
                collectedBy: auth()->id(),
                tendered: isset($validated['tendered']) ? (float) $validated['tendered'] : null,
            );
            $order->refresh();
        }

        return response()->json([
            'success'      => true,
            'order'        => [
                'id'             => $order->id,
                'order_number'   => $order->order_number,
                'total_amount'   => (float) $order->total_amount,
                'paid_amount'    => (float) $order->paid_amount,
                'due_amount'     => $order->due_amount,
                'payment_status' => $order->payment_status,
                'status'         => $order->status,
            ],
            'redirect_url' => route('orders.show', $order),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $tid = $this->tenantId();

        $stats = [
            'total_orders'    => Order::where('tenant_id', $tid)->count(),
            'pending_orders'  => Order::where('tenant_id', $tid)->where('status', 'pending')->count(),
            'revenue_today'   => Order::where('tenant_id', $tid)->whereDate('ordered_at', today())
                ->whereNotIn('status', ['cancelled', 'refunded'])->sum('total_amount'),
            'revenue_month'   => Order::where('tenant_id', $tid)->whereMonth('ordered_at', now()->month)
                ->whereYear('ordered_at', now()->year)
                ->whereNotIn('status', ['cancelled', 'refunded'])->sum('total_amount'),
            'total_customers' => Customer::where('tenant_id', $tid)->count(),
            'total_products'  => Product::where('tenant_id', $tid)->count(),
        ];

        $recentOrders = Order::where('tenant_id', $tid)
            ->with('customer')
            ->orderByDesc('ordered_at')
            ->limit(8)
            ->get();

        $ordersBySource = Order::where('tenant_id', $tid)
            ->selectRaw('source, COUNT(*) as count')
            ->groupBy('source')
            ->orderByDesc('count')
            ->get();

        $ordersByStatus = Order::where('tenant_id', $tid)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $monthlyRevenue = $this->getMonthlyRevenue($tid);

        $recentActivity = AuditLog::where('tenant_id', $tid)
            ->with('user')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'stats',
            'recentOrders',
            'ordersBySource',
            'ordersByStatus',
            'monthlyRevenue',
            'recentActivity'
        ));
    }

    private function getMonthlyRevenue(int $tenantId): array
    {
        $year = now()->year;
        $months = [];

        for ($m = 1; $m <= 12; $m++) {
            $start = Carbon::create($year, $m, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $revenue = Order::where('tenant_id', $tenantId)
                ->whereBetween('ordered_at', [$start, $end])
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->sum('total_amount');

            $months[] = [
                'month' => $start->format('M'),
                'revenue' => (float) $revenue,
            ];
        }

        return $months;
    }

    public function search(Request $request): JsonResponse
    {
        $q = trim($request->input('q', ''));
        $tid = $this->tenantId();

        if (strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [];
        $escaped = str_replace(['%', '_'], ['\%', '\_'], $q);

        // Search orders
        $orders = Order::where('tenant_id', $tid)
            ->where(function ($query) use ($escaped) {
                $query->where('order_number', 'like', "%{$escaped}%")
                    ->orWhere('status', 'like', "%{$escaped}%");
            })
            ->limit(5)
            ->get();

        foreach ($orders as $order) {
            $results[] = [
                'type' => 'order',
                'label' => $order->order_number,
                'description' => ucfirst($order->status) . ' — ৳' . number_format($order->total_amount, 2),
                'url' => route('orders.show', $order),
            ];
        }

        // Search customers
        $customers = Customer::where('tenant_id', $tid)
            ->where(function ($query) use ($escaped) {
                $query->where('name', 'like', "%{$escaped}%")
                    ->orWhere('phone', 'like', "%{$escaped}%")
                    ->orWhere('email', 'like', "%{$escaped}%");
            })
            ->limit(5)
            ->get();

        foreach ($customers as $customer) {
            $results[] = [
                'type' => 'customer',
                'label' => $customer->name,
                'description' => $customer->phone ?? $customer->email ?? '',
                'url' => route('customers.show', $customer),
            ];
        }

        // Search products
        $products = Product::where('tenant_id', $tid)
            ->where(function ($query) use ($escaped) {
                $query->where('name', 'like', "%{$escaped}%")
                    ->orWhere('sku', 'like', "%{$escaped}%");
            })
            ->limit(5)
            ->get();

        foreach ($products as $product) {
            $results[] = [
                'type' => 'product',
                'label' => $product->name,
                'description' => ($product->sku ? "SKU: {$product->sku}" : '') . ' — ৳' . number_format($product->price, 2),
                'url' => route('products.show', $product),
            ];
        }

        return response()->json(['results' => $results]);
    }
}

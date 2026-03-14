<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
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

        return view('dashboard', compact(
            'stats',
            'recentOrders',
            'ordersBySource',
            'ordersByStatus'
        ));
    }
}

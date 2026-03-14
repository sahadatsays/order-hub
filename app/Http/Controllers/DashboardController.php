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
        $stats = [
            'total_orders'   => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'revenue_today'  => Order::whereDate('ordered_at', today())
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->sum('total_amount'),
            'revenue_month'  => Order::whereMonth('ordered_at', now()->month)
                ->whereYear('ordered_at', now()->year)
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->sum('total_amount'),
            'total_customers' => Customer::count(),
            'total_products'  => Product::count(),
        ];

        $recentOrders = Order::with('customer')
            ->orderByDesc('ordered_at')
            ->limit(8)
            ->get();

        $ordersBySource = Order::selectRaw('source, COUNT(*) as count')
            ->groupBy('source')
            ->orderByDesc('count')
            ->get();

        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
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

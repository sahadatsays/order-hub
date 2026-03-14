<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
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
}

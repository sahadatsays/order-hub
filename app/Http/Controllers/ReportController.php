<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $ordersBySource = Order::selectRaw('source, COUNT(*) as count, SUM(total_amount) as revenue')
            ->groupBy('source')
            ->orderByDesc('revenue')
            ->get();

        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $db = config('database.default');
        $yearExpr  = $db === 'sqlite' ? "strftime('%Y', ordered_at)" : 'YEAR(ordered_at)';
        $monthExpr = $db === 'sqlite' ? "strftime('%m', ordered_at)" : 'MONTH(ordered_at)';

        $revenueByMonth = Order::selectRaw(
            "{$yearExpr} as year, {$monthExpr} as month, SUM(total_amount) as revenue, COUNT(*) as orders"
        )
            ->where('ordered_at', '>=', now()->subMonths(12))
            ->whereNotIn('status', ['cancelled', 'refunded'])
            ->groupByRaw("{$yearExpr}, {$monthExpr}")
            ->orderByRaw("year ASC, month ASC")
            ->get()
            ->map(function ($row) {
                $row->year  = (int) $row->year;
                $row->month = (int) $row->month;
                return $row;
            });

        $stats = [
            'total_revenue'  => Order::whereNotIn('status', ['cancelled', 'refunded'])->sum('total_amount'),
            'total_orders'   => Order::count(),
            'avg_order'      => Order::whereNotIn('status', ['cancelled', 'refunded'])->avg('total_amount') ?? 0,
            'this_month'     => Order::whereMonth('ordered_at', now()->month)
                ->whereYear('ordered_at', now()->year)
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->sum('total_amount'),
        ];

        return view('reports.index', compact(
            'ordersBySource',
            'ordersByStatus',
            'revenueByMonth',
            'stats'
        ));
    }
}

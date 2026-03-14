<x-layouts.app title="Reports & Analytics">
<div class="max-w-full">

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Reports & Analytics</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Business performance insights.</p>
    </div>

    {{-- KPI Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-4">
            <p class="text-xs text-zinc-500">Total Revenue</p>
            <p class="text-xl font-bold text-zinc-900 mt-1 tabular-nums">{{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-4">
            <p class="text-xs text-zinc-500">Total Orders</p>
            <p class="text-xl font-bold text-zinc-900 mt-1 tabular-nums">{{ number_format($stats['total_orders']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-4">
            <p class="text-xs text-zinc-500">Avg. Order Value</p>
            <p class="text-xl font-bold text-zinc-900 mt-1 tabular-nums">{{ number_format($stats['avg_order'], 2) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-4">
            <p class="text-xs text-zinc-500">Revenue This Month</p>
            <p class="text-xl font-bold text-indigo-600 mt-1 tabular-nums">{{ number_format($stats['this_month'], 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Orders by Source --}}
        <div class="bg-white border border-zinc-200 rounded-xl p-6">
            <h3 class="text-sm font-semibold text-zinc-900 mb-4">Orders by Channel</h3>
            <div class="space-y-4">
                @php $totalOrders = $ordersBySource->sum('count'); @endphp
                @forelse($ordersBySource as $row)
                @php $pct = $totalOrders > 0 ? round(($row->count / $totalOrders) * 100) : 0; @endphp
                <div>
                    <div class="flex items-center gap-3 mb-1.5">
                        <span class="text-sm font-medium text-zinc-900 flex-1">{{ \App\Models\Order::SOURCES[$row->source] ?? ucfirst($row->source) }}</span>
                        <span class="text-sm text-zinc-600 tabular-nums">{{ $row->count }} orders</span>
                        <span class="text-xs text-zinc-400 w-10 text-right">{{ $pct }}%</span>
                    </div>
                    <div class="relative w-full bg-zinc-100 h-2 rounded-full overflow-hidden">
                        <div class="absolute inset-y-0 left-0 bg-indigo-500 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-zinc-400">No data yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Orders by Status --}}
        <div class="bg-white border border-zinc-200 rounded-xl p-6">
            <h3 class="text-sm font-semibold text-zinc-900 mb-4">Orders by Status</h3>
            @php
                $statusColors = ['delivered' => 'green', 'shipped' => 'orange', 'processing' => 'indigo', 'pending' => 'yellow', 'cancelled' => 'red', 'confirmed' => 'blue', 'packed' => 'purple', 'refunded' => 'zinc', 'on_hold' => 'zinc'];
                $totalByStatus = $ordersByStatus->sum('count');
            @endphp
            <div class="space-y-3">
                @foreach(\App\Models\Order::STATUSES as $key => $label)
                @php $count = $ordersByStatus->get($key)?->count ?? 0; $pct = $totalByStatus > 0 ? round(($count / $totalByStatus) * 100) : 0; @endphp
                @if($count > 0)
                <div class="flex items-center gap-3">
                    <x-ui.badge :color="$statusColors[$key] ?? 'zinc'">{{ $label }}</x-ui.badge>
                    <div class="flex-1 relative bg-zinc-100 h-1.5 rounded-full overflow-hidden">
                        <div class="absolute inset-y-0 left-0 rounded-full" style="width: {{ $pct }}%; background-color: currentColor;" class="bg-indigo-500"></div>
                    </div>
                    <span class="text-sm text-zinc-600 tabular-nums w-8 text-right">{{ $count }}</span>
                </div>
                @endif
                @endforeach
                @if($totalByStatus === 0)
                <p class="text-sm text-zinc-400">No orders yet.</p>
                @endif
            </div>
        </div>

        {{-- Monthly Revenue Table --}}
        <div class="lg:col-span-2 bg-white border border-zinc-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-100">
                <h3 class="text-sm font-semibold text-zinc-900">Monthly Revenue (Last 12 Months)</h3>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 border-b border-zinc-100">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Month</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wide">Orders</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wide">Revenue</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Bar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @php $maxRevenue = $revenueByMonth->max('revenue') ?: 1; @endphp
                    @forelse($revenueByMonth as $row)
                    @php $pct = round(($row->revenue / $maxRevenue) * 100); @endphp
                    <tr class="hover:bg-zinc-50">
                        <td class="px-5 py-3">{{ \Carbon\Carbon::create($row->year, $row->month, 1)->format('F Y') }}</td>
                        <td class="px-4 py-3 text-right text-zinc-600 tabular-nums">{{ $row->orders }}</td>
                        <td class="px-4 py-3 text-right font-medium text-zinc-900 tabular-nums">{{ number_format($row->revenue, 2) }}</td>
                        <td class="px-4 py-3">
                            <div class="relative w-full bg-zinc-100 h-2 rounded-full overflow-hidden">
                                <div class="absolute inset-y-0 left-0 bg-indigo-500 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-sm text-zinc-400">No revenue data yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-layouts.app>

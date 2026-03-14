<x-layouts.app title="Dashboard">

    <x-app.page-header
        title="Dashboard"
        :description="'Welcome back, ' . auth()->user()?->name . '. Here\'s what\'s happening today.'"
    >
        <x-slot:actions>
            <x-ui.button href="{{ route('orders.create') }}" variant="primary" size="sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                New Order
            </x-ui.button>
        </x-slot:actions>
    </x-app.page-header>

    {{-- ROW 1: KPI Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        <x-ui.stat-card
            label="Total Orders"
            :value="number_format($stats['total_orders'])"
            iconBg="bg-indigo-50"
            iconColor="text-indigo-600"
            :icon="'<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'20\' height=\'20\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path d=\'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2\'/><rect x=\'9\' y=\'3\' width=\'6\' height=\'4\' rx=\'2\'/><path d=\'M9 12h6M9 16h4\'/></svg>'"
        />

        <x-ui.stat-card
            label="Revenue This Month"
            :value="number_format($stats['revenue_month'], 2)"
            iconBg="bg-green-50"
            iconColor="text-green-600"
            :icon="'<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'20\' height=\'20\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><line x1=\'12\' y1=\'1\' x2=\'12\' y2=\'23\'/><path d=\'M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6\'/></svg>'"
        />

        <x-ui.stat-card
            label="Total Customers"
            :value="number_format($stats['total_customers'])"
            iconBg="bg-blue-50"
            iconColor="text-blue-600"
            :icon="'<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'20\' height=\'20\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path d=\'M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2\'/><circle cx=\'9\' cy=\'7\' r=\'4\'/><path d=\'M23 21v-2a4 4 0 00-3-3.87\'/><path d=\'M16 3.13a4 4 0 010 7.75\'/></svg>'"
        />

        <x-ui.stat-card
            label="Pending Orders"
            :value="number_format($stats['pending_orders'])"
            iconBg="bg-yellow-50"
            iconColor="text-yellow-600"
            :icon="'<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'20\' height=\'20\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><circle cx=\'12\' cy=\'12\' r=\'10\'/><polyline points=\'12 6 12 12 16 14\'/></svg>'"
        />

    </div>

    {{-- ROW 2: Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">

        {{-- Revenue Over Time (Dynamic) --}}
        @php
            $maxRevenue = max(array_column($monthlyRevenue, 'revenue'));
            $maxRevenue = $maxRevenue > 0 ? $maxRevenue : 1;
            $chartHeight = 146;
            $barWidth = 30;
            $barGap = 42;
            $startX = 47;
            $baselineY = 156;
        @endphp
        <div class="lg:col-span-2 bg-white border border-zinc-200 rounded-xl p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 sm:gap-4 mb-6">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900">Revenue Over Time</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">{{ now()->year }} monthly breakdown</p>
                </div>
            </div>

            @if($maxRevenue > 1)
            <div class="w-full overflow-x-auto">
                <svg viewBox="0 0 600 210" class="w-full" style="min-height:180px;" preserveAspectRatio="xMidYMid meet">
                    {{-- Y-axis gridlines --}}
                    @php
                        $yLabels = [
                            ['y' => 10,  'val' => $maxRevenue],
                            ['y' => 52,  'val' => $maxRevenue * 0.75],
                            ['y' => 94,  'val' => $maxRevenue * 0.50],
                            ['y' => 136, 'val' => $maxRevenue * 0.25],
                        ];
                    @endphp
                    @foreach($yLabels as $label)
                    <line x1="40" y1="{{ $label['y'] }}" x2="590" y2="{{ $label['y'] }}" stroke="#f4f4f5" stroke-width="1" stroke-dasharray="4 3"/>
                    @php
                        $formatted = $label['val'] >= 1000 ? number_format($label['val'] / 1000, 0) . 'k' : number_format($label['val'], 0);
                    @endphp
                    <text x="34" y="{{ $label['y'] + 3 }}" text-anchor="end" font-size="9" fill="#a1a1aa">{{ $formatted }}</text>
                    @endforeach

                    {{-- Chart baseline --}}
                    <line x1="40" y1="{{ $baselineY }}" x2="590" y2="{{ $baselineY }}" stroke="#e4e4e7" stroke-width="1"/>

                    {{-- Dynamic Bars --}}
                    @foreach($monthlyRevenue as $i => $month)
                    @php
                        $x = $startX + ($i * $barGap);
                        $ratio = $maxRevenue > 0 ? $month['revenue'] / $maxRevenue : 0;
                        $barH = max(2, round($ratio * $chartHeight));
                        $barY = $baselineY - $barH;
                        $opacity = $ratio > 0 ? max(0.4, min(0.9, 0.4 + ($ratio * 0.5))) : 0.2;
                        $isCurrentMonth = ($i + 1) === (int) now()->month;
                        $revenueFormatted = $month['revenue'] >= 1000 ? number_format($month['revenue'] / 1000, 0) . 'k' : number_format($month['revenue'], 0);
                    @endphp
                    <rect x="{{ $x }}" y="{{ $barY }}" width="{{ $barWidth }}" height="{{ $barH }}" rx="2" fill="#6366f1" opacity="{{ $isCurrentMonth ? '1' : $opacity }}"/>
                    @if($month['revenue'] > 0)
                    <text x="{{ $x + ($barWidth / 2) }}" y="{{ $barY - 5 }}" text-anchor="middle" font-size="8" fill="#6366f1" @if($isCurrentMonth) font-weight="600" @endif>{{ $revenueFormatted }}</text>
                    @endif
                    <text x="{{ $x + ($barWidth / 2) }}" y="172" text-anchor="middle" font-size="9" fill="{{ $isCurrentMonth ? '#6366f1' : '#a1a1aa' }}" @if($isCurrentMonth) font-weight="600" @endif>{{ $month['month'] }}</text>
                    @endforeach
                </svg>
            </div>
            @else
            <div class="flex items-center justify-center h-40">
                <p class="text-sm text-zinc-400">No revenue data available yet.</p>
            </div>
            @endif
        </div>

        {{-- Orders by Status (Dynamic Donut) --}}
        @php
            $statusColors = [
                'delivered'  => '#22c55e',
                'processing' => '#3b82f6',
                'pending'    => '#eab308',
                'cancelled'  => '#ef4444',
                'confirmed'  => '#6366f1',
                'shipped'    => '#f97316',
                'packed'     => '#a855f7',
                'refunded'   => '#71717a',
                'on_hold'    => '#71717a',
            ];
            $statusColorClasses = [
                'delivered'  => 'bg-green-500',
                'processing' => 'bg-blue-500',
                'pending'    => 'bg-yellow-500',
                'cancelled'  => 'bg-red-500',
                'confirmed'  => 'bg-indigo-500',
                'shipped'    => 'bg-orange-500',
                'packed'     => 'bg-purple-500',
                'refunded'   => 'bg-zinc-500',
                'on_hold'    => 'bg-zinc-400',
            ];
            $totalStatusOrders = $ordersByStatus->sum('count');
            $circumference = 289;
        @endphp
        <div class="bg-white border border-zinc-200 rounded-xl p-4 sm:p-6">
            <div class="mb-5">
                <h3 class="text-sm font-semibold text-zinc-900">Order Status</h3>
                <p class="text-xs text-zinc-500 mt-0.5">All time breakdown</p>
            </div>

            @if($totalStatusOrders > 0)
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <svg viewBox="0 0 120 120" width="120" height="120">
                        <circle cx="60" cy="60" r="46" fill="none" stroke="#f4f4f5" stroke-width="12"/>
                        @php $dashOffset = 72.25; @endphp
                        @foreach($ordersByStatus as $status => $row)
                        @php
                            $pct = $totalStatusOrders > 0 ? $row->count / $totalStatusOrders : 0;
                            $dashLen = $pct * $circumference;
                            $color = $statusColors[$status] ?? '#71717a';
                        @endphp
                        @if($dashLen > 0)
                        <circle cx="60" cy="60" r="46" fill="none" stroke="{{ $color }}" stroke-width="12"
                            stroke-dasharray="{{ $dashLen }} {{ $circumference }}" stroke-dashoffset="{{ $dashOffset }}"
                            stroke-linecap="butt" transform="rotate(-90 60 60)"/>
                        @php $dashOffset -= $dashLen; @endphp
                        @endif
                        @endforeach
                        <text x="60" y="56" text-anchor="middle" font-size="13" font-weight="600" fill="#18181b">{{ number_format($totalStatusOrders) }}</text>
                        <text x="60" y="70" text-anchor="middle" font-size="9" fill="#71717a">orders</text>
                    </svg>
                </div>
            </div>

            <div class="space-y-3">
                @foreach($ordersByStatus->sortByDesc('count') as $status => $row)
                @php
                    $pct = $totalStatusOrders > 0 ? round(($row->count / $totalStatusOrders) * 100) : 0;
                    $dotClass = $statusColorClasses[$status] ?? 'bg-zinc-400';
                @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $dotClass }} shrink-0"></span>
                        <span class="text-xs text-zinc-600">{{ \App\Models\Order::STATUSES[$status] ?? ucfirst($status) }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-zinc-900">{{ number_format($row->count) }}</span>
                        <span class="text-xs text-zinc-400 w-8 text-right">{{ $pct }}%</span>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-5 pt-4 border-t border-zinc-100">
                <p class="text-xs text-zinc-500">Total orders: <span class="font-semibold text-zinc-900">{{ number_format($totalStatusOrders) }}</span></p>
            </div>
            @else
            <div class="flex items-center justify-center h-40">
                <p class="text-sm text-zinc-400">No orders yet.</p>
            </div>
            @endif
        </div>

    </div>

    {{-- ROW 3: Recent Orders + Orders by Source --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">

        {{-- Recent Orders --}}
        <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
            <div class="flex items-center justify-between px-4 sm:px-6 py-4 border-b border-zinc-100">
                <h3 class="text-sm font-semibold text-zinc-900">Recent Orders</h3>
                <a href="{{ route('orders.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-700 transition-colors flex items-center gap-1">
                    View all
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-zinc-50 border-b border-zinc-100">
                            <th class="px-4 sm:px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Order #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden sm:table-cell">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden md:table-cell">Source</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Status</th>
                            <th class="px-4 sm:px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide hidden lg:table-cell">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-4 sm:px-5 py-3.5">
                                <a href="{{ route('orders.show', $order) }}" class="font-mono text-xs text-indigo-600 hover:underline">{{ $order->order_number }}</a>
                            </td>
                            <td class="px-4 py-3.5 text-sm font-medium text-zinc-800 hidden sm:table-cell">{{ $order->customer_name }}</td>
                            <td class="px-4 py-3.5 hidden md:table-cell">
                                <x-ui.badge color="zinc">{{ $order->source_label }}</x-ui.badge>
                            </td>
                            <td class="px-4 py-3.5 text-sm text-zinc-700 tabular-nums">{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3.5">
                                <x-ui.badge :color="$order->status_color">{{ $order->status_label }}</x-ui.badge>
                            </td>
                            <td class="px-4 sm:px-5 py-3.5 text-xs text-zinc-400 hidden lg:table-cell">{{ $order->ordered_at->format('M d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-sm text-zinc-400">No orders yet. <a href="{{ route('orders.create') }}" class="text-indigo-600 hover:underline">Create your first order</a>.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Orders by Source --}}
        <div class="bg-white border border-zinc-200 rounded-xl p-4 sm:p-6">
            <div class="mb-5">
                <h3 class="text-sm font-semibold text-zinc-900">Orders by Source</h3>
                <p class="text-xs text-zinc-500 mt-0.5">All time</p>
            </div>
            <div class="space-y-4">
                @forelse($ordersBySource as $row)
                @php $total = $ordersBySource->sum('count'); $pct = $total > 0 ? round(($row->count / $total) * 100) : 0; @endphp
                <div>
                    <div class="flex items-center gap-3 mb-1.5">
                        <span class="text-sm font-medium text-zinc-900 flex-1 truncate capitalize">{{ \App\Models\Order::SOURCES[$row->source] ?? $row->source }}</span>
                        <span class="text-sm text-zinc-600 tabular-nums shrink-0">{{ $row->count }}</span>
                    </div>
                    <div class="relative w-full bg-zinc-100 h-1.5 rounded-full overflow-hidden">
                        <div class="absolute inset-y-0 left-0 bg-indigo-500 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-zinc-400">No order data yet.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ROW 4: Recent Activity (Dynamic) --}}
    <div class="mt-4 bg-white border border-zinc-200 rounded-xl p-4 sm:p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-sm font-semibold text-zinc-900">Recent Activity</h3>
            <span class="text-xs font-medium text-zinc-500 bg-zinc-50 border border-zinc-200 px-2.5 py-1 rounded-full">Latest</span>
        </div>

        @if($recentActivity->isEmpty())
        <p class="text-sm text-zinc-400 text-center py-6">No recent activity to show.</p>
        @else
        <div class="relative">
            <div class="absolute left-[6px] top-2 bottom-2 w-px bg-zinc-100"></div>

            <div class="space-y-5">
                @foreach($recentActivity as $activity)
                @php
                    $dotColor = match($activity->event) {
                        'created'        => 'bg-indigo-500 ring-indigo-100',
                        'updated'        => 'bg-blue-500 ring-blue-100',
                        'deleted'        => 'bg-red-500 ring-red-100',
                        'status_changed' => 'bg-green-500 ring-green-100',
                        default          => 'bg-zinc-400 ring-zinc-100',
                    };
                    $typeLabel = match(true) {
                        str_contains($activity->auditable_type, 'Order')     => 'Order',
                        str_contains($activity->auditable_type, 'Customer')  => 'Customer',
                        str_contains($activity->auditable_type, 'Product')   => 'Product',
                        str_contains($activity->auditable_type, 'Shipment')  => 'Shipment',
                        str_contains($activity->auditable_type, 'Invoice')   => 'Invoice',
                        str_contains($activity->auditable_type, 'Integrat')  => 'Integration',
                        default => class_basename($activity->auditable_type),
                    };
                    $eventLabel = match($activity->event) {
                        'created'        => 'created',
                        'updated'        => 'updated',
                        'deleted'        => 'deleted',
                        'status_changed' => 'status changed',
                        default          => $activity->event,
                    };
                    $detail = '';
                    if ($activity->event === 'status_changed' && $activity->field === 'status') {
                        $fromLabel = \App\Models\Order::STATUSES[$activity->old_value] ?? $activity->old_value;
                        $toLabel = \App\Models\Order::STATUSES[$activity->new_value] ?? $activity->new_value;
                        $detail = "{$fromLabel} → {$toLabel}";
                    } elseif ($activity->field) {
                        $detail = "{$activity->field} updated";
                    }
                @endphp
                <div class="flex gap-4 relative">
                    <div class="w-3.5 h-3.5 rounded-full {{ $dotColor }} border-2 border-white ring-2 shrink-0 mt-0.5 z-10"></div>
                    <div class="flex-1 min-w-0 -mt-0.5">
                        <p class="text-sm text-zinc-700">
                            <span class="font-medium text-zinc-900">{{ $typeLabel }}</span>
                            #{{ $activity->auditable_id }} {{ $eventLabel }}
                            @if($activity->user)
                            by <span class="font-medium text-zinc-900">{{ $activity->user->name }}</span>
                            @endif
                        </p>
                        @if($detail)
                        <p class="text-xs text-zinc-500 mt-0.5">{{ $detail }}</p>
                        @endif
                        <p class="text-xs text-zinc-400 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

</x-layouts.app>

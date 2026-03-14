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

        {{-- Revenue Over Time --}}
        <div class="lg:col-span-2 bg-white border border-zinc-200 rounded-xl p-6">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900">Revenue Over Time</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">Monthly breakdown</p>
                </div>
                <div class="flex items-center gap-0.5 bg-zinc-50 border border-zinc-200 rounded-md p-0.5 shrink-0">
                    <button class="px-2.5 py-1 text-xs font-medium text-zinc-500 hover:text-zinc-700 rounded transition-colors">This week</button>
                    <button class="px-2.5 py-1 text-xs font-medium bg-white text-zinc-900 rounded shadow-xs border border-zinc-200 transition-colors">This month</button>
                    <button class="px-2.5 py-1 text-xs font-medium text-zinc-500 hover:text-zinc-700 rounded transition-colors">This year</button>
                </div>
            </div>

            {{-- SVG Bar Chart --}}
            <div class="w-full">
                <svg viewBox="0 0 600 210" class="w-full" style="min-height:180px;" preserveAspectRatio="xMidYMid meet">
                    {{-- Y-axis gridlines --}}
                    <line x1="40" y1="10"  x2="590" y2="10"  stroke="#f4f4f5" stroke-width="1" stroke-dasharray="4 3"/>
                    <line x1="40" y1="52"  x2="590" y2="52"  stroke="#f4f4f5" stroke-width="1" stroke-dasharray="4 3"/>
                    <line x1="40" y1="94"  x2="590" y2="94"  stroke="#f4f4f5" stroke-width="1" stroke-dasharray="4 3"/>
                    <line x1="40" y1="136" x2="590" y2="136" stroke="#f4f4f5" stroke-width="1" stroke-dasharray="4 3"/>

                    {{-- Y-axis labels --}}
                    <text x="34" y="13"  text-anchor="end" font-size="9" fill="#a1a1aa">$60k</text>
                    <text x="34" y="55"  text-anchor="end" font-size="9" fill="#a1a1aa">$45k</text>
                    <text x="34" y="97"  text-anchor="end" font-size="9" fill="#a1a1aa">$30k</text>
                    <text x="34" y="139" text-anchor="end" font-size="9" fill="#a1a1aa">$15k</text>

                    {{-- Chart baseline --}}
                    <line x1="40" y1="156" x2="590" y2="156" stroke="#e4e4e7" stroke-width="1"/>

                    {{-- Bars: max height = 146px (y=10 to y=156). Jan=45%=65.7, Feb=52%=75.9, Mar=48%=70.1, Apr=67%=97.8, May=71%=103.7, Jun=85%=124.1, Jul=78%=113.9, Aug=88%=128.5, Sep=76%=110.9, Oct=82%=119.7, Nov=91%=132.9, Dec=95%=138.7 --}}

                    {{-- Jan --}}
                    <rect x="47"  y="90"  width="30" height="66"  rx="2" fill="#6366f1" opacity="0.55"/>
                    <text x="62"  y="85"  text-anchor="middle" font-size="8" fill="#6366f1">$27k</text>
                    <text x="62"  y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">Jan</text>

                    {{-- Feb --}}
                    <rect x="89"  y="80"  width="30" height="76"  rx="2" fill="#6366f1" opacity="0.60"/>
                    <text x="104" y="75"  text-anchor="middle" font-size="8" fill="#6366f1">$31k</text>
                    <text x="104" y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">Feb</text>

                    {{-- Mar --}}
                    <rect x="131" y="86"  width="30" height="70"  rx="2" fill="#6366f1" opacity="0.57"/>
                    <text x="146" y="81"  text-anchor="middle" font-size="8" fill="#6366f1">$29k</text>
                    <text x="146" y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">Mar</text>

                    {{-- Apr --}}
                    <rect x="173" y="58"  width="30" height="98"  rx="2" fill="#6366f1" opacity="0.68"/>
                    <text x="188" y="53"  text-anchor="middle" font-size="8" fill="#6366f1">$40k</text>
                    <text x="188" y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">Apr</text>

                    {{-- May --}}
                    <rect x="215" y="52"  width="30" height="104" rx="2" fill="#6366f1" opacity="0.71"/>
                    <text x="230" y="47"  text-anchor="middle" font-size="8" fill="#6366f1">$43k</text>
                    <text x="230" y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">May</text>

                    {{-- Jun --}}
                    <rect x="257" y="32"  width="30" height="124" rx="2" fill="#6366f1" opacity="0.80"/>
                    <text x="272" y="27"  text-anchor="middle" font-size="8" fill="#6366f1">$51k</text>
                    <text x="272" y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">Jun</text>

                    {{-- Jul --}}
                    <rect x="299" y="42"  width="30" height="114" rx="2" fill="#6366f1" opacity="0.76"/>
                    <text x="314" y="37"  text-anchor="middle" font-size="8" fill="#6366f1">$47k</text>
                    <text x="314" y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">Jul</text>

                    {{-- Aug --}}
                    <rect x="341" y="27"  width="30" height="129" rx="2" fill="#6366f1" opacity="0.83"/>
                    <text x="356" y="22"  text-anchor="middle" font-size="8" fill="#6366f1">$53k</text>
                    <text x="356" y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">Aug</text>

                    {{-- Sep --}}
                    <rect x="383" y="45"  width="30" height="111" rx="2" fill="#6366f1" opacity="0.74"/>
                    <text x="398" y="40"  text-anchor="middle" font-size="8" fill="#6366f1">$46k</text>
                    <text x="398" y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">Sep</text>

                    {{-- Oct --}}
                    <rect x="425" y="36"  width="30" height="120" rx="2" fill="#6366f1" opacity="0.80"/>
                    <text x="440" y="31"  text-anchor="middle" font-size="8" fill="#6366f1">$49k</text>
                    <text x="440" y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">Oct</text>

                    {{-- Nov --}}
                    <rect x="467" y="23"  width="30" height="133" rx="2" fill="#6366f1" opacity="0.87"/>
                    <text x="482" y="18"  text-anchor="middle" font-size="8" fill="#6366f1">$55k</text>
                    <text x="482" y="172" text-anchor="middle" font-size="9" fill="#a1a1aa">Nov</text>

                    {{-- Dec (highlighted) --}}
                    <rect x="509" y="17"  width="30" height="139" rx="2" fill="#6366f1"/>
                    <text x="524" y="12"  text-anchor="middle" font-size="8" fill="#6366f1" font-weight="600">$57k</text>
                    <text x="524" y="172" text-anchor="middle" font-size="9" fill="#6366f1" font-weight="600">Dec</text>
                </svg>
            </div>
        </div>

        {{-- Orders by Status --}}
        <div class="bg-white border border-zinc-200 rounded-xl p-6">
            <div class="mb-5">
                <h3 class="text-sm font-semibold text-zinc-900">Order Status</h3>
                <p class="text-xs text-zinc-500 mt-0.5">This month</p>
            </div>

            {{-- SVG Donut - circumference of r=46: 2π×46 ≈ 289 --}}
            {{-- Delivered 42%=121.4, Processing 30%=86.7, Pending 17%=49.1, Cancelled 11%=31.8 --}}
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <svg viewBox="0 0 120 120" width="120" height="120">
                        <circle cx="60" cy="60" r="46" fill="none" stroke="#f4f4f5" stroke-width="12"/>
                        <circle cx="60" cy="60" r="46" fill="none" stroke="#22c55e" stroke-width="12"
                            stroke-dasharray="121.4 289" stroke-dashoffset="72.25"
                            stroke-linecap="butt" transform="rotate(-90 60 60)"/>
                        <circle cx="60" cy="60" r="46" fill="none" stroke="#3b82f6" stroke-width="12"
                            stroke-dasharray="86.7 289" stroke-dashoffset="-49.15"
                            stroke-linecap="butt" transform="rotate(-90 60 60)"/>
                        <circle cx="60" cy="60" r="46" fill="none" stroke="#eab308" stroke-width="12"
                            stroke-dasharray="49.1 289" stroke-dashoffset="-135.85"
                            stroke-linecap="butt" transform="rotate(-90 60 60)"/>
                        <circle cx="60" cy="60" r="46" fill="none" stroke="#ef4444" stroke-width="12"
                            stroke-dasharray="31.8 289" stroke-dashoffset="-184.95"
                            stroke-linecap="butt" transform="rotate(-90 60 60)"/>
                        <text x="60" y="56" text-anchor="middle" font-size="13" font-weight="600" fill="#18181b">1,284</text>
                        <text x="60" y="70" text-anchor="middle" font-size="9" fill="#71717a">orders</text>
                    </svg>
                </div>
            </div>

            {{-- Legend --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500 shrink-0"></span>
                        <span class="text-xs text-zinc-600">Delivered</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-zinc-900">542</span>
                        <span class="text-xs text-zinc-400 w-8 text-right">42%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 shrink-0"></span>
                        <span class="text-xs text-zinc-600">Processing</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-zinc-900">384</span>
                        <span class="text-xs text-zinc-400 w-8 text-right">30%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 shrink-0"></span>
                        <span class="text-xs text-zinc-600">Pending</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-zinc-900">218</span>
                        <span class="text-xs text-zinc-400 w-8 text-right">17%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shrink-0"></span>
                        <span class="text-xs text-zinc-600">Cancelled</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-zinc-900">140</span>
                        <span class="text-xs text-zinc-400 w-8 text-right">11%</span>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-4 border-t border-zinc-100">
                <p class="text-xs text-zinc-500">Total this month: <span class="font-semibold text-zinc-900">1,284</span></p>
            </div>
        </div>

    </div>

    {{-- ROW 3: Recent Orders + Top Products --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">

        {{-- Recent Orders --}}
        <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100">
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
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Order #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Source</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('orders.show', $order) }}" class="font-mono text-xs text-indigo-600 hover:underline">{{ $order->order_number }}</a>
                            </td>
                            <td class="px-4 py-3.5 text-sm font-medium text-zinc-800">{{ $order->customer_name }}</td>
                            <td class="px-4 py-3.5">
                                <x-ui.badge color="zinc">{{ $order->source_label }}</x-ui.badge>
                            </td>
                            <td class="px-4 py-3.5 text-sm text-zinc-700 tabular-nums">{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3.5">
                                <x-ui.badge :color="$order->status_color">{{ $order->status_label }}</x-ui.badge>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-zinc-400">{{ $order->ordered_at->format('M d') }}</td>
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
        <div class="bg-white border border-zinc-200 rounded-xl p-6">
            <div class="mb-5">
                <h3 class="text-sm font-semibold text-zinc-900">Orders by Source</h3>
                <p class="text-xs text-zinc-500 mt-0.5">all time</p>
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

    {{-- ROW 4: Activity Feed --}}
    <div class="mt-4 bg-white border border-zinc-200 rounded-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-sm font-semibold text-zinc-900">Recent Activity</h3>
            <span class="text-xs font-medium text-zinc-500 bg-zinc-50 border border-zinc-200 px-2.5 py-1 rounded-full">Today</span>
        </div>

        <div class="relative">
            <div class="absolute left-[6px] top-2 bottom-2 w-px bg-zinc-100"></div>

            <div class="space-y-5">

                <div class="flex gap-4 relative">
                    <div class="w-3.5 h-3.5 rounded-full bg-indigo-500 border-2 border-white ring-2 ring-indigo-100 shrink-0 mt-0.5 z-10"></div>
                    <div class="flex-1 min-w-0 -mt-0.5">
                        <p class="text-sm text-zinc-700">New order <span class="font-medium text-zinc-900">#ORD-0284</span> received from <span class="font-medium text-zinc-900">Acme Ltd</span></p>
                        <p class="text-xs text-zinc-400 mt-0.5">2 min ago</p>
                    </div>
                </div>

                <div class="flex gap-4 relative">
                    <div class="w-3.5 h-3.5 rounded-full bg-green-500 border-2 border-white ring-2 ring-green-100 shrink-0 mt-0.5 z-10"></div>
                    <div class="flex-1 min-w-0 -mt-0.5">
                        <p class="text-sm text-zinc-700">Payment confirmed for Invoice <span class="font-medium text-zinc-900">#INV-091</span></p>
                        <p class="text-xs text-zinc-400 mt-0.5">1 hr ago</p>
                    </div>
                </div>

                <div class="flex gap-4 relative">
                    <div class="w-3.5 h-3.5 rounded-full bg-yellow-500 border-2 border-white ring-2 ring-yellow-100 shrink-0 mt-0.5 z-10"></div>
                    <div class="flex-1 min-w-0 -mt-0.5">
                        <p class="text-sm text-zinc-700">Low stock alert: <span class="font-medium text-zinc-900">SKU-443 (Cable Set Pro)</span> below 10 units</p>
                        <p class="text-xs text-zinc-400 mt-0.5">2 hr ago</p>
                    </div>
                </div>

                <div class="flex gap-4 relative">
                    <div class="w-3.5 h-3.5 rounded-full bg-blue-500 border-2 border-white ring-2 ring-blue-100 shrink-0 mt-0.5 z-10"></div>
                    <div class="flex-1 min-w-0 -mt-0.5">
                        <p class="text-sm text-zinc-700">Customer <span class="font-medium text-zinc-900">Emma Wilson</span> registered</p>
                        <p class="text-xs text-zinc-400 mt-0.5">3 hr ago</p>
                    </div>
                </div>

                <div class="flex gap-4 relative">
                    <div class="w-3.5 h-3.5 rounded-full bg-green-500 border-2 border-white ring-2 ring-green-100 shrink-0 mt-0.5 z-10"></div>
                    <div class="flex-1 min-w-0 -mt-0.5">
                        <p class="text-sm text-zinc-700">Order <span class="font-medium text-zinc-900">#ORD-0279</span> shipped via <span class="font-medium text-zinc-900">FedEx</span></p>
                        <p class="text-xs text-zinc-400 mt-0.5">5 hr ago</p>
                    </div>
                </div>

                <div class="flex gap-4 relative">
                    <div class="w-3.5 h-3.5 rounded-full bg-zinc-400 border-2 border-white ring-2 ring-zinc-100 shrink-0 mt-0.5 z-10"></div>
                    <div class="flex-1 min-w-0 -mt-0.5">
                        <p class="text-sm text-zinc-700">Settings updated by <span class="font-medium text-zinc-900">Admin</span></p>
                        <p class="text-xs text-zinc-400 mt-0.5">8 hr ago</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layouts.app>

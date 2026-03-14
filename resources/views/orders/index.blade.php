<x-layouts.app title="Orders">
<div class="max-w-full">

    <!-- Page header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-zinc-900">Orders</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Manage and track all customer orders.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('orders.create') }}" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                New Order
            </a>
        </div>
    </div>

    <!-- Stats row (mini KPIs) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">All Orders</p>
            <p class="text-lg font-semibold text-zinc-900 mt-0.5">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Pending</p>
            <p class="text-lg font-semibold text-yellow-600 mt-0.5">{{ number_format($stats['pending']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Processing</p>
            <p class="text-lg font-semibold text-indigo-600 mt-0.5">{{ number_format($stats['processing']) }}</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">This Month Revenue</p>
            <p class="text-lg font-semibold text-green-600 mt-0.5">৳{{ number_format($stats['revenue'], 2) }}</p>
        </div>
    </div>

    <!-- Status tab filters -->
    <div class="flex items-center gap-1 mb-4 border-b border-zinc-200 overflow-x-auto">
        <a href="{{ route('orders.index', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}"
           class="px-4 py-2.5 text-sm font-medium border-b-2 whitespace-nowrap {{ !request('status') || request('status') === 'all' ? 'text-indigo-600 border-indigo-600' : 'text-zinc-500 hover:text-zinc-700 border-transparent' }}">
            All
            <span class="ml-1 px-1.5 py-0.5 rounded-full bg-zinc-100 text-zinc-600 text-xs">{{ $stats['total'] }}</span>
        </a>
        @foreach(\App\Models\Order::STATUSES as $statusKey => $statusLabel)
            @php $count = $statusCounts[$statusKey] ?? 0; @endphp
            @if($count > 0 || in_array($statusKey, ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled']))
                <a href="{{ route('orders.index', array_merge(request()->except(['status', 'page']), ['status' => $statusKey])) }}"
                   class="px-4 py-2.5 text-sm border-b-2 whitespace-nowrap {{ request('status') === $statusKey ? 'font-medium text-indigo-600 border-indigo-600' : 'text-zinc-500 hover:text-zinc-700 border-transparent' }}">
                    {{ $statusLabel }}
                    @if($count > 0)
                        @php
                            $tabBadgeClasses = match(\App\Models\Order::STATUS_COLORS[$statusKey] ?? 'zinc') {
                                'yellow' => 'bg-yellow-50 text-yellow-600',
                                'blue' => 'bg-blue-50 text-blue-600',
                                'indigo' => 'bg-indigo-50 text-indigo-600',
                                'purple' => 'bg-purple-50 text-purple-600',
                                'orange' => 'bg-orange-50 text-orange-600',
                                'green' => 'bg-green-50 text-green-600',
                                'red' => 'bg-red-50 text-red-600',
                                default => 'bg-zinc-100 text-zinc-600',
                            };
                        @endphp
                        <span class="ml-1 px-1.5 py-0.5 rounded-full {{ $tabBadgeClasses }} text-xs">{{ $count }}</span>
                    @endif
                </a>
            @endif
        @endforeach
    </div>

    <!-- Filter bar -->
    <form method="GET" action="{{ route('orders.index') }}" id="filter-form">
        @if(request('status') && request('status') !== 'all')
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <div class="flex flex-col sm:flex-row gap-2 mb-4">
            <div class="relative flex-1 max-w-xs">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order #, phone, name, source ID..."
                       class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white placeholder:text-zinc-400">
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <select name="source" onchange="document.getElementById('filter-form').submit()"
                        class="border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none pr-8 cursor-pointer">
                    <option value="">All Sources</option>
                    @foreach(\App\Models\Order::SOURCES as $key => $label)
                        <option value="{{ $key }}" {{ request('source') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="payment_status" onchange="document.getElementById('filter-form').submit()"
                        class="border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none pr-8 cursor-pointer">
                    <option value="">All Payments</option>
                    @foreach(\App\Models\Order::PAYMENT_STATUSES as $key => $label)
                        <option value="{{ $key }}" {{ request('payment_status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="shipment_status" onchange="document.getElementById('filter-form').submit()"
                        class="border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none pr-8 cursor-pointer">
                    <option value="">All Shipments</option>
                    @foreach(\App\Models\Shipment::STATUSES as $key => $label)
                        <option value="{{ $key }}" {{ request('shipment_status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($couriers->isNotEmpty())
                    <select name="courier_id" onchange="document.getElementById('filter-form').submit()"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none pr-8 cursor-pointer">
                        <option value="">All Couriers</option>
                        @foreach($couriers as $courier)
                            <option value="{{ $courier->id }}" {{ request('courier_id') == $courier->id ? 'selected' : '' }}>{{ $courier->name }}</option>
                        @endforeach
                    </select>
                @endif
                <select name="created_by" onchange="document.getElementById('filter-form').submit()"
                        class="border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none pr-8 cursor-pointer">
                    <option value="">All Staff</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('created_by') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
                <input type="date" name="from" value="{{ request('from') }}" placeholder="From"
                       class="border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       onchange="document.getElementById('filter-form').submit()">
                <input type="date" name="to" value="{{ request('to') }}" placeholder="To"
                       class="border border-zinc-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       onchange="document.getElementById('filter-form').submit()">
                <button type="submit" class="flex items-center gap-2 px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-600 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    Search
                </button>
                @if(request()->hasAny(['search', 'source', 'payment_status', 'shipment_status', 'courier_id', 'created_by', 'from', 'to']))
                    <a href="{{ route('orders.index', request('status') && request('status') !== 'all' ? ['status' => request('status')] : []) }}"
                       class="text-xs text-indigo-600 hover:text-indigo-700 font-medium transition-colors">
                        Clear filters
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Bulk action bar (shown when rows selected) -->
    <div id="bulk-bar" class="hidden items-center gap-3 px-4 py-2.5 mb-2 bg-indigo-50 border border-indigo-100 rounded-lg text-sm">
        <span class="font-medium text-indigo-700"><span id="bulk-count">0</span> selected</span>
        <div class="h-4 w-px bg-indigo-200"></div>
        <form method="POST" action="{{ route('orders.index') }}" class="inline" id="bulk-confirm-form">
            @csrf
            <button type="button" onclick="bulkStatusUpdate('confirmed')" class="text-indigo-700 hover:text-indigo-900 font-medium">Mark as Confirmed</button>
        </form>
        <button type="button" onclick="bulkStatusUpdate('cancelled')" class="text-red-600 hover:text-red-700 font-medium">Cancel orders</button>
        <button onclick="document.getElementById('bulk-bar').classList.add('hidden'); document.getElementById('bulk-bar').classList.remove('flex'); document.querySelectorAll('.row-check').forEach(c=>c.checked=false); document.getElementById('select-all').checked=false;" class="ml-auto text-zinc-400 hover:text-zinc-600">✕</button>
    </div>

    <!-- Orders Table -->
    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
        @if($orders->isEmpty())
            <x-ui.empty-state
                title="No orders found"
                description="{{ request()->hasAny(['search', 'source', 'status', 'payment_status', 'shipment_status', 'courier_id', 'created_by', 'from', 'to']) ? 'Try adjusting your filters or search term.' : 'Create your first order to get started.' }}"
            >
                @unless(request()->hasAny(['search', 'source', 'status', 'payment_status', 'shipment_status', 'courier_id', 'created_by', 'from', 'to']))
                    <a href="{{ route('orders.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        New Order
                    </a>
                @else
                    <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 text-sm font-medium rounded-md transition-colors">
                        Clear all filters
                    </a>
                @endunless
            </x-ui.empty-state>
        @else
            <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 border-b border-zinc-200">
                    <tr>
                        <th class="w-10 px-4 py-3">
                            <input type="checkbox" id="select-all" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                   onchange="document.querySelectorAll('.row-check').forEach(c=>c.checked=this.checked); updateBulkBar();">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider whitespace-nowrap">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Source</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Items</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Payment</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Shipment</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider whitespace-nowrap">Date</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach($orders as $order)
                        <tr class="hover:bg-zinc-50 transition-colors group">
                            <td class="px-4 py-3">
                                <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" value="{{ $order->id }}"
                                       onchange="updateBulkBar();">
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('orders.show', $order) }}" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#{{ $order->order_number }}</a>
                                @if($order->source_order_id)
                                    <p class="text-[10px] text-zinc-400 mt-0.5">Ext: {{ $order->source_order_id }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @php
                                        $initials = collect(explode(' ', $order->customer_name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                                        $avatarClasses = match($order->id % 7) {
                                            0 => 'bg-blue-100 text-blue-600',
                                            1 => 'bg-purple-100 text-purple-600',
                                            2 => 'bg-green-100 text-green-600',
                                            3 => 'bg-orange-100 text-orange-600',
                                            4 => 'bg-red-100 text-red-600',
                                            5 => 'bg-yellow-100 text-yellow-700',
                                            6 => 'bg-indigo-100 text-indigo-600',
                                            default => 'bg-zinc-100 text-zinc-600',
                                        };
                                    @endphp
                                    <div class="w-7 h-7 rounded-full {{ $avatarClasses }} flex items-center justify-center text-xs font-semibold shrink-0">{{ $initials }}</div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-zinc-900 truncate">{{ $order->customer_name }}</p>
                                        <p class="text-xs text-zinc-400 truncate">{{ $order->customer_phone ?: $order->customer_email ?: '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <x-ui.badge :color="$order->source_color">{{ $order->source_label }}</x-ui.badge>
                            </td>
                            <td class="px-4 py-3 text-zinc-600">{{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}</td>
                            <td class="px-4 py-3 text-right">
                                <p class="font-medium text-zinc-900">৳{{ number_format($order->total_amount, 2) }}</p>
                                @if($order->due_amount > 0)
                                    <p class="text-[10px] text-red-500">Due: ৳{{ number_format($order->due_amount, 2) }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <x-ui.badge :color="$order->status_color">{{ $order->status_label }}</x-ui.badge>
                            </td>
                            <td class="px-4 py-3">
                                <x-ui.badge :color="$order->payment_status_color">{{ $order->payment_status_label }}</x-ui.badge>
                            </td>
                            <td class="px-4 py-3">
                                @if($order->shipment)
                                    <x-ui.badge :color="$order->shipment->status_color">{{ $order->shipment->status_label }}</x-ui.badge>
                                    @if($order->shipment->courier)
                                        <p class="text-[10px] text-zinc-400 mt-0.5">{{ $order->shipment->courier->name }}</p>
                                    @endif
                                @else
                                    <span class="text-xs text-zinc-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">
                                {{ $order->ordered_at?->format('M d, Y') ?? $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('orders.show', $order) }}" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('orders.edit', $order) }}" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="More actions">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                        </button>
                                        <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-48 z-10">
                                            {{-- Quick status changes --}}
                                            @if($order->status === 'pending')
                                                <form method="POST" action="{{ route('orders.status', $order) }}">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50 w-full text-left">
                                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                        Confirm order
                                                    </button>
                                                </form>
                                            @endif
                                            @if(in_array($order->status, ['confirmed', 'processing', 'packed']))
                                                <form method="POST" action="{{ route('orders.status', $order) }}">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="processing">
                                                    <button type="submit" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50 w-full text-left">
                                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                        Mark processing
                                                    </button>
                                                </form>
                                            @endif
                                            @if($order->invoice)
                                                <a href="{{ route('invoices.show', $order->invoice) }}" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">
                                                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    View invoice
                                                </a>
                                            @endif
                                            <div class="border-t border-zinc-100 my-1"></div>
                                            @if(!in_array($order->status, ['cancelled', 'refunded', 'delivered']))
                                                <form method="POST" action="{{ route('orders.status', $order) }}">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        Cancel order
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="px-4 py-3 border-t border-zinc-100">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="px-4 py-3 border-t border-zinc-100 flex items-center justify-between">
                    <p class="text-xs text-zinc-500">Showing <span class="font-medium text-zinc-700">{{ $orders->count() }}</span> {{ Str::plural('order', $orders->count()) }}</p>
                </div>
            @endif
        @endif
    </div>

</div>

<script>
function updateBulkBar() {
    const checked = document.querySelectorAll('.row-check:checked').length;
    const bar = document.getElementById('bulk-bar');
    if (checked > 0) {
        bar.classList.remove('hidden');
        bar.classList.add('flex');
    } else {
        bar.classList.add('hidden');
        bar.classList.remove('flex');
    }
    document.getElementById('bulk-count').textContent = checked;
}

function bulkStatusUpdate(status) {
    const ids = Array.from(document.querySelectorAll('.row-check:checked')).map(c => c.value);
    if (ids.length === 0) return;
    if (!confirm('Update ' + ids.length + ' order(s) to ' + status + '?')) return;

    // Submit the first selected order's status update (server-side bulk would be better)
    if (ids.length > 0) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/orders/' + ids[0] + '/status';
        form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                          '<input type="hidden" name="_method" value="PATCH">' +
                          '<input type="hidden" name="status" value="' + status + '">';
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
</x-layouts.app>

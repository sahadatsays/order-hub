<x-layouts.app title="Orders">
<div class="max-w-full">

    <!-- Page header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-zinc-900">Orders</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Manage and track all customer orders.</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="flex items-center gap-2 px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </button>
            <button class="flex items-center gap-2 px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"/>
                </svg>
                Import
            </button>
            <a href="#" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
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
            <p class="text-lg font-semibold text-zinc-900 mt-0.5">1,284</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Pending</p>
            <p class="text-lg font-semibold text-yellow-600 mt-0.5">24</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">Processing</p>
            <p class="text-lg font-semibold text-indigo-600 mt-0.5">47</p>
        </div>
        <div class="bg-white border border-zinc-200 rounded-lg px-4 py-3">
            <p class="text-xs text-zinc-500">This Month</p>
            <p class="text-lg font-semibold text-green-600 mt-0.5">$48.3k</p>
        </div>
    </div>

    <!-- Status tab filters -->
    <div class="flex items-center gap-1 mb-4 border-b border-zinc-200 overflow-x-auto">
        <button class="px-4 py-2.5 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600 whitespace-nowrap">All <span class="ml-1 px-1.5 py-0.5 rounded-full bg-zinc-100 text-zinc-600 text-xs">1,284</span></button>
        <button class="px-4 py-2.5 text-sm font-medium text-zinc-500 hover:text-zinc-700 border-b-2 border-transparent whitespace-nowrap">Pending <span class="ml-1 px-1.5 py-0.5 rounded-full bg-yellow-50 text-yellow-600 text-xs">24</span></button>
        <button class="px-4 py-2.5 text-sm text-zinc-500 hover:text-zinc-700 border-b-2 border-transparent whitespace-nowrap">Confirmed</button>
        <button class="px-4 py-2.5 text-sm text-zinc-500 hover:text-zinc-700 border-b-2 border-transparent whitespace-nowrap">Processing</button>
        <button class="px-4 py-2.5 text-sm text-zinc-500 hover:text-zinc-700 border-b-2 border-transparent whitespace-nowrap">Shipped</button>
        <button class="px-4 py-2.5 text-sm text-zinc-500 hover:text-zinc-700 border-b-2 border-transparent whitespace-nowrap">Delivered</button>
        <button class="px-4 py-2.5 text-sm text-zinc-500 hover:text-zinc-700 border-b-2 border-transparent whitespace-nowrap">Cancelled</button>
    </div>

    <!-- Filter bar -->
    <div class="flex flex-col sm:flex-row gap-2 mb-4">
        <div class="relative flex-1 max-w-xs">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
            </div>
            <input type="text" placeholder="Search orders..." class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white placeholder:text-zinc-400">
        </div>
        <div class="flex items-center gap-2">
            <button class="flex items-center gap-2 px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-600 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Date range
                <svg class="w-3 h-3 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <button class="flex items-center gap-2 px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-600 transition-colors">
                Customer
                <svg class="w-3 h-3 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <button class="flex items-center gap-2 px-3 py-2 text-sm border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 text-zinc-600 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                More filters
            </button>
        </div>
    </div>

    <!-- Bulk action bar (shown when rows selected) -->
    <div id="bulk-bar" class="hidden items-center gap-3 px-4 py-2.5 mb-2 bg-indigo-50 border border-indigo-100 rounded-lg text-sm">
        <span class="font-medium text-indigo-700"><span id="bulk-count">0</span> selected</span>
        <div class="h-4 w-px bg-indigo-200"></div>
        <button class="text-indigo-700 hover:text-indigo-900 font-medium">Mark as Confirmed</button>
        <button class="text-indigo-700 hover:text-indigo-900 font-medium">Export selected</button>
        <button class="text-red-600 hover:text-red-700 font-medium">Cancel orders</button>
        <button onclick="document.getElementById('bulk-bar').classList.add('hidden')" class="ml-auto text-zinc-400 hover:text-zinc-600">✕</button>
    </div>

    <!-- Orders Table -->
    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 border-b border-zinc-200">
                <tr>
                    <th class="w-10 px-4 py-3">
                        <input type="checkbox" id="select-all" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="document.querySelectorAll('.row-check').forEach(c=>c.checked=this.checked); document.getElementById('bulk-bar').classList.toggle('hidden', !this.checked); document.getElementById('bulk-count').textContent = this.checked ? document.querySelectorAll('.row-check').length : 0;">
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider whitespace-nowrap">Order</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Items</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Payment</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider whitespace-nowrap">Date</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">

                {{-- Row 1: #ORD-0284 | Acme Corp | Delivered | Paid --}}
                <tr class="hover:bg-zinc-50 transition-colors group">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="const c=document.querySelectorAll('.row-check:checked').length; document.getElementById('bulk-bar').classList.toggle('hidden',c===0); document.getElementById('bulk-count').textContent=c;">
                    </td>
                    <td class="px-4 py-3">
                        <a href="#" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#ORD-0284</a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-xs font-semibold text-blue-600 shrink-0">AC</div>
                            <div>
                                <p class="font-medium text-zinc-900">Acme Corp</p>
                                <p class="text-xs text-zinc-400">sarah@acmecorp.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600">3 items</td>
                    <td class="px-4 py-3 font-medium text-zinc-900">$1,240.00</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Delivered</span></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Paid</span></td>
                    <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">Mar 14, 2026</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Print invoice</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Send email</a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Row 2: #ORD-0283 | TechStart Inc | Processing | Paid --}}
                <tr class="hover:bg-zinc-50 transition-colors group">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="const c=document.querySelectorAll('.row-check:checked').length; document.getElementById('bulk-bar').classList.toggle('hidden',c===0); document.getElementById('bulk-count').textContent=c;">
                    </td>
                    <td class="px-4 py-3">
                        <a href="#" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#ORD-0283</a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-purple-100 flex items-center justify-center text-xs font-semibold text-purple-600 shrink-0">TS</div>
                            <div>
                                <p class="font-medium text-zinc-900">TechStart Inc</p>
                                <p class="text-xs text-zinc-400">mike@techstart.io</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600">1 item</td>
                    <td class="px-4 py-3 font-medium text-zinc-900">$890.00</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">Processing</span></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Paid</span></td>
                    <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">Mar 13, 2026</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Print invoice</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Send email</a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Row 3: #ORD-0282 | BlueSky Ltd | Pending | Pending --}}
                <tr class="hover:bg-zinc-50 transition-colors group">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="const c=document.querySelectorAll('.row-check:checked').length; document.getElementById('bulk-bar').classList.toggle('hidden',c===0); document.getElementById('bulk-count').textContent=c;">
                    </td>
                    <td class="px-4 py-3">
                        <a href="#" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#ORD-0282</a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center text-xs font-semibold text-green-600 shrink-0">BS</div>
                            <div>
                                <p class="font-medium text-zinc-900">BlueSky Ltd</p>
                                <p class="text-xs text-zinc-400">hello@bluesky.co</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600">5 items</td>
                    <td class="px-4 py-3 font-medium text-zinc-900">$2,100.00</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">Pending</span></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">Pending</span></td>
                    <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">Mar 13, 2026</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Print invoice</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Send email</a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Row 4: #ORD-0281 | Nexus Group | Shipped | Paid --}}
                <tr class="hover:bg-zinc-50 transition-colors group">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="const c=document.querySelectorAll('.row-check:checked').length; document.getElementById('bulk-bar').classList.toggle('hidden',c===0); document.getElementById('bulk-count').textContent=c;">
                    </td>
                    <td class="px-4 py-3">
                        <a href="#" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#ORD-0281</a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-orange-100 flex items-center justify-center text-xs font-semibold text-orange-600 shrink-0">NG</div>
                            <div>
                                <p class="font-medium text-zinc-900">Nexus Group</p>
                                <p class="text-xs text-zinc-400">ops@nexus.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600">2 items</td>
                    <td class="px-4 py-3 font-medium text-zinc-900">$450.00</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700">Shipped</span></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Paid</span></td>
                    <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">Mar 12, 2026</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Print invoice</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Send email</a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Row 5: #ORD-0280 | Summit Solutions | Cancelled | Refunded --}}
                <tr class="hover:bg-zinc-50 transition-colors group">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="const c=document.querySelectorAll('.row-check:checked').length; document.getElementById('bulk-bar').classList.toggle('hidden',c===0); document.getElementById('bulk-count').textContent=c;">
                    </td>
                    <td class="px-4 py-3">
                        <a href="#" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#ORD-0280</a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-red-100 flex items-center justify-center text-xs font-semibold text-red-600 shrink-0">SS</div>
                            <div>
                                <p class="font-medium text-zinc-900">Summit Solutions</p>
                                <p class="text-xs text-zinc-400">orders@summit.io</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600">4 items</td>
                    <td class="px-4 py-3 font-medium text-zinc-900">$3,200.00</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Cancelled</span></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-600">Refunded</span></td>
                    <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">Mar 12, 2026</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Print invoice</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Send email</a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Row 6: #ORD-0279 | Vertex Co | Confirmed | Paid --}}
                <tr class="hover:bg-zinc-50 transition-colors group">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="const c=document.querySelectorAll('.row-check:checked').length; document.getElementById('bulk-bar').classList.toggle('hidden',c===0); document.getElementById('bulk-count').textContent=c;">
                    </td>
                    <td class="px-4 py-3">
                        <a href="#" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#ORD-0279</a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-yellow-100 flex items-center justify-center text-xs font-semibold text-yellow-700 shrink-0">VC</div>
                            <div>
                                <p class="font-medium text-zinc-900">Vertex Co</p>
                                <p class="text-xs text-zinc-400">info@vertex.co</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600">2 items</td>
                    <td class="px-4 py-3 font-medium text-zinc-900">$670.00</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Confirmed</span></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Paid</span></td>
                    <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">Mar 11, 2026</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Print invoice</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Send email</a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Row 7: #ORD-0278 | Pinnacle LLC | Delivered | Paid --}}
                <tr class="hover:bg-zinc-50 transition-colors group">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="const c=document.querySelectorAll('.row-check:checked').length; document.getElementById('bulk-bar').classList.toggle('hidden',c===0); document.getElementById('bulk-count').textContent=c;">
                    </td>
                    <td class="px-4 py-3">
                        <a href="#" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#ORD-0278</a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-semibold text-indigo-600 shrink-0">PL</div>
                            <div>
                                <p class="font-medium text-zinc-900">Pinnacle LLC</p>
                                <p class="text-xs text-zinc-400">orders@pinnacle.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600">1 item</td>
                    <td class="px-4 py-3 font-medium text-zinc-900">$1,580.00</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Delivered</span></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Paid</span></td>
                    <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">Mar 11, 2026</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Print invoice</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Send email</a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Row 8: #ORD-0277 | CloudBase Inc | Processing | Paid --}}
                <tr class="hover:bg-zinc-50 transition-colors group">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="const c=document.querySelectorAll('.row-check:checked').length; document.getElementById('bulk-bar').classList.toggle('hidden',c===0); document.getElementById('bulk-count').textContent=c;">
                    </td>
                    <td class="px-4 py-3">
                        <a href="#" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#ORD-0277</a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-xs font-semibold text-blue-600 shrink-0">CB</div>
                            <div>
                                <p class="font-medium text-zinc-900">CloudBase Inc</p>
                                <p class="text-xs text-zinc-400">hi@cloudbase.io</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600">6 items</td>
                    <td class="px-4 py-3 font-medium text-zinc-900">$4,100.00</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">Processing</span></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Paid</span></td>
                    <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">Mar 10, 2026</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Print invoice</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Send email</a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Row 9: #ORD-0276 | Redline Corp | Pending | Pending --}}
                <tr class="hover:bg-zinc-50 transition-colors group">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="const c=document.querySelectorAll('.row-check:checked').length; document.getElementById('bulk-bar').classList.toggle('hidden',c===0); document.getElementById('bulk-count').textContent=c;">
                    </td>
                    <td class="px-4 py-3">
                        <a href="#" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#ORD-0276</a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-red-100 flex items-center justify-center text-xs font-semibold text-red-600 shrink-0">RC</div>
                            <div>
                                <p class="font-medium text-zinc-900">Redline Corp</p>
                                <p class="text-xs text-zinc-400">team@redline.io</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600">1 item</td>
                    <td class="px-4 py-3 font-medium text-zinc-900">$220.00</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">Pending</span></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">Pending</span></td>
                    <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">Mar 10, 2026</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Print invoice</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Send email</a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Row 10: #ORD-0275 | FastTrack Ltd | Delivered | Paid --}}
                <tr class="hover:bg-zinc-50 transition-colors group">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="row-check rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="const c=document.querySelectorAll('.row-check:checked').length; document.getElementById('bulk-bar').classList.toggle('hidden',c===0); document.getElementById('bulk-count').textContent=c;">
                    </td>
                    <td class="px-4 py-3">
                        <a href="#" class="font-mono text-xs font-medium text-indigo-600 hover:text-indigo-700">#ORD-0275</a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center text-xs font-semibold text-green-700 shrink-0">FT</div>
                            <div>
                                <p class="font-medium text-zinc-900">FastTrack Ltd</p>
                                <p class="text-xs text-zinc-400">ops@fasttrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600">3 items</td>
                    <td class="px-4 py-3 font-medium text-zinc-900">$980.00</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Delivered</span></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Paid</span></td>
                    <td class="px-4 py-3 text-xs text-zinc-500 whitespace-nowrap">Mar 09, 2026</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="View">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="#" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 rounded-md hover:bg-zinc-100 text-zinc-400 hover:text-zinc-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 w-44 z-10">
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Duplicate</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Print invoice</a>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Send email</a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">Cancel order</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-zinc-100 flex items-center justify-between">
            <p class="text-xs text-zinc-500">Showing <span class="font-medium text-zinc-700">1–10</span> of <span class="font-medium text-zinc-700">1,284</span> orders</p>
            <div class="flex items-center gap-1">
                <button class="px-2.5 py-1.5 text-xs border border-zinc-300 rounded-md text-zinc-500 hover:bg-zinc-50 disabled:opacity-40" disabled>← Prev</button>
                <button class="px-2.5 py-1.5 text-xs bg-indigo-600 text-white rounded-md font-medium">1</button>
                <button class="px-2.5 py-1.5 text-xs border border-zinc-300 rounded-md text-zinc-600 hover:bg-zinc-50">2</button>
                <button class="px-2.5 py-1.5 text-xs border border-zinc-300 rounded-md text-zinc-600 hover:bg-zinc-50">3</button>
                <span class="px-2 text-zinc-400 text-xs">...</span>
                <button class="px-2.5 py-1.5 text-xs border border-zinc-300 rounded-md text-zinc-600 hover:bg-zinc-50">129</button>
                <button class="px-2.5 py-1.5 text-xs border border-zinc-300 rounded-md text-zinc-600 hover:bg-zinc-50">Next →</button>
            </div>
            <div class="flex items-center gap-1.5 text-xs text-zinc-500">
                Per page:
                <select class="border border-zinc-300 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500 bg-white">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
            </div>
        </div>
    </div>

</div>
</x-layouts.app>

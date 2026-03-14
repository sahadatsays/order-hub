<x-layouts.guest title="Order Hub — Modern Order Management for Growing Businesses">

    {{-- TOPBAR NAV --}}
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-zinc-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                        <span class="text-white text-sm font-bold">O</span>
                    </div>
                    <span class="text-base font-semibold text-zinc-900">Order Hub</span>
                </div>

                {{-- Desktop nav links --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm text-zinc-600 hover:text-zinc-900 transition-colors">Features</a>
                    <a href="#pricing" class="text-sm text-zinc-600 hover:text-zinc-900 transition-colors">Pricing</a>
                    <a href="#" class="text-sm text-zinc-600 hover:text-zinc-900 transition-colors">Docs</a>
                    <a href="#" class="text-sm text-zinc-600 hover:text-zinc-900 transition-colors">Blog</a>
                </div>

                {{-- CTA --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="hidden md:block text-sm text-zinc-600 hover:text-zinc-900 font-medium transition-colors">Sign in</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                        Start free →
                    </a>
                </div>

            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="relative overflow-hidden bg-white">

        {{-- Background gradient --}}
        <div class="absolute inset-0 bg-linear-to-br from-indigo-50/60 via-white to-white pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-150 h-150 bg-indigo-50/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 lg:pt-32 lg:pb-32">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                {{-- Left: Copy --}}
                <div>
                    {{-- New badge --}}
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-xs font-medium text-indigo-700 mb-6">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                        New: Bulk order import &amp; export
                        <span class="text-indigo-400">→</span>
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-bold text-zinc-900 leading-tight">
                        Manage orders with<br>
                        <span class="text-indigo-600">complete confidence</span>
                    </h1>

                    <p class="mt-5 text-lg text-zinc-500 leading-relaxed max-w-lg">
                        The all-in-one order management platform for growing businesses. Track, fulfil, and analyse every order from a single, powerful dashboard.
                    </p>

                    {{-- CTAs --}}
                    <div class="flex flex-col sm:flex-row gap-3 mt-8">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                            Start free trial
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="#" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-zinc-300 hover:bg-zinc-50 text-zinc-700 font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 text-zinc-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            Watch demo
                        </a>
                    </div>

                    {{-- Social proof --}}
                    <div class="flex items-center gap-4 mt-8 pt-8 border-t border-zinc-100">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-purple-400 border-2 border-white flex items-center justify-center text-xs font-semibold text-white">JD</div>
                            <div class="w-8 h-8 rounded-full bg-green-400 border-2 border-white flex items-center justify-center text-xs font-semibold text-white">SK</div>
                            <div class="w-8 h-8 rounded-full bg-blue-400 border-2 border-white flex items-center justify-center text-xs font-semibold text-white">MC</div>
                            <div class="w-8 h-8 rounded-full bg-orange-400 border-2 border-white flex items-center justify-center text-xs font-semibold text-white">AL</div>
                        </div>
                        <div>
                            <div class="flex items-center gap-0.5">
                                <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <p class="text-xs text-zinc-500 mt-0.5"><span class="font-medium text-zinc-700">4.9/5</span> from 500+ businesses</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Dashboard preview mock --}}
                <div class="relative">
                    <div class="rounded-xl border border-zinc-200 shadow-2xl overflow-hidden bg-white">

                        {{-- Browser bar --}}
                        <div class="flex items-center gap-2 px-4 py-3 bg-zinc-50 border-b border-zinc-200">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="flex-1 mx-4 bg-white border border-zinc-200 rounded px-3 py-1 text-xs text-zinc-400 font-mono">app.orderhub.io/dashboard</div>
                        </div>

                        {{-- Mini dashboard --}}
                        <div class="p-4 bg-zinc-50">
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <div class="bg-white rounded-lg p-3 border border-zinc-100">
                                    <p class="text-[10px] text-zinc-400">Total Orders</p>
                                    <p class="text-lg font-bold text-zinc-900 mt-0.5">1,284</p>
                                    <p class="text-[10px] text-green-600 mt-0.5">↑ 12.5%</p>
                                </div>
                                <div class="bg-white rounded-lg p-3 border border-zinc-100">
                                    <p class="text-[10px] text-zinc-400">Revenue</p>
                                    <p class="text-lg font-bold text-zinc-900 mt-0.5">$48.3k</p>
                                    <p class="text-[10px] text-green-600 mt-0.5">↑ 8.2%</p>
                                </div>
                                <div class="bg-white rounded-lg p-3 border border-zinc-100">
                                    <p class="text-[10px] text-zinc-400">Customers</p>
                                    <p class="text-lg font-bold text-zinc-900 mt-0.5">892</p>
                                    <p class="text-[10px] text-green-600 mt-0.5">↑ 5.1%</p>
                                </div>
                                <div class="bg-white rounded-lg p-3 border border-zinc-100">
                                    <p class="text-[10px] text-zinc-400">Pending</p>
                                    <p class="text-lg font-bold text-zinc-900 mt-0.5">24</p>
                                    <p class="text-[10px] text-yellow-600 mt-0.5">↓ 3 today</p>
                                </div>
                            </div>

                            {{-- Mini bar chart --}}
                            <div class="bg-white rounded-lg border border-zinc-100 p-3">
                                <p class="text-[10px] text-zinc-400 mb-2">Revenue Overview</p>
                                <div class="flex items-end gap-1 h-16">
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 40%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 48%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 42%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 55%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 50%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 65%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 60%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 68%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 62%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 72%"></div>
                                    <div class="flex-1 bg-indigo-600 rounded-t-sm" style="height: 78%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t-sm opacity-60" style="height: 85%"></div>
                                </div>
                            </div>

                            {{-- Recent orders mini list --}}
                            <div class="mt-3 bg-white rounded-lg border border-zinc-100 overflow-hidden">
                                <div class="px-3 py-2 border-b border-zinc-50">
                                    <p class="text-[10px] font-medium text-zinc-500">Recent Orders</p>
                                </div>
                                <div class="divide-y divide-zinc-50">
                                    <div class="flex items-center justify-between px-3 py-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded-full bg-indigo-100 flex items-center justify-center text-[8px] font-bold text-indigo-600">AC</div>
                                            <span class="text-[10px] font-medium text-zinc-700">Acme Corp</span>
                                        </div>
                                        <span class="text-[10px] bg-green-50 text-green-700 px-1.5 py-0.5 rounded-full font-medium">Delivered</span>
                                    </div>
                                    <div class="flex items-center justify-between px-3 py-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center text-[8px] font-bold text-blue-600">TS</div>
                                            <span class="text-[10px] font-medium text-zinc-700">TechStart Inc</span>
                                        </div>
                                        <span class="text-[10px] bg-indigo-50 text-indigo-700 px-1.5 py-0.5 rounded-full font-medium">Processing</span>
                                    </div>
                                    <div class="flex items-center justify-between px-3 py-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded-full bg-sky-100 flex items-center justify-center text-[8px] font-bold text-sky-600">BL</div>
                                            <span class="text-[10px] font-medium text-zinc-700">BlueSky Ltd</span>
                                        </div>
                                        <span class="text-[10px] bg-yellow-50 text-yellow-700 px-1.5 py-0.5 rounded-full font-medium">Pending</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Floating badge --}}
                    <div class="absolute -top-3 -right-3 bg-green-500 text-white text-xs font-medium px-3 py-1.5 rounded-full shadow-md flex items-center gap-1">
                        ✓ 3 orders shipped
                    </div>

                    {{-- Floating notification --}}
                    <div class="absolute -bottom-4 -left-4 bg-white border border-zinc-200 rounded-xl shadow-lg px-4 py-3 flex items-center gap-3 max-w-55">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-zinc-900">Revenue up 8.2%</p>
                            <p class="text-[10px] text-zinc-400">vs last month</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- LOGO BAR --}}
    <section class="py-12 border-y border-zinc-100 bg-zinc-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-medium text-zinc-400 uppercase tracking-widest mb-8">Trusted by teams at</p>
            <div class="flex flex-wrap items-center justify-center gap-8 lg:gap-12 opacity-50">
                <span class="text-xl font-bold text-zinc-400">Acme</span>
                <span class="text-xl font-bold text-zinc-400">TechCorp</span>
                <span class="text-xl font-bold text-zinc-400">BlueSky</span>
                <span class="text-xl font-bold text-zinc-400">Nexus</span>
                <span class="text-xl font-bold text-zinc-400">Summit</span>
                <span class="text-xl font-bold text-zinc-400">Vertex</span>
            </div>
        </div>
    </section>

    {{-- FEATURES GRID --}}
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest">Features</span>
                <h2 class="text-3xl font-bold text-zinc-900 mt-3">Everything you need to manage orders</h2>
                <p class="mt-4 text-lg text-zinc-500 max-w-2xl mx-auto">Powerful tools built for operational teams who need speed, clarity, and reliability every single day.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Feature 1: Order Management --}}
                <div class="p-6 rounded-xl border border-zinc-200 hover:border-indigo-200 hover:shadow-sm transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center mb-4 group-hover:bg-indigo-100 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-zinc-900">Order Management</h3>
                    <p class="mt-2 text-sm text-zinc-500 leading-relaxed">Create, track, and fulfil orders with full visibility across every stage of the lifecycle.</p>
                </div>

                {{-- Feature 2: Customer Tracking --}}
                <div class="p-6 rounded-xl border border-zinc-200 hover:border-indigo-200 hover:shadow-sm transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center mb-4 group-hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-zinc-900">Customer Tracking</h3>
                    <p class="mt-2 text-sm text-zinc-500 leading-relaxed">Centralise customer data, order history, and communication in one place.</p>
                </div>

                {{-- Feature 3: Inventory Control --}}
                <div class="p-6 rounded-xl border border-zinc-200 hover:border-indigo-200 hover:shadow-sm transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center mb-4 group-hover:bg-green-100 transition-colors">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-zinc-900">Inventory Control</h3>
                    <p class="mt-2 text-sm text-zinc-500 leading-relaxed">Real-time stock tracking with low-inventory alerts and automatic reorder points.</p>
                </div>

                {{-- Feature 4: Invoice Generation --}}
                <div class="p-6 rounded-xl border border-zinc-200 hover:border-indigo-200 hover:shadow-sm transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center mb-4 group-hover:bg-purple-100 transition-colors">
                        <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-zinc-900">Invoice Generation</h3>
                    <p class="mt-2 text-sm text-zinc-500 leading-relaxed">Automatically generate, send, and track invoices with real-time payment status.</p>
                </div>

                {{-- Feature 5: Analytics & Reports --}}
                <div class="p-6 rounded-xl border border-zinc-200 hover:border-indigo-200 hover:shadow-sm transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center mb-4 group-hover:bg-orange-100 transition-colors">
                        <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-zinc-900">Analytics &amp; Reports</h3>
                    <p class="mt-2 text-sm text-zinc-500 leading-relaxed">Data-driven insights on revenue, trends, and operational performance.</p>
                </div>

                {{-- Feature 6: Team Collaboration --}}
                <div class="p-6 rounded-xl border border-zinc-200 hover:border-indigo-200 hover:shadow-sm transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center mb-4 group-hover:bg-yellow-100 transition-colors">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-zinc-900">Team Collaboration</h3>
                    <p class="mt-2 text-sm text-zinc-500 leading-relaxed">Role-based access, full audit logs, and real-time team activity tracking.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- FEATURE DEEP-DIVE (alternating) --}}
    <section class="py-24 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">

            {{-- Section A: Mockup left, copy right --}}
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Left: order list mockup --}}
                <div class="bg-white rounded-xl border border-zinc-200 shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-zinc-100 flex items-center justify-between bg-zinc-50">
                        <span class="text-xs font-medium text-zinc-600">Orders · 1,284 results</span>
                        <div class="flex gap-2">
                            <span class="px-2 py-0.5 text-xs bg-white border border-zinc-200 rounded text-zinc-500 cursor-pointer hover:bg-zinc-50">Filter</span>
                            <span class="px-2 py-0.5 text-xs bg-indigo-600 text-white rounded cursor-pointer">+ New Order</span>
                        </div>
                    </div>
                    <div class="divide-y divide-zinc-100">
                        <div class="flex items-center justify-between px-4 py-3.5 hover:bg-zinc-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs font-semibold text-blue-600">AC</div>
                                <div>
                                    <p class="text-xs font-medium text-zinc-900">#ORD-0284</p>
                                    <p class="text-[10px] text-zinc-400">Acme Corp</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-zinc-900">$1,240</p>
                                <span class="text-[10px] bg-green-50 text-green-700 px-1.5 py-0.5 rounded-full font-medium">Delivered</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3.5 hover:bg-zinc-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-semibold text-indigo-600">TS</div>
                                <div>
                                    <p class="text-xs font-medium text-zinc-900">#ORD-0283</p>
                                    <p class="text-[10px] text-zinc-400">TechStart Inc</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-zinc-900">$890</p>
                                <span class="text-[10px] bg-indigo-50 text-indigo-700 px-1.5 py-0.5 rounded-full font-medium">Processing</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3.5 hover:bg-zinc-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-sky-100 flex items-center justify-center text-xs font-semibold text-sky-600">BL</div>
                                <div>
                                    <p class="text-xs font-medium text-zinc-900">#ORD-0282</p>
                                    <p class="text-[10px] text-zinc-400">BlueSky Ltd</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-zinc-900">$2,100</p>
                                <span class="text-[10px] bg-yellow-50 text-yellow-700 px-1.5 py-0.5 rounded-full font-medium">Pending</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3.5 hover:bg-zinc-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-xs font-semibold text-purple-600">NG</div>
                                <div>
                                    <p class="text-xs font-medium text-zinc-900">#ORD-0281</p>
                                    <p class="text-[10px] text-zinc-400">Nexus Group</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-zinc-900">$450</p>
                                <span class="text-[10px] bg-green-50 text-green-700 px-1.5 py-0.5 rounded-full font-medium">Delivered</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-zinc-50 border-t border-zinc-100 flex items-center justify-between">
                        <span class="text-[10px] text-zinc-400">Showing 4 of 1,284 orders</span>
                        <div class="flex gap-1">
                            <span class="px-2 py-0.5 text-[10px] bg-white border border-zinc-200 rounded text-zinc-500">← Prev</span>
                            <span class="px-2 py-0.5 text-[10px] bg-indigo-600 text-white rounded">1</span>
                            <span class="px-2 py-0.5 text-[10px] bg-white border border-zinc-200 rounded text-zinc-500">2</span>
                            <span class="px-2 py-0.5 text-[10px] bg-white border border-zinc-200 rounded text-zinc-500">Next →</span>
                        </div>
                    </div>
                </div>

                {{-- Right: copy --}}
                <div>
                    <span class="text-sm font-semibold text-indigo-600">Order Management</span>
                    <h3 class="text-2xl font-bold text-zinc-900 mt-2">Full order lifecycle visibility</h3>
                    <p class="mt-4 text-zinc-500 leading-relaxed">Track every order from creation to delivery. Set custom statuses, automate confirmations, and ensure nothing falls through the cracks.</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex items-start gap-3 text-sm text-zinc-600">
                            <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0 mt-0.5 text-xs font-bold">✓</span>
                            Custom order statuses and workflows
                        </li>
                        <li class="flex items-start gap-3 text-sm text-zinc-600">
                            <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0 mt-0.5 text-xs font-bold">✓</span>
                            Bulk order import from CSV or integrations
                        </li>
                        <li class="flex items-start gap-3 text-sm text-zinc-600">
                            <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0 mt-0.5 text-xs font-bold">✓</span>
                            Automatic notifications to customers
                        </li>
                        <li class="flex items-start gap-3 text-sm text-zinc-600">
                            <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0 mt-0.5 text-xs font-bold">✓</span>
                            One-click fulfilment with carrier integrations
                        </li>
                    </ul>
                    <a href="#" class="inline-flex items-center gap-2 mt-8 text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">
                        Learn more
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Section B: Copy left, analytics mockup right --}}
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Left: copy --}}
                <div>
                    <span class="text-sm font-semibold text-orange-600">Analytics &amp; Reporting</span>
                    <h3 class="text-2xl font-bold text-zinc-900 mt-2">Insights that drive better decisions</h3>
                    <p class="mt-4 text-zinc-500 leading-relaxed">Turn raw order data into clear, actionable insights. Understand revenue trends, identify top customers, and spot bottlenecks before they cost you.</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex items-start gap-3 text-sm text-zinc-600">
                            <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0 mt-0.5 text-xs font-bold">✓</span>
                            Revenue, volume, and conversion dashboards
                        </li>
                        <li class="flex items-start gap-3 text-sm text-zinc-600">
                            <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0 mt-0.5 text-xs font-bold">✓</span>
                            Exportable CSV and PDF reports
                        </li>
                        <li class="flex items-start gap-3 text-sm text-zinc-600">
                            <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0 mt-0.5 text-xs font-bold">✓</span>
                            Scheduled email report delivery
                        </li>
                        <li class="flex items-start gap-3 text-sm text-zinc-600">
                            <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0 mt-0.5 text-xs font-bold">✓</span>
                            Custom date ranges and segment filters
                        </li>
                    </ul>
                    <a href="#" class="inline-flex items-center gap-2 mt-8 text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">
                        Explore analytics
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

                {{-- Right: analytics mockup --}}
                <div class="bg-white rounded-xl border border-zinc-200 shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-zinc-100 flex items-center justify-between bg-zinc-50">
                        <span class="text-xs font-medium text-zinc-600">Revenue Analytics</span>
                        <div class="flex gap-1 text-[10px]">
                            <span class="px-2 py-0.5 bg-indigo-600 text-white rounded">Monthly</span>
                            <span class="px-2 py-0.5 bg-white border border-zinc-200 rounded text-zinc-500">Weekly</span>
                        </div>
                    </div>
                    <div class="p-4">
                        {{-- Stats row --}}
                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div class="bg-zinc-50 rounded-lg p-2.5">
                                <p class="text-[10px] text-zinc-400">Total Rev.</p>
                                <p class="text-sm font-bold text-zinc-900 mt-0.5">$57.4k</p>
                                <p class="text-[10px] text-green-600">↑ 14%</p>
                            </div>
                            <div class="bg-zinc-50 rounded-lg p-2.5">
                                <p class="text-[10px] text-zinc-400">Avg. Order</p>
                                <p class="text-sm font-bold text-zinc-900 mt-0.5">$447</p>
                                <p class="text-[10px] text-green-600">↑ 6%</p>
                            </div>
                            <div class="bg-zinc-50 rounded-lg p-2.5">
                                <p class="text-[10px] text-zinc-400">Conversion</p>
                                <p class="text-sm font-bold text-zinc-900 mt-0.5">68.4%</p>
                                <p class="text-[10px] text-green-600">↑ 3%</p>
                            </div>
                        </div>
                        {{-- Bar chart --}}
                        <div class="flex items-end gap-1 h-28 mb-3">
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 40%"></div>
                                <span class="text-[8px] text-zinc-400">J</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 52%"></div>
                                <span class="text-[8px] text-zinc-400">F</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 44%"></div>
                                <span class="text-[8px] text-zinc-400">M</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 60%"></div>
                                <span class="text-[8px] text-zinc-400">A</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 55%"></div>
                                <span class="text-[8px] text-zinc-400">M</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 70%"></div>
                                <span class="text-[8px] text-zinc-400">J</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 65%"></div>
                                <span class="text-[8px] text-zinc-400">J</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 72%"></div>
                                <span class="text-[8px] text-zinc-400">A</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 68%"></div>
                                <span class="text-[8px] text-zinc-400">S</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 78%"></div>
                                <span class="text-[8px] text-zinc-400">O</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-600" style="height: 82%"></div>
                                <span class="text-[8px] text-indigo-700 font-semibold">N</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-sm bg-indigo-200" style="height: 90%"></div>
                                <span class="text-[8px] text-zinc-400">D</span>
                            </div>
                        </div>
                        {{-- Top products table --}}
                        <div class="border-t border-zinc-100 pt-3">
                            <p class="text-[10px] font-medium text-zinc-500 mb-2">Top Products This Month</p>
                            <div class="space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] text-zinc-600 w-28 shrink-0">Enterprise Suite</span>
                                    <div class="flex-1 h-1.5 bg-zinc-100 rounded-full">
                                        <div class="h-1.5 bg-orange-400 rounded-full" style="width: 85%"></div>
                                    </div>
                                    <span class="text-[10px] text-zinc-400 w-10 text-right">$12.4k</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] text-zinc-600 w-28 shrink-0">Pro License</span>
                                    <div class="flex-1 h-1.5 bg-zinc-100 rounded-full">
                                        <div class="h-1.5 bg-orange-400 rounded-full" style="width: 67%"></div>
                                    </div>
                                    <span class="text-[10px] text-zinc-400 w-10 text-right">$9.8k</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] text-zinc-600 w-28 shrink-0">Starter Pack</span>
                                    <div class="flex-1 h-1.5 bg-zinc-100 rounded-full">
                                        <div class="h-1.5 bg-orange-400 rounded-full" style="width: 49%"></div>
                                    </div>
                                    <span class="text-[10px] text-zinc-400 w-10 text-right">$7.2k</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest">Testimonials</span>
                <h2 class="text-3xl font-bold text-zinc-900 mt-3">Loved by operations teams</h2>
                <p class="mt-4 text-zinc-500">Real results from real teams using Order Hub every day.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Testimonial 1 --}}
                <div class="p-6 rounded-xl border border-zinc-200 hover:shadow-sm transition-shadow">
                    <div class="flex items-center gap-0.5 mb-4">
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-zinc-600 text-sm leading-relaxed">"Order Hub cut our processing time by 60%. We handle twice the volume with the same team now. It's genuinely transformed how we operate."</p>
                    <div class="flex items-center gap-3 mt-5 pt-4 border-t border-zinc-100">
                        <div class="w-9 h-9 rounded-full bg-purple-200 flex items-center justify-center text-xs font-bold text-purple-700">SK</div>
                        <div>
                            <p class="text-sm font-medium text-zinc-900">Sarah K.</p>
                            <p class="text-xs text-zinc-500">Operations Lead, TechStart</p>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 2 --}}
                <div class="p-6 rounded-xl border border-zinc-200 hover:shadow-sm transition-shadow">
                    <div class="flex items-center gap-0.5 mb-4">
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-zinc-600 text-sm leading-relaxed">"The analytics alone are worth it. We spotted a product trend we would have completely missed. Our revenue is up 22% since switching to Order Hub."</p>
                    <div class="flex items-center gap-3 mt-5 pt-4 border-t border-zinc-100">
                        <div class="w-9 h-9 rounded-full bg-blue-200 flex items-center justify-center text-xs font-bold text-blue-700">MC</div>
                        <div>
                            <p class="text-sm font-medium text-zinc-900">Marcus C.</p>
                            <p class="text-xs text-zinc-500">Head of Commerce, BlueSky Ltd</p>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 3 --}}
                <div class="p-6 rounded-xl border border-zinc-200 hover:shadow-sm transition-shadow">
                    <div class="flex items-center gap-0.5 mb-4">
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-zinc-600 text-sm leading-relaxed">"Setup took less than an hour. Customer notifications are automatic, invoices go out instantly. Our support tickets dropped by 40% in the first week."</p>
                    <div class="flex items-center gap-3 mt-5 pt-4 border-t border-zinc-100">
                        <div class="w-9 h-9 rounded-full bg-green-200 flex items-center justify-center text-xs font-bold text-green-700">AL</div>
                        <div>
                            <p class="text-sm font-medium text-zinc-900">Alex L.</p>
                            <p class="text-xs text-zinc-500">Founder, Summit Solutions</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- PRICING --}}
    <section id="pricing" class="py-24 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest">Pricing</span>
                <h2 class="text-3xl font-bold text-zinc-900 mt-3">Simple, transparent pricing</h2>
                <p class="mt-4 text-zinc-500">Start free, scale as you grow. No hidden fees.</p>
                <div class="flex items-center justify-center gap-3 mt-6">
                    <span class="text-sm text-zinc-600">Monthly</span>
                    <button class="relative w-11 h-6 bg-indigo-600 rounded-full transition-colors cursor-pointer">
                        <span class="absolute right-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-transform"></span>
                    </button>
                    <span class="text-sm text-zinc-600">Annual <span class="bg-green-100 text-green-700 text-xs px-1.5 py-0.5 rounded-full font-medium">Save 20%</span></span>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">

                {{-- Starter --}}
                <div class="bg-white rounded-xl border border-zinc-200 p-6">
                    <h3 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider">Starter</h3>
                    <div class="mt-3">
                        <span class="text-3xl font-bold text-zinc-900">$29</span>
                        <span class="text-zinc-500 text-sm">/month</span>
                    </div>
                    <p class="mt-2 text-sm text-zinc-500">For small teams just getting started.</p>
                    <a href="{{ route('register') }}" class="mt-5 block text-center px-4 py-2.5 border border-zinc-300 text-zinc-700 text-sm font-medium rounded-lg hover:bg-zinc-50 transition-colors">Get started</a>
                    <ul class="mt-5 space-y-2.5 text-sm text-zinc-600">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Up to 500 orders/month
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            2 team members
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Basic analytics
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Email support
                        </li>
                    </ul>
                </div>

                {{-- Growth (highlighted) --}}
                <div class="bg-indigo-600 rounded-xl border border-indigo-700 p-6 relative shadow-lg">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-green-400 text-green-900 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">Most Popular</div>
                    <h3 class="text-sm font-semibold text-indigo-200 uppercase tracking-wider">Growth</h3>
                    <div class="mt-3">
                        <span class="text-3xl font-bold text-white">$79</span>
                        <span class="text-indigo-200 text-sm">/month</span>
                    </div>
                    <p class="mt-2 text-sm text-indigo-200">For growing teams handling real volume.</p>
                    <a href="{{ route('register') }}" class="mt-5 block text-center px-4 py-2.5 bg-white text-indigo-700 text-sm font-medium rounded-lg hover:bg-indigo-50 transition-colors">Start free trial</a>
                    <ul class="mt-5 space-y-2.5 text-sm text-indigo-100">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Up to 5,000 orders/month
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            10 team members
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Advanced analytics
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Integrations (Shopify, WooCommerce)
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Priority support
                        </li>
                    </ul>
                </div>

                {{-- Enterprise --}}
                <div class="bg-white rounded-xl border border-zinc-200 p-6">
                    <h3 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider">Enterprise</h3>
                    <div class="mt-3">
                        <span class="text-3xl font-bold text-zinc-900">Custom</span>
                    </div>
                    <p class="mt-2 text-sm text-zinc-500">For large teams needing full control.</p>
                    <a href="#" class="mt-5 block text-center px-4 py-2.5 border border-zinc-300 text-zinc-700 text-sm font-medium rounded-lg hover:bg-zinc-50 transition-colors">Contact sales</a>
                    <ul class="mt-5 space-y-2.5 text-sm text-zinc-600">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Unlimited orders
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Unlimited team members
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Custom integrations
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            SSO &amp; advanced security
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Dedicated account manager
                        </li>
                    </ul>
                </div>

            </div>

            <p class="text-center text-sm text-zinc-500 mt-10">
                Questions? <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">Read our FAQ</a> or <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">talk to sales</a>.
            </p>
        </div>
    </section>

    {{-- FINAL CTA BANNER --}}
    <section class="py-24 bg-indigo-600 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-700/50 to-indigo-500/30 pointer-events-none"></div>
        <div class="relative max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white">Ready to take control of your orders?</h2>
            <p class="mt-4 text-indigo-200 text-lg">Join 500+ businesses managing their operations with Order Hub.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center mt-8">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-indigo-700 font-medium rounded-lg hover:bg-indigo-50 transition-colors">Start your free trial</a>
                <a href="#" class="px-6 py-3 bg-indigo-700 text-white font-medium rounded-lg hover:bg-indigo-800 transition-colors border border-indigo-500">Schedule a demo</a>
            </div>
            <p class="mt-4 text-indigo-300 text-sm">No credit card required · 14-day free trial · Cancel anytime</p>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-zinc-950 text-zinc-400 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-8 pb-12 border-b border-zinc-800">

                {{-- Brand col --}}
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                            <span class="text-white text-sm font-bold">O</span>
                        </div>
                        <span class="text-base font-semibold text-white">Order Hub</span>
                    </div>
                    <p class="text-sm leading-relaxed max-w-xs">The modern order management platform for teams that move fast and need to stay in control.</p>
                    <div class="flex items-center gap-4 mt-6">
                        <a href="#" class="text-zinc-500 hover:text-zinc-300 transition-colors" aria-label="Twitter / X">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="#" class="text-zinc-500 hover:text-zinc-300 transition-colors" aria-label="GitHub">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                        </a>
                        <a href="#" class="text-zinc-500 hover:text-zinc-300 transition-colors" aria-label="LinkedIn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Product --}}
                <div>
                    <h4 class="text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-4">Product</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#features" class="hover:text-zinc-200 transition-colors">Features</a></li>
                        <li><a href="#pricing" class="hover:text-zinc-200 transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Changelog</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Roadmap</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Integrations</a></li>
                    </ul>
                </div>

                {{-- Company --}}
                <div>
                    <h4 class="text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-4">Company</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Press</a></li>
                    </ul>
                </div>

                {{-- Legal --}}
                <div>
                    <h4 class="text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-4">Legal</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Privacy</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Terms</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Security</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Status</a></li>
                        <li><a href="#" class="hover:text-zinc-200 transition-colors">Cookies</a></li>
                    </ul>
                </div>

            </div>
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs">© 2026 Order Hub. All rights reserved.</p>
                <p class="text-xs">Built with Laravel · Tailwind CSS</p>
            </div>
        </div>
    </footer>

</x-layouts.guest>

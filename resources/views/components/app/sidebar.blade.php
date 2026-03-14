@php
    $primaryNav = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'routePattern' => 'dashboard*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
        ],
        [
            'label' => 'Orders',
            'route' => 'orders.index',
            'routePattern' => 'orders*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>',
        ],
        [
            'label' => 'Customers',
            'route' => 'customers.index',
            'routePattern' => 'customers*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
        ],
        [
            'label' => 'Products',
            'route' => 'products.index',
            'routePattern' => 'products*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
        ],
        [
            'label' => 'Inventory',
            'route' => 'inventory.index',
            'routePattern' => 'inventory*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
        ],
        [
            'label' => 'Invoices',
            'route' => 'invoices.index',
            'routePattern' => 'invoices*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
        ],
    ];

    $managementNav = [
        [
            'label' => 'Reports',
            'route' => 'reports.index',
            'routePattern' => 'reports*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
        ],
        [
            'label' => 'Integrations',
            'route' => 'integrations.index',
            'routePattern' => 'integrations*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>',
        ],
    ];
@endphp

<aside
    id="app-sidebar"
    data-sidebar-open="false"
    data-sidebar-collapsed="false"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-zinc-950 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-out"
>

    {{-- Brand header --}}
    <div class="flex items-center gap-3 px-4 pt-5 pb-4 shrink-0">
        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-600 shrink-0">
            <span class="text-white font-bold text-sm leading-none">O</span>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-white truncate">Order Hub</p>
            <p class="text-xs text-zinc-400 truncate">Acme Corp</p>
        </div>
        <button
            type="button"
            data-sidebar-toggle
            class="hidden lg:flex items-center justify-center w-6 h-6 rounded-md text-zinc-400 hover:text-white transition-colors"
            aria-label="Collapse sidebar"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
    </div>

    {{-- Search shortcut --}}
    <div class="px-3 pb-3 shrink-0">
        <button
            type="button"
            class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs text-zinc-400 bg-zinc-900 hover:bg-zinc-800 transition-colors group"
            onclick="document.querySelector('[data-global-search]')?.focus()"
        >
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <span class="flex-1 text-left">Search...</span>
            <kbd class="ml-auto text-zinc-600 text-xs font-sans">⌘K</kbd>
        </button>
    </div>

    {{-- Primary navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 pb-4">
        <p class="px-3 mb-1 text-xs font-medium text-zinc-500 uppercase tracking-wider">Main</p>
        <div class="space-y-0.5">
            @foreach ($primaryNav as $item)
                @php
                    $isActive = request()->routeIs($item['routePattern']);
                @endphp
                @if (Route::has($item['route']))
                    <a
                        href="{{ route($item['route']) }}"
                        class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ $isActive ? 'bg-zinc-800 text-white' : 'text-zinc-400 hover:bg-zinc-900 hover:text-white' }}"
                        @if ($isActive) aria-current="page" @endif
                    >
                        <svg class="w-4.5 h-4.5 shrink-0 transition-colors {{ $isActive ? 'text-white' : 'text-zinc-500 group-hover:text-zinc-300' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            {!! $item['icon'] !!}
                        </svg>
                        <span class="truncate">{{ $item['label'] }}</span>
                    </a>
                @else
                    <a
                        href="#"
                        class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ $isActive ? 'bg-zinc-800 text-white' : 'text-zinc-400 hover:bg-zinc-900 hover:text-white' }}"
                    >
                        <svg class="w-4.5 h-4.5 shrink-0 text-zinc-500 group-hover:text-zinc-300 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            {!! $item['icon'] !!}
                        </svg>
                        <span class="truncate">{{ $item['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>

        {{-- Management section --}}
        <p class="px-3 mt-5 mb-1 text-xs font-medium text-zinc-500 uppercase tracking-wider">Management</p>
        <div class="space-y-0.5">
            @foreach ($managementNav as $item)
                @php
                    $isActive = request()->routeIs($item['routePattern']);
                @endphp
                @if (Route::has($item['route']))
                    <a
                        href="{{ route($item['route']) }}"
                        class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ $isActive ? 'bg-zinc-800 text-white' : 'text-zinc-400 hover:bg-zinc-900 hover:text-white' }}"
                        @if ($isActive) aria-current="page" @endif
                    >
                        <svg class="w-4.5 h-4.5 shrink-0 transition-colors {{ $isActive ? 'text-white' : 'text-zinc-500 group-hover:text-zinc-300' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            {!! $item['icon'] !!}
                        </svg>
                        <span class="truncate">{{ $item['label'] }}</span>
                    </a>
                @else
                    <a
                        href="#"
                        class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ $isActive ? 'bg-zinc-800 text-white' : 'text-zinc-400 hover:bg-zinc-900 hover:text-white' }}"
                    >
                        <svg class="w-4.5 h-4.5 shrink-0 text-zinc-500 group-hover:text-zinc-300 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            {!! $item['icon'] !!}
                        </svg>
                        <span class="truncate">{{ $item['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </nav>

    {{-- Bottom section --}}
    <div class="shrink-0 mt-auto px-3 pb-4 border-t border-zinc-800 pt-4 space-y-0.5">

        {{-- Settings --}}
        @if (Route::has('settings.index'))
            <a
                href="{{ route('settings.index') }}"
                class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('settings*') ? 'bg-zinc-800 text-white' : 'text-zinc-400 hover:bg-zinc-900 hover:text-white' }}"
            >
                <svg class="w-4.5 h-4.5 shrink-0 text-zinc-500 group-hover:text-zinc-300 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="truncate">Settings</span>
            </a>
        @else
            <a href="#" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-zinc-400 hover:bg-zinc-900 hover:text-white transition-colors">
                <svg class="w-4.5 h-4.5 shrink-0 text-zinc-500 group-hover:text-zinc-300 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="truncate">Settings</span>
            </a>
        @endif

        {{-- Help & Support --}}
        <a href="#" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-zinc-400 hover:bg-zinc-900 hover:text-white transition-colors">
            <svg class="w-4.5 h-4.5 shrink-0 text-zinc-500 group-hover:text-zinc-300 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="truncate">Help & Support</span>
        </a>

        {{-- User card --}}
        @auth
            <div data-dropdown class="relative mt-2">
                <button
                    type="button"
                    data-dropdown-toggle
                    class="flex items-center gap-3 w-full px-2 py-2 rounded-lg hover:bg-zinc-900 cursor-pointer transition-colors text-left"
                >
                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-semibold text-white shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <svg class="w-4 h-4 text-zinc-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <div
                    data-dropdown-menu
                    class="hidden absolute bottom-full left-0 right-0 mb-1 bg-white border border-zinc-200 rounded-xl shadow-lg py-1 z-10"
                >
                    <div class="px-3 py-2 border-b border-zinc-100 mb-1">
                        <p class="text-sm font-medium text-zinc-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-zinc-500 truncate">{{ auth()->user()->email }}</p>
                    </div>

                    @if (Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50 transition-colors">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profile
                        </a>
                    @endif

                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50 transition-colors">
                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Settings
                    </a>

                    <div class="my-1 border-t border-zinc-100"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="flex items-center gap-2 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="flex items-center gap-3 px-2 py-2 rounded-lg mt-2">
                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-semibold text-white shrink-0">JD</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">John Doe</p>
                    <p class="text-xs text-zinc-400 truncate">john@acmecorp.com</p>
                </div>
                <svg class="w-4 h-4 text-zinc-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        @endauth
    </div>

</aside>

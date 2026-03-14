@props([
    'title' => '',
    'subtitle' => null,
])

<header class="sticky top-0 z-20 flex h-14 items-center gap-4 bg-white border-b border-zinc-200 px-4 lg:px-6 shrink-0">

    {{-- Mobile hamburger --}}
    <button
        type="button"
        data-sidebar-toggle
        class="lg:hidden p-2 rounded-md text-zinc-500 hover:bg-zinc-100 transition-colors"
        aria-label="Toggle sidebar"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    {{-- Page title --}}
    <div class="flex-1 min-w-0">
        @if ($title)
            <h1 class="text-base font-semibold text-zinc-900 truncate leading-tight">{{ $title }}</h1>
            @if ($subtitle)
                <p class="text-xs text-zinc-500 truncate leading-tight">{{ $subtitle }}</p>
            @endif
        @endif
    </div>

    {{-- Right actions --}}
    <div class="flex items-center gap-2 ml-auto">

        {{-- Search (desktop) --}}
        <div class="hidden md:flex items-center gap-2 bg-zinc-50 border border-zinc-200 rounded-md px-3 py-1.5 w-64">
            <svg class="w-3.5 h-3.5 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input
                type="text"
                data-global-search
                placeholder="Search... (⌘K)"
                class="bg-transparent text-sm text-zinc-600 placeholder:text-zinc-400 outline-none w-full"
            >
        </div>

        {{-- Notifications --}}
        <div data-dropdown class="relative">
            <button
                type="button"
                data-dropdown-toggle
                class="relative p-2 rounded-md text-zinc-500 hover:bg-zinc-100 transition-colors"
                aria-label="Notifications"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            <div
                data-dropdown-menu
                class="hidden absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-xl shadow-lg w-80 z-50"
            >
                <div class="px-4 py-3 border-b border-zinc-100 flex items-center justify-between">
                    <span class="text-sm font-semibold text-zinc-900">Notifications</span>
                    <button type="button" class="text-xs text-indigo-600 hover:text-indigo-700 transition-colors">Mark all read</button>
                </div>
                <div class="py-1">
                    <div class="px-4 py-3 hover:bg-zinc-50 cursor-pointer transition-colors">
                        <p class="text-sm font-medium text-zinc-800">New order received</p>
                        <p class="text-xs text-zinc-500 mt-0.5">Order #ORD-0284 from Acme Ltd — 2 min ago</p>
                    </div>
                    <div class="px-4 py-3 hover:bg-zinc-50 cursor-pointer transition-colors">
                        <p class="text-sm font-medium text-zinc-800">Payment confirmed</p>
                        <p class="text-xs text-zinc-500 mt-0.5">Invoice #INV-091 paid — 1 hr ago</p>
                    </div>
                    <div class="px-4 py-3 hover:bg-zinc-50 cursor-pointer transition-colors">
                        <p class="text-sm font-medium text-zinc-800">Low inventory alert</p>
                        <p class="text-xs text-zinc-500 mt-0.5">Product SKU-443 below threshold — 3 hr ago</p>
                    </div>
                </div>
                <div class="px-4 py-2.5 border-t border-zinc-100 text-center">
                    <a href="#" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium transition-colors">View all notifications →</a>
                </div>
            </div>
        </div>

        {{-- User avatar dropdown --}}
        @auth
            <div data-dropdown class="relative">
                <button
                    type="button"
                    data-dropdown-toggle
                    class="flex items-center gap-2 p-1 rounded-lg hover:bg-zinc-100 transition-colors"
                    aria-label="User menu"
                >
                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-semibold text-white shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <span class="hidden md:block text-sm font-medium text-zinc-700">{{ auth()->user()->name }}</span>
                    <svg class="hidden md:block w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    data-dropdown-menu
                    class="hidden absolute right-0 top-full mt-1 bg-white border border-zinc-200 rounded-xl shadow-lg py-1 min-w-52 z-50"
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

                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-50 transition-colors">
                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Help
                    </a>

                    <div class="border-t border-zinc-100 mt-1 pt-1">
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
            </div>
        @else
            <div class="flex items-center gap-2 p-1">
                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-semibold text-white shrink-0">JD</div>
                <span class="hidden md:block text-sm font-medium text-zinc-700">John Doe</span>
                <svg class="hidden md:block w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        @endauth

    </div>
</header>

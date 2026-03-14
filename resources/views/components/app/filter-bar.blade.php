@props([
    'searchPlaceholder' => 'Search...',
    'searchName' => 'search',
])

<div class="flex flex-col gap-3 mb-4">
    {{-- Top row: search + filter controls --}}
    <div class="flex flex-col sm:flex-row gap-2">

        {{-- Search --}}
        <div class="relative flex-1 max-w-xs">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input
                type="text"
                name="{{ $searchName }}"
                placeholder="{{ $searchPlaceholder }}"
                class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white placeholder:text-zinc-400 transition-colors"
                value="{{ request($searchName, '') }}"
            >
        </div>

        {{-- Filter controls slot --}}
        @if (isset($filters))
            <div class="flex items-center gap-2 flex-wrap">
                {{ $filters }}
            </div>
        @endif

        {{-- Right side actions slot --}}
        @if (isset($actions))
            <div class="sm:ml-auto flex items-center gap-2">
                {{ $actions }}
            </div>
        @endif

    </div>

    {{-- Active filter chips row --}}
    @if (isset($chips))
        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-xs text-zinc-500">Active filters:</span>
            {{ $chips }}
            <button
                type="button"
                class="text-xs text-indigo-600 hover:text-indigo-700 transition-colors"
            >
                Clear all
            </button>
        </div>
    @endif
</div>

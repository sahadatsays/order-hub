@props([
    'items' => [],
])

<nav class="flex items-center gap-1.5 text-sm mb-6" aria-label="Breadcrumb">
    @foreach ($items as $index => $item)
        @if ($index > 0)
            <svg class="w-3.5 h-3.5 text-zinc-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        @endif

        @if ($loop->last)
            <span class="text-zinc-800 font-medium truncate max-w-48">{{ $item['label'] }}</span>
        @else
            <a
                href="{{ $item['href'] }}"
                class="text-zinc-500 hover:text-zinc-700 transition-colors truncate max-w-48"
            >{{ $item['label'] }}</a>
        @endif
    @endforeach
</nav>

@props([
    'title',
    'description' => null,
    'backHref' => null,
    'backLabel' => 'Back',
])

<div class="mb-6">
    @if ($backHref)
        <a
            href="{{ $backHref }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-700 mb-3 transition-colors"
        >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ $backLabel }}
        </a>
    @endif

    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-zinc-900">{{ $title }}</h1>
            @if ($description)
                <p class="mt-1 text-sm text-zinc-500">{{ $description }}</p>
            @endif
        </div>

        @if (isset($actions))
            <div class="flex items-center gap-2 shrink-0">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>

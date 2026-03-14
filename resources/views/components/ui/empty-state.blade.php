@props([
    'icon' => null,
    'title',
    'description' => null,
])

<div class="flex flex-col items-center gap-3 py-12 text-center" {{ $attributes->except(['class']) }}>
    {{-- Icon area --}}
    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-zinc-100 text-zinc-400 shrink-0">
        @if($icon)
            {!! $icon !!}
        @else
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z"/>
                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                <line x1="12" x2="12" y1="12" y2="16"/>
                <line x1="10" x2="14" y1="14" y2="14"/>
            </svg>
        @endif
    </div>

    {{-- Text --}}
    <div class="flex flex-col gap-1">
        <p class="text-sm font-medium text-zinc-900">{{ $title }}</p>
        @if($description)
            <p class="text-sm text-zinc-500 max-w-sm">{{ $description }}</p>
        @endif
    </div>

    {{-- CTA slot --}}
    @if($slot->isNotEmpty())
        <div class="mt-1">
            {{ $slot }}
        </div>
    @endif
</div>

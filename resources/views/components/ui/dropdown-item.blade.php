@props([
    'href' => '#',
    'destructive' => false,
    'icon' => null,
])

@php
    $textClass = $destructive
        ? 'text-red-600 hover:bg-red-50'
        : 'text-zinc-700 hover:bg-zinc-50';
@endphp

<a
    href="{{ $href }}"
    class="flex items-center gap-2 px-3 py-2 text-sm {{ $textClass }} transition-colors w-full"
    {{ $attributes->except(['class', 'href']) }}
>
    @if($icon)
        <span class="shrink-0 w-4 h-4 flex items-center justify-center">
            {!! $icon !!}
        </span>
    @endif
    {{ $slot }}
</a>

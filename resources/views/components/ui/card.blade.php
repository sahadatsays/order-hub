@props([
    'padding' => 'default',
    'hover' => false,
    'header' => null,
    'footer' => null,
])

@php
    $paddingClasses = match($padding) {
        'none' => 'p-0',
        'sm' => 'p-4',
        'default' => 'p-6',
        'lg' => 'p-8',
        default => 'p-6',
    };

    $hoverClasses = $hover ? 'transition-shadow hover:shadow-sm cursor-pointer' : '';

    $classes = implode(' ', array_filter([
        'bg-white border border-zinc-200 rounded-xl',
        $paddingClasses,
        $hoverClasses,
    ]));
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($header->isNotEmpty())
        <div class="border-b border-zinc-100 pb-4 mb-4">
            {{ $header }}
        </div>
    @endif

    {{ $slot }}

    @if($footer->isNotEmpty())
        <div class="border-t border-zinc-100 pt-4 mt-4">
            {{ $footer }}
        </div>
    @endif
</div>

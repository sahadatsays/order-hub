@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
    'href' => null,
    'icon' => null,
])

@php
    $sizeClasses = match($size) {
        'xs' => 'px-2.5 py-1 text-xs rounded',
        'sm' => 'px-3 py-1.5 text-sm rounded-md',
        'md' => 'px-4 py-2 text-sm rounded-md',
        'lg' => 'px-5 py-2.5 text-base rounded-md',
        default => 'px-4 py-2 text-sm rounded-md',
    };

    $variantClasses = match($variant) {
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs',
        'secondary' => 'border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700',
        'ghost' => 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-800',
        'destructive' => 'bg-red-600 hover:bg-red-700 text-white',
        'link' => 'text-indigo-600 hover:text-indigo-700 underline-offset-4 hover:underline p-0',
        default => 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs',
    };

    $commonClasses = 'inline-flex items-center gap-2 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 disabled:opacity-60 disabled:cursor-not-allowed';

    $loadingClasses = $loading ? 'pointer-events-none' : '';

    $classes = implode(' ', array_filter([
        $commonClasses,
        $sizeClasses,
        $variantClasses,
        $loadingClasses,
    ]));
@endphp

@if($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if($disabled) aria-disabled="true" tabindex="-1" @endif
    >
        @if($loading)
            <svg class="animate-spin shrink-0" width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            {!! $icon !!}
        @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if($disabled || $loading) disabled @endif
    >
        @if($loading)
            <svg class="animate-spin shrink-0" width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            {!! $icon !!}
        @endif
        {{ $slot }}
    </button>
@endif

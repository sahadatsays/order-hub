@props([
    'variant' => 'soft',
    'color' => 'zinc',
])

@php
    $softClasses = match($color) {
        'zinc' => 'bg-zinc-100 text-zinc-700 ring-1 ring-zinc-200',
        'green' => 'bg-green-50 text-green-700 ring-1 ring-green-200',
        'yellow' => 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200',
        'red' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
        'blue' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
        'indigo' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200',
        'purple' => 'bg-purple-50 text-purple-700 ring-1 ring-purple-200',
        'orange' => 'bg-orange-50 text-orange-700 ring-1 ring-orange-200',
        default => 'bg-zinc-100 text-zinc-700 ring-1 ring-zinc-200',
    };

    $solidClasses = match($color) {
        'zinc' => 'bg-zinc-600 text-white',
        'green' => 'bg-green-600 text-white',
        'yellow' => 'bg-yellow-500 text-white',
        'red' => 'bg-red-600 text-white',
        'blue' => 'bg-blue-600 text-white',
        'indigo' => 'bg-indigo-600 text-white',
        'purple' => 'bg-purple-600 text-white',
        'orange' => 'bg-orange-500 text-white',
        default => 'bg-zinc-600 text-white',
    };

    $outlineClasses = match($color) {
        'zinc' => 'bg-transparent text-zinc-700 ring-1 ring-zinc-400',
        'green' => 'bg-transparent text-green-700 ring-1 ring-green-400',
        'yellow' => 'bg-transparent text-yellow-700 ring-1 ring-yellow-400',
        'red' => 'bg-transparent text-red-700 ring-1 ring-red-400',
        'blue' => 'bg-transparent text-blue-700 ring-1 ring-blue-400',
        'indigo' => 'bg-transparent text-indigo-700 ring-1 ring-indigo-400',
        'purple' => 'bg-transparent text-purple-700 ring-1 ring-purple-400',
        'orange' => 'bg-transparent text-orange-700 ring-1 ring-orange-400',
        default => 'bg-transparent text-zinc-700 ring-1 ring-zinc-400',
    };

    $colorClasses = match($variant) {
        'soft' => $softClasses,
        'solid' => $solidClasses,
        'outline' => $outlineClasses,
        default => $softClasses,
    };

    $classes = 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ' . $colorClasses;
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</span>

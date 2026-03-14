@props([
    'tab',
    'active' => false,
    'badge' => null,
])

@php
    $activeClasses = $active
        ? 'border-indigo-600 text-indigo-600'
        : 'border-transparent text-zinc-500 hover:text-zinc-700';
@endphp

<button
    data-tab-trigger="{{ $tab }}"
    type="button"
    class="px-1 py-2 text-sm font-medium border-b-2 {{ $activeClasses }} transition-colors whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
    {{ $attributes->except(['class']) }}
>
    {{ $slot }}
    @if($badge !== null)
        <span class="ml-1.5 rounded-full bg-zinc-100 px-2 py-0.5 text-xs text-zinc-600 font-normal">{{ $badge }}</span>
    @endif
</button>

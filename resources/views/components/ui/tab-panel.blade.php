@props([
    'tab',
    'active' => false,
])

<div
    data-tab-panel="{{ $tab }}"
    class="{{ $active ? '' : 'hidden' }}"
    {{ $attributes->except(['class']) }}
>
    {{ $slot }}
</div>

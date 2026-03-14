@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'type' => 'text',
    'placeholder' => '',
    'helper' => null,
    'error' => null,
    'required' => false,
    'prefix' => null,
    'suffix' => null,
    'leadingIcon' => false,
    'trailingIcon' => false,
])

@php
    $inputId = $id ?? $name;

    $baseClasses = 'border border-zinc-300 text-sm text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full block transition-colors bg-white';

    $paddingClasses = 'px-3 py-2';

    if ($leadingIcon) {
        $paddingClasses = 'pl-9 pr-3 py-2';
    }

    if ($trailingIcon) {
        $paddingClasses = $leadingIcon ? 'pl-9 pr-9 py-2' : 'pl-3 pr-9 py-2';
    }

    $errorClasses = $error
        ? 'border-red-400 focus:ring-red-500 focus:border-red-400'
        : '';

    $roundingClasses = 'rounded-md';
    if ($prefix && $suffix) {
        $roundingClasses = 'rounded-none';
    } elseif ($prefix) {
        $roundingClasses = 'rounded-l-none rounded-r-md';
    } elseif ($suffix) {
        $roundingClasses = 'rounded-r-none rounded-l-md';
    }

    $inputClasses = implode(' ', array_filter([
        $baseClasses,
        $paddingClasses,
        $errorClasses,
        $roundingClasses,
    ]));
@endphp

<div class="flex flex-col gap-1">
    @if($label)
        <label for="{{ $inputId }}" class="text-sm font-medium text-zinc-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-0.5">*</span>
            @endif
        </label>
    @endif

    <div class="relative flex items-stretch">
        @if($prefix)
            <span class="inline-flex items-center rounded-l-md border border-r-0 border-zinc-300 bg-zinc-50 px-3 text-sm text-zinc-500 select-none">
                {{ $prefix }}
            </span>
        @endif

        <input
            id="{{ $inputId }}"
            name="{{ $name }}"
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            class="{{ $inputClasses }}"
            {{ $attributes->except(['class', 'id', 'name', 'type', 'placeholder']) }}
            @if($required) required @endif
        />

        @if($suffix)
            <span class="inline-flex items-center rounded-r-md border border-l-0 border-zinc-300 bg-zinc-50 px-3 text-sm text-zinc-500 select-none">
                {{ $suffix }}
            </span>
        @endif
    </div>

    @if($error)
        <p class="text-xs text-red-600">{{ $error }}</p>
    @elseif($helper)
        <p class="text-xs text-zinc-500">{{ $helper }}</p>
    @endif
</div>

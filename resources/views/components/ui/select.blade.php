@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'placeholder' => null,
    'helper' => null,
    'error' => null,
    'required' => false,
])

@php
    $inputId = $id ?? $name;

    $baseClasses = 'border border-zinc-300 rounded-md px-3 py-2 text-sm text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full block transition-colors bg-white appearance-none pr-8 cursor-pointer';

    $errorClasses = $error
        ? 'border-red-400 focus:ring-red-500 focus:border-red-400'
        : '';

    $selectClasses = implode(' ', array_filter([
        $baseClasses,
        $errorClasses,
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

    <div class="relative">
        <select
            id="{{ $inputId }}"
            name="{{ $name }}"
            class="{{ $selectClasses }}"
            {{ $attributes->except(['class', 'id', 'name']) }}
            @if($required) required @endif
        >
            @if($placeholder)
                <option value="" disabled selected>{{ $placeholder }}</option>
            @endif
            {{ $slot }}
        </select>

        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-zinc-400">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </div>
    </div>

    @if($error)
        <p class="text-xs text-red-600">{{ $error }}</p>
    @elseif($helper)
        <p class="text-xs text-zinc-500">{{ $helper }}</p>
    @endif
</div>

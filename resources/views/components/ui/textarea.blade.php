@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'placeholder' => '',
    'helper' => null,
    'error' => null,
    'required' => false,
    'rows' => 4,
])

@php
    $inputId = $id ?? $name;

    $baseClasses = 'border border-zinc-300 rounded-md px-3 py-2 text-sm text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full block transition-colors bg-white resize-y';

    $errorClasses = $error
        ? 'border-red-400 focus:ring-red-500 focus:border-red-400'
        : '';

    $textareaClasses = implode(' ', array_filter([
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

    <textarea
        id="{{ $inputId }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        class="{{ $textareaClasses }}"
        {{ $attributes->except(['class', 'id', 'name', 'rows', 'placeholder']) }}
        @if($required) required @endif
    >{{ $slot }}</textarea>

    @if($error)
        <p class="text-xs text-red-600">{{ $error }}</p>
    @elseif($helper)
        <p class="text-xs text-zinc-500">{{ $helper }}</p>
    @endif
</div>

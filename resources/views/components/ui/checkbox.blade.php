@props([
    'name' => null,
    'value' => '1',
    'checked' => false,
    'label' => null,
    'helper' => null,
])

@php
    $inputId = 'checkbox-' . ($name ?? uniqid());
@endphp

<div class="flex items-start gap-2">
    <input
        id="{{ $inputId }}"
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        class="w-4 h-4 mt-0.5 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer shrink-0"
        {{ $attributes->except(['class', 'id', 'name', 'value']) }}
        @if($checked) checked @endif
    />

    @if($label || $helper)
        <div class="flex flex-col gap-0.5">
            @if($label)
                <label for="{{ $inputId }}" class="text-sm text-zinc-700 cursor-pointer leading-tight">
                    {{ $label }}
                </label>
            @endif
            @if($helper)
                <p class="text-xs text-zinc-500">{{ $helper }}</p>
            @endif
        </div>
    @endif
</div>

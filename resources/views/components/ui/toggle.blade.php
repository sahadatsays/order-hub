@props([
    'name' => null,
    'checked' => false,
    'label' => null,
    'helper' => null,
    'size' => 'md',
])

@php
    $trackBase = 'relative inline-flex shrink-0 cursor-pointer rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2';
    $trackSize = match($size) {
        'sm' => 'w-8 h-5',
        'md' => 'w-10 h-6',
        'lg' => 'w-12 h-7',
        default => 'w-10 h-6',
    };
    $trackColor = $checked ? 'bg-indigo-600' : 'bg-zinc-300';

    $thumbSize = match($size) {
        'sm' => 'w-3.5 h-3.5',
        'md' => 'w-4 h-4',
        'lg' => 'w-5 h-5',
        default => 'w-4 h-4',
    };
    $thumbTranslate = $checked ? 'translate-x-4' : 'translate-x-0.5';
@endphp

<div class="flex items-start gap-3">
    <div class="flex items-center">
        <button
            type="button"
            role="switch"
            aria-checked="{{ $checked ? 'true' : 'false' }}"
            data-checked="{{ $checked ? 'true' : 'false' }}"
            class="{{ $trackBase }} {{ $trackSize }} {{ $trackColor }}"
            onclick="
                this.dataset.checked = this.dataset.checked === 'true' ? 'false' : 'true';
                this.setAttribute('aria-checked', this.dataset.checked);
                this.classList.toggle('bg-indigo-600', this.dataset.checked === 'true');
                this.classList.toggle('bg-zinc-300', this.dataset.checked !== 'true');
                this.querySelector('.toggle-thumb').classList.toggle('translate-x-4', this.dataset.checked === 'true');
                this.querySelector('.toggle-thumb').classList.toggle('translate-x-0.5', this.dataset.checked !== 'true');
                var hiddenInput = this.closest('[data-toggle-wrapper]') ? this.closest('[data-toggle-wrapper]').querySelector('input[type=hidden]') : null;
                if (hiddenInput) { hiddenInput.value = this.dataset.checked === 'true' ? '1' : '0'; }
            "
        >
            <span
                class="toggle-thumb pointer-events-none inline-block {{ $thumbSize }} rounded-full bg-white shadow-sm transition-transform {{ $thumbTranslate }}"
                aria-hidden="true"
            ></span>
        </button>
        @if($name)
            <input
                type="hidden"
                name="{{ $name }}"
                value="{{ $checked ? '1' : '0' }}"
            />
        @endif
    </div>

    @if($label || $helper)
        <div class="flex flex-col gap-0.5">
            @if($label)
                <span class="text-sm font-medium text-zinc-700 leading-tight">{{ $label }}</span>
            @endif
            @if($helper)
                <span class="text-xs text-zinc-500">{{ $helper }}</span>
            @endif
        </div>
    @endif
</div>

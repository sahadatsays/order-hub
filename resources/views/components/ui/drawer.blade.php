@props([
    'id',
    'title' => null,
    'size' => 'md',
    'footer' => null,
])

@php
    $sizeClass = match($size) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-xl',
        'xl' => 'max-w-2xl',
        default => 'max-w-md',
    };
@endphp

<div
    id="{{ $id }}"
    class="hidden fixed inset-0 z-40 overflow-hidden"
    role="dialog"
    aria-modal="true"
    @if($title) aria-labelledby="{{ $id }}-title" @endif
>
    {{-- Backdrop --}}
    <div
        class="absolute inset-0 bg-zinc-900/50 transition-opacity"
        onclick="(function(el){ el.classList.add('hidden'); var panel = el.querySelector('#{{ $id }}-panel'); if(panel){ panel.classList.remove('translate-x-0'); panel.classList.add('translate-x-full'); } })(document.getElementById('{{ $id }}'))"
    ></div>

    {{-- Panel --}}
    <div class="absolute inset-y-0 right-0 flex {{ $sizeClass }} w-full">
        <div
            id="{{ $id }}-panel"
            class="flex flex-col bg-white shadow-xl w-full transform transition-transform translate-x-full"
        >
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 shrink-0">
                @if($title)
                    <h3 id="{{ $id }}-title" class="text-base font-semibold text-zinc-900">{{ $title }}</h3>
                @endif
                <button
                    type="button"
                    class="p-1 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 transition-colors ml-auto focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    onclick="(function(el){ el.classList.add('hidden'); var panel = el.querySelector('#{{ $id }}-panel'); if(panel){ panel.classList.remove('translate-x-0'); panel.classList.add('translate-x-full'); } })(document.getElementById('{{ $id }}'))"
                    aria-label="Close"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 6 6 18"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @if($footer && $footer->isNotEmpty())
                <div class="border-t border-zinc-100 px-6 py-4 flex items-center justify-end gap-3 shrink-0">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

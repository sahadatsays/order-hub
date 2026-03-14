@props([
    'id',
    'title' => null,
    'size' => 'md',
    'form' => false,
    'action' => null,
    'method' => 'POST',
    'footer' => null,
])

@php
    $sizeClass = match($size) {
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        default => 'max-w-lg',
    };
@endphp

<div
    id="{{ $id }}"
    class="hidden fixed inset-0 z-50 overflow-y-auto"
    role="dialog"
    aria-modal="true"
    @if($title) aria-labelledby="{{ $id }}-title" @endif
>
    {{-- Backdrop --}}
    <div
        class="fixed inset-0 bg-zinc-900/60 transition-opacity"
        data-modal-close="{{ $id }}"
        onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
    ></div>

    {{-- Panel wrapper --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-lg w-full {{ $sizeClass }} transform transition-all">

            @if($title)
                {{-- Header --}}
                <div class="flex items-center justify-between p-6 border-b border-zinc-100">
                    <h3 id="{{ $id }}-title" class="text-base font-semibold text-zinc-900">{{ $title }}</h3>
                    <button
                        type="button"
                        class="p-1 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
                        aria-label="Close"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if($form)
                <form action="{{ $action }}" method="POST">
                    @csrf
                    @if($method !== 'GET' && $method !== 'POST')
                        @method($method)
                    @endif
                    <div class="p-6">
                        {{ $slot }}
                    </div>
                    @if($footer && $footer->isNotEmpty())
                        <div class="flex items-center justify-end gap-3 px-6 pb-6 pt-0">
                            {{ $footer }}
                        </div>
                    @endif
                </form>
            @else
                <div class="p-6">
                    {{ $slot }}
                </div>
                @if($footer && $footer->isNotEmpty())
                    <div class="flex items-center justify-end gap-3 px-6 pb-6 pt-0">
                        {{ $footer }}
                    </div>
                @endif
            @endif

        </div>
    </div>
</div>

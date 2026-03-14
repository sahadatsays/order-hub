@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
])

@php
    $typeClasses = match($type) {
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        default => 'bg-blue-50 border-blue-200 text-blue-800',
    };
@endphp

<div class="rounded-lg border p-4 flex gap-3 {{ $typeClasses }}" role="alert" {{ $attributes->except(['class']) }}>
    {{-- Icon --}}
    <div class="shrink-0 mt-0.5">
        @if($type === 'info')
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 16v-4"/>
                <path d="M12 8h.01"/>
            </svg>
        @elseif($type === 'success')
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
        @elseif($type === 'warning')
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                <path d="M12 9v4"/>
                <path d="M12 17h.01"/>
            </svg>
        @elseif($type === 'error')
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <path d="m15 9-6 6"/>
                <path d="m9 9 6 6"/>
            </svg>
        @endif
    </div>

    {{-- Content --}}
    <div class="flex-1 min-w-0">
        @if($title)
            <p class="text-sm font-semibold mb-1">{{ $title }}</p>
        @endif
        <div class="text-sm">
            {{ $slot }}
        </div>
    </div>

    {{-- Dismiss button --}}
    @if($dismissible)
        <div class="shrink-0 -mt-0.5 -mr-1">
            <button
                type="button"
                class="p-1 rounded-md opacity-70 hover:opacity-100 transition-opacity focus:outline-none focus:ring-2 focus:ring-current"
                onclick="this.closest('[role=alert]').remove()"
                aria-label="Dismiss"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 6 6 18"/>
                    <path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>
    @endif
</div>

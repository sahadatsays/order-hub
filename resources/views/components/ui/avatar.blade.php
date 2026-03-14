@props([
    'name' => null,
    'src' => null,
    'size' => 'md',
    'status' => null,
])

@php
    $sizeClasses = match($size) {
        'xs' => 'w-6 h-6 text-xs',
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-12 h-12 text-base',
        'xl' => 'w-16 h-16 text-lg',
        default => 'w-10 h-10 text-sm',
    };

    $statusDotSize = match($size) {
        'xs' => 'w-1.5 h-1.5',
        'sm' => 'w-2 h-2',
        'md' => 'w-2.5 h-2.5',
        'lg' => 'w-3 h-3',
        'xl' => 'w-3.5 h-3.5',
        default => 'w-2.5 h-2.5',
    };

    $statusColor = match($status) {
        'online' => 'bg-green-500',
        'offline' => 'bg-zinc-400',
        'away' => 'bg-yellow-400',
        default => '',
    };

    $initials = null;
    if ($name) {
        $parts = explode(' ', trim($name));
        if (count($parts) >= 2) {
            $initials = strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
        } else {
            $initials = strtoupper(substr($parts[0], 0, 2));
        }
    }
@endphp

<span class="relative inline-flex {{ $attributes->get('class') }}" {{ $attributes->except(['class']) }}>
    @if($src)
        <img
            src="{{ $src }}"
            alt="{{ $name ?? 'Avatar' }}"
            class="{{ $sizeClasses }} rounded-full object-cover"
        />
    @elseif($initials)
        <span class="{{ $sizeClasses }} rounded-full bg-indigo-100 text-indigo-700 inline-flex items-center justify-center font-medium leading-none select-none">
            {{ $initials }}
        </span>
    @else
        <span class="{{ $sizeClasses }} rounded-full bg-zinc-100 text-zinc-400 inline-flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3/5 h-3/5" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
            </svg>
        </span>
    @endif

    @if($status)
        <span class="absolute bottom-0 right-0 block {{ $statusDotSize }} rounded-full {{ $statusColor }} ring-2 ring-white" aria-label="{{ $status }}"></span>
    @endif
</span>

@props([
    'align' => 'right',
    'trigger',
])

@php
    $menuAlignClass = $align === 'right' ? 'right-0' : 'left-0';
@endphp

<div class="relative inline-block" data-dropdown {{ $attributes->except(['class']) }}>
    {{-- Trigger --}}
    <div
        data-dropdown-toggle
        onclick="
            var menu = this.closest('[data-dropdown]').querySelector('[data-dropdown-menu]');
            var isHidden = menu.classList.contains('hidden');
            // Close all other open dropdowns
            document.querySelectorAll('[data-dropdown-menu]').forEach(function(m) {
                m.classList.add('hidden');
            });
            if (isHidden) {
                menu.classList.remove('hidden');
            }
        "
        class="cursor-pointer"
    >
        {{ $trigger }}
    </div>

    {{-- Menu --}}
    <div
        data-dropdown-menu
        class="hidden absolute {{ $menuAlignClass }} top-full mt-1 bg-white border border-zinc-200 rounded-lg shadow-lg py-1 min-w-48 z-50"
        onclick="this.classList.add('hidden')"
    >
        {{ $slot }}
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('click', function(e) {
                if (!e.target.closest('[data-dropdown]')) {
                    document.querySelectorAll('[data-dropdown-menu]').forEach(function(menu) {
                        menu.classList.add('hidden');
                    });
                }
            });
        </script>
    @endpush
@endonce

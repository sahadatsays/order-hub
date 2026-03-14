@props([
    'variant' => 'line',
    'triggers' => null,
])

@php
    $triggerWrapperClass = match($variant) {
        'line' => 'flex items-center gap-4 border-b border-zinc-200 overflow-x-auto',
        'pill' => 'flex items-center gap-1 flex-wrap',
        'segmented' => 'inline-flex items-center bg-zinc-100 rounded-lg p-1 gap-0.5',
        default => 'flex items-center gap-4 border-b border-zinc-200 overflow-x-auto',
    };
@endphp

<div data-tabs data-variant="{{ $variant }}" {{ $attributes->except(['class']) }}>
    {{-- Triggers --}}
    @if($triggers && $triggers->isNotEmpty())
        <div class="{{ $triggerWrapperClass }}">
            {{ $triggers }}
        </div>
    @endif

    {{-- Panels --}}
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('[data-tabs]').forEach(function(tabsEl) {
                    var variant = tabsEl.dataset.variant || 'line';

                    tabsEl.querySelectorAll('[data-tab-trigger]').forEach(function(trigger) {
                        trigger.addEventListener('click', function() {
                            var tabName = this.dataset.tabTrigger;

                            // Update triggers
                            tabsEl.querySelectorAll('[data-tab-trigger]').forEach(function(t) {
                                if (variant === 'line') {
                                    t.classList.remove('border-indigo-600', 'text-indigo-600');
                                    t.classList.add('border-transparent', 'text-zinc-500', 'hover:text-zinc-700');
                                } else if (variant === 'pill') {
                                    t.classList.remove('bg-indigo-600', 'text-white');
                                    t.classList.add('text-zinc-600', 'hover:bg-zinc-100');
                                } else if (variant === 'segmented') {
                                    t.classList.remove('bg-white', 'shadow-xs', 'text-zinc-900');
                                    t.classList.add('text-zinc-500');
                                }
                            });

                            if (variant === 'line') {
                                this.classList.remove('border-transparent', 'text-zinc-500', 'hover:text-zinc-700');
                                this.classList.add('border-indigo-600', 'text-indigo-600');
                            } else if (variant === 'pill') {
                                this.classList.remove('text-zinc-600', 'hover:bg-zinc-100');
                                this.classList.add('bg-indigo-600', 'text-white');
                            } else if (variant === 'segmented') {
                                this.classList.remove('text-zinc-500');
                                this.classList.add('bg-white', 'shadow-xs', 'text-zinc-900');
                            }

                            // Update panels
                            tabsEl.querySelectorAll('[data-tab-panel]').forEach(function(panel) {
                                if (panel.dataset.tabPanel === tabName) {
                                    panel.classList.remove('hidden');
                                } else {
                                    panel.classList.add('hidden');
                                }
                            });
                        });
                    });
                });
            });
        </script>
    @endpush
@endonce

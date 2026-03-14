@props([
    'label',
    'value',
    'trend' => null,
    'trendLabel' => null,
    'trendUp' => true,
    'icon' => null,
    'iconBg' => 'bg-indigo-50',
    'iconColor' => 'text-indigo-600',
])

<div class="bg-white border border-zinc-200 rounded-xl p-6" {{ $attributes->except(['class']) }}>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <p class="text-sm font-medium text-zinc-500">{{ $label }}</p>
            <p class="text-2xl font-semibold text-zinc-900 mt-1 tabular-nums">{{ $value }}</p>

            @if($trend)
                <div class="flex items-center gap-1 mt-2">
                    @if($trendUp)
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 shrink-0" aria-hidden="true">
                            <path d="m18 15-6-6-6 6"/>
                        </svg>
                        <span class="text-xs font-medium text-green-600">{{ $trend }}</span>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 shrink-0" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                        <span class="text-xs font-medium text-red-500">{{ $trend }}</span>
                    @endif

                    @if($trendLabel)
                        <span class="text-xs text-zinc-400">{{ $trendLabel }}</span>
                    @endif
                </div>
            @endif
        </div>

        @if($icon)
            <div class="p-2.5 rounded-lg {{ $iconBg }} {{ $iconColor }} shrink-0">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>

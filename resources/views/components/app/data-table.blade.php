@props([
    'columns' => [],
    'rows' => [],
    'emptyTitle' => 'No results',
    'emptyDescription' => null,
    'selectable' => true,
    'stickyHeader' => true,
])

@php
    $bulkId = 'bulk-' . uniqid();
    $tableId = 'table-' . uniqid();
    $colSpan = count($columns) + ($selectable ? 1 : 0);
@endphp

<div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">

    {{-- Bulk action bar --}}
    <div id="{{ $bulkId }}" class="hidden items-center gap-3 px-4 py-3 bg-indigo-50 border-b border-indigo-100">
        <span class="text-sm font-medium text-indigo-700" data-bulk-count>0 selected</span>
        <div class="flex items-center gap-2">
            @if (isset($bulkActions))
                {{ $bulkActions }}
            @else
                <button
                    type="button"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-700 bg-white border border-red-200 rounded-md hover:bg-red-50 transition-colors"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete selected
                </button>
            @endif
        </div>
        <button
            type="button"
            class="ml-auto text-xs text-indigo-500 hover:text-indigo-700 transition-colors"
            onclick="document.getElementById('{{ $bulkId }}').classList.add('hidden'); document.getElementById('{{ $bulkId }}').classList.remove('flex'); document.querySelectorAll('#{{ $tableId }} input[type=checkbox]').forEach(cb => cb.checked = false);"
        >
            Clear selection
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="{{ $tableId }}" class="w-full text-sm">
            <thead class="{{ $stickyHeader ? 'sticky top-0' : '' }} bg-zinc-50 border-b border-zinc-200 z-10">
                <tr>
                    @if ($selectable)
                        <th class="px-4 py-3 w-10">
                            <input
                                type="checkbox"
                                class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                onchange="
                                    const table = document.getElementById('{{ $tableId }}');
                                    table.querySelectorAll('tbody input[type=checkbox]').forEach(cb => cb.checked = this.checked);
                                    const checked = table.querySelectorAll('tbody input[type=checkbox]:checked').length;
                                    const bulk = document.getElementById('{{ $bulkId }}');
                                    if (checked > 0) { bulk.classList.remove('hidden'); bulk.classList.add('flex'); bulk.querySelector('[data-bulk-count]').textContent = checked + ' selected'; }
                                    else { bulk.classList.add('hidden'); bulk.classList.remove('flex'); }
                                "
                                aria-label="Select all"
                            >
                        </th>
                    @endif

                    @foreach ($columns as $column)
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider whitespace-nowrap {{ $column['class'] ?? '' }}">
                            @if (isset($column['sortable']) && $column['sortable'])
                                <button
                                    type="button"
                                    class="inline-flex items-center gap-1 hover:text-zinc-700 transition-colors group"
                                >
                                    {{ $column['label'] }}
                                    <svg class="w-3 h-3 text-zinc-400 group-hover:text-zinc-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                    </svg>
                                </button>
                            @else
                                {{ $column['label'] }}
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="divide-y divide-zinc-100">
                @if (isset($body) && $body->isNotEmpty())
                    {{ $body }}
                @elseif (count($rows) > 0)
                    @foreach ($rows as $row)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            @if ($selectable)
                                <td class="px-4 py-3 w-10">
                                    <input
                                        type="checkbox"
                                        class="w-4 h-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                        onchange="
                                            const table = document.getElementById('{{ $tableId }}');
                                            const checked = table.querySelectorAll('tbody input[type=checkbox]:checked').length;
                                            const bulk = document.getElementById('{{ $bulkId }}');
                                            if (checked > 0) { bulk.classList.remove('hidden'); bulk.classList.add('flex'); bulk.querySelector('[data-bulk-count]').textContent = checked + ' selected'; }
                                            else { bulk.classList.add('hidden'); bulk.classList.remove('flex'); }
                                        "
                                    >
                                </td>
                            @endif

                            @foreach ($columns as $column)
                                <td class="px-4 py-3 text-zinc-700 {{ $column['class'] ?? '' }}">
                                    {{ $row[$column['key']] ?? '—' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="{{ $colSpan }}" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-10 h-10 rounded-full bg-zinc-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-zinc-500">{{ $emptyTitle }}</p>
                                @if ($emptyDescription)
                                    <p class="text-xs text-zinc-400">{{ $emptyDescription }}</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if (isset($pagination))
        <div class="px-4 py-3 border-t border-zinc-100">
            {{ $pagination }}
        </div>
    @endif

</div>

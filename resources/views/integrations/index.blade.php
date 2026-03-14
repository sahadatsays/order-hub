<x-layouts.app title="Integrations">
<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Integrations</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Connect your sales channels to sync orders automatically.</p>
    </div>

    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-md text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        @php
        $icons = [
            'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
            'woocommerce' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#96588A"><path d="M.002 3.107c0-1.714 1.388-3.107 3.098-3.107h17.8C22.61 0 24 1.393 24 3.107v10.26c0 1.714-1.39 3.107-3.1 3.107H14.3l.927 3.526-5.044-3.526H3.1C1.39 16.474 0 15.08 0 13.367V3.107z"/></svg>',
            'shopify' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#96BF48"><path d="M15.337.009s-.184.017-.428.05l-1.51 4.24a6.166 6.166 0 0 1 2.175 1.127l1.69-4.74S16.295.04 15.337.009zm-3.127.578L10.36 5.06a6.166 6.166 0 0 1 1.93.39L14.1.86a6.77 6.77 0 0 0-1.89-.273zM20.94 3.81L13.7 6.03a6.181 6.181 0 0 1 .7 2.62l7.19-2.197A.375.375 0 0 0 21.9 6a.375.375 0 0 0-.96-.19zM5.82 9.07c-2.45 0-4.44 1.985-4.44 4.44s1.99 4.44 4.44 4.44 4.44-1.985 4.44-4.44S8.27 9.07 5.82 9.07zm0 1.5c1.625 0 2.94 1.315 2.94 2.94s-1.315 2.94-2.94 2.94-2.94-1.315-2.94-2.94 1.315-2.94 2.94-2.94zm0 1.26a1.68 1.68 0 1 0 0 3.36 1.68 1.68 0 0 0 0-3.36zm8.41 0c-2.45 0-4.44 1.985-4.44 4.44s1.99 4.44 4.44 4.44 4.44-1.985 4.44-4.44-1.99-4.44-4.44-4.44zm0 1.5c1.625 0 2.94 1.315 2.94 2.94s-1.315 2.94-2.94 2.94-2.94-1.315-2.94-2.94 1.315-2.94 2.94-2.94zm0 1.26a1.68 1.68 0 1 0 0 3.36 1.68 1.68 0 0 0 0-3.36z"/></svg>',
            'whatsapp' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
            'website' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/></svg>',
            'pos' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h18a2 2 0 012 2v14a2 2 0 01-2 2H3a2 2 0 01-2-2V5a2 2 0 012-2z"/><path d="M8 12h.01M12 12h.01M16 12h.01M8 16h.01M12 16h.01M16 16h.01"/></svg>',
        ];
        @endphp

        @foreach(\App\Models\Integration::TYPES as $type => $label)
        @php $integration = $integrations->get($type); $connected = $integration && $integration->is_active; @endphp
        <div class="bg-white border border-zinc-200 rounded-xl p-5">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-zinc-50 border border-zinc-100">
                    {!! $icons[$type] ?? '' !!}
                </div>
                @if($connected)
                    <x-ui.badge color="green">Connected</x-ui.badge>
                @else
                    <x-ui.badge color="zinc">Not Connected</x-ui.badge>
                @endif
            </div>

            <h3 class="font-semibold text-zinc-900 mb-1">{{ $label }}</h3>

            <p class="text-xs text-zinc-500 mb-4">
                @switch($type)
                    @case('facebook') Import orders from Facebook page and messenger. @break
                    @case('woocommerce') Sync orders from your WooCommerce store. @break
                    @case('shopify') Pull orders from Shopify automatically. @break
                    @case('whatsapp') Capture manual WhatsApp orders. @break
                    @case('website') Receive orders from your website via API. @break
                    @case('pos') Sync walk-in POS orders. @break
                @endswitch
            </p>

            @if($connected && $integration->last_synced_at)
            <p class="text-xs text-zinc-400 mb-3">Last synced: {{ $integration->last_synced_at->diffForHumans() }}</p>
            @endif

            @if($connected)
            <form action="{{ route('integrations.disconnect', $integration) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="w-full px-4 py-2 text-sm border border-zinc-300 bg-white hover:bg-zinc-50 text-zinc-700 font-medium rounded-md transition-colors">Disconnect</button>
            </form>
            @else
            <form action="{{ route('integrations.connect', $type) }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">Connect</button>
            </form>
            @endif
        </div>
        @endforeach

    </div>
</div>
</x-layouts.app>

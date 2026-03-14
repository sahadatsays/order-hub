@props([
    'searchUrl'   => null,
    'fieldName'   => 'customer',
    'placeholder' => 'Search by name, phone, or email...',
    'showWalkIn'  => false,
    'label'       => 'Select customer',
])

@php
    $url = $searchUrl ?? route('customers.search');
    $uid = 'cs_' . Str::random(6);
@endphp

<div id="{{ $uid }}" data-customer-search="{{ $url }}" class="space-y-2">

    {{-- Hidden inputs populated by JS --}}
    <input type="hidden" id="{{ $uid }}_id"    name="{{ $fieldName }}_id">
    <input type="hidden" id="{{ $uid }}_name"  name="{{ $fieldName }}_name">
    <input type="hidden" id="{{ $uid }}_phone" name="{{ $fieldName }}_phone">
    <input type="hidden" id="{{ $uid }}_email" name="{{ $fieldName }}_email">

    {{-- Search section --}}
    <div id="{{ $uid }}_search" class="space-y-3">

        @if($label)
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $label }}</label>
        @endif

        <div class="relative">
            {{-- Search icon --}}
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
            </div>

            <input
                type="text"
                id="{{ $uid }}_input"
                placeholder="{{ $placeholder }}"
                autocomplete="off"
                class="w-full pl-10 pr-10 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-slate-50 focus:bg-white placeholder:text-slate-400 transition-all"
            >

            {{-- Spinner (hidden by default) --}}
            <div id="{{ $uid }}_spinner" style="display:none" class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-slate-400 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>

            {{-- Results dropdown --}}
            <div id="{{ $uid }}_results"
                class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl z-30 max-h-60 overflow-y-auto">
            </div>
        </div>

        @if($showWalkIn)
            <div class="flex items-center gap-3">
                <div class="flex-1 h-px bg-slate-100"></div>
                <span class="text-xs text-slate-400 font-medium">or</span>
                <div class="flex-1 h-px bg-slate-100"></div>
            </div>
            <button
                type="button"
                id="{{ $uid }}_walkin"
                class="w-full flex items-center justify-center gap-2.5 px-4 py-2.5 text-sm font-semibold border-2 border-dashed border-slate-200 hover:border-indigo-300 rounded-xl text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Walk-in customer
            </button>
        @endif
    </div>

    {{-- Selected customer card (hidden by default) --}}
    <div id="{{ $uid }}_card" class="hidden items-center gap-3 px-4 py-3 bg-indigo-50 border border-indigo-100 rounded-xl">
        <div class="w-9 h-9 bg-indigo-600 rounded-full flex items-center justify-center shrink-0 shadow-sm">
            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p id="{{ $uid }}_card_name" class="text-sm font-bold text-slate-900 truncate"></p>
            <p id="{{ $uid }}_card_meta" class="text-xs text-slate-500 truncate"></p>
        </div>
        <button
            type="button"
            id="{{ $uid }}_clear"
            class="flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-semibold text-slate-500 hover:text-slate-700 hover:bg-white rounded-lg transition-all shrink-0"
        >
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Change
        </button>
    </div>

</div>

@once
@push('scripts')
<script>
(function () {
    function CustomerSearch(uid, searchUrl) {
        var self = this;
        self.uid        = uid;
        self.searchUrl  = searchUrl;
        self.timer      = null;

        self.root       = document.getElementById(uid);
        self.input      = document.getElementById(uid + '_input');
        self.spinner    = document.getElementById(uid + '_spinner');
        self.results    = document.getElementById(uid + '_results');
        self.searchSec  = document.getElementById(uid + '_search');
        self.card       = document.getElementById(uid + '_card');
        self.cardName   = document.getElementById(uid + '_card_name');
        self.cardMeta   = document.getElementById(uid + '_card_meta');
        self.clearBtn   = document.getElementById(uid + '_clear');
        self.walkInBtn  = document.getElementById(uid + '_walkin');
        self.hiddenId    = document.getElementById(uid + '_id');
        self.hiddenName  = document.getElementById(uid + '_name');
        self.hiddenPhone = document.getElementById(uid + '_phone');
        self.hiddenEmail = document.getElementById(uid + '_email');

        self.input.addEventListener('input', function () {
            clearTimeout(self.timer);
            var q = self.input.value.trim();
            if (q.length < 2) { self.closeDropdown(); return; }
            self.timer = setTimeout(function () { self.search(q); }, 300);
        });

        self.input.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { self.closeDropdown(); }
        });

        self.clearBtn.addEventListener('click', function () { self.clear(); });

        if (self.walkInBtn) {
            self.walkInBtn.addEventListener('click', function () {
                self.select({ id: null, name: 'Walk-in Customer', phone: '', email: '' });
            });
        }

        document.addEventListener('click', function (e) {
            if (!self.root.contains(e.target)) { self.closeDropdown(); }
        });
    }

    CustomerSearch.prototype.search = function (q) {
        var self = this;
        self.spinner.style.display = 'flex';

        fetch(self.searchUrl + '?q=' + encodeURIComponent(q), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        })
        .then(function (res) { return res.json(); })
        .then(function (customers) { self.renderResults(customers); })
        .catch(function () { self.closeDropdown(); })
        .finally(function () {
            self.spinner.style.display = 'none';
        });
    };

    CustomerSearch.prototype.renderResults = function (customers) {
        var self = this;

        if (customers.length === 0) {
            self.results.innerHTML =
                '<div class="px-4 py-5 text-center">' +
                    '<svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>' +
                    '<p class="text-xs font-medium text-slate-400">No customers found</p>' +
                '</div>';
        } else {
            self.results.innerHTML = customers.map(function (c) {
                var meta = [c.phone, c.email].filter(Boolean).join(' · ');
                return '<button type="button" class="cs-result w-full text-left px-4 py-3 hover:bg-indigo-50 transition-colors border-b border-slate-50 last:border-0 flex items-center gap-3"' +
                    ' data-id="' + (c.id || '') + '"' +
                    ' data-name="' + self.esc(c.name) + '"' +
                    ' data-phone="' + self.esc(c.phone || '') + '"' +
                    ' data-email="' + self.esc(c.email || '') + '">' +
                    '<div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center shrink-0">' +
                        '<svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>' +
                    '</div>' +
                    '<div class="min-w-0">' +
                        '<p class="text-sm font-semibold text-slate-900 truncate">' + self.esc(c.name) + '</p>' +
                        '<p class="text-xs text-slate-400 truncate">' + self.esc(meta) + '</p>' +
                    '</div>' +
                '</button>';
            }).join('');

            self.results.querySelectorAll('.cs-result').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    self.select({
                        id:    btn.dataset.id ? parseInt(btn.dataset.id) : null,
                        name:  btn.dataset.name,
                        phone: btn.dataset.phone,
                        email: btn.dataset.email,
                    });
                });
            });
        }

        self.results.classList.remove('hidden');
    };

    CustomerSearch.prototype.select = function (customer) {
        var self = this;
        self.hiddenId.value    = customer.id    != null ? customer.id : '';
        self.hiddenName.value  = customer.name  || '';
        self.hiddenPhone.value = customer.phone || '';
        self.hiddenEmail.value = customer.email || '';

        self.cardName.textContent = customer.name || '';
        var meta = [customer.phone, customer.email].filter(Boolean).join(' · ');
        self.cardMeta.textContent = meta;

        self.searchSec.classList.add('hidden');
        self.card.classList.remove('hidden');
        self.card.classList.add('flex');

        self.input.value = '';
        self.closeDropdown();

        self.root.dispatchEvent(new CustomEvent('customer-selected', {
            bubbles: true,
            detail: { customer: customer, uid: self.uid },
        }));
    };

    CustomerSearch.prototype.clear = function () {
        var self = this;
        self.hiddenId.value = self.hiddenName.value = self.hiddenPhone.value = self.hiddenEmail.value = '';
        self.card.classList.add('hidden');
        self.card.classList.remove('flex');
        self.searchSec.classList.remove('hidden');

        self.root.dispatchEvent(new CustomEvent('customer-cleared', {
            bubbles: true,
            detail: { uid: self.uid },
        }));
    };

    CustomerSearch.prototype.closeDropdown = function () {
        this.results.classList.add('hidden');
        this.results.innerHTML = '';
    };

    CustomerSearch.prototype.esc = function (str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    };

    window.CustomerSearch = CustomerSearch;

    // Auto-init all [data-customer-search] roots when DOM is ready
    function initAll() {
        document.querySelectorAll('[data-customer-search]').forEach(function (el) {
            if (!el._csInit) {
                el._csInit = new CustomerSearch(el.id, el.dataset.customerSearch);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
}());
</script>
@endpush
@endonce

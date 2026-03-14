<x-layouts.app title="Settings — Billing">
<div class="max-w-5xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Settings</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account and organisation settings.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- LEFT: Settings sidebar nav --}}
        <x-settings.sidebar />

        {{-- RIGHT: Main content --}}
        <div class="flex-1 min-w-0 space-y-6">

            @if(session('success'))
                <div class="px-4 py-3 bg-green-50 border border-green-200 rounded-md text-sm text-green-800">{{ session('success') }}</div>
            @endif

            {{-- Current Plan --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Current Plan</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Your current subscription and usage details.</p>
                </div>

                @if($plan)
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-semibold text-zinc-900">{{ $plan->name }}</h3>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200">Active</span>
                            </div>
                            @if($subscription)
                                <p class="text-sm text-zinc-500 mt-1">
                                    Renews {{ $subscription->ends_at ? $subscription->ends_at->format('M d, Y') : 'automatically' }}
                                </p>
                            @endif
                        </div>
                        @if($plan->price ?? null)
                            <p class="text-2xl font-bold text-zinc-900">
                                ৳{{ number_format($plan->price, 0) }}
                                <span class="text-sm font-normal text-zinc-500">/ month</span>
                            </p>
                        @endif
                    </div>

                    {{-- Plan features --}}
                    @if($plan->features ?? null)
                        <div class="border-t border-zinc-100 pt-4">
                            <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-2">Features</p>
                            <ul class="space-y-1.5">
                                @foreach((is_array($plan->features) ? $plan->features : json_decode($plan->features, true)) ?? [] as $feature)
                                    <li class="flex items-center gap-2 text-sm text-zinc-700">
                                        <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @else
                    {{-- No plan / Free or Trial --}}
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-zinc-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                        </div>
                        <div>
                            @if($tenant->trial_ends_at ?? null)
                                <h3 class="text-lg font-semibold text-zinc-900">Trial Plan</h3>
                                <p class="text-sm text-zinc-500">
                                    Your trial ends on {{ $tenant->trial_ends_at->format('M d, Y') }}
                                    @if($tenant->trial_ends_at->isPast())
                                        <span class="text-red-600 font-medium">(Expired)</span>
                                    @else
                                        ({{ $tenant->trial_ends_at->diffForHumans() }})
                                    @endif
                                </p>
                            @else
                                <h3 class="text-lg font-semibold text-zinc-900">Free Plan</h3>
                                <p class="text-sm text-zinc-500">You are currently on the free plan.</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Subscription Details --}}
            @if($subscription)
                <div class="bg-white border border-zinc-200 rounded-xl p-6">
                    <div class="mb-5">
                        <h2 class="text-sm font-semibold text-zinc-900">Subscription Details</h2>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-zinc-500">Status</dt>
                            <dd class="font-medium text-zinc-900 mt-0.5">
                                @if($subscription->active ?? false)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-200">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-50 text-zinc-500 ring-1 ring-zinc-200">Inactive</span>
                                @endif
                            </dd>
                        </div>
                        @if($subscription->created_at ?? null)
                            <div>
                                <dt class="text-zinc-500">Started</dt>
                                <dd class="font-medium text-zinc-900 mt-0.5">{{ $subscription->created_at->format('M d, Y') }}</dd>
                            </div>
                        @endif
                        @if($subscription->ends_at ?? null)
                            <div>
                                <dt class="text-zinc-500">Next Billing Date</dt>
                                <dd class="font-medium text-zinc-900 mt-0.5">{{ $subscription->ends_at->format('M d, Y') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif

        </div>
    </div>
</div>
</x-layouts.app>

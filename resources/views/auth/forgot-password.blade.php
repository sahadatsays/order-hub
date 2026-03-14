<x-layouts.auth title="Forgot password">
    <div class="w-full max-w-sm">

        <a
            href="#"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-700 mb-8 transition-colors"
        >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to sign in
        </a>

        @if (session('status'))
            {{-- Success state --}}
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-50 mb-5">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-zinc-900 mb-2">Check your inbox</h2>
                <p class="text-sm text-zinc-500 leading-relaxed">
                    {{ session('status') }}
                </p>
                <p class="mt-4 text-xs text-zinc-400">
                    Didn't receive it?
                    <button
                        type="button"
                        onclick="document.getElementById('resend-form').submit()"
                        class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors"
                    >
                        Resend email
                    </button>
                </p>
            </div>

            {{-- Hidden resend form --}}
            {{-- TODO: update action to route('password.email') once auth routes are registered --}}
            <form id="resend-form" method="POST" action="#" class="hidden">
                @csrf
                <input type="hidden" name="email" value="{{ old('email', request('email', '')) }}">
            </form>
        @else
            {{-- Icon --}}
            <div class="flex justify-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-indigo-50">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <div class="mb-8 text-center">
                <h2 class="text-2xl font-semibold text-zinc-900">Forgot your password?</h2>
                <p class="mt-1.5 text-sm text-zinc-500 leading-relaxed">
                    Enter your email and we'll send a reset link.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- TODO: update action to route('password.email') once auth routes are registered --}}
            <form method="POST" action="#" class="space-y-4">
                @csrf

                <x-ui.input
                    label="Email address"
                    name="email"
                    type="email"
                    placeholder="you@company.com"
                    :required="true"
                    :error="$errors->first('email')"
                    value="{{ old('email') }}"
                />

                <x-ui.button type="submit" class="w-full justify-center" size="lg">
                    Send reset link
                </x-ui.button>
            </form>

            <p class="mt-6 text-center text-sm text-zinc-500">
                Remembered your password?
                <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">Sign in →</a>
            </p>
        @endif

    </div>
</x-layouts.auth>

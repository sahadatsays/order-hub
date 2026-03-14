<x-layouts.auth title="Reset password">
    <div class="w-full max-w-sm">

        {{-- Icon --}}
        <div class="flex justify-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-indigo-50">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
        </div>

        <div class="mb-8 text-center">
            <h2 class="text-2xl font-semibold text-zinc-900">Set a new password</h2>
            <p class="mt-1.5 text-sm text-zinc-500 leading-relaxed">
                Choose a strong password for your account.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token ?? '' }}">
            <input type="hidden" name="email" value="{{ request()->query('email', old('email', '')) }}">

            <div class="p-3 bg-zinc-50 border border-zinc-200 rounded-md">
                <p class="text-xs text-zinc-500">Resetting password for</p>
                <p class="text-sm font-medium text-zinc-800 truncate mt-0.5">
                    {{ request()->query('email', old('email', 'your account')) }}
                </p>
            </div>

            <div class="flex flex-col gap-1">
                <x-ui.input
                    label="New password"
                    name="password"
                    id="new-password"
                    type="password"
                    placeholder="Min. 8 characters"
                    :required="true"
                    :error="$errors->first('password')"
                />
                <div class="mt-1 h-1 bg-zinc-100 rounded-full overflow-hidden">
                    <div
                        class="h-1 rounded-full bg-red-400 transition-all duration-300"
                        id="reset-pw-strength"
                        style="width: 0%"
                    ></div>
                </div>
                <p class="text-xs text-zinc-400" id="reset-pw-strength-label">Enter a password</p>
            </div>

            <x-ui.input
                label="Confirm password"
                name="password_confirmation"
                id="password_confirmation"
                type="password"
                placeholder="Repeat your new password"
                :required="true"
                :error="$errors->first('password_confirmation')"
            />

            <div class="pt-1">
                <x-ui.button type="submit" class="w-full justify-center" size="lg">
                    Update password
                </x-ui.button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-zinc-500">
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">← Back to sign in</a>
        </p>

    </div>

    <script>
        const resetPasswordInput = document.getElementById('new-password');
        const resetStrengthBar = document.getElementById('reset-pw-strength');
        const resetStrengthLabel = document.getElementById('reset-pw-strength-label');

        if (resetPasswordInput && resetStrengthBar && resetStrengthLabel) {
            resetPasswordInput.addEventListener('input', function () {
                const value = this.value;
                let score = 0;

                if (value.length >= 8) { score += 25; }
                if (value.length >= 12) { score += 15; }
                if (/[A-Z]/.test(value)) { score += 20; }
                if (/[0-9]/.test(value)) { score += 20; }
                if (/[^A-Za-z0-9]/.test(value)) { score += 20; }

                score = Math.min(score, 100);
                resetStrengthBar.style.width = score + '%';

                if (score === 0) {
                    resetStrengthBar.className = 'h-1 rounded-full transition-all duration-300 bg-zinc-200';
                    resetStrengthLabel.textContent = 'Enter a password';
                } else if (score < 40) {
                    resetStrengthBar.className = 'h-1 rounded-full transition-all duration-300 bg-red-400';
                    resetStrengthLabel.textContent = 'Weak password';
                } else if (score < 75) {
                    resetStrengthBar.className = 'h-1 rounded-full transition-all duration-300 bg-yellow-400';
                    resetStrengthLabel.textContent = 'Fair password';
                } else {
                    resetStrengthBar.className = 'h-1 rounded-full transition-all duration-300 bg-green-500';
                    resetStrengthLabel.textContent = 'Strong password';
                }
            });
        }
    </script>
</x-layouts.auth>

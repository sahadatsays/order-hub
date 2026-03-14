<x-layouts.auth title="Create account">
    <div class="w-full max-w-sm">
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-zinc-900">Create your account</h2>
            <p class="mt-1.5 text-sm text-zinc-500">Start managing orders in minutes</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf

            <x-ui.input
                label="Full name"
                name="name"
                type="text"
                placeholder="Jane Smith"
                :required="true"
                :error="$errors->first('name')"
                value="{{ old('name') }}"
            />

            <x-ui.input
                label="Work email"
                name="email"
                type="email"
                placeholder="jane@company.com"
                :required="true"
                :error="$errors->first('email')"
                value="{{ old('email') }}"
            />

            <div class="flex flex-col gap-1">
                <x-ui.input
                    label="Password"
                    name="password"
                    id="password"
                    type="password"
                    placeholder="Min. 8 characters"
                    :required="true"
                    :error="$errors->first('password')"
                />
                <div class="mt-1 h-1 bg-zinc-100 rounded-full overflow-hidden">
                    <div
                        class="h-1 rounded-full bg-red-400 transition-all duration-300"
                        id="pw-strength"
                        style="width: 0%"
                    ></div>
                </div>
                <p class="text-xs text-zinc-400" id="pw-strength-label">Enter a password</p>
            </div>

            <x-ui.input
                label="Company name"
                name="company_name"
                type="text"
                placeholder="Acme Corp"
                :required="true"
                :error="$errors->first('company_name')"
                value="{{ old('company_name') }}"
            />

            <div class="flex flex-col gap-1">
                <label for="company_size" class="text-sm font-medium text-zinc-700">
                    Company size <span class="text-red-500 ml-0.5">*</span>
                </label>
                <select
                    id="company_size"
                    name="company_size"
                    class="border border-zinc-300 text-sm text-zinc-800 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors w-full"
                >
                    <option value="" disabled {{ old('company_size') ? '' : 'selected' }}>Select team size</option>
                    <option value="1-10" {{ old('company_size') === '1-10' ? 'selected' : '' }}>1 – 10 employees</option>
                    <option value="11-50" {{ old('company_size') === '11-50' ? 'selected' : '' }}>11 – 50 employees</option>
                    <option value="51-200" {{ old('company_size') === '51-200' ? 'selected' : '' }}>51 – 200 employees</option>
                    <option value="200+" {{ old('company_size') === '200+' ? 'selected' : '' }}>200+ employees</option>
                </select>
                @error('company_size')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-1">
                <x-ui.button type="submit" class="w-full justify-center" size="lg">
                    Create account
                </x-ui.button>
            </div>

            <p class="text-center text-xs text-zinc-400 leading-relaxed">
                By creating an account you agree to our
                <a href="#" class="text-zinc-600 hover:text-zinc-800 underline underline-offset-2 transition-colors">Terms of Service</a>
                and
                <a href="#" class="text-zinc-600 hover:text-zinc-800 underline underline-offset-2 transition-colors">Privacy Policy</a>.
            </p>
        </form>

        <p class="mt-6 text-center text-sm text-zinc-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">Sign in →</a>
        </p>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('pw-strength');
        const strengthLabel = document.getElementById('pw-strength-label');

        if (passwordInput && strengthBar && strengthLabel) {
            passwordInput.addEventListener('input', function () {
                const value = this.value;
                let score = 0;

                if (value.length >= 8) { score += 25; }
                if (value.length >= 12) { score += 15; }
                if (/[A-Z]/.test(value)) { score += 20; }
                if (/[0-9]/.test(value)) { score += 20; }
                if (/[^A-Za-z0-9]/.test(value)) { score += 20; }

                score = Math.min(score, 100);
                strengthBar.style.width = score + '%';

                if (score === 0) {
                    strengthBar.className = 'h-1 rounded-full transition-all duration-300 bg-zinc-200';
                    strengthLabel.textContent = 'Enter a password';
                } else if (score < 40) {
                    strengthBar.className = 'h-1 rounded-full transition-all duration-300 bg-red-400';
                    strengthLabel.textContent = 'Weak password';
                } else if (score < 75) {
                    strengthBar.className = 'h-1 rounded-full transition-all duration-300 bg-yellow-400';
                    strengthLabel.textContent = 'Fair password';
                } else {
                    strengthBar.className = 'h-1 rounded-full transition-all duration-300 bg-green-500';
                    strengthLabel.textContent = 'Strong password';
                }
            });
        }
    </script>
</x-layouts.auth>

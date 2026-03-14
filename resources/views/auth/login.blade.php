<x-layouts.auth title="Sign in">
    <div class="w-full max-w-sm">
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-zinc-900">Welcome back</h2>
            <p class="mt-1.5 text-sm text-zinc-500">Sign in to your Order Hub account</p>
        </div>

        @if ($errors->any() || session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                {{ $errors->first() ?? session('error') }}
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        {{-- TODO: update action to route('login') once auth routes are registered --}}
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

            <div>
                <x-ui.input
                    label="Password"
                    name="password"
                    type="password"
                    placeholder="••••••••"
                    :required="true"
                    :error="$errors->first('password')"
                />
                <div class="mt-1.5 flex justify-end">
                    <a href="#" class="text-xs text-indigo-600 hover:text-indigo-700 transition-colors">Forgot password?</a>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <x-ui.checkbox name="remember" label="Remember me for 30 days" :checked="old('remember')" />
            </div>

            <x-ui.button type="submit" class="w-full justify-center" size="lg">
                Sign in
            </x-ui.button>
        </form>

        <p class="mt-6 text-center text-sm text-zinc-500">
            Don't have an account?
            <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">Create one →</a>
        </p>
    </div>
</x-layouts.auth>

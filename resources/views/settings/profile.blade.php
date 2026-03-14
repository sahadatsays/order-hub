<x-layouts.app title="Settings — Profile">
<div class="max-w-5xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Settings</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account and organisation settings.</p>
    </div>

    <div class="flex gap-8">

        {{-- LEFT: Settings sidebar nav --}}
        @include('settings.partials.sidebar')

        {{-- RIGHT: Profile content --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- SECTION: Personal Information --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Personal Information</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Update your name, email, and personal details.</p>
                </div>

                {{-- Avatar row --}}
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-zinc-100">
                    <div class="w-16 h-16 rounded-full bg-indigo-600 flex items-center justify-center text-xl font-bold text-white shrink-0">
                        JD
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <button type="button" class="px-3 py-1.5 text-sm border border-zinc-300 rounded-md hover:bg-zinc-50 text-zinc-700 font-medium transition-colors">
                                Change photo
                            </button>
                            <button type="button" class="px-3 py-1.5 text-sm text-red-600 hover:text-red-700 font-medium transition-colors">
                                Remove
                            </button>
                        </div>
                        <p class="text-xs text-zinc-400 mt-1.5">JPG, GIF or PNG. Max size 2MB.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('settings.profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1" for="first_name">First name</label>
                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                value="John"
                                class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1" for="last_name">Last name</label>
                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                value="Doe"
                                class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="email">Email address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="john@acmecorp.com"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                        >
                        <p class="text-xs text-zinc-500 mt-1">Changing your email will require verification.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="job_title">Job title</label>
                        <input
                            type="text"
                            id="job_title"
                            name="job_title"
                            placeholder="e.g. Operations Manager"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="phone">Phone number</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="+1 (555) 000-0000"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                        >
                        <p class="text-xs text-zinc-500 mt-1">Used for account recovery and notifications.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="timezone">Timezone</label>
                        <select
                            id="timezone"
                            name="timezone"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full bg-white"
                        >
                            <option value="Asia/Dhaka" selected>Asia/Dhaka (UTC+6)</option>
                            <option value="America/New_York">America/New_York (UTC-5)</option>
                            <option value="America/Los_Angeles">America/Los_Angeles (UTC-8)</option>
                            <option value="Europe/London">Europe/London (UTC+0)</option>
                            <option value="Europe/Paris">Europe/Paris (UTC+1)</option>
                            <option value="Asia/Tokyo">Asia/Tokyo (UTC+9)</option>
                            <option value="Australia/Sydney">Australia/Sydney (UTC+11)</option>
                        </select>
                        <p class="text-xs text-zinc-500 mt-1">All dates and times will be shown in this timezone.</p>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>

            {{-- SECTION: Password --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6" id="password-section">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900">Password</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Last changed 3 months ago.</p>
                    </div>
                    <button
                        type="button"
                        id="show-password-form-btn"
                        class="px-3 py-1.5 text-sm border border-zinc-300 rounded-md hover:bg-zinc-50 text-zinc-700 font-medium transition-colors"
                    >
                        Change password
                    </button>
                </div>

                <form method="POST" action="{{ route('settings.profile.update') }}" class="mt-5 space-y-4 hidden" id="change-password-form">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="current_password">Current password</label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            autocomplete="current-password"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="new_password">New password</label>
                        <input
                            type="password"
                            id="new_password"
                            name="password"
                            autocomplete="new-password"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                        >
                        <div class="mt-2 h-1.5 bg-zinc-100 rounded-full overflow-hidden">
                            <div id="pw-strength-bar" class="h-1.5 rounded-full bg-zinc-300 transition-all duration-300" style="width: 0%"></div>
                        </div>
                        <p id="pw-strength-label" class="text-xs text-zinc-400 mt-1">Enter a password to see its strength.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1" for="password_confirmation">Confirm new password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            autocomplete="new-password"
                            class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                        >
                    </div>

                    <div class="flex justify-end gap-2">
                        <button
                            type="button"
                            id="cancel-password-form-btn"
                            class="px-3 py-1.5 text-sm text-zinc-600 hover:text-zinc-800 border border-zinc-200 rounded-md hover:bg-zinc-50 transition-colors"
                        >
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                            Update password
                        </button>
                    </div>
                </form>
            </div>

            {{-- SECTION: Two-Factor Authentication --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900">Two-Factor Authentication</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Add an extra layer of security to your account.</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-600 ring-1 ring-zinc-200">
                        Not enabled
                    </span>
                </div>

                <p class="text-sm text-zinc-600 mt-3 leading-relaxed">
                    Two-factor authentication adds an additional layer of security by requiring a verification code from your authenticator app each time you sign in.
                </p>

                <div class="mt-4 flex items-center gap-3">
                    <button type="button" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                        Enable 2FA
                    </button>
                    <span class="text-xs text-zinc-400">Works with Google Authenticator, Authy, and more.</span>
                </div>
            </div>

            {{-- SECTION: Active Sessions --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Active Sessions</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Manage where you're currently logged in.</p>
                </div>

                <div class="space-y-2">
                    {{-- Current session --}}
                    <div class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100 bg-zinc-50/50">
                        <div class="p-2 bg-white border border-zinc-200 rounded-lg shrink-0">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-zinc-800">Chrome on macOS</p>
                            <p class="text-xs text-zinc-400 mt-0.5">Dhaka, Bangladesh &middot; 127.0.0.1 &middot; Active now</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-200 shrink-0">
                            Current
                        </span>
                    </div>

                    {{-- Other session --}}
                    <div class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100">
                        <div class="p-2 bg-white border border-zinc-200 rounded-lg shrink-0">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 15.75h3" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-zinc-800">Safari on iPhone</p>
                            <p class="text-xs text-zinc-400 mt-0.5">Dhaka, Bangladesh &middot; Last active 2 days ago</p>
                        </div>
                        <button type="button" class="text-xs text-red-600 hover:text-red-700 font-medium shrink-0">
                            Revoke
                        </button>
                    </div>

                    {{-- Another session --}}
                    <div class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100">
                        <div class="p-2 bg-white border border-zinc-200 rounded-lg shrink-0">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-zinc-800">Firefox on Windows</p>
                            <p class="text-xs text-zinc-400 mt-0.5">London, UK &middot; Last active 5 days ago</p>
                        </div>
                        <button type="button" class="text-xs text-red-600 hover:text-red-700 font-medium shrink-0">
                            Revoke
                        </button>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-zinc-100">
                    <button type="button" class="px-3 py-1.5 text-sm text-red-600 hover:text-red-700 border border-red-200 rounded-md hover:bg-red-50 transition-colors font-medium">
                        Revoke all other sessions
                    </button>
                </div>
            </div>

            {{-- SECTION: Danger Zone --}}
            <div class="bg-white border border-red-200 rounded-xl p-6">
                <h2 class="text-sm font-semibold text-red-600 mb-4">Danger Zone</h2>

                <div class="flex items-start justify-between gap-6">
                    <div>
                        <p class="text-sm font-medium text-zinc-800">Delete account</p>
                        <p class="text-xs text-zinc-500 mt-0.5">Permanently delete your account and all associated data. This action cannot be undone.</p>
                    </div>
                    <button
                        type="button"
                        class="shrink-0 px-3 py-1.5 text-sm bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors"
                    >
                        Delete account
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Password form toggle
    document.getElementById('show-password-form-btn').addEventListener('click', function () {
        document.getElementById('change-password-form').classList.remove('hidden');
        this.classList.add('hidden');
    });

    document.getElementById('cancel-password-form-btn').addEventListener('click', function () {
        document.getElementById('change-password-form').classList.add('hidden');
        document.getElementById('show-password-form-btn').classList.remove('hidden');
    });

    // Password strength meter
    document.getElementById('new_password').addEventListener('input', function () {
        const value = this.value;
        const checks = [
            value.length >= 8,
            /[A-Z]/.test(value),
            /[0-9]/.test(value),
            /[^A-Za-z0-9]/.test(value),
        ];
        const score = checks.filter(Boolean).length;
        const bar = document.getElementById('pw-strength-bar');
        const label = document.getElementById('pw-strength-label');

        const widths = ['0%', '25%', '50%', '75%', '100%'];
        const colors = ['bg-zinc-300', 'bg-red-400', 'bg-yellow-400', 'bg-yellow-500', 'bg-green-500'];
        const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
        const labelColors = ['text-zinc-400', 'text-red-500', 'text-yellow-600', 'text-yellow-600', 'text-green-600'];

        bar.style.width = value.length === 0 ? '0%' : widths[score];
        bar.className = 'h-1.5 rounded-full transition-all duration-300 ' + (value.length === 0 ? 'bg-zinc-300' : colors[score]);
        label.textContent = value.length === 0 ? 'Enter a password to see its strength.' : labels[score] + ' password';
        label.className = 'text-xs mt-1 ' + (value.length === 0 ? 'text-zinc-400' : labelColors[score]);
    });
</script>
</x-layouts.app>

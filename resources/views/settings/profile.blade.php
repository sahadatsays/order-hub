<x-layouts.app title="Settings — Profile">
<div class="max-w-5xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Settings</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account and organisation settings.</p>
    </div>

    <div class="flex gap-8">

        {{-- LEFT: Settings sidebar nav --}}
        <aside class="w-56 shrink-0">
            <nav class="flex flex-col gap-0.5">
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider px-3 mb-1">Account</p>

                <a href="{{ route('settings.profile') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm bg-zinc-100 text-zinc-900 font-medium">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Profile
                </a>

                <a href="{{ route('settings.security') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Password &amp; Security
                </a>

                <a href="{{ route('settings.notifications') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    Notifications
                </a>

                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider px-3 mb-1 mt-4">Organization</p>

                <a href="{{ route('settings.general') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    General
                </a>

                <a href="{{ route('settings.branding') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                    </svg>
                    Branding
                </a>

                <a href="{{ route('settings.billing') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                    Billing
                </a>

                <a href="{{ route('settings.team') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Team Members
                </a>

                <a href="{{ route('settings.roles') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    Roles &amp; Permissions
                </a>

                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider px-3 mb-1 mt-4">Operations</p>

                <a href="{{ route('settings.orders') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    Order Settings
                </a>

                <a href="{{ route('settings.payment-methods') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Payment Methods
                </a>

                <a href="{{ route('settings.shipping') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    Shipping
                </a>

                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider px-3 mb-1 mt-4">Integrations</p>

                <a href="{{ route('settings.connected-apps') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Connected Apps
                </a>

                <a href="{{ route('settings.api-keys') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                    API Keys
                </a>

                <a href="{{ route('settings.webhooks') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                    </svg>
                    Webhooks
                </a>
            </nav>
        </aside>

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

                <form method="POST" action="{{ route('settings.password.update') }}" class="mt-5 space-y-4 hidden" id="change-password-form">
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

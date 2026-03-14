<x-layouts.app title="Settings — Team Members">
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

                <a href="{{ route('settings.profile') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800">
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

                <a href="{{ route('settings.team') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm bg-zinc-100 text-zinc-900 font-medium">
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

        {{-- RIGHT: Team Members content --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- SECTION: Team Members --}}
            <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                {{-- Card header --}}
                <div class="flex items-center justify-between px-6 py-5 border-b border-zinc-100">
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900">Team Members</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Manage who has access to your organisation.</p>
                    </div>
                    <button
                        type="button"
                        data-modal-open="invite-modal"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Invite member
                    </button>
                </div>

                {{-- Members table --}}
                <div class="divide-y divide-zinc-100">

                    {{-- John Doe — Owner --}}
                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-sm font-semibold text-white shrink-0">
                            JD
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-zinc-900 leading-tight">John Doe</p>
                            <p class="text-xs text-zinc-400 mt-0.5">john@acmecorp.com</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200">
                            Owner
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-200">
                            Active
                        </span>
                        <div class="relative" data-dropdown>
                            <button
                                type="button"
                                class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 transition-colors"
                                data-dropdown-toggle
                                aria-label="Member options"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                </svg>
                            </button>
                            <div class="hidden absolute right-0 mt-1 w-40 bg-white border border-zinc-200 rounded-lg shadow-lg z-10 py-1" data-dropdown-menu>
                                <button type="button" class="w-full text-left px-3 py-1.5 text-sm text-zinc-700 hover:bg-zinc-50">Change role</button>
                                <button type="button" class="w-full text-left px-3 py-1.5 text-sm text-red-600 hover:bg-red-50">Remove member</button>
                            </div>
                        </div>
                    </div>

                    {{-- Sarah Kim — Admin --}}
                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="w-9 h-9 rounded-full bg-pink-500 flex items-center justify-center text-sm font-semibold text-white shrink-0">
                            SK
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-zinc-900 leading-tight">Sarah Kim</p>
                            <p class="text-xs text-zinc-400 mt-0.5">sarah@acmecorp.com</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-blue-200">
                            Admin
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-200">
                            Active
                        </span>
                        <div class="relative" data-dropdown>
                            <button
                                type="button"
                                class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 transition-colors"
                                data-dropdown-toggle
                                aria-label="Member options"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                </svg>
                            </button>
                            <div class="hidden absolute right-0 mt-1 w-40 bg-white border border-zinc-200 rounded-lg shadow-lg z-10 py-1" data-dropdown-menu>
                                <button type="button" class="w-full text-left px-3 py-1.5 text-sm text-zinc-700 hover:bg-zinc-50">Change role</button>
                                <button type="button" class="w-full text-left px-3 py-1.5 text-sm text-red-600 hover:bg-red-50">Remove member</button>
                            </div>
                        </div>
                    </div>

                    {{-- Mike Chen — Member --}}
                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="w-9 h-9 rounded-full bg-teal-500 flex items-center justify-center text-sm font-semibold text-white shrink-0">
                            MC
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-zinc-900 leading-tight">Mike Chen</p>
                            <p class="text-xs text-zinc-400 mt-0.5">mike@acmecorp.com</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-700 ring-1 ring-zinc-200">
                            Member
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-200">
                            Active
                        </span>
                        <div class="relative" data-dropdown>
                            <button
                                type="button"
                                class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 transition-colors"
                                data-dropdown-toggle
                                aria-label="Member options"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                </svg>
                            </button>
                            <div class="hidden absolute right-0 mt-1 w-40 bg-white border border-zinc-200 rounded-lg shadow-lg z-10 py-1" data-dropdown-menu>
                                <button type="button" class="w-full text-left px-3 py-1.5 text-sm text-zinc-700 hover:bg-zinc-50">Change role</button>
                                <button type="button" class="w-full text-left px-3 py-1.5 text-sm text-red-600 hover:bg-red-50">Remove member</button>
                            </div>
                        </div>
                    </div>

                    {{-- Lisa Park — Invited --}}
                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="w-9 h-9 rounded-full bg-zinc-200 flex items-center justify-center text-sm font-semibold text-zinc-500 shrink-0">
                            LP
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-zinc-900 leading-tight">Lisa Park</p>
                            <p class="text-xs text-zinc-400 mt-0.5">lisa@acmecorp.com</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-700 ring-1 ring-zinc-200">
                            Member
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200">
                            Invited
                        </span>
                        <div class="relative" data-dropdown>
                            <button
                                type="button"
                                class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 transition-colors"
                                data-dropdown-toggle
                                aria-label="Member options"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                </svg>
                            </button>
                            <div class="hidden absolute right-0 mt-1 w-40 bg-white border border-zinc-200 rounded-lg shadow-lg z-10 py-1" data-dropdown-menu>
                                <button type="button" class="w-full text-left px-3 py-1.5 text-sm text-zinc-700 hover:bg-zinc-50">Resend invitation</button>
                                <button type="button" class="w-full text-left px-3 py-1.5 text-sm text-zinc-700 hover:bg-zinc-50">Change role</button>
                                <button type="button" class="w-full text-left px-3 py-1.5 text-sm text-red-600 hover:bg-red-50">Cancel invitation</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION: Pending Invitations --}}
            <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-zinc-100">
                    <h2 class="text-sm font-semibold text-zinc-900">Pending Invitations</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Invitations that have been sent but not yet accepted.</p>
                </div>

                <div class="divide-y divide-zinc-100">
                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="w-9 h-9 rounded-full bg-zinc-100 border border-zinc-200 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-zinc-900 leading-tight">lisa@acmecorp.com</p>
                            <p class="text-xs text-zinc-400 mt-0.5">Invited 2 days ago &middot; Member role</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" class="px-2.5 py-1 text-xs font-medium text-indigo-600 hover:text-indigo-700 border border-indigo-200 rounded-md hover:bg-indigo-50 transition-colors">
                                Resend
                            </button>
                            <button type="button" class="px-2.5 py-1 text-xs font-medium text-zinc-500 hover:text-red-600 border border-zinc-200 rounded-md hover:border-red-200 hover:bg-red-50 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION: Roles & Permissions summary --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900">Roles Overview</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Summary of what each role can do in your organisation.</p>
                    </div>
                    <a href="{{ route('settings.roles') }}" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">
                        Manage roles &rarr;
                    </a>
                </div>

                <div class="space-y-3">
                    <div class="flex items-start gap-3 p-3 rounded-lg bg-indigo-50 border border-indigo-100">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 ring-1 ring-indigo-200 shrink-0 mt-0.5">
                            Owner
                        </span>
                        <p class="text-xs text-zinc-600 leading-relaxed">Full access to all settings, billing, and can delete the organisation. Cannot be changed.</p>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-lg bg-zinc-50 border border-zinc-100">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-blue-200 shrink-0 mt-0.5">
                            Admin
                        </span>
                        <p class="text-xs text-zinc-600 leading-relaxed">Can manage team members, settings, integrations, and all orders. Cannot access billing.</p>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-lg bg-zinc-50 border border-zinc-100">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-700 ring-1 ring-zinc-200 shrink-0 mt-0.5">
                            Member
                        </span>
                        <p class="text-xs text-zinc-600 leading-relaxed">Can view and manage orders, customers, and products. Cannot access organisation settings.</p>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-lg bg-zinc-50 border border-zinc-100">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-500 ring-1 ring-zinc-200 shrink-0 mt-0.5">
                            Viewer
                        </span>
                        <p class="text-xs text-zinc-600 leading-relaxed">Read-only access to orders and reports. Cannot create, edit, or delete any records.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Invite Member Modal --}}
<div id="invite-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm" data-modal-close="invite-modal"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md">
            {{-- Modal header --}}
            <div class="flex items-center justify-between p-6 border-b border-zinc-100">
                <h3 class="text-base font-semibold text-zinc-900">Invite team member</h3>
                <button
                    type="button"
                    data-modal-close="invite-modal"
                    class="p-1.5 rounded-md text-zinc-400 hover:bg-zinc-100 hover:text-zinc-600 transition-colors"
                    aria-label="Close"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal body --}}
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1" for="invite-email">Email address</label>
                    <input
                        type="email"
                        id="invite-email"
                        name="email"
                        placeholder="colleague@company.com"
                        class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1" for="invite-role">Role</label>
                    <select
                        id="invite-role"
                        name="role"
                        class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full bg-white"
                    >
                        <option value="admin">Admin</option>
                        <option value="member" selected>Member</option>
                        <option value="viewer">Viewer</option>
                    </select>
                    <p class="text-xs text-zinc-500 mt-1">Admins can manage settings. Members can manage orders. Viewers have read-only access.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1" for="invite-message">Personal message <span class="text-zinc-400 font-normal">(optional)</span></label>
                    <textarea
                        id="invite-message"
                        name="message"
                        rows="2"
                        placeholder="Add a note to your invitation..."
                        class="border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full resize-none"
                    ></textarea>
                </div>
            </div>

            {{-- Modal footer --}}
            <div class="flex justify-end gap-2 px-6 pb-6">
                <button
                    type="button"
                    data-modal-close="invite-modal"
                    class="px-4 py-2 text-sm text-zinc-600 border border-zinc-300 rounded-md hover:bg-zinc-50 transition-colors font-medium"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors"
                >
                    Send invitation
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Modal open/close
    document.querySelectorAll('[data-modal-open]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            var modalId = this.getAttribute('data-modal-open');
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach(function (closer) {
        closer.addEventListener('click', function () {
            var modalId = this.getAttribute('data-modal-close');
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });

    // Dropdown menus
    document.querySelectorAll('[data-dropdown]').forEach(function (dropdown) {
        var toggle = dropdown.querySelector('[data-dropdown-toggle]');
        var menu = dropdown.querySelector('[data-dropdown-menu]');

        if (toggle && menu) {
            toggle.addEventListener('click', function (e) {
                e.stopPropagation();
                // Close all other dropdowns
                document.querySelectorAll('[data-dropdown-menu]').forEach(function (m) {
                    if (m !== menu) {
                        m.classList.add('hidden');
                    }
                });
                menu.classList.toggle('hidden');
            });
        }
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function () {
        document.querySelectorAll('[data-dropdown-menu]').forEach(function (menu) {
            menu.classList.add('hidden');
        });
    });
</script>
</x-layouts.app>

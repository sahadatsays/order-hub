<x-layouts.app title="Settings — Team Members">
<div class="max-w-5xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-zinc-900">Settings</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account and organisation settings.</p>
    </div>

    <div class="flex gap-8">

        {{-- LEFT: Settings sidebar nav --}}
        @include('settings.partials.sidebar')

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
                    <a href="#" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">
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

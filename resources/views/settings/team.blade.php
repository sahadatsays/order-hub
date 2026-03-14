<x-layouts.app title="Settings — Team Members">
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

            {{-- Team Members List --}}
            <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-zinc-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900">Team Members</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Manage who has access to your organization.</p>
                    </div>
                </div>

                @forelse($members as $member)
                    <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-50 last:border-0">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-semibold shrink-0">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-zinc-900 truncate">{{ $member->name }}</p>
                                <p class="text-xs text-zinc-500 truncate">{{ $member->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            {{-- Role badge --}}
                            @php
                                $roleBadge = match($member->pivot->role ?? $member->role ?? 'staff') {
                                    'owner' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
                                    'admin' => 'bg-purple-50 text-purple-700 ring-purple-200',
                                    'manager' => 'bg-blue-50 text-blue-700 ring-blue-200',
                                    default => 'bg-zinc-50 text-zinc-600 ring-zinc-200',
                                };
                                $roleLabel = ucfirst($member->pivot->role ?? $member->role ?? 'staff');
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ring-1 {{ $roleBadge }}">
                                {{ $roleLabel }}
                            </span>

                            {{-- Status --}}
                            @if($member->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-200">Active</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-50 text-zinc-500 ring-1 ring-zinc-200">Inactive</span>
                            @endif

                            {{-- Joined date --}}
                            <span class="text-xs text-zinc-400 hidden sm:inline">{{ $member->created_at->format('M d, Y') }}</span>

                            {{-- Remove button (not for owners) --}}
                            @if(($member->pivot->role ?? $member->role ?? '') !== 'owner')
                                <form method="POST" action="{{ route('settings.team.remove', $member) }}" onsubmit="return confirm('Are you sure you want to remove this member?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Remove</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-sm text-zinc-500">No team members yet.</div>
                @endforelse
            </div>

            {{-- Invite New Member --}}
            <div class="bg-white border border-zinc-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-zinc-900">Invite Team Member</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Send an invitation to join your organization.</p>
                </div>

                <form method="POST" action="{{ route('settings.team.invite') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ui.input label="Name" name="name" :value="old('name')" required :error="$errors->first('name')" />
                        <x-ui.input label="Email Address" name="email" type="email" :value="old('email')" required :error="$errors->first('email')" />
                    </div>

                    <div>
                        <label for="role" class="text-sm font-medium text-zinc-700">Role <span class="text-red-500 ml-0.5">*</span></label>
                        <select id="role" name="role" required class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select a role…</option>
                            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                            <option value="manager" @selected(old('role') === 'manager')>Manager</option>
                            <option value="staff" @selected(old('role') === 'staff')>Staff</option>
                        </select>
                        @error('role')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                            Send Invitation
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</x-layouts.app>

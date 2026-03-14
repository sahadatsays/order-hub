<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $members = User::where('tenant_id', $this->tenantId())
            ->orderByRaw("CASE role WHEN 'owner' THEN 0 WHEN 'admin' THEN 1 WHEN 'manager' THEN 2 WHEN 'staff' THEN 3 ELSE 4 END")
            ->get();

        return view('settings.team', compact('members'));
    }

    public function invite(Request $request): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'string', 'in:admin,manager,staff'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        User::create([
            'tenant_id' => $this->tenantId(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt(str()->random(16)),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return back()->with('success', 'Team member added successfully.');
    }

    public function remove(int $userId): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $user = User::where('tenant_id', $this->tenantId())->findOrFail($userId);

        if ($user->isOwner()) {
            return back()->with('error', 'Cannot remove the account owner.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot remove yourself.');
        }

        $user->update(['is_active' => false]);

        return back()->with('success', 'Team member deactivated successfully.');
    }
}

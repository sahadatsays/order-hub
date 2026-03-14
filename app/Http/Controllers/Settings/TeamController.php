<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        return view('settings.team');
    }

    public function invite(Request $request): RedirectResponse
    {
        //
        return back()->with('success', 'Invitation sent.');
    }

    public function remove(int $user): RedirectResponse
    {
        //
        return back()->with('success', 'Member removed.');
    }
}

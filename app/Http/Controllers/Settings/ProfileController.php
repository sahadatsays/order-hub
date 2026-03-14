<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('settings.profile');
    }

    public function update(Request $request): RedirectResponse
    {
        //
        return back()->with('success', 'Profile updated.');
    }
}

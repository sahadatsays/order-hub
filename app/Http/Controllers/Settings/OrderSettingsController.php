<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderSettingsController extends Controller
{
    public function index(): View
    {
        return view('settings.order-settings');
    }

    public function update(Request $request): RedirectResponse
    {
        //
        return back()->with('success', 'Settings saved.');
    }
}

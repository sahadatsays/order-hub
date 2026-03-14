<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('orders.index');
    }

    public function create(): View
    {
        return view('orders.create');
    }

    public function store(Request $request): RedirectResponse
    {
        //
        return redirect()->route('orders.index');
    }

    public function show(string $id): View
    {
        return view('orders.show');
    }

    public function edit(string $id): View
    {
        //
        return view('orders.edit');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        //
        return redirect()->route('orders.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        //
        return redirect()->route('orders.index');
    }
}

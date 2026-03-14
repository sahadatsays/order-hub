<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourierController extends Controller
{
    public function index(): View
    {
        $couriers = Courier::orderBy('is_default', 'desc')->orderBy('name')->get();

        return view('settings.couriers', compact('couriers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'code'         => 'nullable|string|max:50',
            'tracking_url' => 'nullable|url|max:500',
            'base_rate'    => 'nullable|numeric|min:0',
            'is_active'    => 'boolean',
            'is_default'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default']) {
            Courier::where('is_default', true)->update(['is_default' => false]);
        }

        Courier::create(array_merge($validated, [
            'tenant_id' => auth()->user()->tenant_id,
        ]));

        return redirect()->route('settings.couriers')
            ->with('success', 'Courier added successfully.');
    }

    public function update(Request $request, Courier $courier)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'code'         => 'nullable|string|max:50',
            'tracking_url' => 'nullable|url|max:500',
            'base_rate'    => 'nullable|numeric|min:0',
            'is_active'    => 'boolean',
            'is_default'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default']) {
            Courier::where('id', '!=', $courier->id)->where('is_default', true)->update(['is_default' => false]);
        }

        $courier->update($validated);

        return redirect()->route('settings.couriers')
            ->with('success', 'Courier updated.');
    }

    public function destroy(Courier $courier)
    {
        $courier->delete();

        return redirect()->route('settings.couriers')
            ->with('success', 'Courier removed.');
    }
}

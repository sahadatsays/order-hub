<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IntegrationController extends Controller
{
    public function index(): View
    {
        $integrations = Integration::get()->keyBy('type');

        $availableTypes = Integration::TYPES;

        return view('integrations.index', compact('integrations', 'availableTypes'));
    }

    public function connect(Request $request, string $type)
    {
        abort_unless(array_key_exists($type, Integration::TYPES), 404);

        $validated = $request->validate([
            'name'        => 'nullable|string|max:255',
            'credentials' => 'nullable|array',
            'settings'    => 'nullable|array',
        ]);

        $integration = Integration::updateOrCreate(
            ['type' => $type, 'tenant_id' => auth()->user()->tenant_id],
            array_merge($validated, [
                'name'      => $validated['name'] ?? Integration::TYPES[$type],
                'is_active' => true,
            ])
        );

        return redirect()->route('integrations.index')
            ->with('success', Integration::TYPES[$type] . ' connected successfully.');
    }

    public function disconnect(Integration $integration)
    {
        $integration->update(['is_active' => false]);

        return redirect()->route('integrations.index')
            ->with('success', $integration->type_label . ' disconnected.');
    }
}

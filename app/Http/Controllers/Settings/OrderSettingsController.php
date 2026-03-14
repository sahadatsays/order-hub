<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderSettingsController extends Controller
{
    public function __construct(protected SettingsService $settings) {}

    public function index(): View
    {
        $orderSettings = $this->settings->getGroup('orders', $this->tenantId());

        // Provide defaults for all expected keys
        $defaults = [
            'order_prefix' => 'ORD',
            'order_sequence_start' => '1',
            'order_number_padding' => '5',
            'default_order_status' => 'pending',
            'auto_confirm_manual' => false,
            'auto_confirm_after_payment' => false,
            'allow_draft_orders' => true,
            'duplicate_order_warning' => true,
            'duplicate_detection_window' => '24',
            'default_order_source' => 'manual',
            'auto_assign_orders' => false,
            'invoice_default_note' => '',
            'packing_slip_note' => '',
            'notify_new_order' => true,
            'notify_status_change' => true,
            'notify_assignment' => true,
            'notify_cancellation' => true,
            'notify_payment' => true,
            'notify_delivery' => true,
        ];

        $orderSettings = array_merge($defaults, $orderSettings);

        return view('settings.order-settings', compact('orderSettings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_prefix' => ['required', 'string', 'max:10'],
            'order_sequence_start' => ['required', 'integer', 'min:1'],
            'order_number_padding' => ['required', 'integer', 'min:1', 'max:10'],
            'default_order_status' => ['required', 'string'],
            'auto_confirm_manual' => ['nullable'],
            'auto_confirm_after_payment' => ['nullable'],
            'allow_draft_orders' => ['nullable'],
            'duplicate_order_warning' => ['nullable'],
            'duplicate_detection_window' => ['nullable', 'integer', 'min:1'],
            'default_order_source' => ['nullable', 'string'],
            'auto_assign_orders' => ['nullable'],
            'invoice_default_note' => ['nullable', 'string', 'max:500'],
            'packing_slip_note' => ['nullable', 'string', 'max:500'],
            'notify_new_order' => ['nullable'],
            'notify_status_change' => ['nullable'],
            'notify_assignment' => ['nullable'],
            'notify_cancellation' => ['nullable'],
            'notify_payment' => ['nullable'],
            'notify_delivery' => ['nullable'],
        ]);

        // Convert checkboxes to booleans
        $booleanFields = [
            'auto_confirm_manual', 'auto_confirm_after_payment', 'allow_draft_orders',
            'duplicate_order_warning', 'auto_assign_orders',
            'notify_new_order', 'notify_status_change', 'notify_assignment',
            'notify_cancellation', 'notify_payment', 'notify_delivery',
        ];

        $valueTypes = [];
        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field);
            $valueTypes[$field] = 'boolean';
        }

        $this->settings->updateGroup('orders', $validated, $valueTypes, $this->tenantId());

        return back()->with('success', 'Order settings saved successfully.');
    }
}

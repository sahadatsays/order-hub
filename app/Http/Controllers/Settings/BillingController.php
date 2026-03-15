<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function index(): View
    {
        $tenant = Tenant::with(['plan', 'subscriptions' => function ($q) {
            $q->latest()->limit(1);
        }])->find($this->tenantId());

        $plan = $tenant->plan;
        $subscription = $tenant->activeSubscription();

        return view('settings.billing', compact('tenant', 'plan', 'subscription'));
    }
}

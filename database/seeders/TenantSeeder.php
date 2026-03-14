<?php

namespace Database\Seeders;

use App\Models\Courier;
use App\Models\Integration;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $plan = Plan::where('slug', 'growth')->first();

        $tenant = Tenant::updateOrCreate(
            ['slug' => 'acme-corp'],
            [
                'name'     => 'Acme Corp',
                'email'    => 'admin@acmecorp.com',
                'phone'    => '+8801712345678',
                'currency' => 'BDT',
                'timezone' => 'Asia/Dhaka',
                'city'     => 'Dhaka',
                'country'  => 'BD',
                'plan_id'  => $plan?->id,
                'status'   => 'active',
            ]
        );

        // Owner
        $owner = User::updateOrCreate(
            ['email' => 'admin@acmecorp.com'],
            [
                'tenant_id' => $tenant->id,
                'name'      => 'Admin User',
                'password'  => Hash::make('password'),
                'role'      => 'owner',
                'is_active' => true,
            ]
        );

        // Create subscription
        if ($plan) {
            Subscription::updateOrCreate(
                ['tenant_id' => $tenant->id],
                [
                    'plan_id'       => $plan->id,
                    'billing_cycle' => 'monthly',
                    'status'        => 'active',
                    'starts_at'     => now(),
                    'ends_at'       => now()->addMonth(),
                ]
            );
        }

        // Default couriers
        $couriers = [
            ['name' => 'Pathao', 'code' => 'pathao', 'base_rate' => 60, 'is_default' => true],
            ['name' => 'Steadfast', 'code' => 'steadfast', 'base_rate' => 70],
            ['name' => 'RedX', 'code' => 'redx', 'base_rate' => 65],
        ];

        foreach ($couriers as $courier) {
            Courier::updateOrCreate(
                ['tenant_id' => $tenant->id, 'code' => $courier['code']],
                array_merge($courier, ['tenant_id' => $tenant->id, 'is_active' => true])
            );
        }
    }
}

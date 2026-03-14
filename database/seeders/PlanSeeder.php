<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name'             => 'Starter',
                'slug'             => 'starter',
                'description'      => 'Perfect for small businesses just getting started.',
                'monthly_price'    => 9.99,
                'yearly_price'     => 99.99,
                'max_orders'       => 500,
                'max_users'        => 3,
                'max_products'     => 100,
                'max_integrations' => 2,
                'features'         => ['Orders', 'Customers', 'Basic Reports', '2 Integrations'],
                'sort_order'       => 1,
            ],
            [
                'name'             => 'Growth',
                'slug'             => 'growth',
                'description'      => 'For growing businesses managing high order volume.',
                'monthly_price'    => 29.99,
                'yearly_price'     => 299.99,
                'max_orders'       => 5000,
                'max_users'        => 10,
                'max_products'     => 1000,
                'max_integrations' => 6,
                'features'         => ['Everything in Starter', 'Inventory', 'Invoices', 'All Integrations', 'Couriers'],
                'sort_order'       => 2,
            ],
            [
                'name'             => 'Pro',
                'slug'             => 'pro',
                'description'      => 'Unlimited power for enterprise operations.',
                'monthly_price'    => 79.99,
                'yearly_price'     => 799.99,
                'max_orders'       => null,
                'max_users'        => null,
                'max_products'     => null,
                'max_integrations' => null,
                'features'         => ['Everything in Growth', 'Unlimited Orders', 'Unlimited Users', 'Priority Support', 'Custom Reports'],
                'sort_order'       => 3,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}

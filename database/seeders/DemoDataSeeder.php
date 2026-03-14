<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::where('slug', 'acme-corp')->first();
        if (! $tenant) {
            return;
        }

        // Products
        $products = [
            ['name' => 'Classic T-Shirt', 'sku' => 'TSH-001', 'category' => 'Clothing', 'price' => 450, 'cost_price' => 200],
            ['name' => 'Slim Fit Jeans', 'sku' => 'JNS-001', 'category' => 'Clothing', 'price' => 1200, 'cost_price' => 600],
            ['name' => 'Running Shoes', 'sku' => 'SHO-001', 'category' => 'Footwear', 'price' => 2500, 'cost_price' => 1200],
            ['name' => 'Leather Wallet', 'sku' => 'ACC-001', 'category' => 'Accessories', 'price' => 800, 'cost_price' => 350],
            ['name' => 'Wireless Earbuds', 'sku' => 'ELEC-001', 'category' => 'Electronics', 'price' => 3500, 'cost_price' => 1800],
            ['name' => 'Gym Bag', 'sku' => 'BAG-001', 'category' => 'Accessories', 'price' => 1500, 'cost_price' => 700],
        ];

        $createdProducts = [];
        foreach ($products as $productData) {
            $product = Product::updateOrCreate(
                ['tenant_id' => $tenant->id, 'sku' => $productData['sku']],
                array_merge($productData, ['tenant_id' => $tenant->id, 'is_active' => true])
            );
            $createdProducts[] = $product;

            // Inventory
            $product->inventoryItem()->updateOrCreate(
                ['tenant_id' => $tenant->id],
                [
                    'tenant_id'        => $tenant->id,
                    'quantity_on_hand'  => rand(20, 150),
                    'quantity_reserved' => rand(0, 10),
                    'reorder_point'    => 10,
                    'reorder_quantity'  => 50,
                ]
            );
        }

        // Customers
        $customerData = [
            ['name' => 'Rahim Uddin', 'phone' => '01712345678', 'city' => 'Dhaka', 'source' => 'facebook'],
            ['name' => 'Karim Khan', 'phone' => '01812345678', 'city' => 'Chittagong', 'source' => 'whatsapp'],
            ['name' => 'Fatema Begum', 'phone' => '01912345678', 'city' => 'Sylhet', 'source' => 'website'],
            ['name' => 'Jamal Hossain', 'phone' => '01612345678', 'city' => 'Dhaka', 'source' => 'facebook'],
            ['name' => 'Nadia Islam', 'phone' => '01512345678', 'city' => 'Rajshahi', 'source' => 'woocommerce'],
            ['name' => 'Arif Rahman', 'phone' => '01312345678', 'city' => 'Dhaka', 'source' => 'shopify'],
        ];

        $customers = [];
        foreach ($customerData as $data) {
            $customer = Customer::updateOrCreate(
                ['tenant_id' => $tenant->id, 'phone' => $data['phone']],
                array_merge($data, ['tenant_id' => $tenant->id, 'country' => 'BD'])
            );
            $customers[] = $customer;
        }

        // Demo orders
        $sources = ['facebook', 'website', 'whatsapp', 'woocommerce', 'shopify', 'pos', 'manual'];
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

        for ($i = 1; $i <= 30; $i++) {
            $customer = $customers[array_rand($customers)];
            $status = $statuses[array_rand($statuses)];
            $source = $sources[array_rand($sources)];

            $order = Order::create([
                'tenant_id'      => $tenant->id,
                'customer_id'    => $customer->id,
                'source'         => $source,
                'customer_name'  => $customer->name,
                'customer_phone' => $customer->phone,
                'shipping_city'  => $customer->city,
                'shipping_country' => 'BD',
                'status'         => $status,
                'payment_status' => in_array($status, ['delivered', 'shipped']) ? 'paid' : 'unpaid',
                'payment_method' => 'bKash',
                'currency'       => 'BDT',
                'shipping_charge' => 60,
                'ordered_at'     => now()->subDays(rand(0, 60)),
            ]);

            $selectedProducts = array_slice($createdProducts, 0, rand(1, 3));
            $subtotal = 0;
            foreach ($selectedProducts as $product) {
                $qty = rand(1, 3);
                $lineTotal = $qty * $product->price;
                $subtotal += $lineTotal;

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'product_sku'  => $product->sku,
                    'quantity'     => $qty,
                    'unit_price'   => $product->price,
                    'line_total'   => $lineTotal,
                ]);
            }

            $total = $subtotal + $order->shipping_charge;
            $order->update([
                'subtotal'     => $subtotal,
                'total_amount' => $total,
                'paid_amount'  => $order->payment_status === 'paid' ? $total : 0,
            ]);

            // Invoice for each order
            Invoice::create([
                'tenant_id'     => $tenant->id,
                'order_id'      => $order->id,
                'subtotal'      => $subtotal,
                'total_amount'  => $total,
                'paid_amount'   => $order->payment_status === 'paid' ? $total : 0,
                'status'        => $order->payment_status === 'paid' ? 'paid' : 'draft',
                'issued_at'     => $order->ordered_at,
                'due_at'        => $order->ordered_at->addDays(7),
            ]);
        }
    }
}

<?php

namespace App\Services;

use App\DTOs\OrderData;
use App\Models\AuditLog;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use Illuminate\Support\Facades\DB;

class OrderCreateService
{
    /**
     * Create an internal order from validated data.
     * Supports manual orders and imported orders.
     */
    public function create(OrderData $data): Order
    {
        return DB::transaction(function () use ($data) {
            $customerId = $data->customer_id ?? $this->resolveCustomerId($data);

            $order = Order::create([
                'tenant_id'          => $data->tenant_id,
                'customer_id'        => $customerId,
                'created_by'         => $data->created_by,
                'source'             => $data->source,
                'source_order_id'    => $data->source_order_id,
                'source_raw_payload' => $data->source_raw_payload,
                'customer_name'      => $data->customer_name,
                'customer_phone'     => $data->customer_phone,
                'customer_email'     => $data->customer_email,
                'shipping_address'   => $data->shipping_address,
                'shipping_city'      => $data->shipping_city,
                'payment_method'     => $data->payment_method,
                'payment_status'     => $data->payment_status,
                'discount_amount'    => $data->discount_amount,
                'discount_code'      => $data->discount_code,
                'shipping_charge'    => $data->shipping_charge,
                'tax_amount'         => $data->tax_amount,
                'paid_amount'        => $data->paid_amount,
                'notes'              => $data->notes,
                'internal_notes'     => $data->internal_notes,
                'status'             => 'pending',
                'ordered_at'         => now(),
            ]);

            $subtotal = 0;

            foreach ($data->items as $item) {
                $lineTotal = $item->lineTotal();
                $subtotal += $lineTotal;

                OrderItem::create([
                    'order_id'        => $order->id,
                    'product_id'      => $item->product_id,
                    'product_name'    => $item->product_name,
                    'product_sku'     => $item->product_sku,
                    'variant'         => $item->variant,
                    'quantity'        => $item->quantity,
                    'unit_price'      => $item->unit_price,
                    'discount_amount' => $item->discount_amount,
                    'line_total'      => $lineTotal,
                ]);
            }

            $order->update([
                'subtotal'     => $subtotal,
                'total_amount' => $subtotal - $data->discount_amount + $data->shipping_charge + $data->tax_amount,
            ]);

            OrderStatusLog::log(
                orderId: $order->id,
                changedBy: $data->created_by,
                fromStatus: null,
                toStatus: 'pending',
                note: 'Order created via ' . $data->source,
            );

            AuditLog::record(
                tenantId: $data->tenant_id,
                userId: $data->created_by,
                auditableType: Order::class,
                auditableId: $order->id,
                event: 'created',
                newValue: 'pending',
            );

            return $order->load(['items', 'customer', 'statusLogs']);
        });
    }

    /**
     * Find or create a customer from order data.
     */
    private function resolveCustomerId(OrderData $data): ?int
    {
        if (! $data->customer_phone && ! $data->customer_email) {
            return null;
        }

        $customer = Customer::where('tenant_id', $data->tenant_id)
            ->where(function ($q) use ($data) {
                if ($data->customer_phone) {
                    $q->where('phone', $data->customer_phone);
                }
                if ($data->customer_email) {
                    $q->orWhere('email', $data->customer_email);
                }
            })
            ->first();

        if ($customer) {
            return $customer->id;
        }

        $customer = Customer::create([
            'tenant_id' => $data->tenant_id,
            'name'      => $data->customer_name,
            'phone'     => $data->customer_phone,
            'email'     => $data->customer_email,
            'address'   => $data->shipping_address,
            'city'      => $data->shipping_city,
            'source'    => $data->source,
        ]);

        return $customer->id;
    }
}

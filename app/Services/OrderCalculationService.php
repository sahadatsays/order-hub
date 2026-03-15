<?php

namespace App\Services;

use App\Models\Order;

class OrderCalculationService
{
    /**
     * Calculate subtotal from order items.
     */
    public function calculateSubtotal(array $items): float
    {
        $subtotal = 0;
        foreach ($items as $item) {
            $qty   = (int) ($item['quantity'] ?? 0);
            $price = (float) ($item['unit_price'] ?? 0);
            $disc  = (float) ($item['discount_amount'] ?? 0);
            $subtotal += ($qty * $price) - $disc;
        }
        return round($subtotal, 2);
    }

    /**
     * Calculate total from components.
     */
    public function calculateTotal(float $subtotal, float $discount = 0, float $shipping = 0, float $tax = 0): float
    {
        return round(max(0, $subtotal - $discount + $shipping + $tax), 2);
    }

    /**
     * Derive payment_status from paid vs total.
     */
    public function derivePaymentStatus(float $paidAmount, float $totalAmount): string
    {
        if ($totalAmount <= 0) {
            return 'paid';
        }
        if ($paidAmount <= 0) {
            return 'unpaid';
        }
        if ($paidAmount >= $totalAmount) {
            return 'paid';
        }
        return 'partial';
    }

    /**
     * Calculate the due amount for an order.
     */
    public function dueAmount(float $totalAmount, float $paidAmount): float
    {
        return round(max(0, $totalAmount - $paidAmount), 2);
    }

    /**
     * Recalculate and persist an order's totals from its items.
     */
    public function recalculateOrder(Order $order): Order
    {
        $order->load('items');

        $subtotal = (float) $order->items->sum('line_total');

        $total = $this->calculateTotal(
            $subtotal,
            (float) $order->discount_amount,
            (float) $order->shipping_charge,
            (float) $order->tax_amount
        );

        $paymentStatus = $this->derivePaymentStatus(
            (float) $order->paid_amount,
            $total
        );

        $order->update([
            'subtotal'       => $subtotal,
            'total_amount'   => $total,
            'payment_status' => $paymentStatus,
        ]);

        return $order;
    }
}

<?php

namespace App\DTOs;

class WooCommerceOrderData
{
    public function __construct(
        public readonly string $source_order_id,
        public readonly CustomerData $customer,
        public readonly array $items,
        public readonly string $status,
        public readonly string $payment_status,
        public readonly ?string $payment_method,
        public readonly float $subtotal,
        public readonly float $discount_amount,
        public readonly float $shipping_charge,
        public readonly float $tax_amount,
        public readonly float $total_amount,
        public readonly string $currency,
        public readonly array $raw_payload,
    ) {}
}

<?php

namespace App\DTOs;

class OrderData
{
    /**
     * @param  OrderItemData[]  $items
     */
    public function __construct(
        public readonly int $tenant_id,
        public readonly int $created_by,
        public readonly string $source,
        public readonly string $customer_name,
        public readonly array $items,
        public readonly string $payment_status = 'unpaid',
        public readonly ?int $customer_id = null,
        public readonly ?string $customer_phone = null,
        public readonly ?string $customer_email = null,
        public readonly ?string $shipping_address = null,
        public readonly ?string $shipping_city = null,
        public readonly ?string $payment_method = null,
        public readonly float $discount_amount = 0,
        public readonly ?string $discount_code = null,
        public readonly float $shipping_charge = 0,
        public readonly float $tax_amount = 0,
        public readonly float $paid_amount = 0,
        public readonly ?string $notes = null,
        public readonly ?string $internal_notes = null,
        public readonly ?string $source_order_id = null,
        public readonly ?array $source_raw_payload = null,
    ) {}

    public static function fromRequest(array $validated, int $tenantId, int $userId): self
    {
        $items = array_map(
            fn (array $item) => OrderItemData::fromArray($item),
            $validated['items']
        );

        return new self(
            tenant_id: $tenantId,
            created_by: $userId,
            source: $validated['source'],
            customer_name: $validated['customer_name'],
            items: $items,
            payment_status: $validated['payment_status'] ?? 'unpaid',
            customer_id: $validated['customer_id'] ?? null,
            customer_phone: $validated['customer_phone'] ?? null,
            customer_email: $validated['customer_email'] ?? null,
            shipping_address: $validated['shipping_address'] ?? null,
            shipping_city: $validated['shipping_city'] ?? null,
            payment_method: $validated['payment_method'] ?? null,
            discount_amount: (float) ($validated['discount_amount'] ?? 0),
            discount_code: $validated['discount_code'] ?? null,
            shipping_charge: (float) ($validated['shipping_charge'] ?? 0),
            tax_amount: (float) ($validated['tax_amount'] ?? 0),
            paid_amount: (float) ($validated['paid_amount'] ?? 0),
            notes: $validated['notes'] ?? null,
            internal_notes: $validated['internal_notes'] ?? null,
            source_order_id: $validated['source_order_id'] ?? null,
            source_raw_payload: $validated['source_raw_payload'] ?? null,
        );
    }
}

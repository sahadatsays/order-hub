<?php

namespace App\DTOs;

class OrderItemData
{
    public function __construct(
        public readonly string $product_name,
        public readonly int $quantity,
        public readonly float $unit_price,
        public readonly ?int $product_id = null,
        public readonly ?string $product_sku = null,
        public readonly ?string $variant = null,
        public readonly float $discount_amount = 0,
    ) {}

    public function lineTotal(): float
    {
        return ($this->quantity * $this->unit_price) - $this->discount_amount;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            product_name: $data['product_name'],
            quantity: (int) $data['quantity'],
            unit_price: (float) $data['unit_price'],
            product_id: $data['product_id'] ?? null,
            product_sku: $data['product_sku'] ?? null,
            variant: $data['variant'] ?? null,
            discount_amount: (float) ($data['discount_amount'] ?? 0),
        );
    }
}

<?php

namespace App\Services;

use App\DTOs\CustomerData;
use App\DTOs\OrderItemData;
use App\DTOs\WooCommerceOrderData;

class WooCommerceOrderMapper
{
    /**
     * WooCommerce status → internal status mapping.
     */
    public const STATUS_MAP = [
        'pending'    => 'pending',
        'processing' => 'confirmed',
        'on-hold'    => 'on_hold',
        'completed'  => 'delivered',
        'cancelled'  => 'cancelled',
        'refunded'   => 'refunded',
        'failed'     => 'cancelled',
    ];

    /**
     * WooCommerce status → internal payment status mapping.
     */
    public const PAYMENT_STATUS_MAP = [
        'pending'    => 'unpaid',
        'processing' => 'paid',
        'on-hold'    => 'unpaid',
        'completed'  => 'paid',
        'cancelled'  => 'unpaid',
        'refunded'   => 'refunded',
        'failed'     => 'unpaid',
    ];

    /**
     * Map a raw WooCommerce order payload to internal DTO.
     */
    public function map(array $payload): WooCommerceOrderData
    {
        return new WooCommerceOrderData(
            source_order_id: (string) $payload['id'],
            customer: $this->mapCustomer($payload),
            items: $this->mapItems($payload['line_items'] ?? []),
            status: $this->mapStatus($payload['status'] ?? 'pending'),
            payment_status: $this->mapPaymentStatus($payload['status'] ?? 'pending'),
            payment_method: $payload['payment_method_title'] ?? $payload['payment_method'] ?? null,
            subtotal: (float) ($payload['total'] ?? 0) - (float) ($payload['shipping_total'] ?? 0) - (float) ($payload['total_tax'] ?? 0) + (float) ($payload['discount_total'] ?? 0),
            discount_amount: (float) ($payload['discount_total'] ?? 0),
            shipping_charge: (float) ($payload['shipping_total'] ?? 0),
            tax_amount: (float) ($payload['total_tax'] ?? 0),
            total_amount: (float) ($payload['total'] ?? 0),
            currency: $payload['currency'] ?? 'BDT',
            raw_payload: $payload,
        );
    }

    public function mapCustomer(array $payload): CustomerData
    {
        $billing = $payload['billing'] ?? [];

        $name = trim(($billing['first_name'] ?? '') . ' ' . ($billing['last_name'] ?? ''));

        return new CustomerData(
            name: $name ?: 'WooCommerce Customer',
            phone: $billing['phone'] ?? null,
            email: $billing['email'] ?? null,
            address: $billing['address_1'] ?? null,
            city: $billing['city'] ?? null,
            source: 'woocommerce',
        );
    }

    /**
     * @return OrderItemData[]
     */
    public function mapItems(array $lineItems): array
    {
        return array_map(fn (array $item) => new OrderItemData(
            product_name: $item['name'] ?? 'Unknown Product',
            quantity: (int) ($item['quantity'] ?? 1),
            unit_price: (float) ($item['price'] ?? 0),
            product_id: null,
            product_sku: $item['sku'] ?? null,
            variant: null,
            discount_amount: 0,
        ), $lineItems);
    }

    public function mapStatus(string $wcStatus): string
    {
        return self::STATUS_MAP[$wcStatus] ?? 'pending';
    }

    public function mapPaymentStatus(string $wcStatus): string
    {
        return self::PAYMENT_STATUS_MAP[$wcStatus] ?? 'unpaid';
    }
}

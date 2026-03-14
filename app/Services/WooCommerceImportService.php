<?php

namespace App\Services;

use App\DTOs\OrderData;
use App\DTOs\WooCommerceOrderData;
use App\Models\Order;

class WooCommerceImportService
{
    public function __construct(
        private WooCommerceOrderMapper $mapper,
        private OrderCreateService $orderCreateService,
    ) {}

    /**
     * Import a WooCommerce order into the internal system.
     * Returns null if the order is a duplicate.
     */
    public function import(array $rawPayload, int $tenantId, int $userId): ?Order
    {
        $mapped = $this->mapper->map($rawPayload);

        if ($this->isDuplicate($tenantId, $mapped->source_order_id)) {
            return null;
        }

        $orderData = $this->toOrderData($mapped, $tenantId, $userId);

        return $this->orderCreateService->create($orderData);
    }

    /**
     * Check if this WooCommerce order was already imported.
     */
    public function isDuplicate(int $tenantId, string $sourceOrderId): bool
    {
        return Order::where('tenant_id', $tenantId)
            ->where('source', 'woocommerce')
            ->where('source_order_id', $sourceOrderId)
            ->exists();
    }

    /**
     * Convert WooCommerce mapped data to internal OrderData DTO.
     */
    private function toOrderData(WooCommerceOrderData $wc, int $tenantId, int $userId): OrderData
    {
        return new OrderData(
            tenant_id: $tenantId,
            created_by: $userId,
            source: 'woocommerce',
            customer_name: $wc->customer->name,
            items: $wc->items,
            payment_status: $wc->payment_status,
            customer_phone: $wc->customer->phone,
            customer_email: $wc->customer->email,
            shipping_address: $wc->customer->address,
            shipping_city: $wc->customer->city,
            payment_method: $wc->payment_method,
            discount_amount: $wc->discount_amount,
            shipping_charge: $wc->shipping_charge,
            tax_amount: $wc->tax_amount,
            source_order_id: $wc->source_order_id,
            source_raw_payload: $wc->raw_payload,
        );
    }
}

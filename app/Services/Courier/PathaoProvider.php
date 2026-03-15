<?php

namespace App\Services\Courier;

use App\Contracts\CourierProviderInterface;

class PathaoProvider implements CourierProviderInterface
{
    public const STATUS_MAP = [
        'Pending'            => 'pending',
        'Assigned for Pickup' => 'pending',
        'Picked'             => 'picked_up',
        'In Transit'         => 'in_transit',
        'At Sorting Hub'     => 'in_transit',
        'Out for Delivery'   => 'out_for_delivery',
        'Delivered'          => 'delivered',
        'Partial Delivered'  => 'delivered',
        'Return'             => 'returned',
        'Exchange'           => 'returned',
        'On Hold'            => 'pending',
        'Failed Delivery'    => 'failed',
        'Cancelled'          => 'failed',
    ];

    public function getProviderName(): string
    {
        return 'pathao';
    }

    public function testConnection(array $config): bool
    {
        $this->validateConfig($config);

        // In production, this would make an HTTP call to Pathao API
        // to validate credentials and get a token.
        return ! empty($config['client_id'])
            && ! empty($config['client_secret'])
            && ! empty($config['base_url']);
    }

    public function createShipment(array $orderData, array $config): array
    {
        $this->validateConfig($config);

        $payload = $this->buildCreatePayload($orderData);

        // In production: HTTP POST to Pathao consignment create endpoint
        // $response = Http::withToken($token)->post($config['base_url'] . '/aladdin/api/v1/orders', $payload);

        return [
            'consignment_id' => '',
            'tracking_code'  => '',
            'status'         => 'pending',
            'raw_response'   => [],
        ];
    }

    public function getTracking(string $consignmentId, array $config): array
    {
        $this->validateConfig($config);

        // In production: HTTP GET to Pathao tracking endpoint
        // $response = Http::withToken($token)->get($config['base_url'] . '/aladdin/api/v1/orders/' . $consignmentId);

        return [
            'status' => 'pending',
            'events' => [],
        ];
    }

    public function normalizeStatus(string $providerStatus): string
    {
        return self::STATUS_MAP[$providerStatus] ?? 'pending';
    }

    /**
     * Build the API payload for Pathao shipment creation.
     */
    private function buildCreatePayload(array $orderData): array
    {
        return [
            'store_id'             => $orderData['store_id'] ?? null,
            'merchant_order_id'    => $orderData['order_number'] ?? null,
            'recipient_name'       => $orderData['customer_name'] ?? '',
            'recipient_phone'      => $orderData['customer_phone'] ?? '',
            'recipient_address'    => $orderData['shipping_address'] ?? '',
            'recipient_city'       => $orderData['shipping_city_id'] ?? null,
            'recipient_zone'       => $orderData['shipping_zone_id'] ?? null,
            'recipient_area'       => $orderData['shipping_area_id'] ?? null,
            'delivery_type'        => $orderData['delivery_type'] ?? 48,
            'item_type'            => $orderData['item_type'] ?? 2,
            'special_instruction'  => $orderData['notes'] ?? '',
            'item_quantity'        => $orderData['item_quantity'] ?? 1,
            'item_weight'          => $orderData['item_weight'] ?? 0.5,
            'amount_to_collect'    => $orderData['amount_to_collect'] ?? 0,
            'item_description'     => $orderData['item_description'] ?? '',
        ];
    }

    private function validateConfig(array $config): void
    {
        $required = ['client_id', 'client_secret', 'base_url'];

        foreach ($required as $key) {
            if (empty($config[$key])) {
                throw new \InvalidArgumentException("Pathao config missing required field: {$key}");
            }
        }
    }
}

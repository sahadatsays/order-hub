<?php

namespace App\Contracts;

interface CourierProviderInterface
{
    /**
     * Test the courier connection with given credentials.
     */
    public function testConnection(array $config): bool;

    /**
     * Create a shipment/consignment from order data.
     *
     * @return array{consignment_id: string, tracking_code: string, status: string, raw_response: array}
     */
    public function createShipment(array $orderData, array $config): array;

    /**
     * Fetch tracking updates for a consignment.
     *
     * @return array{status: string, events: array}
     */
    public function getTracking(string $consignmentId, array $config): array;

    /**
     * Map provider-specific status to internal shipment status.
     */
    public function normalizeStatus(string $providerStatus): string;

    /**
     * Get the provider name identifier.
     */
    public function getProviderName(): string;
}

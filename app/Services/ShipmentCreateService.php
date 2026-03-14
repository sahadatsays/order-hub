<?php

namespace App\Services;

use App\Models\Courier;
use App\Models\Order;
use App\Models\Shipment;
use App\Services\Courier\CourierProviderFactory;
use Illuminate\Support\Facades\DB;

class ShipmentCreateService
{
    /**
     * Create a shipment for an order using the specified courier.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function create(Order $order, Courier $courier, array $extraData = []): Shipment
    {
        $this->validateOrder($order);
        $this->preventDuplicate($order);

        $provider = CourierProviderFactory::make($courier->code);
        $config = $courier->api_config ?? [];

        $orderPayload = $this->buildOrderPayload($order, $extraData);

        return DB::transaction(function () use ($order, $courier, $provider, $config, $orderPayload) {
            $shipment = Shipment::create([
                'order_id'        => $order->id,
                'courier_id'      => $courier->id,
                'status'          => 'pending',
                'shipping_cost'   => $courier->base_rate ?? 0,
                'request_payload' => $orderPayload,
            ]);

            try {
                $result = $provider->createShipment($orderPayload, $config);

                $shipment->update([
                    'tracking_number'  => $result['tracking_code'] ?? null,
                    'status'           => $result['status'] ?? 'pending',
                    'response_payload' => $result['raw_response'] ?? [],
                    'notes'            => $result['consignment_id'] ?? null,
                ]);
            } catch (\Throwable $e) {
                $shipment->update([
                    'status'           => 'failed',
                    'response_payload' => ['error' => $e->getMessage()],
                ]);

                throw $e;
            }

            return $shipment;
        });
    }

    private function validateOrder(Order $order): void
    {
        if (empty($order->customer_name)) {
            throw new \InvalidArgumentException('Order must have a customer name for shipment.');
        }

        if (empty($order->customer_phone) && empty($order->shipping_address)) {
            throw new \InvalidArgumentException('Order must have a phone number or shipping address for shipment.');
        }

        if (in_array($order->status, ['cancelled', 'refunded'])) {
            throw new \InvalidArgumentException('Cannot create shipment for cancelled or refunded order.');
        }
    }

    private function preventDuplicate(Order $order): void
    {
        $activeShipment = Shipment::where('order_id', $order->id)
            ->whereNotIn('status', ['failed', 'returned'])
            ->first();

        if ($activeShipment) {
            throw new \RuntimeException('An active shipment already exists for this order.');
        }
    }

    private function buildOrderPayload(Order $order, array $extraData): array
    {
        return array_merge([
            'order_number'     => $order->order_number,
            'customer_name'    => $order->customer_name,
            'customer_phone'   => $order->customer_phone,
            'shipping_address' => $order->shipping_address,
            'shipping_city'    => $order->shipping_city,
            'notes'            => $order->notes,
            'amount_to_collect' => max(0, ($order->total_amount ?? 0) - ($order->paid_amount ?? 0)),
            'item_quantity'    => $order->items()->sum('quantity'),
        ], $extraData);
    }
}

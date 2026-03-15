<?php

namespace App\Jobs;

use App\Models\Shipment;
use App\Models\ShipmentTrackingLog;
use App\Services\Courier\CourierProviderFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncTrackingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public array $backoff = [60, 120, 240];

    public function __construct(
        public readonly int $shipmentId,
    ) {}

    public function handle(): void
    {
        $shipment = Shipment::with('courier')->find($this->shipmentId);

        if (! $shipment || ! $shipment->courier) {
            return;
        }

        // Skip terminal statuses
        if (in_array($shipment->status, ['delivered', 'returned'])) {
            return;
        }

        if (! $shipment->tracking_number && ! $shipment->notes) {
            return;
        }

        $courier = $shipment->courier;

        if (! CourierProviderFactory::has($courier->code)) {
            return;
        }

        $provider = CourierProviderFactory::make($courier->code);
        $config = $courier->api_config ?? [];
        $consignmentId = $shipment->notes ?? $shipment->tracking_number;

        try {
            $result = $provider->getTracking($consignmentId, $config);
        } catch (\Throwable) {
            // Allow retry via queue
            throw new \RuntimeException("Failed to fetch tracking for shipment #{$this->shipmentId}");
        }

        $normalizedStatus = $provider->normalizeStatus($result['status'] ?? '');

        // Prevent duplicate log entries by checking the latest
        $latestLog = $shipment->trackingLogs()->orderByDesc('tracked_at')->first();

        if (! $latestLog || $latestLog->status !== $normalizedStatus) {
            ShipmentTrackingLog::create([
                'shipment_id' => $shipment->id,
                'status'      => $normalizedStatus,
                'description' => $result['description'] ?? null,
                'location'    => $result['location'] ?? null,
                'raw_payload' => $result,
                'tracked_at'  => now(),
                'created_at'  => now(),
            ]);
        }

        // Update shipment status if changed
        if ($shipment->status !== $normalizedStatus) {
            $shipment->update(['status' => $normalizedStatus]);

            // Update delivered timestamp
            if ($normalizedStatus === 'delivered' && ! $shipment->delivered_at) {
                $shipment->update(['delivered_at' => now()]);
            }
        }
    }

    /**
     * Unique job identifier to prevent overlapping syncs.
     */
    public function uniqueId(): string
    {
        return 'tracking-sync-' . $this->shipmentId;
    }
}

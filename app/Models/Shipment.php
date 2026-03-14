<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    protected $fillable = [
        'order_id',
        'courier_id',
        'tracking_number',
        'tracking_url',
        'status',
        'shipping_cost',
        'notes',
        'request_payload',
        'response_payload',
        'shipped_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'shipping_cost' => 'decimal:2',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
            'request_payload' => 'array',
            'response_payload' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }

    public function trackingLogs(): HasMany
    {
        return $this->hasMany(ShipmentTrackingLog::class)->orderByDesc('created_at');
    }

    public function getTrackingLinkAttribute(): ?string
    {
        if (! $this->tracking_url && ! $this->courier?->tracking_url) {
            return null;
        }
        $base = $this->tracking_url ?? $this->courier->tracking_url;

        return $this->tracking_number
            ? rtrim($base, '/') . '/' . $this->tracking_number
            : $base;
    }
}

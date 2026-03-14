<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentTrackingLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'shipment_id',
        'status',
        'location',
        'description',
        'raw_payload',
        'tracked_at',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'raw_payload' => 'array',
            'tracked_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}

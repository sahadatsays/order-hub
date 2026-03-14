<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Webhook extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'url',
        'events',
        'signing_secret',
        'is_active',
        'description',
    ];

    const SUPPORTED_EVENTS = [
        'order.created',
        'order.updated',
        'order.status_changed',
        'order.cancelled',
        'shipment.created',
        'shipment.tracking_updated',
        'shipment.delivered',
        'shipment.failed',
        'payment.received',
        'inventory.low_stock',
        'integration.sync_failed',
    ];

    protected function casts(): array
    {
        return [
            'events' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(WebhookLog::class);
    }
}

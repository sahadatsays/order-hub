<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Courier extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'code',
        'tracking_url',
        'api_key',
        'api_config',
        'base_rate',
        'is_active',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'api_config' => 'array',
            'base_rate' => 'decimal:2',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function getTrackingLinkAttribute(): ?string
    {
        if (! $this->tracking_url) {
            return null;
        }

        return $this->tracking_url;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

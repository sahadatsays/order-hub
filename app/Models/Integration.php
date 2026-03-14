<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Integration extends Model
{
    const TYPES = [
        'facebook'    => 'Facebook',
        'woocommerce' => 'WooCommerce',
        'shopify'     => 'Shopify',
        'whatsapp'    => 'WhatsApp',
        'website'     => 'Website',
        'pos'         => 'POS',
    ];

    const TYPE_ICONS = [
        'facebook'    => 'fab fa-facebook',
        'woocommerce' => 'fab fa-wordpress',
        'shopify'     => 'fab fa-shopify',
        'whatsapp'    => 'fab fa-whatsapp',
        'website'     => 'fas fa-globe',
        'pos'         => 'fas fa-cash-register',
    ];

    protected $fillable = [
        'tenant_id',
        'type',
        'name',
        'credentials',
        'settings',
        'is_active',
        'last_synced_at',
        'sync_status',
        'sync_error',
    ];

    protected function casts(): array
    {
        return [
            'credentials' => 'encrypted:array',
            'settings' => 'array',
            'is_active' => 'boolean',
            'last_synced_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryItem extends Model
{
    protected $fillable = [
        'tenant_id',
        'product_id',
        'location',
        'quantity_on_hand',
        'quantity_reserved',
        'reorder_point',
        'reorder_quantity',
        'last_counted_at',
    ];

    protected function casts(): array
    {
        return [
            'last_counted_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getQuantityAvailableAttribute(): int
    {
        return max(0, $this->quantity_on_hand - $this->quantity_reserved);
    }

    public function isLowStock(): bool
    {
        return $this->quantity_on_hand <= $this->reorder_point;
    }

    public function isOutOfStock(): bool
    {
        return $this->quantity_on_hand <= 0;
    }
}

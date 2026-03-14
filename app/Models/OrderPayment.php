<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPayment extends Model
{
    const METHODS = [
        'cash'            => 'Cash',
        'card'            => 'Card',
        'bank_transfer'   => 'Bank Transfer',
        'mobile_banking'  => 'Mobile Banking',
        'cod'             => 'Cash on Delivery',
        'other'           => 'Other',
    ];

    protected $fillable = [
        'order_id',
        'collected_by',
        'method',
        'amount',
        'tendered',
        'change_amount',
        'reference',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'amount'        => 'decimal:2',
            'tendered'      => 'decimal:2',
            'change_amount' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function collectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collected_by');
    }
}

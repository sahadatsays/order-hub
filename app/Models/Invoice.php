<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'order_id',
        'invoice_number',
        'status',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'paid_amount',
        'notes',
        'issued_at',
        'due_at',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'issued_at' => 'datetime',
            'due_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getDueAmountAttribute(): float
    {
        return max(0, $this->total_amount - $this->paid_amount);
    }

    public function isOverdue(): bool
    {
        return $this->status === 'sent'
            && $this->due_at !== null
            && $this->due_at->isPast();
    }

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            if (! $invoice->invoice_number) {
                $invoice->invoice_number = static::generateInvoiceNumber($invoice->tenant_id);
            }
        });
    }

    public static function generateInvoiceNumber(int $tenantId): string
    {
        $prefix = 'INV';
        $year = now()->format('Y');
        $count = static::where('tenant_id', $tenantId)
            ->whereYear('created_at', $year)
            ->count() + 1;

        return sprintf('%s-%s-%05d', $prefix, $year, $count);
    }
}

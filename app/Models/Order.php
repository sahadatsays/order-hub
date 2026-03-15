<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const STATUSES = [
        'pending'    => 'Pending',
        'confirmed'  => 'Confirmed',
        'processing' => 'Processing',
        'packed'     => 'Packed',
        'shipped'    => 'Shipped',
        'delivered'  => 'Delivered',
        'cancelled'  => 'Cancelled',
        'refunded'   => 'Refunded',
        'on_hold'    => 'On Hold',
    ];

    const ORDER_TYPES = [
        'pos'         => 'POS',
        'manual'      => 'Manual',
        'ecommerce'   => 'Ecommerce',
        'imported'    => 'Imported',
    ];

    const SOURCES = [
        'facebook'    => 'Facebook',
        'website'     => 'Website',
        'whatsapp'    => 'WhatsApp',
        'woocommerce' => 'WooCommerce',
        'shopify'     => 'Shopify',
        'pos'         => 'POS',
        'manual'      => 'Manual',
        'phone'       => 'Phone',
        'other'       => 'Other',
    ];

    const STATUS_COLORS = [
        'pending'    => 'yellow',
        'confirmed'  => 'blue',
        'processing' => 'indigo',
        'packed'     => 'purple',
        'shipped'    => 'orange',
        'delivered'  => 'green',
        'cancelled'  => 'red',
        'refunded'   => 'zinc',
        'on_hold'    => 'zinc',
    ];

    const PAYMENT_STATUSES = [
        'unpaid'   => 'Unpaid',
        'partial'  => 'Partial',
        'paid'     => 'Paid',
        'refunded' => 'Refunded',
    ];

    const PAYMENT_STATUS_COLORS = [
        'unpaid'   => 'red',
        'partial'  => 'yellow',
        'paid'     => 'green',
        'refunded' => 'zinc',
    ];

    const SOURCE_COLORS = [
        'facebook'    => 'blue',
        'website'     => 'indigo',
        'whatsapp'    => 'green',
        'woocommerce' => 'purple',
        'shopify'     => 'green',
        'pos'         => 'orange',
        'manual'      => 'zinc',
        'phone'       => 'yellow',
        'other'       => 'zinc',
    ];

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'created_by',
        'order_number',
        'source',
        'order_type',
        'source_order_id',
        'source_raw_payload',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_country',
        'shipping_postal_code',
        'status',
        'payment_status',
        'payment_method',
        'subtotal',
        'discount_amount',
        'discount_code',
        'shipping_charge',
        'tax_amount',
        'total_amount',
        'paid_amount',
        'currency',
        'notes',
        'internal_notes',
        'ordered_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'shipping_charge' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'ordered_at' => 'datetime',
            'source_raw_payload' => 'array',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class)->latest();
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class)->latest();
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLog::class)->orderByDesc('created_at');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(OrderPayment::class)->orderByDesc('created_at');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'auditable_id')
            ->where('auditable_type', self::class)
            ->orderByDesc('created_at');
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'zinc';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getSourceLabelAttribute(): string
    {
        return self::SOURCES[$this->source] ?? ucfirst($this->source);
    }

    public function getSourceColorAttribute(): string
    {
        return self::SOURCE_COLORS[$this->source] ?? 'zinc';
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return self::PAYMENT_STATUSES[$this->payment_status] ?? ucfirst($this->payment_status);
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return self::PAYMENT_STATUS_COLORS[$this->payment_status] ?? 'zinc';
    }

    public function getDueAmountAttribute(): float
    {
        return max(0, $this->total_amount - $this->paid_amount);
    }

    public function scopeForTenant($query, int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeBySource($query, string $source)
    {
        return $query->where('source', $source);
    }

    public function recalculateTotals(): void
    {
        $subtotal = $this->items->sum('line_total');
        $this->subtotal = $subtotal;
        $this->total_amount = $subtotal - $this->discount_amount + $this->shipping_charge + $this->tax_amount;
        $this->save();
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (! $order->order_number) {
                $order->order_number = static::generateOrderNumber($order->tenant_id);
            }
        });
    }

    public static function generateOrderNumber(?int $tenantId): string
    {
        $prefix = 'ORD';
        $date = now()->format('ymd');
        $count = static::when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->whereDate('created_at', today())
            ->count() + 1;

        return sprintf('%s-%s-%04d', $prefix, $date, $count);
    }
}

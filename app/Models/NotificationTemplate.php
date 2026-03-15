<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotificationTemplate extends Model
{
    const CHANNELS = [
        'database' => 'In-App',
        'email'    => 'Email',
        'sms'      => 'SMS',
    ];

    const EVENTS = [
        'order_created'              => 'Order Created',
        'order_assigned'             => 'Order Assigned',
        'order_status_changed'       => 'Order Status Changed',
        'shipment_created'           => 'Shipment Created',
        'shipment_tracking_updated'  => 'Shipment Tracking Updated',
        'shipment_delivered'         => 'Shipment Delivered',
        'shipment_delivery_failed'   => 'Shipment Delivery Failed',
        'payment_received'           => 'Payment Received',
        'low_stock_detected'         => 'Low Stock Detected',
        'integration_sync_failed'    => 'Integration Sync Failed',
    ];

    const VARIABLES = [
        'customer_name', 'customer_phone', 'customer_email',
        'order_no', 'order_status', 'total_amount', 'currency',
        'courier_name', 'tracking_code', 'current_status',
        'product_name', 'stock_quantity',
        'integration_name', 'error_message',
        'tenant_name', 'app_url',
    ];

    protected $fillable = [
        'tenant_id',
        'name',
        'event',
        'channel',
        'subject',
        'body',
        'variables',
        'is_system',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'variables' => 'array',
            'is_system' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function scopeForTenant($query, ?int $tenantId)
    {
        return $query->where(function ($q) use ($tenantId) {
            $q->where('tenant_id', $tenantId)
              ->orWhere('is_system', true);
        });
    }

    public function scopeForEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    public function scopeForChannel($query, string $channel)
    {
        return $query->where('channel', $channel);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    const STATUSES = [
        'pending' => 'Pending',
        'sent'    => 'Sent',
        'failed'  => 'Failed',
        'read'    => 'Read',
    ];

    const STATUS_COLORS = [
        'pending' => 'yellow',
        'sent'    => 'green',
        'failed'  => 'red',
        'read'    => 'zinc',
    ];

    protected $fillable = [
        'tenant_id',
        'rule_id',
        'event',
        'channel',
        'recipient_type',
        'recipient_id',
        'recipient_contact',
        'subject',
        'body',
        'status',
        'related_type',
        'related_id',
        'idempotency_key',
        'read_at',
        'sent_at',
        'scheduled_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at'      => 'datetime',
            'sent_at'      => 'datetime',
            'scheduled_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(NotificationRule::class, 'rule_id');
    }

    public function related(): MorphTo
    {
        return $this->morphTo('related');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(NotificationLog::class)->orderByDesc('attempted_at');
    }

    public function markAsSent(): void
    {
        $this->update([
            'status'  => 'sent',
            'sent_at' => now(),
        ]);
    }

    public function markAsFailed(): void
    {
        $this->update(['status' => 'failed']);
    }

    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update([
                'status'  => 'read',
                'read_at' => now(),
            ]);
        }
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'zinc';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function scopeForTenant($query, int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at')->where('channel', 'database');
    }

    public function scopeForRecipient($query, string $type, int $id)
    {
        return $query->where('recipient_type', $type)->where('recipient_id', $id);
    }
}

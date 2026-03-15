<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'notification_id',
        'tenant_id',
        'channel',
        'provider',
        'status',
        'request_payload',
        'response_payload',
        'error_message',
        'attempt_number',
        'attempted_at',
    ];

    protected function casts(): array
    {
        return [
            'request_payload'  => 'array',
            'response_payload' => 'array',
            'attempted_at'     => 'datetime',
        ];
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public static function record(
        int $notificationId,
        int $tenantId,
        string $channel,
        string $status,
        ?string $provider = null,
        ?array $request = null,
        ?array $response = null,
        ?string $error = null,
        int $attempt = 1
    ): self {
        return static::create([
            'notification_id'  => $notificationId,
            'tenant_id'        => $tenantId,
            'channel'          => $channel,
            'provider'         => $provider,
            'status'           => $status,
            'request_payload'  => $request,
            'response_payload' => $response,
            'error_message'    => $error,
            'attempt_number'   => $attempt,
            'attempted_at'     => now(),
        ]);
    }

    public function scopeForNotification($query, int $notificationId)
    {
        return $query->where('notification_id', $notificationId);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}

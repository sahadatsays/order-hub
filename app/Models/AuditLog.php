<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'auditable_type',
        'auditable_id',
        'event',
        'field',
        'old_value',
        'new_value',
        'ip_address',
        'user_agent',
        'metadata',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function record(
        ?int $tenantId,
        ?int $userId,
        string $auditableType,
        int $auditableId,
        string $event,
        ?string $field = null,
        mixed $oldValue = null,
        mixed $newValue = null,
        array $metadata = []
    ): self {
        return static::create([
            'tenant_id'      => $tenantId,
            'user_id'        => $userId,
            'auditable_type' => $auditableType,
            'auditable_id'   => $auditableId,
            'event'          => $event,
            'field'          => $field,
            'old_value'      => $oldValue !== null ? (string) $oldValue : null,
            'new_value'      => $newValue !== null ? (string) $newValue : null,
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
            'metadata'       => $metadata,
            'created_at'     => now(),
        ]);
    }
}

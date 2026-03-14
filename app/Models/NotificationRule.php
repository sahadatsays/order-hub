<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationRule extends Model
{
    const TARGETS = [
        'customer'       => 'Order Customer',
        'assigned_staff' => 'Assigned Staff',
        'admins'         => 'All Admins',
        'owner'          => 'Tenant Owner',
    ];

    protected $fillable = [
        'tenant_id',
        'name',
        'event',
        'channels',
        'targets',
        'conditions',
        'delay_seconds',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'channels'      => 'array',
            'targets'       => 'array',
            'conditions'    => 'array',
            'delay_seconds' => 'integer',
            'is_active'     => 'boolean',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function scopeForTenant($query, int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeForEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function evaluateConditions(array $context): bool
    {
        $conditions = $this->conditions ?? [];
        if (empty($conditions)) {
            return true;
        }

        foreach ($conditions as $field => $expected) {
            $actual = $context[$field] ?? null;
            if ($actual === null) {
                continue;
            }

            if ($field === 'min_amount') {
                if ((float) ($context['total_amount'] ?? 0) < (float) $expected) {
                    return false;
                }
                continue;
            }

            if (is_array($expected)) {
                if (!in_array($actual, $expected)) {
                    return false;
                }
            } elseif ($actual !== $expected) {
                return false;
            }
        }

        return true;
    }
}

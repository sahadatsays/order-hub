<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    protected $fillable = [
        'tenant_id',
        'user_id',
        'group',
        'key',
        'value',
        'value_type',
        'default_value',
        'metadata',
    ];

    const VALUE_TYPES = [
        'string' => 'String',
        'boolean' => 'Boolean',
        'number' => 'Number',
        'json' => 'JSON',
        'encrypted' => 'Encrypted',
        'file' => 'File',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
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

    public function getTypedValueAttribute(): mixed
    {
        return match ($this->value_type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'number' => is_numeric($this->value) ? (float) $this->value : null,
            'json' => json_decode($this->value, true),
            'encrypted' => $this->value ? decrypt($this->value) : null,
            default => $this->value,
        };
    }

    public static function prepareValue(mixed $value, string $type): ?string
    {
        return match ($type) {
            'boolean' => $value ? '1' : '0',
            'number' => (string) $value,
            'json' => is_string($value) ? $value : json_encode($value),
            'encrypted' => $value ? encrypt($value) : null,
            default => (string) $value,
        };
    }
}

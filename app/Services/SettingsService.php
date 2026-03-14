<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\SettingAuditLog;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    /**
     * Get a setting value with fallback: user → tenant → system default → provided default.
     */
    public function get(string $key, mixed $default = null, ?int $tenantId = null, ?int $userId = null): mixed
    {
        [$group, $settingKey] = $this->parseKey($key);

        // Try user-level setting first
        if ($userId) {
            $value = $this->getFromCache("user:{$userId}:{$group}:{$settingKey}", function () use ($group, $settingKey, $tenantId, $userId) {
                return Setting::where('tenant_id', $tenantId)
                    ->where('user_id', $userId)
                    ->where('group', $group)
                    ->where('key', $settingKey)
                    ->first();
            });

            if ($value !== null) {
                return $value;
            }
        }

        // Try tenant-level setting
        if ($tenantId) {
            $value = $this->getFromCache("tenant:{$tenantId}:{$group}:{$settingKey}", function () use ($group, $settingKey, $tenantId) {
                return Setting::where('tenant_id', $tenantId)
                    ->whereNull('user_id')
                    ->where('group', $group)
                    ->where('key', $settingKey)
                    ->first();
            });

            if ($value !== null) {
                return $value;
            }
        }

        // Try system-level setting
        $value = $this->getFromCache("system:{$group}:{$settingKey}", function () use ($group, $settingKey) {
            return Setting::whereNull('tenant_id')
                ->whereNull('user_id')
                ->where('group', $group)
                ->where('key', $settingKey)
                ->first();
        });

        if ($value !== null) {
            return $value;
        }

        return $default;
    }

    /**
     * Set a setting value.
     */
    public function set(string $key, mixed $value, string $valueType = 'string', ?int $tenantId = null, ?int $userId = null): Setting
    {
        [$group, $settingKey] = $this->parseKey($key);

        $preparedValue = Setting::prepareValue($value, $valueType);

        $setting = Setting::updateOrCreate(
            [
                'tenant_id' => $tenantId,
                'user_id' => $userId,
                'group' => $group,
                'key' => $settingKey,
            ],
            [
                'value' => $preparedValue,
                'value_type' => $valueType,
            ]
        );

        // Invalidate cache
        $this->invalidateCache($tenantId, $userId, $group, $settingKey);

        return $setting;
    }

    /**
     * Get all settings for a group.
     */
    public function getGroup(string $group, ?int $tenantId = null, ?int $userId = null): array
    {
        $query = Setting::where('group', $group);

        if ($userId) {
            $query->where(function ($q) use ($tenantId, $userId) {
                $q->where(function ($sub) use ($userId, $tenantId) {
                    $sub->where('user_id', $userId)->where('tenant_id', $tenantId);
                })->orWhere(function ($sub) use ($tenantId) {
                    $sub->where('tenant_id', $tenantId)->whereNull('user_id');
                })->orWhere(function ($sub) {
                    $sub->whereNull('tenant_id')->whereNull('user_id');
                });
            });
        } elseif ($tenantId) {
            $query->where(function ($q) use ($tenantId) {
                $q->where(function ($sub) use ($tenantId) {
                    $sub->where('tenant_id', $tenantId)->whereNull('user_id');
                })->orWhere(function ($sub) {
                    $sub->whereNull('tenant_id')->whereNull('user_id');
                });
            });
        } else {
            $query->whereNull('tenant_id')->whereNull('user_id');
        }

        $settings = $query->get();

        // Merge: system < tenant < user (higher priority overrides)
        $result = [];
        foreach ($settings->sortBy(function ($s) {
            if ($s->user_id) return 2;
            if ($s->tenant_id) return 1;
            return 0;
        }) as $setting) {
            $result[$setting->key] = $setting->typed_value;
        }

        return $result;
    }

    /**
     * Update multiple settings at once for a group.
     */
    public function updateGroup(string $group, array $values, array $valueTypes = [], ?int $tenantId = null, ?int $userId = null): void
    {
        $oldValues = $this->getGroup($group, $tenantId, $userId);

        foreach ($values as $key => $value) {
            $type = $valueTypes[$key] ?? 'string';
            $this->set("{$group}.{$key}", $value, $type, $tenantId, $userId);
        }

        // Log changes
        if (auth()->check()) {
            foreach ($values as $key => $value) {
                $oldValue = $oldValues[$key] ?? null;
                $newValue = $value;

                if ($oldValue !== $newValue) {
                    $this->logChange($group, $key, $oldValue, $newValue, $tenantId);
                }
            }
        }
    }

    /**
     * Log a settings change for audit trail.
     */
    protected function logChange(string $group, string $key, mixed $oldValue, mixed $newValue, ?int $tenantId): void
    {
        SettingAuditLog::create([
            'tenant_id' => $tenantId,
            'user_id' => auth()->id(),
            'group' => $group,
            'key' => $key,
            'old_value' => is_array($oldValue) ? json_encode($oldValue) : (string) $oldValue,
            'new_value' => is_array($newValue) ? json_encode($newValue) : (string) $newValue,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }

    /**
     * Parse "group.key" into array.
     */
    protected function parseKey(string $key): array
    {
        $parts = explode('.', $key, 2);

        if (count($parts) !== 2) {
            throw new \InvalidArgumentException("Setting key must be in format 'group.key', got '{$key}'");
        }

        return $parts;
    }

    /**
     * Get value from cache or load it.
     */
    protected function getFromCache(string $cacheKey, callable $loader): mixed
    {
        $fullKey = "settings:{$cacheKey}";

        return Cache::remember($fullKey, 3600, function () use ($loader) {
            $setting = $loader();
            return $setting?->typed_value;
        });
    }

    /**
     * Invalidate cache for a specific setting.
     */
    protected function invalidateCache(?int $tenantId, ?int $userId, string $group, string $key): void
    {
        if ($userId) {
            Cache::forget("settings:user:{$userId}:{$group}:{$key}");
        }
        if ($tenantId) {
            Cache::forget("settings:tenant:{$tenantId}:{$group}:{$key}");
        }
        Cache::forget("settings:system:{$group}:{$key}");
    }
}

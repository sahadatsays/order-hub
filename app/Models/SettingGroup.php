<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SettingGroup extends Model
{
    protected $fillable = [
        'key',
        'label',
        'description',
        'icon',
        'sort_order',
        'is_system',
    ];

    protected function casts(): array
    {
        return [
            'is_system' => 'boolean',
        ];
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class, 'group', 'key');
    }
}

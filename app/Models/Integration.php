<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Integration extends Model
{
    const TYPES = [
        'facebook'    => 'Facebook',
        'woocommerce' => 'WooCommerce',
        'shopify'     => 'Shopify',
        'whatsapp'    => 'WhatsApp',
        'website'     => 'Website',
        'pos'         => 'POS',
        'pathao'      => 'Pathao',
    ];

    const TYPE_ICONS = [
        'facebook'    => 'fab fa-facebook',
        'woocommerce' => 'fab fa-wordpress',
        'shopify'     => 'fab fa-shopify',
        'whatsapp'    => 'fab fa-whatsapp',
        'website'     => 'fas fa-globe',
        'pos'         => 'fas fa-cash-register',
        'pathao'      => 'fas fa-truck',
    ];

    const CATEGORIES = [
        'sales_channel' => ['facebook', 'woocommerce', 'shopify', 'whatsapp', 'website', 'pos'],
        'courier'       => ['pathao'],
    ];

    const CREDENTIAL_FIELDS = [
        'woocommerce' => [
            ['name' => 'store_url',       'label' => 'Store URL',       'type' => 'url',      'required' => true,  'placeholder' => 'https://yourstore.com'],
            ['name' => 'consumer_key',    'label' => 'Consumer Key',    'type' => 'text',     'required' => true,  'placeholder' => 'ck_...'],
            ['name' => 'consumer_secret', 'label' => 'Consumer Secret', 'type' => 'password', 'required' => true,  'placeholder' => 'cs_...'],
        ],
        'pathao'      => [
            ['name' => 'base_url',      'label' => 'API Base URL',    'type' => 'url',      'required' => true,  'placeholder' => 'https://api-hermes.pathao.com'],
            ['name' => 'client_id',     'label' => 'Client ID',       'type' => 'text',     'required' => true,  'placeholder' => 'Your Client ID'],
            ['name' => 'client_secret', 'label' => 'Client Secret',   'type' => 'password', 'required' => true,  'placeholder' => 'Your Client Secret'],
            ['name' => 'username',      'label' => 'Username (Email)', 'type' => 'email',    'required' => true,  'placeholder' => 'user@example.com'],
            ['name' => 'password',      'label' => 'Password',         'type' => 'password', 'required' => true,  'placeholder' => '••••••••'],
        ],
        'shopify'     => [
            ['name' => 'store_url',    'label' => 'Store URL',    'type' => 'url',      'required' => true,  'placeholder' => 'https://yourstore.myshopify.com'],
            ['name' => 'access_token', 'label' => 'Access Token', 'type' => 'password', 'required' => true,  'placeholder' => 'shpat_...'],
        ],
    ];

    const SETTINGS_FIELDS = [
        'woocommerce' => [
            ['name' => 'auto_sync',       'label' => 'Auto Sync Orders',          'type' => 'toggle', 'default' => false],
            ['name' => 'sync_interval',   'label' => 'Sync Interval (minutes)',    'type' => 'number', 'default' => 30],
            ['name' => 'import_statuses', 'label' => 'Import Order Statuses',      'type' => 'text',   'default' => 'processing,completed'],
        ],
        'pathao'      => [
            ['name' => 'default_store_id', 'label' => 'Default Store ID', 'type' => 'text',   'default' => ''],
            ['name' => 'default_city_id',  'label' => 'Default City ID',  'type' => 'text',   'default' => ''],
            ['name' => 'default_zone_id',  'label' => 'Default Zone ID',  'type' => 'text',   'default' => ''],
        ],
        'shopify'     => [
            ['name' => 'auto_sync',     'label' => 'Auto Sync Orders',       'type' => 'toggle', 'default' => false],
            ['name' => 'sync_interval', 'label' => 'Sync Interval (minutes)', 'type' => 'number', 'default' => 30],
        ],
    ];

    const DEFAULT_STATUS_MAPPING = [
        'woocommerce' => [
            'pending'    => 'pending',
            'processing' => 'processing',
            'on-hold'    => 'on_hold',
            'completed'  => 'delivered',
            'cancelled'  => 'cancelled',
            'refunded'   => 'refunded',
            'failed'     => 'cancelled',
        ],
        'pathao'      => [
            'Pending'          => 'pending',
            'Pickup Assigned'  => 'processing',
            'Picked'           => 'packed',
            'In Transit'       => 'shipped',
            'Out for Delivery' => 'shipped',
            'Delivered'        => 'delivered',
            'Returned'         => 'cancelled',
            'On Hold'          => 'on_hold',
        ],
    ];

    protected $fillable = [
        'tenant_id',
        'type',
        'name',
        'credentials',
        'settings',
        'status_mapping',
        'webhook_url',
        'webhook_secret',
        'is_active',
        'last_synced_at',
        'sync_status',
        'sync_error',
    ];

    protected function casts(): array
    {
        return [
            'credentials' => 'encrypted:array',
            'settings' => 'array',
            'status_mapping' => 'array',
            'is_active' => 'boolean',
            'last_synced_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(IntegrationLog::class)->orderByDesc('created_at');
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    public function getCategoryAttribute(): string
    {
        foreach (self::CATEGORIES as $category => $types) {
            if (in_array($this->type, $types)) {
                return $category;
            }
        }

        return 'other';
    }

    public function getCredentialFieldsAttribute(): array
    {
        return self::CREDENTIAL_FIELDS[$this->type] ?? [];
    }

    public function getSettingsFieldsAttribute(): array
    {
        return self::SETTINGS_FIELDS[$this->type] ?? [];
    }

    public function getStatusMappingOrDefaultAttribute(): array
    {
        return $this->status_mapping ?? self::DEFAULT_STATUS_MAPPING[$this->type] ?? [];
    }

    public function getWebhookEndpointAttribute(): string
    {
        return url("/api/webhooks/{$this->type}/{$this->id}");
    }

    public function hasCredentialFields(): bool
    {
        return !empty(self::CREDENTIAL_FIELDS[$this->type]);
    }

    public function isSyncable(): bool
    {
        return in_array($this->type, ['woocommerce', 'shopify']);
    }

    public function isCourier(): bool
    {
        return in_array($this->type, self::CATEGORIES['courier'] ?? []);
    }

    public function getLastSuccessfulLog(): ?IntegrationLog
    {
        return $this->logs()->where('status', 'success')->first();
    }

    public function getLastFailedLog(): ?IntegrationLog
    {
        return $this->logs()->where('status', 'failed')->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }
}

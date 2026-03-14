<?php

namespace App\Services\Courier;

use App\Contracts\CourierProviderInterface;

class CourierProviderFactory
{
    /**
     * Known provider mappings.
     *
     * @var array<string, class-string<CourierProviderInterface>>
     */
    private static array $providers = [
        'pathao' => PathaoProvider::class,
    ];

    /**
     * Create a courier provider instance by code.
     */
    public static function make(string $courierCode): CourierProviderInterface
    {
        $class = self::$providers[$courierCode] ?? null;

        if (! $class) {
            throw new \InvalidArgumentException("Unknown courier provider: {$courierCode}");
        }

        return new $class();
    }

    /**
     * Register a new provider for extensibility.
     */
    public static function register(string $code, string $providerClass): void
    {
        self::$providers[$code] = $providerClass;
    }

    /**
     * Check if a provider is registered.
     */
    public static function has(string $courierCode): bool
    {
        return isset(self::$providers[$courierCode]);
    }
}

<?php

namespace App\Contracts;

interface SmsProviderInterface
{
    /**
     * Send an SMS message.
     *
     * @return array{success: bool, message: string, provider_response: mixed}
     */
    public function send(string $phone, string $body): array;

    /**
     * Get the provider name for logging.
     */
    public function providerName(): string;
}

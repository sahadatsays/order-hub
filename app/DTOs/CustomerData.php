<?php

namespace App\DTOs;

class CustomerData
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $phone = null,
        public readonly ?string $email = null,
        public readonly ?string $address = null,
        public readonly ?string $city = null,
        public readonly ?string $source = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            source: $data['source'] ?? null,
        );
    }
}

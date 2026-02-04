<?php

namespace App\Data;

use App\Models\Address;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class AddressData extends Data
{
    public function __construct(
        public ?string $street,
        public ?string $city,
        public ?string $state,
        public ?string $postalCode,
        public ?string $country,
    ) {}

    public static function fromModel(Address $address): self
    {
        return new self(
            street: $address->street,
            city: $address->city,
            state: $address->state,
            postalCode: $address->postal_code,
            country: $address->country,
        );
    }
}

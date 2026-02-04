<?php

namespace App\Data;

use App\Models\UserProfile;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class UserProfileData extends Data
{
    public function __construct(
        public int $id,
        public ?string $bio,
        public ?string $phone,
        public ?AddressData $address,
        public ?array $avatar,
        public ?string $dateOfBirth,
        public ?string $gender,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {}

    public static function fromModel(UserProfile $profile): self
    {
        return new self(
            id: $profile->id,
            bio: $profile->bio,
            phone: $profile->phone,
            address: $profile->address ? AddressData::fromModel($profile->address) : null,
            avatar: self::getAvatarData($profile),
            dateOfBirth: $profile->date_of_birth?->format('Y-m-d'),
            gender: $profile->gender,
            createdAt: $profile->created_at,
            updatedAt: $profile->updated_at,
        );
    }

    private static function getAvatarData(UserProfile $profile): ?array
    {
        if (! $profile->hasMedia('avatar')) {
            return null;
        }

        return [
            'original' => $profile->getFirstMediaUrl('avatar'),
            'thumb' => $profile->getFirstMediaUrl('avatar', 'thumb'),
            'preview' => $profile->getFirstMediaUrl('avatar', 'preview'),
        ];
    }
}

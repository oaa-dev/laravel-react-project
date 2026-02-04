<?php

namespace App\Data;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class UserData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?Carbon $emailVerifiedAt,
        public ?array $avatar,
        public ?UserProfileData $profile,
        public ?Collection $roles,
        public ?Collection $permissions,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {}

    public static function fromModel(User $user): self
    {
        $avatar = null;
        if ($user->relationLoaded('profile') && $user->profile?->hasMedia('avatar')) {
            $avatar = [
                'original' => $user->profile->getFirstMediaUrl('avatar'),
                'thumb' => $user->profile->getFirstMediaUrl('avatar', 'thumb'),
                'preview' => $user->profile->getFirstMediaUrl('avatar', 'preview'),
            ];
        }

        $profile = null;
        if ($user->relationLoaded('profile') && $user->profile) {
            $profile = UserProfileData::fromModel($user->profile);
        }

        $roles = null;
        if ($user->relationLoaded('roles')) {
            $roles = $user->roles->pluck('name');
        }

        $permissions = null;
        if ($user->relationLoaded('roles')) {
            $permissions = $user->getAllPermissions()->pluck('name');
        }

        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            emailVerifiedAt: $user->email_verified_at,
            avatar: $avatar,
            profile: $profile,
            roles: $roles,
            permissions: $permissions,
            createdAt: $user->created_at,
            updatedAt: $user->updated_at,
        );
    }
}

<?php

namespace App\Data;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\Permission\Models\Role;

#[MapOutputName(SnakeCaseMapper::class)]
class RoleData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public ?Collection $permissions,
        public ?int $usersCount,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {}

    public static function fromModel(Role $role): self
    {
        $permissions = null;
        if ($role->relationLoaded('permissions')) {
            $permissions = $role->permissions->pluck('name');
        }

        return new self(
            id: $role->id,
            name: $role->name,
            permissions: $permissions,
            usersCount: $role->users_count ?? null,
            createdAt: $role->created_at,
            updatedAt: $role->updated_at,
        );
    }
}

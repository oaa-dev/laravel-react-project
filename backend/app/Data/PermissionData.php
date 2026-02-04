<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\Permission\Models\Permission;

#[MapOutputName(SnakeCaseMapper::class)]
class PermissionData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {}

    public static function fromModel(Permission $permission): self
    {
        return new self(
            id: $permission->id,
            name: $permission->name,
            createdAt: $permission->created_at,
            updatedAt: $permission->updated_at,
        );
    }
}

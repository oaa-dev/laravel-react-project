<?php

namespace App\Data;

use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class NotificationData extends Data
{
    public function __construct(
        public string $id,
        public string $type,
        public array $data,
        public ?Carbon $readAt,
        public Carbon $createdAt,
    ) {}

    public static function fromModel(DatabaseNotification $notification): self
    {
        return new self(
            id: $notification->id,
            type: $notification->type,
            data: $notification->data,
            readAt: $notification->read_at,
            createdAt: $notification->created_at,
        );
    }
}

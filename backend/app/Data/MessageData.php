<?php

namespace App\Data;

use App\Models\Message;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class MessageData extends Data
{
    public function __construct(
        public int $id,
        public int $conversationId,
        public int $senderId,
        public ?array $sender,
        public string $body,
        public ?Carbon $readAt,
        public bool $isMine,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {}

    public static function fromModel(Message $message, ?int $currentUserId = null): self
    {
        $sender = null;
        if ($message->relationLoaded('sender') && $message->sender) {
            $user = $message->sender;
            $sender = [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => self::getAvatarData($user->profile),
            ];
        }

        return new self(
            id: $message->id,
            conversationId: $message->conversation_id,
            senderId: $message->sender_id,
            sender: $sender,
            body: $message->body,
            readAt: $message->read_at,
            isMine: $currentUserId !== null && $message->sender_id === $currentUserId,
            createdAt: $message->created_at,
            updatedAt: $message->updated_at,
        );
    }

    private static function getAvatarData($profile): ?array
    {
        if (! $profile || ! $profile->hasMedia('avatar')) {
            return null;
        }

        return [
            'original' => $profile->getFirstMediaUrl('avatar'),
            'thumb' => $profile->getFirstMediaUrl('avatar', 'thumb'),
            'preview' => $profile->getFirstMediaUrl('avatar', 'preview'),
        ];
    }
}

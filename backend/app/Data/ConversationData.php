<?php

namespace App\Data;

use App\Models\Conversation;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class ConversationData extends Data
{
    public function __construct(
        public int $id,
        public array $otherUser,
        public ?MessageData $latestMessage,
        public int $unreadCount,
        public ?Carbon $lastMessageAt,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {}

    public static function fromModel(Conversation $conversation, ?int $currentUserId = null): self
    {
        $otherUser = $currentUserId
            ? $conversation->getOtherUser($currentUserId)
            : $conversation->userOne;

        // Get unread count from participant relationship
        $unreadCount = 0;
        if ($conversation->relationLoaded('participants')) {
            $participant = $conversation->participants->first();
            $unreadCount = $participant?->unread_count ?? 0;
        }

        // Get latest message
        $latestMessage = null;
        if ($conversation->relationLoaded('latestMessage') && $conversation->latestMessage) {
            $latestMessage = MessageData::fromModel($conversation->latestMessage, $currentUserId);
        }

        return new self(
            id: $conversation->id,
            otherUser: [
                'id' => $otherUser->id,
                'name' => $otherUser->name,
                'avatar' => self::getAvatarData($otherUser->profile),
            ],
            latestMessage: $latestMessage,
            unreadCount: $unreadCount,
            lastMessageAt: $conversation->last_message_at,
            createdAt: $conversation->created_at,
            updatedAt: $conversation->updated_at,
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

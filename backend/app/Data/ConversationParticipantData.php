<?php

namespace App\Data;

use App\Models\ConversationParticipant;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class ConversationParticipantData extends Data
{
    public function __construct(
        public int $id,
        public int $conversationId,
        public int $userId,
        public int $unreadCount,
        public ?Carbon $lastReadAt,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {}

    public static function fromModel(ConversationParticipant $participant): self
    {
        return new self(
            id: $participant->id,
            conversationId: $participant->conversation_id,
            userId: $participant->user_id,
            unreadCount: $participant->unread_count,
            lastReadAt: $participant->last_read_at,
            createdAt: $participant->created_at,
            updatedAt: $participant->updated_at,
        );
    }
}

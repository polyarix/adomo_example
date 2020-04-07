<?php

namespace App\UseCase\User\Conversation;

use App\Entity\User\Conversation\Conversation;
use App\Entity\User\Conversation\Message;
use SebastianBerc\Repositories\Repository;

class MessageRepository extends Repository
{
    public function takeModel()
    {
        return Message::class;
    }

    public function totalUnseenCount($authUserId)
    {
        return Conversation::withCount(['messages' => function($q) use($authUserId) {
                $q->where('user_id', '!=', $authUserId)->where('is_seen', false);
            }])
            ->where('user_one', $authUserId)
            ->orWhere('user_two', $authUserId)
            ->get()
            ->sum('messages_count');
    }

    public function seenForConversation($conversationId, $forUser)
    {
        $this->model->where('conversation_id', $conversationId)->where('user_id', '!=', $forUser)->update(['is_seen' => true]);
    }

    public function deleteMessages($conversationId)
    {
        return (boolean) Message::where('conversation_id', $conversationId)->delete();
    }

    public function softDeleteMessage($messageId, $authUserId)
    {
        $message = $this->with(['conversation' => function ($q) use ($authUserId) {
            $q->where('user_one', $authUserId);
            $q->orWhere('user_two', $authUserId);
        }])->find($messageId);

        if (is_null($message->conversation)) {
            return false;
        }

        if ($message->user_id == $authUserId) {
            $message->deleted_from_sender = 1;
        } else {
            $message->deleted_from_receiver = 1;
        }

        return (boolean) $this->update($message);
    }
}

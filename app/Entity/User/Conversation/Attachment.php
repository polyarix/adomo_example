<?php

namespace App\Entity\User\Conversation;

use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    const MAX_UPLOAD_SIZE = 5120; // 5 Mb
    const STORAGE_DIR = 'attachments';

    protected $table = 'chat_conversation_attachments';

    protected $fillable = ['filename', 'mime', 'path', 'user_id', 'message_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    public function conversation()
    {
        return $this->hasOneThrough(Conversation::class, Message::class, 'id', 'id', 'message_id', 'conversation_id');
    }

    public function isOwnedBy(User $user): bool
    {
        return $user->id === $this->user_id;
    }
    public function belongsToUserConversation(User $user): bool
    {
        return $this->attachedToMessage() && in_array($user->id, [$this->conversation->user_one, $this->conversation->user_two]);
    }
    public function attachedToMessage(): bool
    {
        return !empty($this->message);
    }
}

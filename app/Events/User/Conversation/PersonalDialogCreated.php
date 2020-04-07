<?php

namespace App\Events\User\Conversation;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Entity\User\Conversation\Message;

class PersonalDialogCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Conversation between users.
     *
     * @var string
     */
    public $conversation;
    /**
     * User receiving the event.
     *
     * @var string
     */
    public $receiver;

    /**
     * User sender.
     *
     * @var string
     */
    public $sender;

    /**
     * Message.
     *
     * @var Message
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($conversation, $receiver, $sender, $message)
    {
        $this->conversation = $conversation;
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->message = $message;
    }
}

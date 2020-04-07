<?php

namespace App\Events\User\Conversation;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Entity\User\Conversation\Message;

class MessageConversationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User receiving the event.
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

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'user.message.sent';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.conversation.'.$this->conversation);
    }
}

<?php

namespace App\Notifications\User;

use App\Entity\User\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PersonalMessageNotification extends Notification
{
    /**
     * @var string
     */
    private $message;
    /**
     * @var User
     */
    private $sender;
    /**
     * @var int
     */
    private $conversationId;

    public function __construct(User $sender, int $conversationId, string $message)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->conversationId = $conversationId;
    }

    public function toMail($notifiable)
    {
        $createTaskUrl = $notifiable->isExecutor() ? route('cabinet.services.create') : route('advert.order.create');

        $sender = $this->sender;

        return (new MailMessage())
            ->subject("Пользователь {$sender->getName()} отправил вам новое сообщение")
            ->view('emails.cabinet.private_message', [
                'conversationId' => $this->conversationId,
                'sender' => $sender,
                'createTaskUrl' => $createTaskUrl,
                'text' => $this->message
            ])
        ;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
}

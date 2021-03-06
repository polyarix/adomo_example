<?php

namespace App\Notifications\User;

use App\Entity\Advert\Advert\Order;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PersonalProjectNotification extends Notification
{
    /**
     * @var Order
     */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function toMail($notifiable)
    {
        $createTaskUrl = $notifiable->isExecutor() ? route('cabinet.services.create') : route('advert.order.create');

        return (new MailMessage())
            ->subject('Вам предложена работа в персональном проекте')
            ->view('emails.advert.personal_order', [
                'order' => $this->order,
                'createTaskUrl' => $createTaskUrl
            ])
        ;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
}

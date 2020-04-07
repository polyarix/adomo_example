<?php

namespace App\Notifications\User;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptOrderByCustomerNotification extends Notification
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var User
     */
    private $executor;

    public function __construct(Order $order, User $executor)
    {
        $this->order = $order;
        $this->executor = $executor;
    }

    public function toMail($notifiable)
    {
        $createTaskUrl = $notifiable->isExecutor() ? route('cabinet.services.create') : route('advert.order.create');

        return (new MailMessage())
            ->subject('Исполнитель принял вашу задачу')
            ->view('emails.advert.accept_request_order', [
                'order' => $this->order,
                'executor' => $this->executor,
                'createTaskUrl' => $createTaskUrl
            ])
        ;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
}

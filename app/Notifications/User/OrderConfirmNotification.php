<?php

namespace App\Notifications\User;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmNotification extends Notification
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var User
     */
    private $confirmedBy;

    public function __construct(Order $order, User $confirmedBy)
    {
        $this->order = $order;
        $this->confirmedBy = $confirmedBy;
    }

    public function toMail($notifiable)
    {
        $createTaskUrl = $notifiable->isExecutor() ? route('cabinet.services.create') : route('advert.order.create');

        return (new MailMessage())
            ->subject("{$this->confirmedBy->getType()} завершил задачу")
            ->view('emails.advert.confirm_order', [
                'order' => $this->order,
                'confirmedBy' => $this->confirmedBy,
                'createTaskUrl' => $createTaskUrl
            ])
        ;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
}

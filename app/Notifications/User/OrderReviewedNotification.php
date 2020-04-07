<?php

namespace App\Notifications\User;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderReviewedNotification extends Notification
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var User
     */
    private $user;

    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function toMail($notifiable)
    {
        $createTaskUrl = $notifiable->isExecutor() ? route('cabinet.services.create') : route('advert.order.create');

        return (new MailMessage())
            ->subject('Вы получили новый отзыв')
            ->view('emails.advert.reviewed_order_user', [
                'order' => $this->order,
                'user' => $this->user,
                'createTaskUrl' => $createTaskUrl
            ])
        ;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
}

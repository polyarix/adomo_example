<?php

namespace App\Listeners\User\Advert;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use App\Events\User\Advert\OrderCompleted;
use App\Events\User\Advert\RequestAccepted;
use App\Notifications\User\AcceptOrderByCustomerNotification;
use App\Notifications\User\OrderConfirmNotification;

class SendConfirmMessage
{
    public function handle(OrderCompleted $event)
    {
        /** @var Order $order */
        $order = $event->order;

        $event->notifyUser->notify(new OrderConfirmNotification($order, $event->confirmedBy));
    }
}

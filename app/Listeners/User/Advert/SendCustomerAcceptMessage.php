<?php

namespace App\Listeners\User\Advert;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use App\Events\User\Advert\RequestAccepted;
use App\Notifications\User\AcceptOrderByCustomerNotification;

class SendCustomerAcceptMessage
{
    public function handle(RequestAccepted $event)
    {
        /** @var User $user */
        $user = $event->author;
        /** @var Order $order */
        $order = $event->order;

        $user->notify(new AcceptOrderByCustomerNotification($order, $event->executor));
    }
}

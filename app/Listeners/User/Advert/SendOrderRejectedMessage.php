<?php

namespace App\Listeners\User\Advert;

use App\Entity\Advert\Advert\Order;
use App\Events\Advert\Order\OrderRejected;
use App\Notifications\User\AdvertRejectedNotification;

class SendOrderRejectedMessage
{
    public function handle(OrderRejected $event)
    {
        /** @var Order $order */
        $order = $event->order;

        $order->user->notify(new AdvertRejectedNotification($order));
    }
}

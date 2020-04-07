<?php

namespace App\Listeners\User\Advert;

use App\Entity\Advert\Advert\Order;
use App\Events\Advert\Order\OrderModerated;
use App\Notifications\User\AdvertModeratedNotification;

class SendOrderModeratedMessage
{
    public function handle(OrderModerated $event)
    {
        /** @var Order $order */
        $order = $event->order;

        $order->user->notify(new AdvertModeratedNotification($order));
    }
}

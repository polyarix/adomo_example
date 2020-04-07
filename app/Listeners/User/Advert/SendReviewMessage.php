<?php

namespace App\Listeners\User\Advert;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use App\Events\User\Advert\OrderCompleted;
use App\Events\User\Advert\RequestAccepted;
use App\Events\User\Advert\ReviewAdded;
use App\Notifications\User\AcceptOrderByCustomerNotification;
use App\Notifications\User\OrderConfirmNotification;
use App\Notifications\User\OrderReviewedNotification;

class SendReviewMessage
{
    public function handle(ReviewAdded $event)
    {
        /** @var Order $order */
        $order = $event->order;

        $event->target->notify(new OrderReviewedNotification($order, $event->user));
    }
}

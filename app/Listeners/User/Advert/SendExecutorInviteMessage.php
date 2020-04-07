<?php

namespace App\Listeners\User\Advert;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use App\Events\User\Advert\PersonalOrderCreated;
use App\Notifications\User\PersonalProjectNotification;

class SendExecutorInviteMessage
{
    public function handle(PersonalOrderCreated $event)
    {
        /** @var User $user */
        $user = $event->executor;
        /** @var Order $order */
        $order = $event->order;

        $user->notify(new PersonalProjectNotification($order));
    }
}

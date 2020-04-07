<?php

namespace App\Listeners\User\SignUp;

use App\Entity\User\User;
use App\Events\User\SignUp\UserActivated;
use App\Notifications\User\CongratsNotification;

class SendCongratsMessage
{
    public function handle(UserActivated $event)
    {
        /** @var User $user */
        $user = $event->user;
        $user->notify(new CongratsNotification());
    }
}

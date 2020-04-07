<?php

namespace App\Listeners\User\Rating;

use App\Entity\User\User;
use App\Events\User\SignUp\UserActivated;

class ActivationRatingCalculator
{
    public function handle(UserActivated $event)
    {
        /** @var User $user */
        $user = $event->user;

        $user->addRating(User::RATING_CONFIRM_CREDENTIALS_POINTS);
    }
}

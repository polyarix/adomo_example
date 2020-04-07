<?php

namespace App\Listeners\User\Rating;

use App\Entity\User\User;
use App\Events\User\Cabinet\PortfolioAlbumCreated;

class AlbumCreatedRatingCalculator
{
    public function handle(PortfolioAlbumCreated $event)
    {
        /** @var User $user */
        $user = $event->user;

        $user->addRating(User::RATING_CREATE_PORTFOLIO_ALBUM_POINTS);
    }
}

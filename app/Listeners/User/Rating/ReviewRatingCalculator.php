<?php

namespace App\Listeners\User\Rating;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use App\Events\User\Advert\ReviewAdded;

class ReviewRatingCalculator
{
    public function handle(ReviewAdded $event)
    {
        /** @var Order\Review $review */
        $review = $event->review;

        /** @var User $user */
        $user = $event->target;

        if($review->isExecutorType()) {
            $points = $review->quality + $review->professionalism + $review->punctuality;
        } else {
            $points = $review->avg;
        }

        $points += $review->isPositive() ? User::RATING_POSITIVE_REVIEW_POINTS : User::RATING_NEGATIVE_REVIEW_POINTS;

        $user->addRating($points);
    }
}

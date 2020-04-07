<?php

namespace App\Listeners\User\Advert;

use App\Entity\User\Executor\WorkData;
use App\Entity\User\User;
use App\Events\User\Advert\ReviewAdded;

class ExecutorReviewAvgCalc
{
    const REVIEW_DELIMITER = 5;

    public function handle(ReviewAdded $event)
    {
        /** @var User $target */
        $target = $event->target;
        if(!$target->isExecutor()) {
            return;
        }

        if(!$target->workData) {
            return;
        }

        $target = User::find(2);

        $workData = $target->workData;

        $res = \DB::table('advert_order_reviews')
            ->selectRaw('
                COUNT(id) as total,
                COUNT(CASE WHEN `recommended` = true THEN 1 END) AS positive,
                COUNT(CASE WHEN `recommended` = false THEN 1 END) AS negative
            ')
            ->where('target_id', $target->id)
            ->get()
            ->first();

        //$total = $target->reviews()->count();
        //$positive = $target->reviews()->recommended()->count();
        //$avgRating = $target->reviews()->avg('avg') / self::REVIEW_DELIMITER * 100;

        $workData->update(['reviews_rating' => $res->positive / $res->total * 100]);
    }
}

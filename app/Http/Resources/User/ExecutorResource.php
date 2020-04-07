<?php

namespace App\Http\Resources\User;

use App\Entity\User\Executor\WorkData;

class ExecutorResource extends UserResource
{
    public function toArray($request)
    {
        $workData = $this->workData;

        return array_merge(
            parent::toArray($request),
            [
                'team_type' => $workData ? $workData->team_type : WorkData::TYPE_INDIVIDUAL,
                'is_best_executor' => $workData ? $workData->isBestExecutor() : false
            ]
        );
    }
}

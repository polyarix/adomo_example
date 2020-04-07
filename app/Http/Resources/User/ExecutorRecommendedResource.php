<?php

namespace App\Http\Resources\User;

class ExecutorRecommendedResource extends ExecutorResource
{
    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            [
                'city' => $this->city,
                'age' => $this->getAge()
            ]
        );
    }
}

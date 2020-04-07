<?php

namespace App\Http\Resources\User\Cabinet;

use App\Entity\Advert\Advert\Order\Review;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var $this Review */
        return [
            'id' => $this->id,
            'text' => $this->text,
            'author' => new UserResource($this->user),
            'target' => $this->target,
            'advert' => $this->order,
            'type' => $this->type,
            'quality' => $this->quality,
            'professionalism' => $this->professionalism,
            'punctuality' => $this->punctuality,
            'stars' => $this->avg,
            'created_at' => $this->created_at,
        ];
    }
}

<?php

namespace App\Http\Resources\User;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'sex' => $this->sex,
            'type' => $this->type,
            'photo' => $this->photo,
            'reviews_count' => $this->reviews_count,
            'reviews_positive_percent' => $this->getPositiveReviewsPercent(),
            'rating' => $this->getRating(),
            'star_rating' => $this->getStarRating(),
            'avatar' => $this->getAvatar(),
            'has_premium' => $this->hasPremium(),
            'confirmed' => $this->isConfirmed(),
        ];
    }
}

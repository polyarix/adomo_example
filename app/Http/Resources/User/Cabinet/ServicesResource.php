<?php

namespace App\Http\Resources\User\Cabinet;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->getDescription(),
            'user_id' => $this->user_id,
            'city_id' => $this->city_id,
            'price' => $this->price,
            'price_type' => $this->price_type,
            'status' => $this->status,
            'close_reason' => $this->close_reason,
            'closed_at' => $this->closed_at,
            'moderated_at' => $this->moderated_at,
            'slug' => $this->slug,
            'views' => $this->views,
            'categories' => $this->categories,
            'photos' => $this->photos,
            'preview' => $this->getPreview(),
            'created_at' => $this->created_at,
        ];
    }
}

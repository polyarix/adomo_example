<?php

namespace App\Http\Resources\Advert;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertOffersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'price' => $this->price,
            'address' => $this->address,
            'price_type' => $this->price_type,
            'beginning_date' => $this->beginning_date,
            'map_lat' => $this->map_lat,
            'map_long' => $this->map_long,
            'house_provision' => $this->house_provision,
            'materials_provision' => $this->materials_provision,
            'status' => $this->status,
            'close_reason' => $this->close_reason,
            'created_at' => $this->created_at,
            'author' => $this->user,
            'executor' => $this->executor,
            'preview' => $this->getPreview(),
            'left_request' => $this->requests_count && $this->requests_count > 0,
            'requests' => $this->requests
        ];
    }
}

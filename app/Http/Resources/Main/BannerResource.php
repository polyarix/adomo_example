<?php

namespace App\Http\Resources\Main;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'url' => $this->url,
            'image' => $this->image
        ];
    }
}

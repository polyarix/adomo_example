<?php

namespace App\Http\Resources\User\Cabinet;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'preview' => $this->getPreview(),
            'created_at' => $this->created_at,
        ];
    }
}

<?php

namespace App\Http\Resources\User;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => nl2br(strip_tags($this->description)),
            'preview' => $this->getPreview(),
            'count' => $this->photos_count
        ];
    }
}

<?php

namespace App\Http\Resources\User\Cabinet;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'crop' => $this->crop,
            'type' => $this->type,
            'status' => $this->status,
            'reject_reason' => $this->reject_reason,
            'created_at' => $this->created_at,
        ];
    }
}

<?php

namespace App\Http\Resources\Company;

use App\Entity\User\User;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user' => new UserResource($this->user),
            'city' => $this->city,
            'logo' => $this->logo,
            'cover' => $this->cover,
            'workers_count' => $this->workers_count,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categories' => $this->categories,
        ];
    }
}

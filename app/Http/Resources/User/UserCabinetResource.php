<?php

namespace App\Http\Resources\User;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCabinetResource extends JsonResource
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
            'about' => $this->about,
            'banned_to' => $this->banned_to,
            'birth_date' => $this->birth_date,
            'email' => $this->email,
            'phone' => $this->phone,
            'city_id' => $this->city_id,
            'avatar' => $this->getAvatar(),
            'has_premium' => $this->hasPremium(),
            'confirmed' => $this->isConfirmed(),
            'phone_verified_at' => $this->phone_verified_at,
            'phone_code_expires' => $this->phone_code_expires,
            'work_data' => $this->workData ? UserWorkDataResource::make($this->workData) : [],
        ];
    }
}

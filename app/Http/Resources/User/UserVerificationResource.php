<?php

namespace App\Http\Resources\User;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserVerificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'passport_series' => $this->passport_series,
            'registration' => $this->registration,
            'criminal_record' => $this->criminal_record
        ];
    }
}

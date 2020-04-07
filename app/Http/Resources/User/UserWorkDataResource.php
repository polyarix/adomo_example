<?php

namespace App\Http\Resources\User;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWorkDataResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'about' => $this->about,
            'brigade_size' => $this->brigade_size,
            'company_name' => $this->company_name,
            'legal_type' => $this->legal_type,
            'team_type' => $this->team_type,
            'districts' => $this->districts
        ];
    }
}

<?php

namespace App\Helpers\Factory\Auth\Drivers;

class OkSocializeDriver extends AbstractDriver
{
    public function getFirstName(): ?string
    {
        return $this->response['first_name'] ?? null;
    }
    public function getLastName(): ?string
    {
        return $this->response['last_name'] ?? null;
    }
    public function getAvatar(): ?string
    {
        return $this->response['pic_3'] ?? null;
    }

    public function getScopes(): array
    {
        return ['email'];
    }
}

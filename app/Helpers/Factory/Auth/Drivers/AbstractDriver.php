<?php

namespace App\Helpers\Factory\Auth\Drivers;

use App\Helpers\Factory\Auth\SocializeInterface;
use Laravel\Socialite\Contracts\User;

abstract class AbstractDriver implements SocializeInterface
{
    /** @var array */
    protected $response;

    public function loadResponse(array $user): self
    {
        $this->response = $user;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return null;
    }

    public function getLastName(): ?string
    {
        return null;
    }

    public function getEmail(): ?string
    {
        return null;
    }

    public function getAvatar(): ?string
    {
        return null;
    }

    public function getScopes(): array
    {
        return [];
    }
}

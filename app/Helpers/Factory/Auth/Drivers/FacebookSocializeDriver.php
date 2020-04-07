<?php

namespace App\Helpers\Factory\Auth\Drivers;

class FacebookSocializeDriver extends AbstractDriver
{
    const PHOTO_TYPE = 'square';

    public function getFirstName(): ?string
    {
        @list($lastName, $firstName) = explode(' ', $this->response['name']);

        return $firstName;
    }
    public function getLastName(): ?string
    {
        @list($lastName, $firstName) = explode(' ', $this->response['name']);

        return $lastName;
    }
    public function getAvatar(): ?string
    {
        return "https://graph.facebook.com/{$this->response['id']}/picture?type=" . self::PHOTO_TYPE;
        //return $this->response['avatar'] ?? null;
    }
    public function getScopes(): array
    {
        return ['email'];
    }
}

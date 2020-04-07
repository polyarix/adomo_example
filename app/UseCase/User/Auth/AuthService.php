<?php

namespace App\UseCase\User\Auth;

use App\Entity\User\User;
use App\Service\User\Auth\UserEcho\UeSsoCipher;

class AuthService
{
    /**
     * @var UeSsoCipher
     */
    private $ueSsoCipher;
    /**
     * @var string
     */
    private $baseUrl;

    public function __construct(UeSsoCipher $ueSsoCipher, $baseUrl = 'https://%s?sso_token=%s')
    {
        $this->ueSsoCipher = $ueSsoCipher;
        $this->baseUrl = $baseUrl;
    }

    public function generateSsoToken(User $user)
    {
        $data_json = [
            'guid' 			=> $user->id,
            'display_name' 	=> $user->getName(),
            'email'			=> $user->email,
            'locale'		=> 'ru',
            'avatar_url'	=> asset($user->getAvatar()),
        ];

        return $this->ueSsoCipher->encrypt($data_json);
    }

    public function getSsoUrl(string $token)
    {
        return sprintf($this->baseUrl, config('services.userecho.host'), $token);
    }
}

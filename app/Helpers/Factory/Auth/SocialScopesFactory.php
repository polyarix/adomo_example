<?php

namespace App\Helpers\Factory\Auth;

use App\Helpers\Factory\Auth\Drivers\OkSocializeDriver;
use Illuminate\Support\Str;
use SocialiteProviders\VKontakte\Provider as VkProvider;
use SocialiteProviders\Facebook\Provider as FacebookProvider;
use SocialiteProviders\Odnoklassniki\Provider as OkProvider;
use SocialiteProviders\VKontakte\VKontakteExtendSocialite;

class SocialScopesFactory
{
    public function getInstance(string $network, $data): SocializeInterface
    {
        switch ($network) {
            case VkProvider::IDENTIFIER:
                //array_push($data, 'first_name');
                break;

            case FacebookProvider::IDENTIFIER:
                //array_push($data, 'first_name');
                break;

            case OkProvider::IDENTIFIER:
                return new OkSocializeDriver();
                break;
        }

        throw new \DomainException();
    }

    public function getScopes(?string $network = null): array
    {
        $network = Str::upper($network);

        $data = ['email'];

        switch ($network) {
            case VkProvider::IDENTIFIER:
                //array_push($data, 'first_name');
            break;

            case FacebookProvider::IDENTIFIER:
                //array_push($data, 'first_name');
            break;

            case OkProvider::IDENTIFIER:
                //array_push($data, 'first_name');
            break;
        }

        return $data;
    }
}

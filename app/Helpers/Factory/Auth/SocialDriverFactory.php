<?php

namespace App\Helpers\Factory\Auth;

use App\Helpers\Factory\Auth\Drivers\AbstractDriver;
use App\Helpers\Factory\Auth\Drivers\FacebookSocializeDriver;
use App\Helpers\Factory\Auth\Drivers\OkSocializeDriver;
use App\Helpers\Factory\Auth\Drivers\VkSocializeDriver;
use Illuminate\Support\Str;
use SocialiteProviders\VKontakte\Provider as VkProvider;
use SocialiteProviders\Facebook\Provider as FacebookProvider;
use SocialiteProviders\Odnoklassniki\Provider as OkProvider;

class SocialDriverFactory
{
    public function getInstance(string $network): AbstractDriver
    {
        $network = strtoupper($network);

        switch ($network) {
            case VkProvider::IDENTIFIER: return new VkSocializeDriver();
            case FacebookProvider::IDENTIFIER: return new FacebookSocializeDriver();
            case OkProvider::IDENTIFIER: return new OkSocializeDriver();
        }

        throw new \InvalidArgumentException('The driver is undefined.');
    }
}

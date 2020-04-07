<?php

namespace App\UseCase\User\Auth\Providers\Vk;

use SocialiteProviders\Manager\SocialiteWasCalled;

class VKontakteExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'vkontakte', __NAMESPACE__.'\Provider'
        );
    }
}

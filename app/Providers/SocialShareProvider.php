<?php

namespace App\Providers;

use App\Service\Blog\Share\SocShare;
use Illuminate\Support\ServiceProvider;

class SocialShareProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('social_share', function ($app) {
            return new SocShare();
        });
    }
}

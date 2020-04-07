<?php

namespace App\Providers;

use App\Helpers\Models\Lang\UserLang;
use App\Helpers\Models\Lang\UserLangFacade;
use App\Service\Main\Location\CityCoordinatesDetector;
use App\Service\Main\Location\CityCoordinatesDetectorInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class LangServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CityCoordinatesDetectorInterface::class, function() {
            return new CityCoordinatesDetector();
        });

        $this->app->singleton('UserLang', function (Application $app) {
            return $app->get(UserLang::class);
        });

        $this->app->alias('UserLang', UserLangFacade::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

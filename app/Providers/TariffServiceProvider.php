<?php

namespace App\Providers;

use App\Service\Tariff\TariffCrudService;
use App\Service\Tariff\TariffCrudServiceInterface;
use Illuminate\Support\ServiceProvider;

class TariffServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(TariffCrudServiceInterface::class, TariffCrudService::class);

        $this->app->bind(TariffCrudServiceInterface::class, function () {
            return new TariffCrudService();
        });
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

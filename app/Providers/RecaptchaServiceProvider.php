<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;

/**
 * Class RecaptchaServiceProvider
 * @package Huangdijia\Recaptcha
 */
class RecaptchaServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $app = $this->app;

        // v2
        $app['validator']->extend('recaptcha-v2', function ($attribute, $value, $parameters, $validator) use ($app) {
            $recaptcha = $app['recaptcha-v2']->setExpectedHostname($app['request']->getHttpHost());

            if ($parameters[0] ?? '') {
                $recaptcha->setExpectedAction($parameters[0]);
            }

            if ($parameters[1] ?? '') {
                $recaptcha->setScoreThreshold($parameters[1]);
            }

            return $recaptcha->verify($value, $app['request']->getClientIp())->isSuccess();
        });

        // v3
        $app['validator']->extend('recaptcha', function ($attribute, $value, $parameters, $validator) use ($app) {
            $host = $app['request']->getHttpHost();
            if($app['config']['recaptcha-v3.custom_host']) {
                $host = $app['config']['recaptcha-v3.custom_host'];
            }

            /** @var ReCaptcha $recaptcha */
            $recaptcha = $app['recaptcha-v3']->setExpectedHostname($host);

            if ($parameters[0] ?? '') {
                $recaptcha->setExpectedAction($parameters[0]);
            }

            if ($parameters[1] ?? '') {
                $recaptcha->setScoreThreshold($parameters[1]);
            }

            $remoteIp = null;
            if($app['config']['recaptcha-v3.ip_check_enabled']) {
                $remoteIp = $app['request']->getClientIp();
            }

            return $recaptcha->verify($value, $remoteIp)->isSuccess();
        });

        $app['validator']->extend('recaptcha-v3', function ($attribute, $value, $parameters, $validator) use ($app) {
            $recaptcha = $app['recaptcha-v3']->setExpectedHostname($app['request']->getHttpHost());

            if ($parameters[0] ?? '') {
                $recaptcha->setExpectedAction($parameters[0]);
            }

            if ($parameters[1] ?? '') {
                $recaptcha->setScoreThreshold($parameters[1]);
            }

            return $recaptcha->verify($value, $app['request']->getClientIp())->isSuccess();
        });

        // TODO fix views cache...
        $this->loadViewsFrom(__DIR__ . '/../views', 'recaptcha');

        // @recapcha_initjs(['site_key' => 'xxx', 'action' => 'action_name']);
        Blade::directive('recaptcha_initjs', function ($expression) {
            $expression = Blade::stripParentheses($expression) ?: '[]';

            return "@include('recaptcha::components.initjs', {$expression})";
        });

        // @recapcha_field(['site_key' => 'xxx', 'name' => 'input_name']);
        Blade::directive('recaptcha_field', function ($expression) {
            $expression = Blade::stripParentheses($expression) ?: '[]';

            return "@include('recaptcha::components.field', {$expression})";
        });
    }

    /**
     * Booting configure.
     */
    protected function bootConfig()
    {
        $configV3 = __DIR__ . '/../config/recaptcha-v3.php';
        $configV2 = __DIR__ . '/../config/recaptcha-v2.php';

        $this->mergeConfigFrom($configV3, 'recaptcha-v3');
        $this->mergeConfigFrom($configV2, 'recaptcha-v2');

        if ($this->app->runningInConsole()) {
            $this->publishes([$configV3 => $this->app->basePath('config/recaptcha-v3.php')], 'config');
            $this->publishes([$configV2 => $this->app->basePath('config/recaptcha-v2.php')], 'config');
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // singleton
        $this->app->singleton('recaptcha-v3', function ($app) {
            return new ReCaptcha($app['config']['recaptcha-v3.secret_key']);
        });
        $this->app->singleton('recaptcha-v2', function ($app) {
            return new ReCaptcha($app['config']['recaptcha-v2.secret_key']);
        });

        // alias
        $this->app->alias('recaptcha-v3', 'recaptcha');
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return [
            'recaptcha',
            'recaptcha-v3',
            'recaptcha-v2',
        ];
    }
}

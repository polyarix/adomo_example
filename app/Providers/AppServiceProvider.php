<?php

namespace App\Providers;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Service;
use App\Entity\Advert\Category;
use App\Entity\Blog\Comment;
use App\Entity\Contact\Contact;
use App\Entity\Location\City;
use App\Entity\User\Conversation\Broadcast;
use App\Entity\User\Conversation\Talk;
use App\Entity\User\User;
use App\Helpers\Services\Downloader\DownloaderInterface;
use App\Helpers\Services\Downloader\GuzzleDownloader;
use App\Observers\CategoryObserver;
use App\Observers\OrderObserver;
use App\Observers\ServiceObserver;
use App\Service\Main\Config\CommonConfigLoader;
use App\Service\Main\Config\SlugsLoader;
use App\Service\Main\Upload\ImageUploader;
use App\Service\Main\Upload\SimpleImageUploader;
use App\Service\Sms\EmailSender;
use App\Service\Sms\SmsSenderInterface;
use App\Service\User\Auth\UserEcho\UeSsoCipher;
use App\Service\User\ConfirmCode\CodeGeneratorInterface;
use App\Service\User\ConfirmCode\NumberCodeGenerator;
use App\UseCase\Advert\Location\CitiesService;
use App\UseCase\User\Location\LocationService;
use Carbon\Carbon;
use Elasticsearch\ClientBuilder;
use Illuminate\Foundation\Application;
use Illuminate\Mail\Mailer;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use App\UseCase\User\Conversation\ConversationRepository;
use App\UseCase\User\Conversation\MessageRepository;
use Auth;
use Jenssegers\Date\Date;
use PulkitJalan\GeoIP\GeoIP;
use YandexCheckout\Client\CurlClient;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CodeGeneratorInterface::class, function() {
            return new NumberCodeGenerator();
        });
        $this->app->bind(ImageUploader::class, function() {
            return new SimpleImageUploader();
        });

        $this->app->bind(SmsSenderInterface::class, function(Application $app) {
            return new EmailSender($app->get(Mailer::class));
        });

        $this->app->bind(DownloaderInterface::class, function(Application $app) {
            return $app->get(GuzzleDownloader::class);
        });

        $this->app->singleton('talk', function (Application $app) {
            return new Talk($app['config'], $app[Broadcast::class], $app[ConversationRepository::class], $app[MessageRepository::class]);
        });
        $this->app->alias('talk', Talk::class);

        $this->app->singleton(CommonConfigLoader::class, function() {
            return (new CommonConfigLoader())->getInstance();
        });
        $this->app->singleton(SlugsLoader::class, function() {
            return (new SlugsLoader())->getInstance();
        });

        $this->app->singleton(GeoIP::class, function() {
            return new GeoIP(config('services.ip', []));
        });

        $this->app->singleton(UeSsoCipher::class, function() {
            return new UeSsoCipher(config('services.userecho.sso_key'));
        });

        $this->app->singleton(\YandexCheckout\Client::class, function() {
            $configs = config('services.yandex_kassa');

            $client = new \YandexCheckout\Client();

            if($proxy = config('services.yandex_kassa.proxy')) {
                $apiClient = new CurlClient();
                $apiClient->setProxy($proxy);

                $client->setApiClient($apiClient);
            }

            return $client->setAuth($configs['shop_id'], $configs['secret_key']);
        });

        $this->app->singleton(\Elasticsearch\Client::class, function(Application $app) {
            $config = config('services.elasticsearch');

            return ClientBuilder::create()
                ->setHosts($config['hosts'])
                ->setRetries($config['retries'])
                ->build();
        });

        \View::composer('*sidebar_content', function (View $view) {
            $view->with('new_contact_requests', Contact::new()->count());
            $view->with('comments_on_moderation', Comment::moderation()->count());
        });

        // View composer for email main layout
        \View::composer('emails.*', function (View $view) {
            $view->with('siteUrl', 'www.adomo.com');
        });

        \View::composer('layouts.frontend', function (View $view) {
            $cities = app(CitiesService::class)->getCities();
            $detectedCityName = app(LocationService::class)->getCity();

            $view->with('city', $detectedCityName);
            $view->with('currentCity', $cities->where('name', $detectedCityName)->first());
            $view->with('cities', $cities);

            if(!Auth::check()) {
                return;
            }

            /** @var User $user */
            $user = Auth::user();

            $requestsCount = $user->isCustomer() ? $user->orders()->working()->count() : $user->performOrders()->working()->count();

            \Talk::setAuthUserId($user->id);
            $view->with('totalUnseenMessages', \Talk::getMessagesUnseenCount());
            $view->with('totalPendingRequests', $requestsCount);
        });
    }

    public function boot()
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');
        Carbon::setLocale(config('app.locale'));
        Date::setLocale('ru');

        Order::observe(OrderObserver::class);
        Service::observe(ServiceObserver::class);
        Category::observe(CategoryObserver::class);
    }
}

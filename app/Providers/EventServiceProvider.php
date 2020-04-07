<?php

namespace App\Providers;

use App\Events\Advert\Category\CategoryUpdated;
use App\Events\Advert\Category\HideCategory;
use App\Events\Advert\Category\SetVisibleCategory;
use App\Events\Advert\Order\OrderClosed;
use App\Events\Advert\Order\OrderCreated;
use App\Events\Advert\Order\OrderModerated;
use App\Events\Advert\Order\OrderOpened;
use App\Events\Advert\Order\OrderRejected;
use App\Events\Advert\Service\ServiceClosed;
use App\Events\Advert\Service\ServiceModerated;
use App\Events\Advert\Service\ServiceOpened;
use App\Events\User\Advert\OrderCompleted;
use App\Events\User\Advert\PersonalOrderCreated;
use App\Events\User\Advert\RequestAccepted;
use App\Events\User\Advert\ReviewAdded;
use App\Events\User\Cabinet\PortfolioAlbumCreated;
use App\Events\User\Conversation\PersonalDialogCreated;
use App\Events\User\Document\DocumentRejected;
use App\Events\User\Document\DocumentVerified;
use App\Events\User\SignUp\UserActivated;
use App\Listeners\Advert\Category\AddCategoryToIndex;
use App\Listeners\Advert\Category\ReindexCategory;
use App\Listeners\Advert\Order\ReindexOrder;
use App\Listeners\Advert\Category\RemoveCategoryFromIndex;
use App\Listeners\Advert\Order\AddOrderToIndex;
use App\Listeners\Advert\Order\RemoveOrderFromIndex;
use App\Listeners\Advert\Service\ReindexService;
use App\Listeners\Advert\Service\RemoveServiceFromIndex;
use App\Listeners\Main\Contact\SendAdminNotification;
use App\Listeners\User\Advert\ExecutorReviewAvgCalc;
use App\Listeners\User\Advert\SendConfirmMessage;
use App\Listeners\User\Advert\SendCustomerAcceptMessage;
use App\Listeners\User\Advert\SendExecutorInviteMessage;
use App\Listeners\User\Advert\SendOrderModeratedMessage;
use App\Listeners\User\Advert\SendOrderRejectedMessage;
use App\Listeners\User\Advert\SendReviewMessage;
use App\Listeners\User\Conversation\SendNewDialogNotification;
use App\Listeners\User\Rating\ActivationRatingCalculator;
use App\Listeners\User\Rating\AlbumCreatedRatingCalculator;
use App\Listeners\User\Rating\ReviewRatingCalculator;
use App\Listeners\User\SignUp\SendCongratsMessage;
use App\Listeners\User\Verification\SendEmailCode;
use App\UseCase\User\Auth\Providers\Vk\VKontakteExtendSocialite;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\Main\Contact\RequestCreated as ContactRequestCreated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailCode::class,
        ],
        UserActivated::class => [
            SendCongratsMessage::class,
            ActivationRatingCalculator::class,
        ],
        PortfolioAlbumCreated::class => [
            AlbumCreatedRatingCalculator::class
        ],
        OrderCreated::class => [
            // mb make notification to user about moderation - hz
        ],
        OrderModerated::class => [
            SendOrderModeratedMessage::class,
            AddOrderToIndex::class
        ],
        //OrderOpened::class => [ReindexOrder::class],
        //OrderClosed::class => [RemoveOrderFromIndex::class],
        //ServiceOpened::class => [ReindexService::class],
        //ServiceModerated::class => [ReindexService::class],
        //ServiceClosed::class => [RemoveServiceFromIndex::class],
        OrderRejected::class => [
            SendOrderRejectedMessage::class
        ],
        PersonalOrderCreated::class => [
            SendExecutorInviteMessage::class
        ],
        RequestAccepted::class => [
            SendCustomerAcceptMessage::class
        ],
        OrderCompleted::class => [
            SendConfirmMessage::class
        ],
        ReviewAdded::class => [
            SendReviewMessage::class,
            ReviewRatingCalculator::class,
            ExecutorReviewAvgCalc::class,
        ],
        ContactRequestCreated::class => [
            SendAdminNotification::class
        ],
        HideCategory::class => [
            //RemoveCategoryFromIndex::class
        ],
        SetVisibleCategory::class => [
            //AddCategoryToIndex::class
        ],
        CategoryUpdated::class => [
            //ReindexCategory::class
        ],
        PersonalDialogCreated::class => [SendNewDialogNotification::class],
        DocumentRejected::class => [

        ],
        DocumentVerified::class => [

        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            VKontakteExtendSocialite::class . '@handle',
            'SocialiteProviders\\Odnoklassniki\\OdnoklassnikiExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

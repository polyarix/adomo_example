<?php

namespace App\Providers;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Service;
use App\Entity\User\Company\Company;
use App\Entity\User\Conversation\Attachment;
use App\Entity\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();
        $this->registerPermissions();
    }

    private function registerPermissions(): void
    {
        // gate for access to admin panel
        Gate::define('admin-panel', function (User $user) {
            return $user->isAdmin() || $user->isManager();
        });
        Gate::define('administrate', function (User $user) {
            return $user->isAdmin();
        });
        // gate for actions inside admin panel
        Gate::define('moderate', function (User $user) {
            return $user->isAdmin() || $user->isManager();
        });
        Gate::define('edit-company-contacts', function (User $user, Company $company) {
            return $user->isAdmin() || $company->isOwnedBy($user);
        });
        Gate::define('edit-company-categories', function (User $user, Company $company) {
            return $user->isAdmin() || $company->isOwnedBy($user);
        });
        Gate::define('edit-company-about', function (User $user, Company $company) {
            return $user->isAdmin() || $company->isOwnedBy($user);
        });
        Gate::define('edit-company-blog', function (User $user, Company $company) {
            return $user->isAdmin() || $company->isOwnedBy($user);
        });
        Gate::define('edit-company-works', function (User $user, Company $company) {
            return $user->isAdmin() || $company->isOwnedBy($user);
        });
        Gate::define('review-order', function (User $user, Order $order) {
            return ($user->authorOf($order) || $user->isExecutorFor($order))
                && $order->isCompleted()
                && !$order->reviews()->forUser($user->id)->exists();
        });
        Gate::define('catch-up-order', function (User $user, Order $order) {
            return $user->isAdmin() || $user->authorOf($order);
        });
        Gate::define('catch-up-service', function (User $user, Service $service) {
            return $user->isAdmin() || $user->authorOfService($service);
        });
        Gate::define('show-order', function (User $user, Order $order) {
            return $user->isAdmin() || $order->user_id === $user->id || $user->id === $order->executor_id || $order->isActive();
        });
        Gate::define('show-service', function (User $user, Service $service) {
            return $user->isAdmin() || $service->user_id === $user->id;
        });
        Gate::define('offer-job', function (User $user, Service $order) {
            return $user->isCustomer();
        });
        Gate::define('edit-order', function (User $user, Order $order) {
            return $user->isAdmin() || $order->user_id === $user->id;
        });
        Gate::define('delete-order', function (User $user, Order $order) {
            return $user->isAdmin() || $order->user_id === $user->id;
        });
        Gate::define('kick-order-executor', function (User $user, Order $order) {
            return $user->isAdmin() || $order->user_id === $user->id;
        });
        Gate::define('confirm-order-execution', function (User $user, Order $order) {
            return $user->authorOf($order) || $order->ofExecutor($user);
        });
        Gate::define('change-order-visibility', function (User $user, Order $order) {
            return $user->authorOf($order);
        });
        Gate::define('review-order', function (User $user, Order $order) {
            return $order->isCompleted() && !$order->reviewedBy($user) && ($user->id === $order->user_id || $user->id === $order->executor_id);
        });
        Gate::define('show_order_coordinates', function (User $user, Order $order) {
            return $user->id === $order->user_id || $user->id === $order->executor_id;
        });
        Gate::define('show_conversation_attachments', function (User $user, Attachment $attachment) {
            return $attachment->isOwnedBy($user) || $attachment->belongsToUserConversation($user);
        });
    }
}

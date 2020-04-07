<?php

namespace App\UseCase\User\Auth;

use App\Entity\User\User;
use App\Helpers\Factory\Auth\SocialDriverFactory;
use App\Helpers\Factory\Auth\SocialScopesFactory;
use App\UseCase\User\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Contracts\User as NetworkUser;

class NetworkService
{
    /**
     * @var SocialDriverFactory
     */
    private $socialDriverFactory;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(SocialDriverFactory $socialDriverFactory, UserService $userService)
    {
        $this->socialDriverFactory = $socialDriverFactory;
        $this->userService = $userService;
    }

    public function auth(string $network, NetworkUser $data, ?string $type = null)
    {
        if ($user = User::byNetwork($network, $data->getId())->first()) {
            return $user;
        }
        if(!$type) {
            throw new \DomainException('You aren\'t registered by the network.');
        }
        if ($data->getEmail() && $user = User::where('email', $data->getEmail())->exists()) {
            throw new \DomainException('User with this email "'.$data->getEmail().'" is already exists.');
        }
        $user = DB::transaction(function () use ($network, $data, $type) {
            return User::registerByNetwork($network, $data->getId(), $type, $data->getEmail());
        });

        if($avatar = $data->getAvatar()) {
            $this->userService->uploadSocialAvatar($user, $avatar);
        }

        $factory = $this->socialDriverFactory->getInstance($network)->loadResponse($data->user);
        $user->update([
            'first_name' => $factory->getFirstName(),
            'last_name' => $factory->getLastName(),
        ]);

        event(new Registered($user));
        return $user;
    }
}

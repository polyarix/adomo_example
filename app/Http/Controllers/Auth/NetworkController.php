<?php

namespace App\Http\Controllers\Auth;

use App\Entity\User\User;
use App\Helpers\Factory\Auth\SocialScopesFactory;
use App\UseCase\User\Auth\NetworkService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\VKontakte\Provider;

class NetworkController extends Controller
{
    /**
     * @var NetworkService
     */
    private $service;
    /**
     * @var Store
     */
    private $session;

    const SESSION_TYPE_KEY = 'type';
    /**
     * @var SocialScopesFactory
     */
    private $socialScopesFactory;

    public function __construct(NetworkService $service, Store $session, SocialScopesFactory $socialScopesFactory)
    {
        $this->service = $service;
        $this->session = $session;
        $this->socialScopesFactory = $socialScopesFactory;
    }

    public function redirect(string $network, ?string $type = null)
    {
        try {
            $types = User::getTypes();
            if($type && !array_key_exists($type, $types)) {
                return redirect()->back()->with('error', 'Неизвестный тип пользователя.');
            }
            $this->session->put(self::SESSION_TYPE_KEY, $type);

            return Socialite::driver($network)->scopes($this->socialScopesFactory->getScopes($type))->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }

    public function callback(string $network)
    {
        try {
            $data = Socialite::driver($network)->user();
            $type = $this->session->get(self::SESSION_TYPE_KEY, User::TYPE_EXECUTOR);

            /** @var User $user */
            $user = $this->service->auth($network, $data, $type);
            Auth::login($user, true);

            if($user->isActive()) {
                return redirect('/');
            }
            return redirect()->route('verification.notice', '#');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }
}

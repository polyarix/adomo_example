<?php

namespace App\Http\Controllers\Auth;

use App\Entity\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\UseCase\User\Auth\AuthService;

class UserEchoController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function redirect()
    {
        /** @var \App\Entity\User\User $user */
        $user = Auth::user();

        $url = 'https://'.config('services.userecho.host');
        if($user) {
            $url = $this->authService->getSsoUrl($this->authService->generateSsoToken($user));
        }

        return redirect($url);
    }

    public function login(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if(!$user) {
            // set intended for redirect to userecho after successful login
            \Redirect::setIntendedUrl($request->fullUrl());

            return redirect()->route('login');
        }

        $token = $this->authService->generateSsoToken($user);

        return redirect($this->authService->getSsoUrl($token));
    }
}

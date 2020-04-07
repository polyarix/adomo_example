<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Http\ResponsesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers, ResponsesTrait;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $rules = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];
        if(config('recaptcha-v3.enable')) {
            $rules[config('recaptcha-v3.input_name', 'g-recaptcha-response')] = 'required|recaptcha:login';
        }

        $request->validate($rules);
    }

    protected function authenticated(Request $request, $user)
    {
        return $this->success([
            'url' => redirect()->intended()->getTargetUrl()
        ]);
    }
}


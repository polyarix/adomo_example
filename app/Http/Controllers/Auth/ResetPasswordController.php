<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Http\ResponsesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords, ResponsesTrait;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return $this->error(trans($response));
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return $this->success(['message' => trans($response)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }
}

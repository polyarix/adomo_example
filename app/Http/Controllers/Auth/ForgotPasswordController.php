<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Http\ResponsesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails, ResponsesTrait;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $this->success(['message' => trans($response)]);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return $this->error(trans($response));
    }
}

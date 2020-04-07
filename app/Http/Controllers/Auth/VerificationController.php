<?php

namespace App\Http\Controllers\Auth;

use App\Entity\Location\City;
use App\Entity\User\User;
use App\Helpers\Http\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\UseCase\User\Auth\SignUpService;
use App\UseCase\User\UserService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerifiesEmails, ResponsesTrait;

    protected $redirectTo = '/home';

    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var SignUpService
     */
    private $signUpService;

    public function __construct(UserService $userService, SignUpService $signUpService)
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->middleware('throttle:2,1')->only('resendPhone');

        $this->userService = $userService;
        $this->signUpService = $signUpService;
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('verification.phone');
        }

        $this->signUpService->sendEmailConfirmCode($user);

        return $this->success([]);
    }

    public function resendPhone(Request $request)
    {
        /** @var User $user */
        $user = \Auth::user();

        if ($user->hasVerifiedPhone()) {
            return redirect($this->redirectPath());
        }

        $this->signUpService->sendPhoneConfirmCode($user->phone, Carbon::now()->addMinutes(2));

        return $this->success([]);
    }

    // show confirm email form
    public function show(Request $request)
    {
        /** @var User $user */
        $user = \Auth::user();

        return $user->hasVerifiedEmail()
            ? redirect()->route('verification.phone')
            : view('auth.verify', ['user' => $user]);
    }

    // show confirm phone form and other user info
    public function verifyPhone()
    {
        /** @var User $user */
        $user = \Auth::user();

        /*if($user->hasFilledProfile()) {
            if($user->isExecutor()) {
                return redirect()->route('sign-up.work-data');
            }

            return redirect($this->redirectPath());
        }*/

        if(!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        $cities = City::select(['id', 'name'])->get();

        return view('auth.verify_phone', [
            'user' => $user,
            'cities' => $cities
        ]);
    }
}

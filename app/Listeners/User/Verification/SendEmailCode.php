<?php

namespace App\Listeners\User\Verification;

use App\Entity\User\User;
use App\Service\User\ConfirmCode\CodeGeneratorInterface;
use App\UseCase\User\Auth\SignUpService;
use App\UseCase\User\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailCode
{
    /**
     * @var CodeGeneratorInterface
     */
    private $codeGenerator;
    /**
     * @var SignUpService
     */
    private $signUpService;

    public function __construct(CodeGeneratorInterface $codeGenerator, SignUpService $signUpService)
    {
        $this->codeGenerator = $codeGenerator;
        $this->signUpService = $signUpService;
    }

    public function handle(Registered $event)
    {
        $user = $event->user;

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail() && $user->email) {
            /** @var User $user */
            $this->signUpService->sendEmailConfirmCode($user);
        }
    }
}

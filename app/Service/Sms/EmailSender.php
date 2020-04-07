<?php

namespace App\Service\Sms;

// for manual testing
use App\Mail\SignUp\VerifyCode;
use Illuminate\Contracts\Mail\Mailer;

class EmailSender implements SmsSenderInterface
{
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($number, string $text): void
    {
        $this->mailer
            ->to(\Auth::user()->email)
            ->send(new VerifyCode($text))
        ;
    }
}

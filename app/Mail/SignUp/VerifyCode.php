<?php

namespace App\Mail\SignUp;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyCode extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this
            ->subject('Подтверждение телефона.')
            ->markdown('emails.sign_up.verify_code')
        ;
    }
}

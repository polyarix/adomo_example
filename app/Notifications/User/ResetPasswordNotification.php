<?php

namespace App\Notifications\User;

use Illuminate\Auth\Notifications\ResetPassword as ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification  extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = route('password.reset', ['token' => $this->token, 'email' => $notifiable->email]);
        $createTaskUrl = $notifiable->isExecutor() ? route('cabinet.services.create') : route('advert.order.create');

        return (new MailMessage())
            ->subject('Восстановление пароля')
            ->view('emails.sign_up.recovery', [
                'recoveryUrl'   => $url,
                'createTaskUrl' => $createTaskUrl,
                'name'          => $notifiable->first_name
            ])
        ;
    }
}

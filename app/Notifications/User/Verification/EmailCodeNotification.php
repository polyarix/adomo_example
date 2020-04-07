<?php

namespace App\Notifications\User\Verification;

use App\Entity\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailCodeNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail(User $user)
    {
        return (new MailMessage)
            ->subject('Подтверждение почты')
            ->view('emails.sign_up.email_code', [
                'code' => $user->verification_email_code
            ])
        ;
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

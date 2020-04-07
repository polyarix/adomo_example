<?php

namespace App\Notifications\User;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CongratsNotification extends Notification
{
    public function toMail($notifiable)
    {
        $createTaskUrl = $notifiable->isExecutor() ? route('cabinet.services.create') : route('advert.order.create');

        return (new MailMessage())
            ->subject('Поздравляем с регистрацией')
            ->view('emails.sign_up.congrats', [
                'avatar'        => image_to_base64($notifiable->photo),
                'type'          => $notifiable->getType(),
                'email'         => $notifiable->email,
                'name'          => "{$notifiable->first_name} {$notifiable->last_name}",
                'createTaskUrl' => $createTaskUrl
            ])
        ;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
}

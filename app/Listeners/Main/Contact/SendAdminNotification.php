<?php

namespace App\Listeners\Main\Contact;

use App\Events\Main\Contact\RequestCreated;
use App\Mail\Main\Contact\AdminMailNotification;

class SendAdminNotification
{
    public function handle(RequestCreated $event)
    {
        $to = main_config('email_notify', config('mail.admin_email'));

        if(!$to) {
            return;
        }

        \Mail::to($to)->send(new AdminMailNotification($event->contact));
    }
}


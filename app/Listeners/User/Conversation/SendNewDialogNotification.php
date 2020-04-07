<?php

namespace App\Listeners\User\Conversation;

use App\Entity\User\User;
use App\Events\User\Conversation\PersonalDialogCreated;
use App\Notifications\User\PersonalMessageNotification;

class SendNewDialogNotification
{
    public function handle(PersonalDialogCreated $event)
    {
        $user = User::where('id', $event->receiver)->firstOrFail();

        $user->notify(new PersonalMessageNotification($user, $event->conversation, $event->message));
    }
}

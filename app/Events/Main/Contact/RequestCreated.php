<?php

namespace App\Events\Main\Contact;

use App\Entity\Contact\Contact;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Contact
     */
    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
}

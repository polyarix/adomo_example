<?php

namespace App\Mail\Main\Contact;

use App\Entity\Contact\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminMailNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Contact
     */
    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this
            ->subject('Новый запрос из контактной формы.')
            ->view('emails.main.contact.request_notification')
        ;
    }
}

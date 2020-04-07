<?php

namespace App\Mail;

use App\Entity\Contact\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactRespond extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Contact
     */
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->markdown('emails.contact.respond')->with('contact', $this->contact);
    }
}

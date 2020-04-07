<?php

namespace App\Events\User\Document;

use App\Entity\User\User;
use App\Entity\User\Verification\Document;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class DocumentVerified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public $user;
    /**
     * @var Document
     */
    public $document;

    public function __construct(User $user, Document $document)
    {
        $this->user = $user;
        $this->document = $document;
    }
}

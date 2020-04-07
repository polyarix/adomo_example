<?php

namespace App\Events\User\Advert;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PersonalOrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Order
     */
    public $order;
    /**
     * @var User
     */
    public $author;
    /**
     * @var User
     */
    public $executor;

    public function __construct(Order $order, User $author, User $executor)
    {
        $this->order = $order;
        $this->author = $author;
        $this->executor = $executor;
    }
}

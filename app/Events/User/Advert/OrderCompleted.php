<?php

namespace App\Events\User\Advert;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class OrderCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Order
     */
    public $order;
    /**
     * @var User
     */
    public $confirmedBy;
    /**
     * @var User
     */
    public $notifyUser;

    public function __construct(Order $order, User $confirmedBy, User $notifyUser)
    {
        $this->order = $order;
        $this->confirmedBy = $confirmedBy;
        $this->notifyUser = $notifyUser;
    }
}

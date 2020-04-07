<?php

namespace App\Events\User\Advert;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ReviewAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Order
     */
    public $order;
    /**
     * @var User
     */
    public $user;
    /**
     * @var User
     */
    public $target;
    /**
     * @var Order\Review
     */
    public $review;

    public function __construct(Order\Review $review, Order $order, User $user, User $target)
    {
        $this->review = $review;
        $this->order = $order;
        $this->user = $user; // user, who left the review
        $this->target = $target; // user, about who the review
    }
}

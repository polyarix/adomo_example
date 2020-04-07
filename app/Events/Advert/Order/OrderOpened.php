<?php

namespace App\Events\Advert\Order;

use App\Entity\Advert\Advert\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

// extended for use same listener for index
class OrderOpened extends OrderModerated
{
}

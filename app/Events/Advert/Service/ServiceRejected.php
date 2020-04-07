<?php

namespace App\Events\Advert\Service;

use App\Entity\Advert\Advert\Service;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ServiceRejected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Service
     */
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}

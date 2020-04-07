<?php

namespace App\Listeners\Advert\Order;

use App\Events\Advert\Order\OrderModerated;
use App\Service\Search\OrderIndexer;

class AddOrderToIndex
{
    /**
     * @var OrderIndexer
     */
    private $indexer;

    public function __construct(OrderIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

    public function handle(OrderModerated $event)
    {
        $this->indexer->index($event->order);
    }
}


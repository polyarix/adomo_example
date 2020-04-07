<?php

namespace App\Listeners\Advert\Order;

use App\Service\Search\OrderIndexer;

class RemoveOrderFromIndex
{
    /**
     * @var OrderIndexer
     */
    private $indexer;

    public function __construct(OrderIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

    public function handle($event)
    {
        $this->indexer->remove($event->order);
    }
}


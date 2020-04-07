<?php

namespace App\Listeners\Advert\Order;

use App\Service\Search\OrderIndexer;

class ReindexOrder
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
        $this->indexer->reindex($event->order);
    }
}


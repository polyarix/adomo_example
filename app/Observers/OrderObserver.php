<?php

namespace App\Observers;

use App\Entity\Advert\Advert\Order;
use App\Service\Search\OrderIndexer;

class OrderObserver
{
    /**
     * @var OrderIndexer
     */
    private $indexer;

    public function __construct(OrderIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

    public function deleted(Order $order)
    {
        $this->indexer->remove($order);
    }
}

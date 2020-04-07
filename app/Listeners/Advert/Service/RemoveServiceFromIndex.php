<?php

namespace App\Listeners\Advert\Service;

use App\Service\Search\ServiceIndexer;

class RemoveServiceFromIndex
{
    /**
     * @var ServiceIndexer
     */
    private $indexer;

    public function __construct(ServiceIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

    public function handle($event)
    {
        $this->indexer->remove($event->service);
    }
}


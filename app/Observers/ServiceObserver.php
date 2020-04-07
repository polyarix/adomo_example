<?php

namespace App\Observers;

use App\Entity\Advert\Advert\Service;
use App\Service\Search\ServiceIndexer;

class ServiceObserver
{
    /**
     * @var ServiceIndexer
     */
    private $indexer;

    public function __construct(ServiceIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

    public function deleted(Service $service)
    {
        $this->indexer->remove($service);
    }
}

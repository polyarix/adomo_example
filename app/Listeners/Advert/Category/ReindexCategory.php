<?php

namespace App\Listeners\Advert\Category;

use App\Events\Advert\Category\CategoryUpdated;
use App\Service\Search\CategoryIndexer;
use App\Service\Search\OrderIndexer;

class ReindexCategory
{
    /**
     * @var OrderIndexer
     */
    private $indexer;

    public function __construct(CategoryIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

    public function handle(CategoryUpdated $event)
    {
        $this->indexer->reindex($event->category);
    }
}


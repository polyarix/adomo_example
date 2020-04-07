<?php

namespace App\Listeners\Advert\Category;

use App\Events\Advert\Category\HideCategory;
use App\Service\Search\CategoryIndexer;
use App\Service\Search\OrderIndexer;

class RemoveCategoryFromIndex
{
    /**
     * @var OrderIndexer
     */
    private $indexer;

    public function __construct(CategoryIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

    public function handle(HideCategory $event)
    {
        $this->indexer->remove($event->category);
    }
}


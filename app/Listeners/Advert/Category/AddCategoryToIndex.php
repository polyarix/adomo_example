<?php

namespace App\Listeners\Advert\Category;

use App\Events\Advert\Category\SetVisibleCategory;
use App\Service\Search\CategoryIndexer;
use App\Service\Search\OrderIndexer;

class AddCategoryToIndex
{
    /**
     * @var OrderIndexer
     */
    private $indexer;

    public function __construct(CategoryIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

    public function handle(SetVisibleCategory $event)
    {
        $this->indexer->index($event->category);
    }
}


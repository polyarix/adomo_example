<?php

namespace App\Observers;

use App\Entity\Advert\Category;
use App\Service\Search\CategoryIndexer;

class CategoryObserver
{
    /**
     * @var CategoryIndexer
     */
    private $indexer;

    public function __construct(CategoryIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

    public function deleted(Category $category)
    {
        $this->indexer->remove($category);
    }
}

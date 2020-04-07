<?php

namespace App\Console\Commands\Search;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Service;
use App\Entity\Advert\Category;
use App\Service\Search\CategoryIndexer;
use App\Service\Search\OrderIndexer;
use App\Service\Search\ServiceIndexer;
use Illuminate\Console\Command;

class AdvertReindexCommand extends Command
{
    protected $signature = 'search:advert:reindex';
    protected $description = 'Index adverts';

    public function handle(OrderIndexer $orderIndexer, ServiceIndexer $serviceIndexer, CategoryIndexer $categoryIndexer)
    {
        $orderIndexer->clear();

        $count = 0;
        foreach(Order::displayable()->orderBy('id')->cursor() as $order) {
            $orderIndexer->index($order);
            $count++;
        }

        $this->info("Total {$count} orders were indexed.");

        $count = 0;
        foreach(Service::active()->orderBy('id')->cursor() as $service) {
            $serviceIndexer->index($service);
            $count++;
        }

        $this->info("Total {$count} services were indexed.");

        $count = 0;
        foreach(Category::visible()->orderBy('created_at')->cursor() as $category) {
            $categoryIndexer->index($category);
            $count++;
        }

        $this->info("Total {$count} categories were indexed.");
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Category;

class AdvertsSeeder extends Seeder
{
    public function run()
    {
        Category::all()->each(function (Category $category) {
            if(random_int(0, 3) === 3) {
                // skip few categories (let them to be an empty)
                return;
            }
            $category->orders()->saveMany(factory(Order::class, 40));
        });
    }
}

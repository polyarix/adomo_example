<?php

use App\Entity\Advert\Tag;
use Illuminate\Database\Seeder;

class CategoriesTagsSeeder extends Seeder
{
    public function run()
    {
        factory(Tag::class, 30)->create();
    }
}

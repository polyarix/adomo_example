<?php

use App\Entity\Advert\Tag;
use Illuminate\Database\Seeder;
use App\Entity\Advert\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        //DB::table('advert_categories')->truncate();

        $this->realCategoriesSeeder();
        //$this->fakeCategoriesSeeder();
    }

    private function realCategoriesSeeder()
    {
        $file = storage_path('app/categories.txt');
        if(!file_exists($file)) {
            return;
        }

        $categories = trim(file_get_contents($file));

        $categories = explode("\n\n", $categories);

        $data = [];

        foreach ($categories as $key => $pack) {
            $list = explode("\n", $pack);

            $parent = array_shift($list);

            $childs = [];
            if(count($list) > 0) {
                $lastCategoryIndex = 0;

                foreach ($list as $index => &$item) {
                    if(strpos($item, ' - ') !== false) {
                        $item = trim($item, ' - ');

                        $childs[$lastCategoryIndex]['children'][] = [
                            'name' => trim($item),
                            'slug' => \Illuminate\Support\Str::slug(trim($item)),
                            'is_visible' => true,
                        ];
                    } else {
                        $lastCategoryIndex++;

                        $childs[$lastCategoryIndex] = [
                            'name' => trim($item),
                            'slug' => \Illuminate\Support\Str::slug(trim($item)),
                            'is_visible' => true,
                        ];
                    }
                }
            }

            $data[] = array_filter([
                'name' => trim($parent),
                'slug' => \Illuminate\Support\Str::slug(trim($parent)),
                'is_visible' => true,
                'children' => array_values($childs)
            ]);
        }

        // TODO make rebuild of depth
        Category::rebuildTree($data);
    }

    private function fakeCategoriesSeeder()
    {
        factory(Category::class, 10)->create()->each(function(Category $category) {
            $category->tags()->saveMany(factory(Tag::class, random_int(3, 10))->create());

            $category->children()->saveMany(factory(Category::class, random_int(3, 10))->create())->each(function(Category $category) {
                $category->children()->saveMany(factory(Category::class, random_int(3, 10))->make());
            });
        });
    }
}

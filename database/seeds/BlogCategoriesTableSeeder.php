<?php

use Illuminate\Database\Seeder;

class BlogCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('blog_categories')->delete();
        
        \DB::table('blog_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Категория 1',
                'slug' => 'kategoriya-1',
                'image' => 'blog/category/b3335e0c34e26dd6e5bb4934fbdbec20.jpeg',
                'is_visible' => 1,
                'created_at' => '2020-01-08 12:56:36',
                'updated_at' => '2020-01-08 13:01:17',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Клининг',
                'slug' => 'klining',
                'image' => 'blog/category/7acd89be77a4ab6494c6bda09f186cfe.jpg',
                'is_visible' => 1,
                'created_at' => '2020-01-11 14:07:53',
                'updated_at' => '2020-01-11 14:23:08',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Животные',
                'slug' => 'zhivotnye',
                'image' => 'blog/category/fe3afd025840e017db78eb25dae4784f.jpg',
                'is_visible' => 1,
                'created_at' => '2020-01-11 14:37:39',
                'updated_at' => '2020-01-11 14:37:39',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
            ),
        ));
        
        
    }
}
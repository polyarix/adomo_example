<?php

use Illuminate\Database\Seeder;

class CategoryTagsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('category_tags')->delete();
        
        \DB::table('category_tags')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Test_teg',
                'slug' => 'test-teg',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'стройка',
                'slug' => 'stroyka',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '1',
                'slug' => '1',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'qwer',
                'slug' => 'qwer',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'azazzel',
                'slug' => 'azazzel',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '3',
                'slug' => '3',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => '4',
                'slug' => '4',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => '5',
                'slug' => '5',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => '1',
                'slug' => '1-1',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => '4',
                'slug' => '4-1',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'newone',
                'slug' => 'newone',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => '1',
                'slug' => '1-2',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => '4',
                'slug' => '4-2',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => '11',
                'slug' => '11',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'qwaqwa',
                'slug' => 'qwaqwa',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'кухня',
                'slug' => 'kuhnya',
                'breadcrumb_name' => NULL,
                'meta_title' => NULL,
                'meta_keywords' => NULL,
                'seo_text' => NULL,
                'meta_description' => NULL,
                'image' => 'tags/0ab487ae3f88fad8dbe0156686ddeb64.jpg',
            ),
        ));
        
        
    }
}
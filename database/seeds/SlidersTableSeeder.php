<?php

use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sliders')->delete();
        
        \DB::table('sliders')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'Слайдер 1',
                'title' => 'Первый сервис  для поиска специалистов',
                'image' => 'sliders/de0f0f8447f0ac4c5f5827756509e554.jpg',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
                'is_visible' => 1,
                'type' => 'main',
                'created_at' => '2019-12-26 17:09:28',
                'updated_at' => '2020-03-12 11:10:37',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'Слайдер 2',
                'title' => 'Создавайте задачи и находите лучших специалистов прямо сейчас',
                'image' => 'sliders/de769dcd155fd6c988e113d280c40554.jpg',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
                'is_visible' => 1,
                'type' => 'main',
                'created_at' => '2019-12-26 17:14:43',
                'updated_at' => '2020-03-24 13:06:24',
            ),
        ));
        
        
    }
}
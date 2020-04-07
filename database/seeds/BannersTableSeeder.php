<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('banners')->delete();
        
        \DB::table('banners')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Test',
                'image' => 'banners/315a3be08f66b0fe46ae87450ca122c8.png',
                'url' => 'http://adomo.polyarix.com',
                'views' => 135,
                'is_visible' => 1,
                'type' => 'category',
                'created_at' => '2020-01-15 16:56:37',
                'updated_at' => '2020-03-23 09:10:18',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'New 1',
                'image' => 'banners/8ab3a635dd5431af3955339318bcd420.jpg',
                'url' => 'http://polyarix.com',
                'views' => 120,
                'is_visible' => 1,
                'type' => 'category',
                'created_at' => '2020-01-16 09:09:08',
                'updated_at' => '2020-03-23 14:28:27',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Новый баннер',
                'image' => 'banners/3be38a6ae1c98626e6b1dda21fce8de4.jpg',
                'url' => 'https://www.footboom.com/',
                'views' => 82,
                'is_visible' => 1,
                'type' => 'category',
                'created_at' => '2020-02-10 16:06:23',
                'updated_at' => '2020-03-20 15:40:35',
            ),
        ));
        
        
    }
}
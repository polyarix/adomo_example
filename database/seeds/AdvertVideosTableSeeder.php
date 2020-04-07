<?php

use Illuminate\Database\Seeder;

class AdvertVideosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('advert_videos')->delete();
        
        \DB::table('advert_videos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'url' => 'Vs4GKqStOdw',
                'crop' => NULL,
                'description' => NULL,
                'morph_id' => 11,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
            ),
            1 => 
            array (
                'id' => 2,
                'url' => 'v6IhNUpSeAM',
                'crop' => NULL,
                'description' => NULL,
                'morph_id' => 15,
                'morph_type' => 'App\\Entity\\User\\Portfolio\\Album',
            ),
            2 => 
            array (
                'id' => 3,
                'url' => 'ETCZzPBNEcI',
                'crop' => NULL,
                'description' => NULL,
                'morph_id' => 12,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
            ),
            3 => 
            array (
                'id' => 4,
                'url' => 'nFWxi3zbsNo',
                'crop' => NULL,
                'description' => NULL,
                'morph_id' => 3,
                'morph_type' => 'App\\Entity\\User\\Company\\Portfolio\\Work',
            ),
            4 => 
            array (
                'id' => 5,
                'url' => 'ETCZzPBNEcI',
                'crop' => NULL,
                'description' => NULL,
                'morph_id' => 4,
                'morph_type' => 'App\\Entity\\User\\Company\\Portfolio\\Work',
            ),
            5 => 
            array (
                'id' => 6,
                'url' => '9lwYrfE6FA0',
                'crop' => NULL,
                'description' => NULL,
                'morph_id' => 14,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
            ),
            6 => 
            array (
                'id' => 7,
                'url' => 'k5sAnTTQxFA',
                'crop' => NULL,
                'description' => NULL,
                'morph_id' => 16,
                'morph_type' => 'App\\Entity\\User\\Portfolio\\Album',
            ),
            7 => 
            array (
                'id' => 8,
                'url' => 'k5sAnTTQxFA',
                'crop' => NULL,
                'description' => NULL,
                'morph_id' => 15,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
            ),
        ));
        
        
    }
}
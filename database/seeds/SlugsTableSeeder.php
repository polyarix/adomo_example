<?php

use Illuminate\Database\Seeder;

class SlugsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('slugs')->delete();
        
        \DB::table('slugs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'slug' => 'about',
                'type' => 'about_page',
                'meta' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'slug' => 'faq',
                'type' => 'faq_page',
                'meta' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'slug' => 'contacts',
                'type' => 'contacts_page',
                'meta' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}
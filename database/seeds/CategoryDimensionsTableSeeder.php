<?php

use Illuminate\Database\Seeder;

class CategoryDimensionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('category_dimensions')->delete();
        
        \DB::table('category_dimensions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'label' => 'м2',
            ),
        ));
        
        
    }
}
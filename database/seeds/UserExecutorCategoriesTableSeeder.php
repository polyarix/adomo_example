<?php

use Illuminate\Database\Seeder;

class UserExecutorCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_executor_categories')->delete();
        
        \DB::table('user_executor_categories')->insert(array (
            0 => 
            array (
                'id' => 290,
                'category_id' => 9,
                'user_id' => 65,
                'price' => NULL,
            ),
        ));
        
        
    }
}
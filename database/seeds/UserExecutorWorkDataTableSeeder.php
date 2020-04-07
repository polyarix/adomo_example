<?php

use Illuminate\Database\Seeder;

class UserExecutorWorkDataTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_executor_work_data')->delete();
        
        \DB::table('user_executor_work_data')->insert(array (
            0 => 
            array (
                'id' => 16,
                'company_name' => 'Электрод',
                'legal_type' => 'private',
                'team_type' => 'individual',
                'brigade_size' => NULL,
                'about' => 'About me / brigade info ......',
                'user_id' => 65,
                'main_city_id' => 1,
                'created_at' => '2020-03-20 09:42:52',
                'updated_at' => '2020-03-20 09:42:52',
            ),
        ));
        
        
    }
}
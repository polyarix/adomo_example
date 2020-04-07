<?php

use Illuminate\Database\Seeder;

class CompanyWorkPhotosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('company_work_photos')->delete();
        
        \DB::table('company_work_photos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'path' => 'companies/works/5e32c3fd3783a.jpeg',
                'crop' => 'companies/works/5e32c3fd3783a_crop.jpeg',
                'work_id' => 2,
            ),
            1 => 
            array (
                'id' => 2,
                'path' => 'companies/works/5e32c3ffe6544.jpeg',
                'crop' => 'companies/works/5e32c3ffe6544_crop.jpeg',
                'work_id' => 2,
            ),
            2 => 
            array (
                'id' => 3,
                'path' => 'companies/works/5e5e4aac5d8cd.jpeg',
                'crop' => 'companies/works/5e5e4aac5d8cd_crop.jpeg',
                'work_id' => 3,
            ),
            3 => 
            array (
                'id' => 4,
                'path' => 'companies/works/5e5e4ab91a8dc.jpeg',
                'crop' => 'companies/works/5e5e4ab91a8dc_crop.jpeg',
                'work_id' => 3,
            ),
            4 => 
            array (
                'id' => 5,
                'path' => 'companies/works/5e61245837d15.jpeg',
                'crop' => 'companies/works/5e61245837d15_crop.jpeg',
                'work_id' => 4,
            ),
        ));
        
        
    }
}
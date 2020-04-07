<?php

use Illuminate\Database\Seeder;

class TariffServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tariff_services')->delete();
        
        \DB::table('tariff_services')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Топ-объявление',
                'icon' => 'uploads/escobar-computer-icons-call-icon.jpg',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'поднятий в верх списка',
                'icon' => 'uploads/_318-9331.jpg',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'VIP-объявление',
                'icon' => 'uploads/images.png',
            ),
        ));
        
        
    }
}
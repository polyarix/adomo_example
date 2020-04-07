<?php

use Illuminate\Database\Seeder;

class ContactRequestsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contact_requests')->delete();
        
        \DB::table('contact_requests')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'asdfad 21234',
                'phone' => NULL,
                'email' => 'admin123121232133@admin.com',
                'text' => '897987897987897987',
                'type' => 'offer',
                'viewed' => 1,
                'status' => 'respond',
                'response_text' => 'про рщшршг лощшьт',
                'respond_at' => '2020-01-13 18:28:03',
                'created_at' => '2019-11-18 09:24:37',
                'updated_at' => '2020-01-13 17:28:03',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Тест',
            'phone' => '+3 (809) 545 45 45',
                'email' => 'fdshd@gmail.com',
                'text' => 'dhfdjhdj sodis flsk',
                'type' => 'request',
                'viewed' => 1,
                'status' => 'new',
                'response_text' => NULL,
                'respond_at' => NULL,
                'created_at' => '2020-01-11 15:41:24',
                'updated_at' => '2020-01-29 13:07:26',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Test',
                'phone' => NULL,
                'email' => 'admin@admin.com',
                'text' => 'vcbvcbvbvbvbvcbv',
                'type' => 'offer',
                'viewed' => 1,
                'status' => 'new',
                'response_text' => NULL,
                'respond_at' => NULL,
                'created_at' => '2020-01-11 15:42:00',
                'updated_at' => '2020-01-13 17:27:28',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '34asdfasfd@adsf.ru',
                'phone' => NULL,
                'email' => '34asdfasfd@adsf.ru',
                'text' => '34asdfasfd@adsf.ru',
                'type' => 'offer',
                'viewed' => 0,
                'status' => 'new',
                'response_text' => NULL,
                'respond_at' => NULL,
                'created_at' => '2020-01-28 17:02:52',
                'updated_at' => '2020-01-28 17:02:52',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Тестововый заказчик',
            'phone' => '+4 (545) 454 54 54',
                'email' => 'sladosti.nd@gmail.com',
                'text' => 'dhjfhkjfd dfkdlfk vdkfposf vfokdp vdfod[v',
                'type' => 'request',
                'viewed' => 1,
                'status' => 'respond',
                'response_text' => 'Сообщение принято.',
                'respond_at' => '2020-01-29 14:34:02',
                'created_at' => '2020-01-29 13:33:10',
                'updated_at' => '2020-01-29 13:34:02',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Натали',
                'phone' => NULL,
                'email' => 'sladosti.nd@gmail.com',
                'text' => 'djfdskfsd fsdkpasdki dsp[awdo dp;ok',
                'type' => 'offer',
                'viewed' => 1,
                'status' => 'respond',
                'response_text' => 'Hi/ I`m here',
                'respond_at' => '2020-01-29 14:35:35',
                'created_at' => '2020-01-29 13:35:02',
                'updated_at' => '2020-01-29 13:35:35',
            ),
        ));
        
        
    }
}
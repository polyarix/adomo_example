<?php

use Illuminate\Database\Seeder;

class UserNetworksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_networks')->delete();
        
        \DB::table('user_networks')->insert(array (
            0 => 
            array (
                'user_id' => 24,
                'network' => 'odnoklassniki',
                'identity' => '574049734158',
            ),
            1 => 
            array (
                'user_id' => 28,
                'network' => 'odnoklassniki',
                'identity' => '574049734158',
            ),
            2 => 
            array (
                'user_id' => 37,
                'network' => 'vkontakte',
                'identity' => '3969240',
            ),
            3 => 
            array (
                'user_id' => 38,
                'network' => 'vkontakte',
                'identity' => '500662177',
            ),
            4 => 
            array (
                'user_id' => 39,
                'network' => 'vkontakte',
                'identity' => '500662177',
            ),
            5 => 
            array (
                'user_id' => 40,
                'network' => 'vkontakte',
                'identity' => '500662177',
            ),
            6 => 
            array (
                'user_id' => 41,
                'network' => 'vkontakte',
                'identity' => '500662177',
            ),
            7 => 
            array (
                'user_id' => 42,
                'network' => 'odnoklassniki',
                'identity' => '574049734158',
            ),
            8 => 
            array (
                'user_id' => 43,
                'network' => 'vkontakte',
                'identity' => '500662177',
            ),
            9 => 
            array (
                'user_id' => 44,
                'network' => 'vkontakte',
                'identity' => '500662177',
            ),
            10 => 
            array (
                'user_id' => 45,
                'network' => 'odnoklassniki',
                'identity' => '574049734158',
            ),
            11 => 
            array (
                'user_id' => 46,
                'network' => 'vkontakte',
                'identity' => '500662177',
            ),
            12 => 
            array (
                'user_id' => 47,
                'network' => 'vkontakte',
                'identity' => '500662177',
            ),
            13 => 
            array (
                'user_id' => 48,
                'network' => 'odnoklassniki',
                'identity' => '574049734158',
            ),
            14 => 
            array (
                'user_id' => 49,
                'network' => 'vkontakte',
                'identity' => '500662177',
            ),
            15 => 
            array (
                'user_id' => 50,
                'network' => 'vkontakte',
                'identity' => '500662177',
            ),
            16 => 
            array (
                'user_id' => 52,
                'network' => 'odnoklassniki',
                'identity' => '579808183277',
            ),
            17 => 
            array (
                'user_id' => 53,
                'network' => 'facebook',
                'identity' => '925788967793723',
            ),
            18 => 
            array (
                'user_id' => 54,
                'network' => 'odnoklassniki',
                'identity' => '574049734158',
            ),
            19 => 
            array (
                'user_id' => 60,
                'network' => 'facebook',
                'identity' => '10150080023230690',
            ),
        ));
        
        
    }
}
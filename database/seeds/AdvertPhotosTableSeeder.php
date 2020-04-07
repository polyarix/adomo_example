<?php

use Illuminate\Database\Seeder;

class AdvertPhotosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('advert_photos')->delete();
        
        \DB::table('advert_photos')->insert(array (
            0 => 
            array (
                'id' => 3,
                'path' => 'items/5daed4161a77d.jpeg',
                'crop' => 'items/5daed4161a77d_crop.jpeg',
                'morph_id' => 1,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            1 => 
            array (
                'id' => 4,
                'path' => 'items/5daed4161a35c.jpeg',
                'crop' => 'items/5daed4161a35c_crop.jpeg',
                'morph_id' => 1,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            2 => 
            array (
                'id' => 5,
                'path' => 'items/5daefa728091f.jpeg',
                'crop' => 'items/5daefa728091f_crop.jpeg',
                'morph_id' => 2,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            3 => 
            array (
                'id' => 6,
                'path' => 'items/5dcd241dccbb7.jpeg',
                'crop' => 'items/5dcd241dccbb7_crop.jpeg',
                'morph_id' => 1,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-11 14:47:51',
            ),
            4 => 
            array (
                'id' => 7,
                'path' => 'items/5dcd241dd8fd1.jpeg',
                'crop' => 'items/5dcd241dd8fd1_crop.jpeg',
                'morph_id' => 1,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-11 14:47:51',
            ),
            5 => 
            array (
                'id' => 8,
                'path' => 'items/5dcd241de20e0.jpeg',
                'crop' => 'items/5dcd241de20e0_crop.jpeg',
                'morph_id' => 1,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-11 14:47:51',
            ),
            6 => 
            array (
                'id' => 9,
                'path' => 'items/5dcd241dccd14.jpeg',
                'crop' => 'items/5dcd241dccd14_crop.jpeg',
                'morph_id' => 1,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-11 14:47:51',
            ),
            7 => 
            array (
                'id' => 11,
                'path' => 'items/5dde586094360.jpeg',
                'crop' => 'items/5dde586094360_crop.jpeg',
                'morph_id' => 5,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-11 14:47:51',
            ),
            8 => 
            array (
                'id' => 21,
                'path' => 'items/5df93313c3b32.jpeg',
                'crop' => 'items/5df93313c3b32_crop.jpeg',
                'morph_id' => 6,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-11 14:47:51',
            ),
            9 => 
            array (
                'id' => 22,
                'path' => 'items/5df93319121ed.jpeg',
                'crop' => 'items/5df93319121ed_crop.jpeg',
                'morph_id' => 6,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-11 14:47:51',
            ),
            10 => 
            array (
                'id' => 23,
                'path' => 'items/5df9332358ef4.jpeg',
                'crop' => 'items/5df9332358ef4_crop.jpeg',
                'morph_id' => 6,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-11 14:47:51',
            ),
            11 => 
            array (
                'id' => 27,
                'path' => 'items/5df9dff4441cf.jpeg',
                'crop' => 'items/5df9dff4441cf_crop.jpeg',
                'morph_id' => 4,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            12 => 
            array (
                'id' => 28,
                'path' => 'items/5df9dff4afa45.jpeg',
                'crop' => 'items/5df9dff4afa45_crop.jpeg',
                'morph_id' => 4,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            13 => 
            array (
                'id' => 29,
                'path' => 'items/5df9dff4c6b84.jpeg',
                'crop' => 'items/5df9dff4c6b84_crop.jpeg',
                'morph_id' => 4,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            14 => 
            array (
                'id' => 30,
                'path' => 'items/5df9e0b20a193.jpeg',
                'crop' => 'items/5df9e0b20a193_crop.jpeg',
                'morph_id' => 5,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            15 => 
            array (
                'id' => 31,
                'path' => 'items/5df9e0b260517.jpeg',
                'crop' => 'items/5df9e0b260517_crop.jpeg',
                'morph_id' => 5,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            16 => 
            array (
                'id' => 32,
                'path' => 'items/5df9e0b27f7ee.jpeg',
                'crop' => 'items/5df9e0b27f7ee_crop.jpeg',
                'morph_id' => 5,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            17 => 
            array (
                'id' => 33,
                'path' => 'items/5dfa4f7dcd702.jpeg',
                'crop' => 'items/5dfa4f7dcd702_crop.jpeg',
                'morph_id' => 6,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            18 => 
            array (
                'id' => 34,
                'path' => 'items/5dfb3cce51543.jpeg',
                'crop' => 'items/5dfb3cce51543_crop.jpeg',
                'morph_id' => 14,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            19 => 
            array (
                'id' => 35,
                'path' => 'items/5dfb3cce51544.jpeg',
                'crop' => 'items/5dfb3cce51544_crop.jpeg',
                'morph_id' => 14,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            20 => 
            array (
                'id' => 36,
                'path' => 'items/5dfb49c089316.jpeg',
                'crop' => 'items/5dfb49c089316_crop.jpeg',
                'morph_id' => 17,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            21 => 
            array (
                'id' => 37,
                'path' => 'items/5dfb49c099558.jpeg',
                'crop' => 'items/5dfb49c099558_crop.jpeg',
                'morph_id' => 17,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            22 => 
            array (
                'id' => 38,
                'path' => 'items/5dfb49d4af550.jpeg',
                'crop' => 'items/5dfb49d4af550_crop.jpeg',
                'morph_id' => 17,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            23 => 
            array (
                'id' => 39,
                'path' => 'items/5dfe43b161366.jpeg',
                'crop' => 'items/5dfe43b161366_crop.jpeg',
                'morph_id' => 18,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            24 => 
            array (
                'id' => 40,
                'path' => 'items/5e0067e55059f.jpeg',
                'crop' => 'items/5e0067e55059f_crop.jpeg',
                'morph_id' => 19,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            25 => 
            array (
                'id' => 41,
                'path' => 'items/5e0067e5476b3.jpeg',
                'crop' => 'items/5e0067e5476b3_crop.jpeg',
                'morph_id' => 19,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            26 => 
            array (
                'id' => 42,
                'path' => 'items/5e0496c80a839.jpeg',
                'crop' => 'items/5e0496c80a839_crop.jpeg',
                'morph_id' => 20,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            27 => 
            array (
                'id' => 43,
                'path' => 'items/5e04bf41b17e8.jpeg',
                'crop' => 'items/5e04bf41b17e8_crop.jpeg',
                'morph_id' => 7,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-11 14:47:51',
            ),
            28 => 
            array (
                'id' => 44,
                'path' => 'items/5e04c535d3257.jpeg',
                'crop' => 'items/5e04c535d3257_crop.jpeg',
                'morph_id' => 21,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            29 => 
            array (
                'id' => 46,
                'path' => 'items/5e04d8cfc4952.jpeg',
                'crop' => 'items/5e04d8cfc4952_crop.jpeg',
                'morph_id' => 23,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-11 14:47:51',
            ),
            30 => 
            array (
                'id' => 47,
                'path' => 'items/5e1c81a4870d2.jpeg',
                'crop' => 'items/5e1c81a4870d2_crop.jpeg',
                'morph_id' => 26,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-13 16:41:40',
            ),
            31 => 
            array (
                'id' => 48,
                'path' => 'items/5e1de142a6090.jpeg',
                'crop' => 'items/5e1de142a6090_crop.jpeg',
                'morph_id' => 28,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-14 17:41:54',
            ),
            32 => 
            array (
                'id' => 52,
                'path' => 'items/5e1de24bd8023.jpeg',
                'crop' => 'items/5e1de24bd8023_crop.jpeg',
                'morph_id' => 28,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-14 17:46:19',
            ),
            33 => 
            array (
                'id' => 53,
                'path' => 'items/5e1de276210ba.jpeg',
                'crop' => 'items/5e1de276210ba_crop.jpeg',
                'morph_id' => 28,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-14 17:47:02',
            ),
            34 => 
            array (
                'id' => 54,
                'path' => 'items/5e1de2922d37a.jpeg',
                'crop' => 'items/5e1de2922d37a_crop.jpeg',
                'morph_id' => 28,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-14 17:47:30',
            ),
            35 => 
            array (
                'id' => 69,
                'path' => 'items/5e2040be25db2.jpeg',
                'crop' => 'items/5e2040be25db2_crop.jpeg',
                'morph_id' => 8,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-16 12:53:50',
            ),
            36 => 
            array (
                'id' => 71,
                'path' => 'items/5e297ab926d4a.png',
                'crop' => 'items/5e297ab926d4a_crop.png',
                'morph_id' => 29,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-23 12:51:37',
            ),
            37 => 
            array (
                'id' => 72,
                'path' => 'items/5e2eab5311e95.png',
                'crop' => 'items/5e2eab5311e95_crop.png',
                'morph_id' => 30,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-27 11:20:19',
            ),
            38 => 
            array (
                'id' => 73,
                'path' => 'items/5e301620c6a68.jpeg',
                'crop' => 'items/5e301620c6a68_crop.jpeg',
                'morph_id' => 31,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-28 13:08:16',
            ),
            39 => 
            array (
                'id' => 75,
                'path' => 'items/5e302253ed8ed.jpeg',
                'crop' => 'items/5e302253ed8ed_crop.jpeg',
                'morph_id' => 32,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-01-28 14:00:19',
            ),
            40 => 
            array (
                'id' => 76,
                'path' => 'items/5e302d0abdb5c.jpeg',
                'crop' => 'items/5e302d0abdb5c_crop.jpeg',
                'morph_id' => 9,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-01-28 14:46:02',
            ),
            41 => 
            array (
                'id' => 81,
                'path' => 'items/5e41793bc2b91.jpeg',
                'crop' => 'items/5e41793bc2b91_crop.jpeg',
                'morph_id' => 35,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-02-10 17:39:40',
            ),
            42 => 
            array (
                'id' => 84,
                'path' => 'items/5e428009d9ccc.jpeg',
                'crop' => 'items/5e428009d9ccc_crop.jpeg',
                'morph_id' => 10,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-02-11 12:20:58',
            ),
            43 => 
            array (
                'id' => 85,
                'path' => 'items/5e42800da1120.jpeg',
                'crop' => 'items/5e42800da1120_crop.jpeg',
                'morph_id' => 10,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-02-11 12:21:01',
            ),
            44 => 
            array (
                'id' => 86,
                'path' => 'items/5e440691bc75d.jpeg',
                'crop' => 'items/5e440691bc75d_crop.jpeg',
                'morph_id' => 11,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-02-12 16:07:13',
            ),
            45 => 
            array (
                'id' => 87,
                'path' => 'items/5e4412ae9c079.jpeg',
                'crop' => 'items/5e4412ae9c079_crop.jpeg',
                'morph_id' => 12,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-02-12 16:58:54',
            ),
            46 => 
            array (
                'id' => 92,
                'path' => 'items/5e5397436b648.jpeg',
                'crop' => 'items/5e5397436b648_crop.jpeg',
                'morph_id' => 13,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-02-24 11:28:35',
            ),
            47 => 
            array (
                'id' => 93,
                'path' => 'items/5e53974b7aa85.jpeg',
                'crop' => 'items/5e53974b7aa85_crop.jpeg',
                'morph_id' => 13,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-02-24 11:28:43',
            ),
            48 => 
            array (
                'id' => 94,
                'path' => 'items/5e53974beae34.jpeg',
                'crop' => 'items/5e53974beae34_crop.jpeg',
                'morph_id' => 13,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-02-24 11:28:44',
            ),
            49 => 
            array (
                'id' => 95,
                'path' => 'items/5e622b68a0c0b.jpeg',
                'crop' => 'items/5e622b68a0c0b_crop.jpeg',
                'morph_id' => 37,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-03-06 12:52:24',
            ),
            50 => 
            array (
                'id' => 96,
                'path' => 'items/5e622b6b917fb.png',
                'crop' => 'items/5e622b6b917fb_crop.png',
                'morph_id' => 37,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-03-06 12:52:27',
            ),
            51 => 
            array (
                'id' => 97,
                'path' => 'items/5e622b76a800a.png',
                'crop' => 'items/5e622b76a800a_crop.png',
                'morph_id' => 37,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-03-06 12:52:38',
            ),
            52 => 
            array (
                'id' => 98,
                'path' => 'items/5e622b76a7178.png',
                'crop' => 'items/5e622b76a7178_crop.png',
                'morph_id' => 37,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-03-06 12:52:38',
            ),
            53 => 
            array (
                'id' => 99,
                'path' => 'advs/5e6b2c35c3e3a.png',
                'crop' => 'advs/5e6b2c35c3e3a_crop.png',
                'morph_id' => 38,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-03-13 08:46:14',
            ),
            54 => 
            array (
                'id' => 100,
                'path' => 'advs/5e6b64650e3f5.png',
                'crop' => 'advs/5e6b64650e3f5_crop.png',
                'morph_id' => 39,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-03-13 12:45:57',
            ),
            55 => 
            array (
                'id' => 101,
                'path' => 'advs/5e6b64650c64f.png',
                'crop' => 'advs/5e6b64650c64f_crop.png',
                'morph_id' => 39,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-03-13 12:45:57',
            ),
            56 => 
            array (
                'id' => 102,
                'path' => 'advs/5e6b646518419.png',
                'crop' => 'advs/5e6b646518419_crop.png',
                'morph_id' => 39,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-03-13 12:45:57',
            ),
            57 => 
            array (
                'id' => 103,
                'path' => 'advs/5e6b646532eed.png',
                'crop' => 'advs/5e6b646532eed_crop.png',
                'morph_id' => 39,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-03-13 12:45:57',
            ),
            58 => 
            array (
                'id' => 108,
                'path' => 'advs/5e6f3f0c7f24a.jpeg',
                'crop' => 'advs/5e6f3f0c7f24a_crop.jpeg',
                'morph_id' => 40,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Order',
                'created_at' => '2020-03-16 10:55:40',
            ),
            59 => 
            array (
                'id' => 109,
                'path' => 'advs/5e6f8a151d4e5.png',
                'crop' => 'advs/5e6f8a151d4e5_crop.png',
                'morph_id' => NULL,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-03-16 16:15:49',
            ),
            60 => 
            array (
                'id' => 110,
                'path' => 'advs/5e71dc5262331.png',
                'crop' => 'advs/5e71dc5262331_crop.png',
                'morph_id' => 14,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-03-18 10:31:14',
            ),
            61 => 
            array (
                'id' => 111,
                'path' => 'advs/5e74e714bb300.png',
                'crop' => 'advs/5e74e714bb300_crop.png',
                'morph_id' => 15,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-03-20 17:53:57',
            ),
            62 => 
            array (
                'id' => 112,
                'path' => 'advs/5e79d7194fbed.png',
                'crop' => 'advs/5e79d7194fbed_crop.png',
                'morph_id' => 16,
                'morph_type' => 'App\\Entity\\Advert\\Advert\\Service',
                'created_at' => '2020-03-24 11:47:05',
            ),
        ));
        
        
    }
}
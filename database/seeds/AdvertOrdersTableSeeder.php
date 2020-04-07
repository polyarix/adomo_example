<?php

use App\Entity\Advert\Advert\Order;
use Illuminate\Database\Seeder;

class AdvertOrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table((new Order())->getTable())->delete();
        
        \DB::table((new Order())->getTable())->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Тестовое задание для питерских',
                'description' => 'Тестовое задание для питерских\nТестовое задание для питерских\nТестовое задание для питерских',
                'category_id' => 7,
                'user_id' => 1,
                'city_id' => 3,
                'price' => 700,
                'price_type' => 'specific',
                'time_type' => 'any',
                'address' => 'street addres 1, street addres 2',
                'beginning_date' => null,
                'map_address' => null,
                'map_lat' => NULL,
                'map_long' => null,
                'house_provision' => 1,
                'materials_provision' => 1,
                'status' => Order::STATUS_ACTIVE,
                'close_reason' => null,
                'closed_at' => null,
                'moderated_at' => NULL,
                'created_at' => '2020-03-27 17:17:28',
                'updated_at' => '2020-03-27 17:17:28',
                'slug' => 'russkiy-taytl',
                'meta_title' => NULL,
                'meta_description' => NULL,
                'meta_keywords' => NULL,
                'executor_id' => NULL,
                'tyme_type' => 'any',
                'is_visible' => 1,
                'catched_up_at' => NULL,
                'catched_up_to' => NULL,
                'comment' => NULL,
                'district_id' => NULL,
            ),
            1 =>
                array (
                    'id' => 2,
                    'title' => 'Подчинка крана',
                    'description' => 'Barbatus galluss ducunt ad fraticinida.Ho-ho-ho! treasure of beauty.',
                    'category_id' => 10,
                    'user_id' => 1,
                    'city_id' => 3,
                    'price' => 700,
                    'price_type' => 'specific',
                    'time_type' => 'any',
                    'address' => 'street addres 1, street addres 2',
                    'beginning_date' => null,
                    'map_address' => null,
                    'map_lat' => NULL,
                    'map_long' => null,
                    'house_provision' => 1,
                    'materials_provision' => 1,
                    'status' => Order::STATUS_ACTIVE,
                    'close_reason' => null,
                    'closed_at' => null,
                    'moderated_at' => NULL,
                    'created_at' => '2020-03-27 17:17:28',
                    'updated_at' => '2020-03-27 17:17:28',
                    'slug' => 'russkiy-taytl1',
                    'meta_title' => NULL,
                    'meta_description' => NULL,
                    'meta_keywords' => NULL,
                    'executor_id' => NULL,
                    'tyme_type' => 'any',
                    'is_visible' => 1,
                    'catched_up_at' => NULL,
                    'catched_up_to' => NULL,
                    'comment' => NULL,
                    'district_id' => NULL,
                ),
            2 =>
                array (
                    'id' => 3,
                    'title' => 'When one loves surrender and dimension, one is able to discover faith.',
                    'description' => 'For a grey mild stir-fry, add some emeril\'s essence and oregano.',
                    'category_id' => 11,
                    'user_id' => 1,
                    'city_id' => 3,
                    'price' => 700,
                    'price_type' => 'specific',
                    'time_type' => 'any',
                    'address' => 'street addres 1, street addres 2',
                    'beginning_date' => null,
                    'map_address' => null,
                    'map_lat' => NULL,
                    'map_long' => null,
                    'house_provision' => 1,
                    'materials_provision' => 1,
                    'status' => Order::STATUS_MODERATION,
                    'close_reason' => null,
                    'closed_at' => null,
                    'moderated_at' => NULL,
                    'created_at' => '2020-03-27 17:17:28',
                    'updated_at' => '2020-03-27 17:17:28',
                    'slug' => 'russkiy-taytl11',
                    'meta_title' => NULL,
                    'meta_description' => NULL,
                    'meta_keywords' => NULL,
                    'executor_id' => NULL,
                    'tyme_type' => 'any',
                    'is_visible' => 1,
                    'catched_up_at' => NULL,
                    'catched_up_to' => NULL,
                    'comment' => NULL,
                    'district_id' => NULL,
                ),
        ));
        
        
    }
}
<?php

use App\Entity\Advert\Advert\Service;
use Illuminate\Database\Seeder;

class AdvertServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table((new Service())->getTable())->delete();
        
        \DB::table((new Service())->getTable())->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Тестовое задание для питерских',
                'description' => 'Тестовое задание для питерских\nТестовое задание для питерских\nТестовое задание для питерских',

                'user_id' => 1,
                'city_id' => 3,
                'price' => 700,
                'price_type' => 'specific',
                'status' => Service::STATUS_ACTIVE,
                'close_reason' => null,
                'closed_at' => null,
                'moderated_at' => NULL,
                'created_at' => '2020-03-27 17:17:28',
                'updated_at' => '2020-03-27 17:17:28',
                'slug' => 'russkiy-taytl',
                'meta_title' => NULL,
                'meta_description' => NULL,
                'meta_keywords' => NULL,
                'catched_up_at' => NULL,
                'catched_up_to' => NULL,
            ),
            1 =>
                array (
                    'id' => 2,
                    'title' => 'Apostolic sex studies most arts.',
                    'description' => 'Nobilis, secundus extums solite convertam de domesticus, pius byssus. ',
                    'user_id' => 1,
                    'city_id' => 3,
                    'price' => 700,
                    'price_type' => 'specific',
                    'status' => Service::STATUS_CLOSED,
                    'close_reason' => null,
                    'closed_at' => null,
                    'moderated_at' => NULL,
                    'created_at' => '2020-03-27 17:17:28',
                    'updated_at' => '2020-03-27 17:17:28',
                    'slug' => 'russkiy-tayt2l',
                    'meta_title' => NULL,
                    'meta_description' => NULL,
                    'meta_keywords' => NULL,
                    'catched_up_at' => NULL,
                    'catched_up_to' => NULL,
                ),
            2 =>
                array (
                    'id' => 3,
                    'title' => 'Pars, heuretes, et accentor. ',
                    'description' => 'Rumour at the solar sphere that is when modern ships die. ',
                    'user_id' => 1,
                    'city_id' => 3,
                    'price' => 700,
                    'price_type' => 'specific',
                    'status' => Service::STATUS_MODERATION,
                    'close_reason' => null,
                    'closed_at' => null,
                    'moderated_at' => NULL,
                    'created_at' => '2020-03-27 17:17:28',
                    'updated_at' => '2020-03-27 17:17:28',
                    'slug' => 'russkiy-tayt3l',
                    'meta_title' => NULL,
                    'meta_description' => NULL,
                    'meta_keywords' => NULL,
                    'catched_up_at' => NULL,
                    'catched_up_to' => NULL,
                ),
            3 =>
                array (
                    'id' => 4,
                    'title' => 'Lasses are the pants of the fine treasure.',
                    'description' => 'Not nirvana or chaos, synthesise the uniqueness.',
                    'user_id' => 1,
                    'city_id' => 3,
                    'price' => 700,
                    'price_type' => 'specific',
                    'status' => Service::STATUS_EXPIRED,
                    'close_reason' => null,
                    'closed_at' => null,
                    'moderated_at' => NULL,
                    'created_at' => '2020-03-27 17:17:28',
                    'updated_at' => '2020-03-27 17:17:28',
                    'slug' => 'russkiy-taytl4',
                    'meta_title' => NULL,
                    'meta_description' => NULL,
                    'meta_keywords' => NULL,
                    'catched_up_at' => NULL,
                    'catched_up_to' => NULL,
                ),
            4 =>
                array (
                    'id' => 5,
                    'title' => 'Varnish the seaweed with chilled baking powder, woodruff, green curry, and pepper making sure to cover all of it.',
                    'description' => 'The pegleg desires with punishment, rob the galley until it laughs.',
                    'user_id' => 1,
                    'city_id' => 3,
                    'price' => 700,
                    'price_type' => 'specific',
                    'status' => Service::STATUS_ACTIVE,
                    'close_reason' => null,
                    'closed_at' => null,
                    'moderated_at' => NULL,
                    'created_at' => '2020-03-27 17:17:28',
                    'updated_at' => '2020-03-27 17:17:28',
                    'slug' => 'russkiy-tayt33l',
                    'meta_title' => NULL,
                    'meta_description' => NULL,
                    'meta_keywords' => NULL,
                    'catched_up_at' => NULL,
                    'catched_up_to' => NULL,
                ),
        ));
        
        
    }
}
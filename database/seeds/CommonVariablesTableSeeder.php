<?php

use Illuminate\Database\Seeder;

class CommonVariablesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('common_variables')->delete();
        
        \DB::table('common_variables')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Телефон 1',
                'key' => 'phone1',
            'value' => '8 (800) 333-16-70',
                'type' => 'common',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Телефон 2',
                'key' => 'phone2',
            'value' => '8 (800) 500-77-00',
                'type' => 'common',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Email',
                'key' => 'email',
                'value' => 'info@adomo.ru',
                'type' => 'common',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Email для уведомлений',
                'key' => 'email_notify',
                'value' => 'admin@admin.com',
                'type' => 'common',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'VK ссылка',
                'key' => 'vk_url',
                'value' => 'https://vk.com/',
                'type' => 'common',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Facebook ссылка',
                'key' => 'facebook_url',
                'value' => 'https://facebook.com',
                'type' => 'common',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'OK ссылка',
                'key' => 'ok_url',
                'value' => 'https://ok.ru/',
                'type' => 'common',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Заголовок блока 1',
                'key' => 'main_1_title',
                'value' => 'Мы освободим вам время в поиске строительных услуг',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Текст блока 1',
                'key' => 'main_1_text',
                'value' => 'Вам нужно сделать натяжной потолок, поставить межкомнатные двери или сделать ремонт квартиры под ключ? На ADOMO.ru найдутся мастера для выполнения любой задачи!

Регистрируйтесь на сайте ADOMO.ru и все мастера станут доступны онлайн. Смотрите портфолио, читайте отзывы, выбирайте мастера и договаривайтесь о цене не выходя из дома!

ADOMO.ru – первая и единственная строительно-ремонтная и бытовая онлайн биржа с представленным функционалом в Улан-Удэ! С такими возможностями вы сэкономите массу времени и нервов.',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Счётчик посетителей в день',
                'key' => 'main_1_count',
                'value' => '100500',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Фоновая картинка',
                'key' => 'main_1_bg',
                'value' => '/images/section-3-bg.jpg',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Заголовок блока 1',
                'key' => 'main_2_1_title',
                'value' => 'Автоподбор мастера',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Текст блока 1',
                'key' => 'main_2_1_text',
                'value' => 'Выбор исполнителя может занять немало времени. ADOMO.ru поможет вам упростить эту задачу, просто воспользуйтесь услугой!',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Иконка блока 1',
                'key' => 'main_2_1_image',
                'value' => '/images/advantages-icon-1.svg',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Текст кнопки 1',
                'key' => 'main_2_1_button',
                'value' => 'Подобрать автоматически',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Заголовок блока 2',
                'key' => 'main_2_2_title',
                'value' => 'Онлайн оплата',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Текст блока 2',
                'key' => 'main_2_2_text',
                'value' => 'Дополнительные услуги на сайте ADOMO.ru вы можете оплатить онлайн, быстро и не выходя из дома.',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Иконка блока 2',
                'key' => 'main_2_2_image',
                'value' => '/images/advantages-icon-2-1.svg',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Заголовок блока 3',
                'key' => 'main_2_3_title',
                'value' => 'Честный рейтинг',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Текст блока 3',
                'key' => 'main_2_3_text',
                'value' => 'На нашем сайте можно оставить отзыв или поставить оценку только после выполнения согласованных работ.',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Иконка блока 3',
                'key' => 'main_2_3_image',
                'value' => '/images/advantages-icon-2-2.svg',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Заголовок блока 3',
                'key' => 'main_2_4_title',
                'value' => 'Обратная связь',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Текст блока 3',
                'key' => 'main_2_4_text',
                'value' => 'Благодаря вашей обратной связи, мы постоянно улучшаем наш сервис. Напишите ваши пожелания и мы обязательно их учтем.',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Иконка блока 3',
                'key' => 'main_2_4_image',
                'value' => '/images/advantages-icon-3.svg',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Текст кнопки 3',
                'key' => 'main_2_4_button',
                'value' => 'Предложить улучшение',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Заголовок блока 3',
                'key' => 'main_3_title',
                'value' => 'Уникальная услуга “Технадзор”',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Текст юлока 3',
                'key' => 'main_3_text',
                'value' => 'На нашем сервисе вы можете воспользоваться услугой ТЕХНАДЗОР. Она предназначена для тех, кто не разбирается в стройке и ремонте или для тех, у кого нет времени контролировать работу. Таким образом, вы можете заказать услуги профессионала, который проконтролирует работу ваших мастеров на разных этапах. Если что-то пойдет не так, то это будет отражено в акте технадзора и вашим мастерам придется исправлять недочеты.',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Преимущества',
                'key' => 'main_3_benefits',
                'value' => 'Качественное выполнение работ

Честная стоимость материалов

Экономия вашего времени

Официальная документация',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Фоновая картинка',
                'key' => 'main_3_bg',
                'value' => '/images/section-5-bg.jpg',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Meta title',
                'key' => 'main_meta_title',
                'value' => '',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Meta description',
                'key' => 'main_meta_description',
                'value' => '',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Meta keywords',
                'key' => 'main_meta_keywords',
                'value' => '',
                'type' => 'main_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Верхняя надпись',
                'key' => 'about_label',
                'value' => 'О ПРОЕКТЕ',
                'type' => 'about_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Заголовок',
                'key' => 'about_title',
                'value' => 'Adomo.com',
                'type' => 'about_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Текст',
                'key' => 'about_text',
                'value' => 'Онлайн сервис поиска частных специалистов',
                'type' => 'about_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Фоновая картинка',
                'key' => 'about_bg',
                'value' => '/images/about-head.jpg',
                'type' => 'about_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Текст над счётчиком',
                'key' => 'about_top_text',
                'value' => '<h2>Что мы делаем?</h2>
<p>Adomo.com - онлайн сервис поиска частных специалистов для решения бытовых и бизнес задач. Площадка объединяет заказчиков услуг, которым необходимо выполнить какую-либо работу, и компетентных исполнителей, ищущих подработку или дополнительный заработок.</p>
<h2>Наша команда</h2>
<p>Все мы - разные. Каждый из нас занимается своей работой. Мы любим разную пиццу и смотрим разные фильмы. Мы выросли в разных городах и в разное время, но все сталкивались с одной и той же проблемой - ужасным сервисом в сфере услуг.</p>',
                'type' => 'about_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Текст под счётчиком',
                'key' => 'about_bottom_text',
                'value' => '<h2>Наша миссия</h2>
<p>Мы хотим помочь решить любую задачу и освободить вам время для семьи или друзей. Мы хотим дать работу миллиону компетентных и ответственных специалистов и развивать предпринимательство в головах украинцев. Это наша главная миссия и мысль, с которой мы просыпаемся каждое утро.</p>',
                'type' => 'about_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Заголовок нижнего блока',
                'key' => 'about_action_title',
                'value' => 'Найдите исполнителя или выполняйте задания на Adomo.com',
                'type' => 'about_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Meta title',
                'key' => 'about_meta_title',
                'value' => '',
                'type' => 'about_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Meta description',
                'key' => 'about_meta_description',
                'value' => '',
                'type' => 'about_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Meta keywords',
                'key' => 'about_meta_keywords',
                'value' => '',
                'type' => 'about_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Заголовок контактов',
                'key' => 'contacts_title',
                'value' => 'Контакты',
                'type' => 'contacts_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Текст контактов',
                'key' => 'contacts_text',
                'value' => 'Если у вас есть вопросы о работе сервиса, кратко опишите ситуацию в форме или используйте для связи наши контакты.
Мы окажем консультацию',
                'type' => 'contacts_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Заголовок формы предложений',
                'key' => 'contacts_title_advices',
                'value' => 'Предложения об улучшении сервиса ADOMO.ru',
                'type' => 'contacts_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Meta title',
                'key' => 'contacts_meta_title',
                'value' => '',
                'type' => 'contacts_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Meta description',
                'key' => 'contacts_meta_description',
                'value' => '',
                'type' => 'contacts_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Meta keywords',
                'key' => 'contacts_meta_keywords',
                'value' => '',
                'type' => 'contacts_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'Хлебная крошка контактов',
                'key' => 'faq_breadcrumb',
                'value' => 'Часто задаваемые вопросы',
                'type' => 'faq_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Заголовок FAQ',
                'key' => 'faq_title',
                'value' => 'Часто задаваемые вопросы',
                'type' => 'faq_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Текст FAQ',
                'key' => 'faq_text',
                'value' => 'Часто задаваемые вопросы',
                'type' => 'faq_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Meta title',
                'key' => 'faq_meta_title',
                'value' => '',
                'type' => 'faq_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Meta description',
                'key' => 'faq_meta_description',
                'value' => '',
                'type' => 'faq_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Meta keywords',
                'key' => 'faq_meta_keywords',
                'value' => '',
                'type' => 'faq_page',
                'created_at' => '2020-03-24 12:09:37',
                'updated_at' => '2020-03-24 12:09:37',
            ),
        ));
        
        
    }
}
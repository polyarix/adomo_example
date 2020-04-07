<?php

use App\Entity\Common\Variable;
use Illuminate\Database\Seeder;

class VariablesTableSeeder extends Seeder
{
    protected $commonData = [
        'phone1' => ['value' => '8 (800) 333-16-70', 'name' => 'Телефон 1'],
        'phone2' => ['value' => '8 (800) 500-77-00', 'name' => 'Телефон 2'],
        'email' => ['value' => 'info@adomo.ru', 'name' => 'Email'],
        'email_notify' => ['value' => 'admin@admin.com', 'name' => 'Email для уведомлений'],
        'vk_url' => ['value' => 'https://vk.com/', 'name' => 'VK ссылка'],
        'facebook_url' => ['value' => 'https://facebook.com', 'name' => 'Facebook ссылка'],
        'ok_url' => ['value' => 'https://ok.ru/', 'name' => 'OK ссылка'],
    ];

    protected $mainPageData = [
        'main_1_title' => ['value' => 'Мы освободим вам время в поиске строительных услуг', 'name' => 'Заголовок блока 1'],
        'main_1_text' => ['value' => 'Вам нужно сделать натяжной потолок, поставить межкомнатные двери или сделать ремонт квартиры под ключ? На ADOMO.ru найдутся мастера для выполнения любой задачи!

Регистрируйтесь на сайте ADOMO.ru и все мастера станут доступны онлайн. Смотрите портфолио, читайте отзывы, выбирайте мастера и договаривайтесь о цене не выходя из дома!

ADOMO.ru – первая и единственная строительно-ремонтная и бытовая онлайн биржа с представленным функционалом в Улан-Удэ! С такими возможностями вы сэкономите массу времени и нервов.', 'name' => 'Текст блока 1'],
        'main_1_count' => ['value' => '100500', 'name' => 'Счётчик посетителей в день'],
        'main_1_bg' => ['value' => '/images/section-3-bg.jpg', 'name' => 'Фоновая картинка'],

        // section 2
        'main_2_1_title' => ['value' => 'Автоподбор мастера', 'name' => 'Заголовок блока 1'],
        'main_2_1_text' => ['value' => 'Выбор исполнителя может занять немало времени. ADOMO.ru поможет вам упростить эту задачу, просто воспользуйтесь услугой!', 'name' => 'Текст блока 1'],
        'main_2_1_image' => ['value' => '/images/advantages-icon-1.svg', 'name' => 'Иконка блока 1'],
        'main_2_1_button' => ['value' => 'Подобрать автоматически', 'name' => 'Текст кнопки 1'],

        'main_2_2_title' => ['value' => 'Онлайн оплата', 'name' => 'Заголовок блока 2'],
        'main_2_2_text' => ['value' => 'Дополнительные услуги на сайте ADOMO.ru вы можете оплатить онлайн, быстро и не выходя из дома.', 'name' => 'Текст блока 2'],
        'main_2_2_image' => ['value' => '/images/advantages-icon-2-1.svg', 'name' => 'Иконка блока 2'],

        'main_2_3_title' => ['value' => 'Честный рейтинг', 'name' => 'Заголовок блока 3'],
        'main_2_3_text' => ['value' => 'На нашем сайте можно оставить отзыв или поставить оценку только после выполнения согласованных работ.', 'name' => 'Текст блока 3'],
        'main_2_3_image' => ['value' => '/images/advantages-icon-2-2.svg', 'name' => 'Иконка блока 3'],

        'main_2_4_title' => ['value' => 'Обратная связь', 'name' => 'Заголовок блока 3'],
        'main_2_4_text' => ['value' => 'Благодаря вашей обратной связи, мы постоянно улучшаем наш сервис. Напишите ваши пожелания и мы обязательно их учтем.', 'name' => 'Текст блока 3'],
        'main_2_4_image' => ['value' => '/images/advantages-icon-3.svg', 'name' => 'Иконка блока 3'],
        'main_2_4_button' => ['value' => 'Предложить улучшение', 'name' => 'Текст кнопки 3'],

        //section 3
        'main_3_title' => ['value' => 'Уникальная услуга “Технадзор”', 'name' => 'Заголовок блока 3'],
        'main_3_text' => ['value' => 'На нашем сервисе вы можете воспользоваться услугой ТЕХНАДЗОР. Она предназначена для тех, кто не разбирается в стройке и ремонте или для тех, у кого нет времени контролировать работу. Таким образом, вы можете заказать услуги профессионала, который проконтролирует работу ваших мастеров на разных этапах. Если что-то пойдет не так, то это будет отражено в акте технадзора и вашим мастерам придется исправлять недочеты.', 'name' => 'Текст юлока 3'],
        'main_3_benefits' => ['value' => "Качественное выполнение работ\n
Честная стоимость материалов\n
Экономия вашего времени\n
Официальная документация", 'name' => "Преимущества"],
        'main_3_bg' => ['value' => '/images/section-5-bg.jpg', 'name' => 'Фоновая картинка'],

        'main_meta_title' => ['value' => '', 'name' => 'Meta title'],
        'main_meta_description' => ['value' => '', 'name' => 'Meta description'],
        'main_meta_keywords' => ['value' => '', 'name' => 'Meta keywords'],
    ];

    protected $aboutPageData = [
        'about_label' => ['value' => 'О ПРОЕКТЕ', 'name' => 'Верхняя надпись'],
        'about_title' => ['value' => 'Adomo.com', 'name' => 'Заголовок'],
        'about_text' => ['value' => 'Онлайн сервис поиска частных специалистов', 'name' => 'Текст'],
        'about_bg' => ['value' => '/images/about-head.jpg', 'name' => 'Фоновая картинка'],

        'about_top_text' => ['value' => '<h2>Что мы делаем?</h2>
        <p>Adomo.com - онлайн сервис поиска частных специалистов для решения бытовых и бизнес задач. Площадка объединяет заказчиков услуг, которым необходимо выполнить какую-либо работу, и компетентных исполнителей, ищущих подработку или дополнительный заработок.</p>
        <h2>Наша команда</h2>
        <p>Все мы - разные. Каждый из нас занимается своей работой. Мы любим разную пиццу и смотрим разные фильмы. Мы выросли в разных городах и в разное время, но все сталкивались с одной и той же проблемой - ужасным сервисом в сфере услуг.</p>', 'name' => 'Текст над счётчиком'],
        'about_bottom_text' => ['value' => '<h2>Наша миссия</h2>
        <p>Мы хотим помочь решить любую задачу и освободить вам время для семьи или друзей. Мы хотим дать работу миллиону компетентных и ответственных специалистов и развивать предпринимательство в головах украинцев. Это наша главная миссия и мысль, с которой мы просыпаемся каждое утро.</p>', 'name' => 'Текст под счётчиком'],

        'about_action_title' => ['value' => 'Найдите исполнителя или выполняйте задания на Adomo.com', 'name' => 'Заголовок нижнего блока'],

        'about_meta_title' => ['value' => '', 'name' => 'Meta title'],
        'about_meta_description' => ['value' => '', 'name' => 'Meta description'],
        'about_meta_keywords' => ['value' => '', 'name' => 'Meta keywords'],
    ];

    protected $contactsPageData = [
        'contacts_title' => ['value' => 'Контакты', 'name' => 'Заголовок контактов'],
        'contacts_text' => ['value' => 'Если у вас есть вопросы о работе сервиса, кратко опишите ситуацию в форме или используйте для связи наши контакты.
Мы окажем консультацию', 'name' => 'Текст контактов'],
        'contacts_title_advices' => ['value' => 'Предложения об улучшении сервиса ADOMO.ru', 'name' => 'Заголовок формы предложений'],

        'contacts_meta_title' => ['value' => '', 'name' => 'Meta title'],
        'contacts_meta_description' => ['value' => '', 'name' => 'Meta description'],
        'contacts_meta_keywords' => ['value' => '', 'name' => 'Meta keywords'],
    ];

    protected $faqPageData = [
        'faq_breadcrumb' => ['value' => 'Часто задаваемые вопросы', 'name' => 'Хлебная крошка контактов'],
        'faq_title' => ['value' => 'Часто задаваемые вопросы', 'name' => 'Заголовок FAQ'],
        'faq_text' => ['value' => 'Часто задаваемые вопросы', 'name' => 'Текст FAQ'],

        'faq_meta_title' => ['value' => '', 'name' => 'Meta title'],
        'faq_meta_description' => ['value' => '', 'name' => 'Meta description'],
        'faq_meta_keywords' => ['value' => '', 'name' => 'Meta keywords'],
    ];

    public function run()
    {
        DB::table('common_variables')->truncate();

        $this->populateCommonData();
        $this->populateMainPageData();
        $this->populateAboutPageData();
        $this->populateContactsPageData();
        $this->populateFaqPageData();
    }

    private function storeVariable(array $data): Variable
    {
        return Variable::create($data);
    }

    private function populateMainPageData()
    {
        foreach ($this->mainPageData as $key => $data) {
            $this->storeVariable(['key' => $key, 'value' => $data['value'], 'name' => $data['name'], 'type' => Variable::TYPE_MAIN_PAGE]);
        }
    }

    private function populateFaqPageData()
    {
        foreach ($this->faqPageData as $key => $data) {
            $this->storeVariable(['key' => $key, 'value' => $data['value'], 'name' => $data['name'], 'type' => Variable::TYPE_FAQ_PAGE]);
        }
    }

    private function populateContactsPageData()
    {
        foreach ($this->contactsPageData as $key => $data) {
            $this->storeVariable(['key' => $key, 'value' => $data['value'], 'name' => $data['name'], 'type' => Variable::TYPE_CONTACTS_PAGE]);
        }
    }

    private function populateAboutPageData()
    {
        foreach ($this->aboutPageData as $key => $data) {
            $this->storeVariable(['key' => $key, 'value' => $data['value'], 'name' => $data['name'], 'type' => Variable::TYPE_ABOUT_PAGE]);
        }
    }

    private function populateCommonData()
    {
        foreach ($this->commonData as $key => $data) {
            $this->storeVariable(['key' => $key, 'value' => $data['value'], 'name' => $data['name'], 'type' => Variable::TYPE_COMMON]);
        }
    }
}

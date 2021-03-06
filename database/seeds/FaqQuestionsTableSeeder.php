<?php

use Illuminate\Database\Seeder;

class FaqQuestionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('faq_questions')->delete();
        
        \DB::table('faq_questions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'На балансе нет денег после пополнения',
            'text' => '<p>Если вы обнаружили, что по истечению 72 часов деньги не были зачислены на баланс вашего профиля, рекомендуем обратиться в службу поддержки сервиса по почте support@com и указать номер платежа (отправляется письмом на почту). Информация будет проверена в платежной системе.</p><p>При выявлении ошибки зачисления, деньги будут введены на баланс профиля администратором.</p><p>Если вы не можете найти номер платежа, пожалуйста, пришлите квитанцию/чек или скриншот выписки по банковскому счету, которые будут указывать на пополнение баланса на сервисе.</p>',
                'group_title' => 'Финансовые вопросы',
                'group' => 'finance',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Как проверить списания и зачисления денег в профиле?',
                'text' => '<p>Для отслеживания состояния баланса профиля создана вкладка , которая находится по ссылке a/cabinet/payments. На данной странице списком выводятся все операции в хронологическом порядке снизу вверх с балансом, с указанием суммы, типом и датой операции:Финансовые операции</p><p>При списании средств в рамках задания, вы сможете просмотреть его детальнее, нажав на название рядом со списанием.</p><p>Если вы заметили какие-то финансовые операции, которые были произведены без вашего участия, пожалуйста, сообщите об этом службу поддержки сервиса support@a</p>',
                'group_title' => 'Финансовые вопросы',
                'group' => 'finance',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Зачем загружать фото профиля?',
                'text' => '<p>Фото профиля создает первое впечатление о пользователе, поэтому важно, чтобы оно было эстетически приятным, а черты лица хорошо различимы. Для исполнителей условие фото в профиле обязательно. Таким образом заказчику удобно определять, кому он готов доверять и с кем готов работать. А если работа предполагает личный контакт, то фото поможет избежать мошенничества.</p><p>Не рекомендуем работать с людьми, которые представляются пользователям сайта, но на фото профиля другой человек. Возможно это мошенник, будьте бдительны.</p>',
                'group_title' => 'Настройки профиля',
                'group' => 'profile',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Почему мое объявление не может пройти модерацию?',
                'text' => '<p>Ваше объявление является дополнительным способом рекламы профильных услуг исполнителя, поэтому должно содержать полезную, привлекательную и понятную информацию для заказчика. Если ваше объявление отправлено на доработку модератором, оно не достаточно эффективно. Обратите внимание на рекомендации к нему и сможете отправить объявление повторно исправленным.</p>',
                'group_title' => 'Настройки профиля',
                'group' => 'profile',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Как зарегистрироваться исполнителю?',
                'text' => '<p>Первым в форме регистрации необходимо выбрать режим профиля "Частный специалист" или "Компания".</p><p>Режим "Частный специалист" подходит для исполнителей, которые готовы выполнять работы самостоятельно и не имеют открытого юридического лица.</p><p>Режим "Компания" подходит компаниям и физическим лицам - предпринимателям, которые будут предлагать услуги от нескольких исполнителей, и готовы за всех нести ответственность. Также обязательным условием для этого режима является наличие регистрационных документов на компанию.</p>',
                'group_title' => 'Настройки профиля',
                'group' => 'profile',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Разнообразный и богатый опыт сложившаяся структура организации?',
                'text' => '<p>Равным образом консультация с широким активом способствует подготовки и реализации направлений прогрессивного развития. Товарищи! начало повседневной работы по формированию позиции требуют определения и уточнения соответствующий условий активизации. Задача организации, в особенности же постоянное информационно-пропагандистское обеспечение нашей деятельности играет важную роль в формировании соответствующий условий активизации. Повседневная практика показывает, что рамки и место обучения кадров требуют определения и уточнения новых предложений.</p>',
                'group_title' => 'Общие вопросы',
                'group' => 'other',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Задача организации, в особенности же постоянный количественный рост и сфер?',
                'text' => '<p>авным образом начало повседневной работы по формированию позиции способствует подготовки и реализации модели развития. Разнообразный и богатый опыт постоянный количественный рост и сфера нашей активности требуют от нас анализа новых предложений. Идейные соображения высшего порядка, а также дальнейшее развитие различных форм деятельности требуют от нас анализа новых предложений. Товарищи! укрепление и развитие структуры влечет за собой процесс внедрения и модернизации системы обучения кадров, соответствует насущным потребностям. Идейные соображения высшего порядка, а также консультация с широким активом способствует подготовки и реализации модели развития.</p>',
                'group_title' => 'Общие вопросы',
                'group' => 'other',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'Что такое первичные документы?',
            'text' => '<p>Первичные документы - это акт за фактически предоставленные услуги доступа и дополнительные услуги за месяц. Мы можем сформировать и отправить такой акт Пользователю при наличии полной и достоверной информации, чтобы его составить.</p><p>Мы предоставляем акт до 15-го числа следующего месяца в бумажном виде или до 7-го числа следующего месяца в электронном виде.</p><p>Специалисту нужно подписать Акт и передать его Компании на протяжении 5 (пяти) рабочих дней с даты получения его от Компании, или в этот же срок направить мотивированные возражения.</p>',
                'group_title' => 'Компаниям',
                'group' => 'company',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Как оспорить отзыв?',
                'text' => '<p>На наш взгляд отзыв - это виденье пользователя взаимодействия по заданию между вами. И для нас важно дать возможность выразить свое мнение каждой стороне сделки. Уверены, что отзыв был оставлен на основе ощущений, поэтому очень хотим, чтобы отзыв был не камнем преткновения, а возможностью исправить ситуацию.</p><p>Если вы не согласны с таким отзывом, рекомендуем обратиться ко второй стороне сделки для поиска компромиссного решения.</p><p>Администрация сайта не в праве удалить отзыв без согласия автора или при отсутствии доказательств его фиктивности.</p>',
                'group_title' => 'Заказ услуги',
                'group' => 'order',
                'depth' => 1,
                'lft' => 0,
                'rgt' => 0,
                'parent_id' => NULL,
            ),
        ));
        
        
    }
}
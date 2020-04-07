<?php

use Illuminate\Database\Seeder;
use App\Entity\Common\FaqQuestion;

class FaqQuestionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('faq_questions')->truncate();

        $groups = [
            'finance' => 'Финансовые вопросы',
            'profile' => 'Настройки профиля',
            'other' => 'Общие вопросы',
            'company' => 'Компаниям',
            'order' => 'Заказ услуги'
        ];

        foreach($this->data() as $question) {
            FaqQuestion::create([
                'title' => $question['quest'],
                'text' => '<p>' . implode('</p><p>', $question['answ']) . '</p>',
                'group_title' => $groups[$question['group']],
                'group' => $question['group'],
            ]);
        }
    }

    private function data()
    {
        return \GuzzleHttp\json_decode(File::get(storage_path('app/faq.json')), true);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Entity\Common\Page;

class PageSlugsSeeder extends Seeder
{
    public function run()
    {
        Page::create(['slug' => 'about',    'type' => Page::TYPE_ABOUT_PAGE]);
        Page::create(['slug' => 'faq',      'type' => Page::TYPE_FAQ_PAGE]);
        Page::create(['slug' => 'contacts', 'type' => Page::TYPE_CONTACTS_PAGE]);
    }
}

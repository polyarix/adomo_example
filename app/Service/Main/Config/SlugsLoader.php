<?php

namespace App\Service\Main\Config;

use App\Entity\Common\Page;

class SlugsLoader
{
    protected $data = [];

    protected function __clone() {}

    private function loadData(): array
    {
        return Page::select(['slug', 'type'])
            ->whereIn('type', [Page::TYPE_FAQ_PAGE, Page::TYPE_CONTACTS_PAGE, Page::TYPE_ABOUT_PAGE, Page::TYPE_COMMON])
            ->get()
            ->keyBy('type')
            ->toArray()
        ;
    }

    public function getInstance()
    {
        if(!$this->data) {
            $this->data = $this->loadData();
        }
        return $this->data;
    }
}

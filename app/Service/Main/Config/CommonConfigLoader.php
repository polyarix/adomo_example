<?php

namespace App\Service\Main\Config;

use App\Entity\Common\Variable;
use App\Helpers\Models\SingletonTrait;

class CommonConfigLoader
{
    protected $data = [];

    protected function __clone() {}

    private function loadData(): array
    {
        return Variable::select(['key', 'value'])->common()->get()->keyBy('key')->toArray();
    }

    public function getInstance()
    {
        if(!$this->data) {
            $this->data = $this->loadData();
        }
        return $this->data;
    }
}

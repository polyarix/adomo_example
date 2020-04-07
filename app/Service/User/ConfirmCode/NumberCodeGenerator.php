<?php

namespace App\Service\User\ConfirmCode;

class NumberCodeGenerator implements CodeGeneratorInterface
{
    public function generate()
    {
        return random_int(100000, 999999);
    }
}

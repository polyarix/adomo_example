<?php

namespace App\Service\Sms;

interface SmsSenderInterface
{
    public function send($number, string $text): void;
}

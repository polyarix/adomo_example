<?php

namespace App\Service\Sms;

class ArraySender implements SmsSenderInterface
{
    private $messages = [];

    public function send($number, string $text): void
    {
        $this->messages[] = [
            'to' => '+' . trim($number, '+'),
            'text' => $text
        ];
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}

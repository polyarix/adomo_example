<?php

namespace App\Events\User\Document;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use YandexCheckout\Model\PaymentInterface;

class SuccessfulPayed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var PaymentInterface
     */
    public $payment;

    public function __construct(PaymentInterface $payment)
    {
        $this->payment = $payment;
    }
}

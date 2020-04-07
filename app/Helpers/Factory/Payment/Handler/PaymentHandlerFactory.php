<?php

namespace App\Helpers\Factory\Payment\Handler;

use App\UseCase\User\PaymentService;
use YandexCheckout\Model\PaymentInterface;

class PaymentHandlerFactory
{
    public static function make(PaymentInterface $payment)
    {
        $meta = $payment->getMetadata();
        $type = $meta['type'];

        switch ($type) {
            case PaymentService::PAY_PREMIUM:
                return app()->make(PaymentPremiumHandler::class)->process($payment);
                break;

            case PaymentService::PAY_CATCH_UP:
                return app()->make(PaymentOrderHandler::class)->process($payment);
                break;

            default: throw new \DomainException('Unable to handle payment.');
        }
    }
}

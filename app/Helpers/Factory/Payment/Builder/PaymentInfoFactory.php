<?php

namespace App\Helpers\Factory\Payment\Builder;

use App\UseCase\User\PaymentService;
use Illuminate\Http\Request;

class PaymentInfoFactory
{
    public static function make(Request $request): AbstractPaymentInfo
    {
        $type = $request->get('type');

        switch ($type) {
            case PaymentService::PAY_PREMIUM: return new PremiumPaymentInfo($request);
            case PaymentService::PAY_CATCH_UP: return new OrderCatchUpPaymentInfo($request);
        }

        throw new \DomainException("Unable to handle type {$type}");
    }
}

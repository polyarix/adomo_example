<?php

namespace App\Helpers\Factory\Payment\Builder;

use App\UseCase\User\PaymentService;

class PremiumPaymentInfo extends AbstractPaymentInfo
{
    public function getDescription(): string
    {
        return 'Оплата премиум доступа.';
    }

    public function getRedirectUrl(): string
    {
        return $this->request->get('redirect_to') ?? url('/');
    }

    public function getType(): string
    {
        return PaymentService::PAY_PREMIUM;
    }

    public function getId(): int
    {
        return \Auth::id();
    }

    public function getAmount(): int
    {
        return 100;
    }
}

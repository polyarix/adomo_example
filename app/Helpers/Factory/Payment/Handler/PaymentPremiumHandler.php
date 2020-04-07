<?php

namespace App\Helpers\Factory\Payment\Handler;

use App\UseCase\User\UserService;
use YandexCheckout\Model\PaymentInterface;

class PaymentPremiumHandler
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function process(PaymentInterface $payment)
    {
        $user = $this->userService->getById($payment->getMetadata()['id']);

        $this->userService->extendPremium($user, 30);
    }
}

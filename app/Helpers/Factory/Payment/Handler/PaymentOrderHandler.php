<?php

namespace App\Helpers\Factory\Payment\Handler;

use App\UseCase\Advert\Advert\AdvertService;
use App\UseCase\Advert\Advert\Order\OrderService;
use App\UseCase\User\PaymentService;
use App\UseCase\User\Profile\ServicesService;
use Carbon\Carbon;
use YandexCheckout\Model\PaymentInterface;

class PaymentOrderHandler
{
    /**
     * @var AdvertService
     */
    private $advertService;
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var ServicesService
     */
    private $servicesService;

    public function __construct(AdvertService $advertService, OrderService $orderService, ServicesService $servicesService)
    {
        $this->advertService = $advertService;
        $this->orderService = $orderService;
        $this->servicesService = $servicesService;
    }

    public function process(PaymentInterface $payment)
    {
        $entity = $payment->getMetadata()['entity'];
        $id = $payment->getMetadata()['id'];

        if($entity === PaymentService::TYPE_SERVICE) {
            $advert = $this->servicesService->getById($id);
        }
        if($entity === PaymentService::TYPE_ORDER) {
            $advert = $this->orderService->get($id);
        }

        $advert->catchUp(Carbon::now(), 5);
    }
}

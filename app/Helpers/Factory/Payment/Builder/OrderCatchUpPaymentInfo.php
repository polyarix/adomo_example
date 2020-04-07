<?php

namespace App\Helpers\Factory\Payment\Builder;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Service;
use App\UseCase\User\PaymentService;
use Illuminate\Http\Request;

class OrderCatchUpPaymentInfo extends AbstractPaymentInfo
{
    protected $advert;
    protected $redirectUrl;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $id = $request->get('id');

        if(!$id) {
            throw new \InvalidArgumentException('You must pass advert id.');
        }

        $advert = null;
        switch ($request->get('entity')) {
            case PaymentService::TYPE_ORDER:
                $this->advert = Order::where('id', $id)->firstOrFail();
                $this->redirectUrl = route('advert.order.show', $this->advert);
                break;

            case PaymentService::TYPE_SERVICE:
                $this->advert = Service::where('id', $id)->firstOrFail();
                $this->redirectUrl = route('advert.task.show', $this->advert);
                break;

            default: throw new \DomainException('Unable to handle payment.');
        }
    }

    public function getDescription(): string
    {
        return "Оплата за поднятие объявления #{$this->advert->id} в топ.";
    }

    public function getRedirectUrl(): string
    {
        return $this->request->get('redirect_to') ?? $this->redirectUrl;
    }

    public function getType(): string
    {
        return PaymentService::PAY_CATCH_UP;
    }

    public function getMetaData(): array
    {
        return ['entity' => $this->request->get('entity')];
    }

    public function getId(): int
    {
        return $this->advert->id;
    }

    public function getAmount(): int
    {
        return 50;
    }
}

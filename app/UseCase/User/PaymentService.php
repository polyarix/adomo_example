<?php

namespace App\UseCase\User;

use YandexCheckout\Client;
use YandexCheckout\Model\ConfirmationAttributes\ConfirmationAttributesRedirect;
use YandexCheckout\Model\Metadata;
use YandexCheckout\Model\MonetaryAmount;
use YandexCheckout\Request\Payments\CreatePaymentRequest;
use YandexCheckout\Request\Payments\CreatePaymentResponse;

class PaymentService
{
    const PAY_CATCH_UP_SERVICE = 'service';
    const PAY_CATCH_UP_ORDER = 'order';

    const PAY_PREMIUM = 'premium';
    const PAY_CATCH_UP = 'catch_up';

    const TYPE_ADVERT = 'advert';
    const TYPE_ORDER = 'order';
    const TYPE_SERVICE = 'service';

    /**
     * @var Client
     */
    private $yandex;

    public function __construct(Client $yandex)
    {
        $this->yandex = $yandex;
    }

    public function createPayment(string $type, int $id, int $amount, string $description, string $redirectUrl, array $meta = []): CreatePaymentResponse
    {
        if(!in_array($type, array_keys(self::getPayTypes()))) {
            throw new \InvalidArgumentException("Unable to process {$type} type.");
        }

        $metadata = new Metadata();
        $metadata->fromArray(array_merge(['id' => $id, 'type' => $type], $meta));

        $request = new CreatePaymentRequest();
        $request->setAmount(new MonetaryAmount($amount));
        $request->setDescription($description);
        $request->setMetadata($metadata);

        $confirmation = new ConfirmationAttributesRedirect();
        $confirmation->setReturnUrl($redirectUrl);
        $request->setConfirmation($confirmation);
        $request->setCapture(true);

        return $this->yandex->createPayment($request);
    }

    public function payAdvertCatchUp(int $id, string $type, int $amount, string $returnUrl)
    {
        if(!in_array($type, self::getPayTypes())) {
            throw new \InvalidArgumentException("Unable to process {$type} type.");
        }

        $metadata = new Metadata();
        $metadata->fromArray(['id' => $id, 'advert' => $type, 'type' => self::TYPE_ADVERT]);

        $request = new CreatePaymentRequest();
        $request->setMetadata($metadata);
        $request->setAmount(new MonetaryAmount($amount));
        $request->setDescription("Оплата за поднятие объявления #{$id} в топ.");
        $request->setMetadata($metadata);

        $confirmation = new ConfirmationAttributesRedirect();
        $confirmation->setReturnUrl($returnUrl);
        $request->setConfirmation($confirmation);

        $res = $this->yandex->createPayment($request);

        dd($res);
    }

    public static function getPayTypes(): array
    {
        return [self::PAY_CATCH_UP_ORDER, self::PAY_CATCH_UP_SERVICE, self::PAY_PREMIUM];
    }
}

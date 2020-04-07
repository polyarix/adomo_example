<?php

namespace App\Http\Controllers\Api\Advert;

use App\Entity\User\User;
use App\Helpers\Http\ResponsesTrait;
use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Advert\Task\CreateRequestRequest;
use App\UseCase\Advert\Advert\Order\OrderService;
use App\UseCase\Advert\Advert\Order\RequestsService;
use App\UseCase\Advert\Advert\Service\ServicesService;
use App\Entity\Advert\Advert\Order\Request as OrderRequest;

class RequestsController extends Controller
{
    use ResponsesTrait;

    /**
     * @var ServicesService
     */
    private $servicesService;
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var RequestsService
     */
    private $requestsService;

    public function __construct(ServicesService $servicesService, OrderService $orderService, RequestsService $requestsService)
    {
        $this->servicesService = $servicesService;
        $this->orderService = $orderService;
        $this->requestsService = $requestsService;
    }

    public function accept($orderId)
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            $order = $this->orderService->get($orderId);

            $message = $this->requestsService->accept($user, $order);

            return $this->success($message);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function reject($orderId)
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            $order = $this->orderService->get($orderId);

            $message = $this->requestsService->reject($user, $order);

            return $this->success($message);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}

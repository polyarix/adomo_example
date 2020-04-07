<?php

namespace App\Http\Controllers\Api\Advert;

use App\Entity\Location\City;
use App\Entity\User\User;
use App\Helpers\Http\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Advert\Task\CreateRequestRequest;
use App\Http\Requests\Api\Advert\Task\FilterRequest;
use App\Http\Resources\Advert\AdvertOffersResource;
use App\Http\Resources\Advert\AdvertResource;
use App\UseCase\Advert\Advert\Order\OrderService;
use App\UseCase\Advert\Advert\Service\ServicesService;
use App\UseCase\User\Location\LocationService;

class TasksController extends Controller
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
     * @var LocationService
     */
    private $locationService;

    public function __construct(ServicesService $servicesService, OrderService $orderService, LocationService $locationService)
    {
        $this->servicesService = $servicesService;
        $this->orderService = $orderService;
        $this->locationService = $locationService;
    }

    public function offer(CreateRequestRequest $request)
    {
        try {
            /** @var User $user */
            $user = \Auth::user();

            $order = $this->orderService->get($request->get('id'));

            $this->servicesService->createRequest($user, $order, $request->get('message'));

            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function index(FilterRequest $request)
    {
        /** @var User $user */
        $user = \Auth::user();

        return AdvertResource::collection($this->servicesService->getAll($request, $user));
    }

    public function offers(FilterRequest $request)
    {
        /** @var User $user */
        $user = \Auth::user();

        $adverts = AdvertOffersResource::collection($this->servicesService->offers($user, $request));

        return $this->success($adverts);
    }

    public function recommendations(FilterRequest $request)
    {
        /** @var User $user */
        $user = \Auth::user();

        $adverts = AdvertResource::collection($this->servicesService->recommendations($user, $request));

        return $this->success($adverts);
    }
}

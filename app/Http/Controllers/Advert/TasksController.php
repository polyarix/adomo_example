<?php

namespace App\Http\Controllers\Advert;

use App\Entity\Advert\Category;
use App\Entity\Location\City;
use App\Http\Controllers\Controller;
use App\Http\Resources\Advert\AdvertResource;
use App\UseCase\Advert\Advert\Order\OrderService;
use App\UseCase\Advert\Advert\Service\ServicesService;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * @var ServicesService
     */
    private $servicesService;
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(ServicesService $servicesService, OrderService $orderService)
    {
        $this->servicesService = $servicesService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $categories = Category::defaultOrder()
            ->visible()
            ->withDepth()
            ->withCount('descendants')
            ->having('depth', '=', 0)
            ->get();

        $cities = City::select(['id', 'name'])->get();

        $premium = AdvertResource::collection($this->orderService->getPremium(5));

        return view('app.advert.task.index', [
            'categories' => $categories,
            'cities' => $cities,
            'premium' => $premium
        ]);
    }

    public function recommended()
    {
        $adverts = [];
        $cities = City::select(['id', 'name'])->get();

        return view('app.advert.task.recommended', [
            'adverts' => $adverts,
            'cities' => $cities,
        ]);
    }

    public function offers()
    {
        $adverts = [];
        $cities = City::select(['id', 'name'])->get();

        return view('app.advert.task.offers', [
            'adverts' => $adverts,
            'cities' => $cities,
        ]);
    }

    public function show($slug)
    {
        $order = $this->servicesService->getOne($slug);

        if (!($order->isActive() || \Gate::allows('show-service', $order))) {
            abort(404);
        }

        $this->servicesService->incrementView($order);

        return view('app.advert.task.show', [
            'order'     => $order,
            'user'      => $order->user,
            'reviews'   => $order->user->reviews
        ]);
    }
}

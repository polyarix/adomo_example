<?php

namespace App\Http\Controllers\Cabinet;

use App\Entity\User\User;
use App\Http\Controllers\Controller;
use App\UseCase\Advert\Category\CategoryService;
use App\UseCase\Advert\Location\CitiesService;
use App\UseCase\User\Profile\ServicesService;

class ServicesController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var ServicesService
     */
    private $servicesService;
    /**
     * @var CitiesService
     */
    private $citiesService;

    public function __construct(CategoryService $categoryService, ServicesService $servicesService, CitiesService $citiesService)
    {
        $this->categoryService = $categoryService;
        $this->servicesService = $servicesService;
        $this->citiesService = $citiesService;
    }

    public function create()
    {
        $user = \Auth::user();

        $cities = $this->citiesService->getCities();

        return view('app.users.cabinet.services.create', [
            'categories' => $this->categoryService->buildForTree(),
            'cities' => $cities,
            'user' =>  $user,
        ]);
    }

    public function edit($serviceId)
    {
        /** @var User $user */
        $user = \Auth::user();
        $service = $this->servicesService->getById($serviceId);

        if(!$this->servicesService->isUserOwnOfService($user, $service)) {
            abort(404);
        }

        return view('app.users.cabinet.services.edit', [
            'categories' => $this->categoryService->buildForTree(),
            'user' =>  $user,
            'service' => $service,
            'cities' => $this->citiesService->getCities()
        ]);
    }

    public function index()
    {
        /** @var User $user */
        $user = \Auth::user();

        if(!$user->isExecutor()) {
            abort(404);
        }

        $categories = $this->servicesService->getAvailableCategories($user);

        return view('app.users.cabinet.services.index', [
            'categories' => $categories,
            'user' =>  $user
        ]);
    }
}

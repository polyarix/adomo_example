<?php

namespace App\Http\Controllers\Api\Advert;

use App\Entity\Advert\Category;
use App\Entity\Location\City;
use App\Entity\User\User;
use App\Helpers\Http\ResponsesTrait;
use App\Helpers\Models\Lang\UserLangFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Advert\Order\PhotoUploadRequest;
use App\Http\Requests\Api\Advert\Order\RecommendedRequest;
use App\Http\Requests\Api\Advert\Order\StoreRequest;
use App\Http\Resources\Advert\AdvertResource;
use App\Http\Resources\Advert\TagResource;
use App\Http\Resources\Main\BannerResource;
use App\Http\Resources\User\ExecutorRecommendedResource;
use App\Http\Resources\User\ExecutorResource;
use App\UseCase\Advert\Advert\AdvertService;
use App\UseCase\Advert\Category\CategoryService;
use App\UseCase\Site\BannerService;
use App\UseCase\User\Location\LocationService;
use Illuminate\Http\Request;

class AdvertsController extends Controller
{
    const EXECUTORS_PER_PAGE = 5;
    const RECOMMENDED_PER_PAGE = 5;
    const RECOMMENDED_EXECUTORS_PER_PAGE = 5;

    /**
     * @var AdvertService
     */
    private $adverts;
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var BannerService
     */
    private $bannerService;
    /**
     * @var LocationService
     */
    private $locationService;

    use ResponsesTrait;

    public function __construct(AdvertService $advertService, CategoryService $categoryService, BannerService $bannerService, LocationService $locationService)
    {
        $this->adverts = $advertService;
        $this->categoryService = $categoryService;
        $this->bannerService = $bannerService;
        $this->locationService = $locationService;
    }

    public function index(Request $request)
    {
        /** @var Category $category */
        $category = Category::find($request->get('category_id'));
        $city = City::where('name', $this->locationService->getCity())->first();

        return AdvertResource::collection($this->categoryService->getServices($category, $city));
    }

    public function recommended(RecommendedRequest $request)
    {
        try {
            $category = $this->categoryService->getById($request->get('category'));

            $city = City::first();

            $data = $this->categoryService->getPremiumUsers($category, $city, self::RECOMMENDED_EXECUTORS_PER_PAGE);

            return $this->success(ExecutorRecommendedResource::collection($data));
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function userAdverts(Request $request)
    {
        /** @var User $user */
        $user = User::find($request->get('user_id'));

        return AdvertResource::collection($this->adverts->getByUser($user));
    }

    public function store(StoreRequest $request)
    {
        try {
            /** @var User $user */
            $user = \Auth::user();

            $advert = $this->adverts->create($request, $user);

            return $this->success(new AdvertResource($advert));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(StoreRequest $request, int $id)
    {
        try {
            $order = $this->adverts->getById($id);

            $advert = $this->adverts->update($request, $order);

            return $this->success(new AdvertResource($advert));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function uploadPhoto(PhotoUploadRequest $request)
    {
        $photo = $this->adverts->uploadPhoto($request);

        return response()->json([
            'data' => $photo->path, 'code' => 200, 'id' => $photo->id, 'msg' => ''
        ]);
    }

    public function banner(Request $request)
    {
        $category = $request->get('category_id') ? $this->getCategory($request->get('category_id')) : null;

        $banner = $this->bannerService->getForCategory($category);

        if($banner) {
            $this->bannerService->incrementView($banner);
        }

        return $banner ?  ['count' => 1, 'data' => new BannerResource($banner)] : $this->success(['count' => 0]);
    }

    public function tags(Request $request)
    {
        $category = $this->getCategory($request->get('category_id'));

        return TagResource::collection($this->categoryService->getTags($category));
    }

    public function autofitTags(Request $request)
    {
        $category = $this->getCategory($request->get('category_id'));

        return $this->success([
            'list' => TagResource::collection($this->categoryService->getTags($category)),
            'popular' => TagResource::collection($this->categoryService->getPopularTags($category, 4)),
            'prices' => $this->categoryService->getPriceLimits($category)
        ]);
    }

    public function executors(Request $request)
    {
        $category = $this->getCategory($request->get('category_id'));

        $city = UserLangFacade::city();

        $executors = $category->executors()
            ->with(['workData'])
            ->withoutPremium()
            ->where('city_id', $city->id)
            ->orderBy('rating', 'DESC')
            ->paginate(self::EXECUTORS_PER_PAGE);

        return ExecutorResource::collection($executors);
    }

    public function recommendedExecutors(Request $request)
    {
        $category = $this->getCategory($request->get('category_id'));

        $executors = $category->recommendedExecutors()->paginate(self::RECOMMENDED_EXECUTORS_PER_PAGE);

        return ExecutorResource::collection($executors);
    }

    private function getCategory(int $id): Category
    {
        return Category::findOrFail($id);
    }
}

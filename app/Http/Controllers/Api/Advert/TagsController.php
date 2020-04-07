<?php

namespace App\Http\Controllers\Api\Advert;

use App\Entity\Advert\Category;
use App\Entity\Advert\Tag;
use App\Entity\User\User;
use App\Helpers\Http\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Advert\AdvertResource;
use App\Http\Resources\Main\BannerResource;
use App\Http\Resources\User\ExecutorResource;
use App\UseCase\Advert\Advert\AdvertService;
use App\UseCase\Advert\Category\CategoryService;
use App\UseCase\Site\BannerService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    const EXECUTORS_PER_PAGE = 10;

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

    use ResponsesTrait;

    public function __construct(AdvertService $advertService, CategoryService $categoryService, BannerService $bannerService)
    {
        $this->adverts = $advertService;
        $this->categoryService = $categoryService;
        $this->bannerService = $bannerService;
    }

    public function adverts(Request $request)
    {
        $tag = $this->getTag($request->get('tag_id'));

        return AdvertResource::collection($this->categoryService->getServicesByTag($tag));
    }

    public function banner(Request $request)
    {
        $tag = $this->getTag($request->get('tag_id'));

        $banner = $this->bannerService->getForTag($tag);

        if($banner) {
            $this->bannerService->incrementView($banner);
        }

        return $banner ?  ['count' => 1, 'data' => new BannerResource($banner)] : $this->success(['count' => 0]);
    }

    public function executors(Request $request)
    {
        /** @var Tag $tag */
        $tag = $this->getTag($request->get('tag_id'));

        $executors = User::whereHas('services', function($q) use($tag) {
            $q->whereHas('tags', function ($q) use($tag) {
                $q->where('tag_id', $tag->id);
            });
        })->paginate(self::EXECUTORS_PER_PAGE);

        return ExecutorResource::collection($executors);
    }

    private function getCategory(int $id): Category
    {
        return Category::findOrFail($id);
    }

    private function getTag(int $id): Tag
    {
        return Tag::findOrFail($id);
    }
}

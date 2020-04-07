<?php

namespace App\Http\Controllers\Advert;

use App\Entity\Advert\Category;
use App\Entity\Advert\Tag;
use App\Entity\Location\City;
use App\Entity\User\User;
use App\Helpers\Models\Lang\UserLangFacade;
use App\Http\Controllers\Controller;
use App\Http\Resources\Advert\AdvertResource;
use App\UseCase\Advert\Advert\TagService;
use App\UseCase\Advert\Category\CategoryService;
use App\UseCase\Advert\Location\CitiesService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var TagService
     */
    private $tagService;
    /**
     * @var CitiesService
     */
    private $citiesService;

    public function __construct(CategoryService $categoryService, TagService $tagService, CitiesService $citiesService)
    {
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
        $this->citiesService = $citiesService;
    }

    public function tag(Tag $tag)
    {
        $similarTags = $this->tagService->findSimilar($tag, 5);

        return view('app.advert.category.tag', compact('tag', 'similarTags'));
    }

    public function show(Category $category)
    {
        if(!$category->isVisible()) {
            abort(404);
        }

        /** @var User $user */
        $user = \Auth::user();

        if($user && $user->isExecutor()) {
            $cities = $this->citiesService->getCities();

            $premium = AdvertResource::collection($this->categoryService->getPremiumOrders($category));

            return view('app.advert.task.category', [
                'category' => $category,
                'cities' => $cities,
                'premium' => $premium
            ]);
        }

        $city = UserLangFacade::city();

        $popularCategories = $category->children()->visible()->withCount([
            'descendantsServices' => function($q) use($city) {
                return $q->where('city_id', $city->id);
            }
        ])->limit(8)->get();
        $siblings = Category::withDepth()->visible()->having('depth', '=', $category->depth - 1)->get();

        $tags = $this->categoryService->getTags($category);

        $premium = AdvertResource::collection($this->categoryService->getPremiumServices($category, $city));

        $city = UserLangFacade::city();

        return view('app.advert.category.show', [
            'category' => $category,
            'popularCategories' => $popularCategories,
            'depth' => $category->depth,
            'siblings' => $siblings,
            'totalExecutors' => $this->categoryService->getExecutorsCount($category, $city),
            'tags' => $tags,
            'premium' => $premium
        ]);
    }
}

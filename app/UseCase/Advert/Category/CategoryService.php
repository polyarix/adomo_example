<?php

namespace App\UseCase\Advert\Category;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Service;
use App\Entity\Advert\Category;
use App\Entity\Advert\Tag;
use App\Entity\Location\City;
use App\Entity\User\User;
use App\Events\Advert\Category\HideCategory;
use App\Events\Advert\Category\SetVisibleCategory;
use Carbon\Carbon;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    const SERVICES_PER_PAGE = 5;
    const PREMIUM_SERVICES_PER_PAGE = 5;
    const PREMIUM_ORDERS_PER_PAGE = 5;

    public function getById(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function getServicesByCategoryTag(Category $category, array $tags = [])
    {
        $services = $category->descendantsServices()->whereHas('tags', function($q) use($tags) {
            return $q->whereIn('tag_id', $tags);
        })->orderBy('moderated_at');

        return $services->paginate(self::SERVICES_PER_PAGE);
    }

    public function getServicesByTag(Tag $tag)
    {
        $services = $tag->services()->with(['city.districts', 'tags'])->orderBy('moderated_at');

        return $services->paginate(self::SERVICES_PER_PAGE);
    }

    public function getCategoryById($id): Category
    {
        return Category::where('id', $id)->firstOrFail();
    }

    public function setVisible(Category $category)
    {
        if($category->isVisible()) {
            throw new \DomainException('Category is already visible.');
        }

        $category->update(['is_visible' => true]);
        event(new SetVisibleCategory($category));
    }

    public function setHidden(Category $category)
    {
        if($category->isHidden()) {
            throw new \DomainException('Category is already hidden.');
        }

        $category->update(['is_visible' => false]);
        event(new HideCategory($category));
    }

    public function getTags(Category $category)
    {
        return Tag::whereHas('categories', function($q) use($category) {
            $q->whereIn('category_id', $category->ancestors->pluck('id')->push($category->id));
        })->get();
    }

    public function getPriceLimits(Category $category)
    {
        $price = \DB::table('user_executor_categories')
            ->selectRaw('MIN(price) as min, MAX(price) as max')
            ->where('category_id', $category->id)
            ->first()
        ;

        return [
            'min' => $price->min > 0 ? $price->min : 0,
            'max' => $price->max > 0 && $price->max > $price->min ? $price->max : 2000,
        ];
    }

    public function getPopularTags(Category $category, $limit = 5)
    {
        return Tag::withCount('services')->whereHas('categories', function($q) use($category) {
            $q->whereIn('category_id', $category->ancestors->pluck('id')->push($category->id));
        })->orderBy('services_count', 'DESC')->limit($limit)->get();
    }

    public function getCategoriesArrayTags(Collection $categories)
    {
        return Tag::whereHas('categories', function($q) use($categories) {
            $q->whereIn('category_id', $categories->map(function(Category $category) {
                return $category->ancestors->pluck('id')->push($category->id);
            }));
        })->get();
    }

    public function getServices(Category $category, ?City $city = null): AbstractPaginator
    {
        $services = Service::with(['user', 'photos', 'city' => function($q) {$q->select('name', 'id');}, 'tags'])
            ->orderByRaw("FIELD(status, '" .Service::STATUS_ACTIVE . "') DESC")
            ->orderBy('moderated_at', 'DESC')
            ->active()
            ->withoutPremium();

        if($city) {
            $services->where('city_id', $city->id);
        }

        if($category) {
            $categories = $category->descendants ? $category->descendants->pluck('id')->push($category->id)->toArray() : [];

            $services->whereHas('categories', function($q) use($categories) {
                $q->whereIn('category_id', $categories);
            });
        }

        return $services->paginate(self::SERVICES_PER_PAGE);
    }

    public function getPremiumServices(Category $category, ?City $city = null): AbstractPaginator
    {
        $services = Service::orderBy('catched_up_at', 'DESC')->active()->activePremium();

        if($category) {
            $categories = $category->descendants ? $category->descendants->pluck('id')->push($category->id)->toArray() : [];

            $services->whereHas('categories', function($q) use($categories) {
                $q->whereIn('category_id', $categories);
            });
        }

        if($city) {
            $services->where('city_id', $city->id);
        }

        return $services->paginate(self::PREMIUM_SERVICES_PER_PAGE);
    }

    public function getPremiumOrders(?Category $category = null, ?City $city = null): AbstractPaginator
    {
        $orders = Order::orderBy('catched_up_at', 'DESC')->active()->activePremium();

        if($category) {
            $categories = $category->descendants ? $category->descendants->pluck('id')->push($category->id)->toArray() : [];

            $orders->whereIn('category_id', $categories);
        }

        if($city) {
            $orders->where('city_id', $city->id);
        }

        return $orders->paginate(self::PREMIUM_ORDERS_PER_PAGE);
    }

    public function getPremiumUsers(Category $category, City $city, $limit = 5): Collection
    {
        $users = User::inRandomOrder()
            ->with(['city'])
            ->activePremium()
            ->where('city_id', $city->id)
            ->whereExists(function($q) use($category) {
                $q
                    ->from('user_executor_categories')
                    ->whereRaw('users.id = user_executor_categories.user_id')
                    ->where('category_id', $category->id)
                ;
            })
            ->limit($limit)
        ;

        return $users->get();
    }

    public function getExecutorsCount(Category $category, ?City $city = null): int
    {
        // find in child categories, and add parent one
        $categories = $category->descendants->pluck('id')->add($category->id);

        $q = \DB::table('user_executor_categories')
            ->select('user_id')
            ->distinct()
            ->groupBy('user_id')
            ->whereIn('category_id', $categories)
        ;

        if($city) {
            $q->whereExists(function($q) use($city) {
                $q->select(\DB::raw(1))->from('users')->whereRaw('user_executor_categories.user_id = users.id')->where('city_id', $city->id);
            });
        }

        return $q->get()->count();
    }

    public function getExecutors(Category $category)
    {
        $categories = $category->descendants->pluck('id')->add($category->id);
        $userIds = \DB::table('user_executor_categories')
            ->select('user_id')
            ->groupBy('user_id')
            ->whereIn('category_id', $categories)
            ->get()
            ->pluck('user_id');

        return User::whereIn('id', $userIds)->get();
    }

    public function buildForTree(): array
    {
        $tree = Category::with('dimension')->get()->toTree()->toArray();

        return $this->arrayFilterRecursive($tree);
    }

    private function arrayFilterRecursive($input)
    {
        foreach ($input as &$value) {
            if (isset($value['children']) && is_array($value['children']) && count($value['children']) > 0) {
                $value['children'] = $this->arrayFilterRecursive($value['children']);
            } else {
                unset($value['children']);
            }
        }

        return $input;
    }
}

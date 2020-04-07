<?php

namespace App\UseCase\Advert\Advert;

use App\Entity\Advert\Advert\Service;
use App\Entity\Location\District;
use App\Entity\User\User;
use App\Http\Requests\Api\Site\Autofit\SearchRequest;
use App\Http\Resources\Advert\AdvertResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class AutofitService
{
    const USERS_PER_PAGE = 1;
    const PREMIUM_USERS_PER_PAGE = 1;
    const SERVICES_PER_PAGE = 1;

    public function search(SearchRequest $request)
    {
        return [
            'users' => [
                'premium' => UserResource::collection($this->premiumUsers($request))->resource,
                'list' => UserResource::collection($this->users($request))->resource,
            ],
            'services' => AdvertResource::collection($this->services($request))->resource,
        ];
    }

    public function users(SearchRequest $request, $limit = self::USERS_PER_PAGE)
    {
        return $this->filterUsers($request)->withoutPremium()->paginate($limit);
    }

    public function premiumUsers(SearchRequest $request, $limit = self::PREMIUM_USERS_PER_PAGE)
    {
        return $this->filterUsers($request)->activePremium()->paginate($limit);
    }

    protected function filterUsers(SearchRequest $request): Builder
    {
        /** @var \Illuminate\Database\Eloquent\Builder $users */
        $users = User::where('city_id', $request->get('city'));

        if($district = $request->get('district')) {
            $users->whereExists(function($q) use($district) {
                $q
                    ->from('advert_districts')
                    ->whereRaw('users.id = advert_districts.entity_id')
                    ->where('district_id', $district)
                    ->where('type',District::TYPE_USER)
                ;
            });
        }

        if($request->get('with_reviews')) {
            $users->whereHas('reviews');
        }

        if($category = $request->get('category')) {
            $minPrice = $request->get('price_from');
            $maxPrice = $request->get('price_to');

            $users->whereExists(function($q) use($category, $minPrice, $maxPrice) {
                $q
                    ->from('user_executor_categories')
                    ->whereRaw('users.id = user_executor_categories.user_id')
                    ->where('category_id', $category)
                ;

                if($minPrice) {
                    $q->where('price', '>=', $minPrice);
                }
                if($maxPrice) {
                    $q->where('price', '<=', $maxPrice);
                }
            });
        }
        if($type = $request->get('executor_type')) {
            $users->whereHas('workData', function($q) use($type) {
                $q->where('team_type', $type);
            });
        }

        return $users;
    }

    public function services(SearchRequest $request, $limit = self::SERVICES_PER_PAGE): LengthAwarePaginator
    {
        /** @var \Illuminate\Database\Eloquent\Builder $services */
        $services = Service::where('city_id', $request->get('city'));

        if($request->get('with_reviews')) {
            $services->whereHas('user', function($q) {
                $q->whereHas('reviews');
            });
        }
        if($district = $request->get('district')) {
            $services->whereExists(function($q) use($district) {
                $q
                    ->from('advert_districts')
                    ->whereRaw('advert_services.id = advert_districts.entity_id')
                    ->where('district_id', $district)
                    ->where('type', District::TYPE_SERVICE)
                ;
            });
        }
        if($category = $request->get('category')) {
            $services->whereExists(function($q) use($category) {
                $q
                    ->from('advert_service_categories')
                    ->whereRaw('advert_services.id = advert_service_categories.service_id')
                    ->where('category_id', $category)
                ;
            });
        }
        if($type = $request->get('executor_type')) {
            $services->whereExists(function($q) use($type) {
                $q
                    ->from('user_executor_work_data')
                    ->whereRaw('advert_services.id = user_executor_work_data.user_id')
                    ->where('team_type', $type)
                ;
            });
        }

        return $services->paginate($limit);
    }
}

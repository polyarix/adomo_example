<?php

namespace App\UseCase\Advert\Advert\Service;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Service;
use App\Entity\Advert\Category;
use App\Entity\Location\City;
use App\Entity\User\User;
use App\Http\Requests\Api\Advert\Task\FilterRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ServicesService
{
    public function getAll(FilterRequest $request, ?User $user = null, ?City $city = null)
    {
        $query = $this->applyFilter(
            Order::orderByRaw("FIELD(status, '" .Order::STATUS_ACTIVE . "') DESC")
                ->orderBy('moderated_at', 'DESC')
                ->displayable()
                ->visible()
                ->withoutPremium(),
            $request
        )
            ->with(['user', 'executor', 'photos', 'reviews', 'requests', 'category'])
            ->withoutPremium()
        ;

        $query->with(['city' => function($q) {
            return $q->select('name', 'id');
        }]);

        if($cityId = $request->get('city')) {
            $query->where('city_id', $cityId);
        }
        if($districtId = $request->get('district')) {
            $query->where('district_id', $districtId);
        }

        if($user) {
            $query->withCount(['requests' => function($q) use($user) {
                return $q->where('user_id', $user->id);
            }]);
        }

        return $query->paginate(15);
    }

    public function getPremium($limit)
    {
        return Service::with(['city'])->activePremium()->limit($limit)->get();
    }

    public function catchUp(Service $order, User $user, $catchUpDays = 10)
    {
        $order->catchUp(Carbon::now(), $catchUpDays);
    }

    public function incrementView(Service $service)
    {
        if($service->isActive()) {
            $service->increment('views');
        }
    }

    public function getOne($slug): Service
    {
        $service = Service::with(['photos', 'user.reviews.order', 'user.reviews.user', 'videos'])->where('slug', $slug)->first();

        return $service;
    }

    public function recommendations(User $user, FilterRequest $request)
    {
        $query = $this->applyFilter(Order::orderBy('moderated_at', 'DESC')->active(), $request)->with(['user', 'executor', 'photos']);

        if($user->isExecutor() && $user->workData) {
            $categories = $user->workData->categories->pluck('id');

            $query->whereIn('category_id', $categories);
        }

        $query->whereDoesntHave('requests', function($query) use($user) {
            $query->where('user_id', $user->id);
        });

        return $query->paginate(15);
    }

    public function createRequest(User $user, Order $order, ?string $message = null)
    {
        if($user->id === $order->user->id) {
            throw new \InvalidArgumentException('You can\'t create request for own order.');
        }
        if($order->requests()->forUser($user->id)->forOrder($order->id)->exists()) {
            throw new \InvalidArgumentException('You already have request on this offer.');
        }

        $request = $order->requests()->create([
            'user_id' => $user->id,
            'message' => $message
        ]);

        return $request;
    }

    public function offers(User $user, FilterRequest $request)
    {
        if(!$user->isExecutor()) {
            throw new \DomainException('Offers are available only for executors.');
        }

        $requests = $user->orderRequests()
            ->fromCustomer()
            ->orderBy(\DB::raw("FIELD(status, '".Order\Request::STATUS_WAITING."')"), 'asc')
            ->orderBy('created_at', 'ASC')
            ->get();

        $criteria = function($q) use($user) {
            $q->where('user_id', $user->id);
        };

        $ids = $requests->pluck('order_id');

        if($ids->count() === 0) {
            return collect([]);
        }

        $orders = Order::with(['requests' => $criteria, 'user', 'executor', 'photos'])
            ->withCount(['requests' => $criteria])
            ->whereIn('id', $ids)
            ->orderBy(\DB::raw('FIELD(id,' . $ids->join(',') . ')'), 'DESC')
            ->active()
            ->get();

        return collect($orders);
    }

    public function moderate(Service $order): void
    {
        $order->moderate(Carbon::now());
    }

    public function reject(Service $order, string $status, $reason = null): void
    {
        if($status === Service::STATUS_SPAM) {
            $order->toSpam(Carbon::now());
        } elseif ($status === Service::STATUS_REJECTED) {
            $order->reject(Carbon::now(), $reason);
        }
    }

    public function close(Service $order): void
    {
        if(!$order->isActive()) {
            throw new \DomainException('Only active adverts can be closed.');
        }

        $order->close(Carbon::now());
    }

    public function open(Service $order): void
    {
        if(!$order->isClosed()) {
            throw new \DomainException('Only closed adverts can be opened.');
        }

        $order->open();
    }

    protected function applyFilter(Builder $query, FilterRequest $request)
    {
        if($categoryId = $request->get('category')) {
            $categories = Category::find($categoryId)->descendants->pluck('id')->push($categoryId);

            $query->whereIn('category_id', $categories);
        }
        if($priceFrom = $request->input('price.from')) {
            $query->where('price', '>=', $priceFrom);
        }
        if($priceTo = $request->input('price.to')) {
            $query->where('price', '<=', $priceTo);
        }
        if($date = $request->get('date')) {
            $parsed = Carbon::parse($date);

            $query->whereDate('beginning_date', '=', $parsed->format('Y-m-d'));
        }
        if($city = $request->get('city')) {
            $query->where('city_id', $city);
        }
        if($onlyActive = $request['active_only']) {
            $query->active();
        }

        return $query;
    }
}

<?php

namespace App\Http\Controllers\Api\Advert;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use App\Helpers\Http\ResponsesTrait;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Advert\Order\PhotoUploadRequest;
use App\Http\Requests\Api\Advert\Order\Review\StoreRequest;
use App\Http\Requests\Api\Advert\Order\SimilarRequest;
use App\Http\Resources\Advert\AdvertResource;
use App\UseCase\Advert\Advert\Order\OrderService;
use App\UseCase\Advert\Category\CategoryService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    use ResponsesTrait;

    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var CategoryService
     */
    private $categoryService;

    public function __construct(OrderService $orderService, CategoryService $categoryService)
    {
        $this->orderService = $orderService;
        $this->categoryService = $categoryService;
    }

    public function review(Order $order, StoreRequest $request)
    {
        try {
            if(!\Gate::allows('review-order', $order)) {
                abort(403);
            }

            /** @var User $user */
            $user = \Auth::user();

            $this->orderService->addReview($order, $user, $request);

            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function catchUp(Order $order)
    {
        try {
            if(!\Gate::allows('catch-up-order', $order)) {
                abort(403);
            }

            /** @var User $user */
            $user = \Auth::user();

            $this->orderService->catchUp($order, $user, 1);

            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function remove(Order $order)
    {
        try {
            if(!\Gate::allows('delete-order', $order)) {
                abort(403);
            }

            $this->orderService->delete($order);

            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function confirm(Order $order)
    {
        try {
            if(!\Gate::allows('confirm-order-execution', $order)) {
                abort(403);
            }

            /** @var User $user */
            $user = \Auth::user();

            $this->orderService->confirm($order, $user);

            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function visibility(Order $order, Request $request)
    {
        try {
            if(!\Gate::allows('change-order-visibility', $order)) {
                abort(403);
            }

            $data = $this->orderService->setVisibility($order, $request->get('visible', false));

            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function kickExecutor(Order $order)
    {
        try {
            if(!\Gate::allows('kick-order-executor', $order)) {
                abort(403);
            }

            $this->orderService->kickExecutor($order);

            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function similar(SimilarRequest $request)
    {
        $category = $this->categoryService->getById($request->get('category_id'));

        $similarOrders = $this->orderService->findSimilar($category, $request->get('except_id'));

        return AdvertResource::collection($similarOrders);
    }

    public function uploadPhoto(PhotoUploadRequest $request)
    {
        dd($request->file('file'));
    }
}

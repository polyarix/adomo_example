<?php

namespace App\Http\Controllers\Advert;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Category;
use App\Entity\User\Conversation\Message;
use App\Entity\User\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Advert\Order\PhotoUploadRequest;
use App\UseCase\Advert\Advert\Order\OrderService;
use App\UseCase\Advert\Advert\Order\RequestsService;
use App\UseCase\Advert\Category\CategoryService;
use App\UseCase\Advert\Location\CitiesService;
use App\UseCase\User\Conversation\ConversationRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var CitiesService
     */
    private $citiesService;
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var RequestsService
     */
    private $requestsService;
    /**
     * @var ConversationRepository
     */
    private $conversationRepository;

    public function __construct(CategoryService $categoryService, CitiesService $citiesService, OrderService $orderService, RequestsService $requestsService, ConversationRepository $conversationRepository)
    {
        $this->categoryService = $categoryService;
        $this->citiesService = $citiesService;
        $this->orderService = $orderService;
        $this->requestsService = $requestsService;
        $this->conversationRepository = $conversationRepository;
    }

    public function rejectExecutor(Order\Request $request)
    {
        try {
            /** @var User $user */
            $user = \Auth::user();

            $this->requestsService->rejectByOwner($user, $request);

            return redirect()->route('advert.order.show', $request->order)->with('success', 'Заявка успешно отклонена.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function setExecutor(Order\Request $request)
    {
        try {
            /** @var Order $order */
            $order = $request->order;

            /** @var User $author */
            $author = \Auth::user();

            /** @var User $user */
            $user = $request->user;

            $this->orderService->setExecutor($order, $user);

            // create conversation for the users
            $conversation = $this->conversationRepository->createByOrder($order);

            $conversation->messages()->create([
                'message' => 'Условия приняты исполнителем.',
                'type' => Message::TYPE_SUCCESS_NOTIFICATION,
                'user_id' => $user->id,
            ]);
            $conversation->messages()->create([
                'message' => 'Условия приняты заказчиком.',
                'type' => Message::TYPE_SUCCESS_NOTIFICATION,
                'user_id' => $author->id,
            ]);

            return redirect()->route('advert.order.show', $order)->with('success', 'Исполнитель успешно выбран.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        if (!($order->isActive() || $order->isWorking() || $order->isCompleted() || $order->isFinished() || \Gate::allows('show-order', $order))) {
            abort(403);
        }

        $order->load(['user', 'requests', 'photos']);

        /** @var User $user */
        $user = \Auth::user();

        $showCoordinates = \Gate::allows('show_order_coordinates', $order);
        $leftRequest = $user ? $order->requests()->forUser($user->id)->exists() : false;

        $requests = $this->requestsService->getForOrder($order);

        return view('app.advert.order.show', [
            'user' => $user,
            'order' => $order,
            'requests' => $requests,
            'showCoordinates' => $showCoordinates,
            'leftRequest' => $leftRequest,
        ]);
    }

    public function finish(Order $order)
    {
        /** @var User $user */
        $user = \Auth::user();

        if (!($order->isFinished() || $order->reviews()->forUser($user->id)->exists())) {
            abort(403);
        }

        return view('app.advert.order.finish', ['user' => $user, 'order' => $order]);
    }

    public function review(Order $order)
    {
        if (!($order->isFinished() || \Gate::allows('review-order', $order))) {
            abort(403);
        }

        $order->load(['user', 'executor']);

        /** @var User $user */
        $user = \Auth::user();

        if($order->reviews()->forUser($user->id)->exists()) {
            return redirect()->route('advert.order.finish', $order);
        }

        // if the user is owner of the order
        if($order->user_id === $user->id) {
            $target = $order->executor;
        } else {
            $target = $order->user;
        }

        return view('app.advert.order.review', [
            'user' => $user, 'order' => $order, 'target' => $target
        ]);
    }

    public function edit(Order $order)
    {
        if (!\Gate::allows('edit-order', $order)) {
            abort(403);
        }

        $order->load(['photos', 'tags', 'city.districts']);

        return view('app.advert.order.edit', [
            'order' => $order,
            'categories' => $this->categoryService->buildForTree(),
            'cities' => $this->citiesService->getCities(),
        ]);
    }

    public function create(?Category $category = null, ?User $user = null)
    {
        if($user && $user->isCustomer()) {
            $user = null;
        }

        if($user) {
            $reviews = $user->reviews()->with(['user', 'order'])->limit(4)->orderBy('created_at', 'ASC')->get();
        } else {
            $reviews = [];
        }

        return view('app.advert.order.create', [
            'category' => $category,
            'user' => $user,
            'categories' => $this->categoryService->buildForTree(),
            'cities' => $this->citiesService->getCities(),
            'reviews' => $reviews
        ]);
    }

    public function createAs(Order $order)
    {
        /** @var User $user */
        $user = \Auth::user();
        if(!$user->authorOf($order)) {
            return redirect()->back()->with('error', 'Вы можете создавать объявления только на основе своих.');
        }

        return view('app.advert.order.create', [
            'categories' => $this->categoryService->buildForTree(),
            'cities' => $this->citiesService->getCities(),
            'category' => $order->category,
            'order' => $order,
            'user' => null
        ]);
    }

    public function createIndividual(User $user = null)
    {
        $reviews = $user->reviews()->with(['user', 'order'])->limit(4)->orderBy('created_at', 'ASC')->get();

        return view('app.advert.order.create', [
            'category' => null,
            'user' => $user,
            'categories' => $this->categoryService->buildForTree(),
            'cities' => $this->citiesService->getCities(),
            'reviews' => $reviews
        ]);
    }
}

<?php

namespace App\UseCase\Advert\Advert\Order;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Photo;
use App\Entity\Advert\Category;
use App\Entity\User\Conversation\Message;
use App\Entity\User\User;
use App\Events\Advert\Order\OrderClosed;
use App\Events\Advert\Order\OrderModerated;
use App\Events\Advert\Order\OrderOpened;
use App\Events\Advert\Order\OrderRejected;
use App\Events\User\Advert\OrderCompleted;
use App\Events\User\Advert\ReviewAdded;
use App\Events\User\Conversation\MessageSent;
use App\Http\Requests\Api\Advert\Order\Review\StoreRequest;
use App\UseCase\User\Conversation\ConversationService;
use Carbon\Carbon;

class OrderService
{
    /**
     * @var ConversationService
     */
    private $conversationService;

    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    public function getPremium($limit)
    {
        return Order::with(['executor', 'requests'])->activePremium()->limit($limit)->get();
    }

    public function catchUp(Order $order, User $user, $catchUpDays)
    {
        $order->catchUp(Carbon::now(), $catchUpDays);
    }

    public function addReview(Order $order, User $user, StoreRequest $request): Order\Review
    {
        if(!$order->isCompleted()) {
            throw new \DomainException('Order is\'nt completed yet.');
        }
        if($order->reviews()->forUser($user->id)->exists()) {
            throw new \DomainException('You already wrote review.');
        }

        $data = [];
        // it's author, review about customer
        if($order->user_id === $user->id) {
            $data['quality'] = $request->get('quality');
            $data['professionalism'] = $request->get('professionalism');
            $data['punctuality'] = $request->get('punctuality');
            $data['avg'] = array_sum($data) / 3;

            $data['type'] = Order\Review::TYPE_EXECUTOR;
            $data['target_id'] = $order->executor_id;
        } else {
            $data['avg'] = $request->get('grade');

            $data['type'] = Order\Review::TYPE_CUSTOMER;
            $data['target_id'] = $order->user_id;
        }

        /** @var Order\Review $review */
        $review = $order->reviews()->create(array_merge([
            'text' => $request->get('text'),
            'user_id' => $user->id,
        ], $data));

        event(new ReviewAdded($review, $order, $user, $review->target));

        if($conversation = $this->conversationService->findForOrder($order)) {
            $message = $conversation->messages()->create([
                'message' => ($user->isExecutor() ? 'Исполнитель' : 'Заказчик') . ' оставил отзыв.',
                'type' => Message::TYPE_SUCCESS_NOTIFICATION,
                'user_id' => $user->id
            ]);
            $message->load(['conversation', 'sender']);
            event(new MessageSent($data['target_id'], $user->id, $message));
        }

        return $review;
    }

    // finish the order
    public function confirm(Order $order, User $user)
    {
        // $user - confirmed by. Add in a future if need
        $order->toCompleted(Carbon::now());

        $notifyUser = $user->isExecutorFor($order) ? $order->user : $order->executor;
        event(new OrderCompleted($order, $user, $notifyUser));
    }

    // finish the order
    public function setVisibility(Order $order, bool $visible): Order
    {
        if(!$order->isCompleted() && !$order->isFinished()) {
            throw new \DomainException('Изменять настройки отображения можно только к завершенным заказам.');
        }

        if($visible) {
            $order->toVisible();
        } else {
            $order->toHidden();
        }

        return $order;
    }

    public function kickExecutor(Order $order)
    {
        if(!$order->isWorking()) {
            throw new \DomainException('Only for orders in work you can kick executor.');
        }

        $order->requests()->accepted()->update([
            'status' => Order\Request::STATUS_REJECTED
        ]);

        $order->update(['executor_id' => null]);
        $order->toActive();
    }

    public function setExecutor(Order $order, User $user)
    {
        if(!$order->isActive()) {
            throw new \DomainException('Only for active orders you can set executor.');
        }

        /** @var Order\Request $request */
        $request = $order->requests()->forUser($user->id)->first();
        if(!$request) {
            throw new \DomainException('User didn\'t left request to this order.');
        }

        $request->setAccepted();

        $order->requests()
            ->where('id', '!=', $request->id)
            ->update(['status' => Order::STATUS_REJECTED]);

        $order->toWorking($user->id, Carbon::now());
    }

    public function delete(Order $order)
    {
        $order->photos->map(function(Photo $photo) {
            \Storage::delete($photo->path);
            $photo->delete();
        });

        $order->delete();
    }

    public function findSimilar(Category $category, $except = null)
    {
        $similarOrders = $category
            ->orders()
            ->whereNotIn('id', [$except])
            ->active()
            ->orderBy('moderated_at', 'ASC')
            ->paginate(1);

        return $similarOrders;
    }

    public function get(int $id): Order
    {
        return Order::findOrFail($id);
    }

    public function moderate(Order $order): void
    {
        $order->moderate(Carbon::now());
        event(new OrderModerated($order));
    }

    public function reject(Order $order, string $status, $reason = null): void
    {
        if($status === Order::STATUS_SPAM) {
            $order->toSpam(Carbon::now());
        } elseif ($status === Order::STATUS_REJECTED) {
            $order->reject(Carbon::now(), $reason);
        }
        event(new OrderRejected($order));
    }

    public function close(Order $order): void
    {
        if(!$order->isActive()) {
            throw new \DomainException('Only active adverts can be closed.');
        }

        $order->close(Carbon::now());
        event(new OrderClosed($order));
    }

    public function open(Order $order): void
    {
        if(!$order->isClosed()) {
            throw new \DomainException('Only closed adverts can be opened.');
        }

        $order->open();
        event(new OrderOpened($order));
    }
}

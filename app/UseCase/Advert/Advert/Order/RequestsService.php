<?php

namespace App\UseCase\Advert\Advert\Order;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\Conversation\Conversation;
use App\Entity\User\Conversation\Message;
use App\Entity\User\User;
use App\Events\User\Advert\RequestAccepted;
use App\Events\User\Conversation\MessageConversationSent;
use App\Events\User\Conversation\MessageSent;
use App\UseCase\User\Conversation\ConversationRepository;
use Carbon\Carbon;

class RequestsService
{
    /**
     * @var ConversationRepository
     */
    private $conversations;

    public function __construct(ConversationRepository $conversations)
    {
        $this->conversations = $conversations;
    }

    public function getForOrder(Order $order)
    {
        return $order->requests()
            ->with(['user'])
            ->orderBy(\DB::raw("FIELD(status, '".Order\Request::STATUS_ACCEPTED."', '".Order\Request::STATUS_WAITING."')"), 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    public function accept(User $user, Order $order): Message
    {
        $this->checkAccess($order, $user);

        /** @var Order\Request $request */
        if(!($request = $order->requests()->forUser($user->id)->waiting()->fromCustomer()->first())) {
            throw new \DomainException('Не найдено вашей заявки.');
        }

        $request->setAccepted();
        event(new RequestAccepted($order, $user, $order->executor));

        /** @var Conversation $conversation */
        $conversation = $this->conversations->getForOrder($order);

        /** @var Message $message */
        $message = $conversation->messages()->create([
            'user_id' => $order->executor_id,
            'type' => Message::TYPE_SUCCESS_NOTIFICATION,
            'message' => 'Условия приняты'
        ]);
        $message->load(['conversation', 'sender']);

        event(new MessageSent($order->user_id, $user->id, $message));

        $order->toWorking($user->id, Carbon::now());

        return $message;
    }

    public function reject(User $user, Order $order): Message
    {
        $this->checkAccess($order, $user);

        /** @var Order\Request $request */
        if(!($request = $order->requests()->forUser($user->id)->waiting()->fromCustomer()->first())) {
            throw new \DomainException('Не найдено вашей заявки.');
        }

        $request->setRejected();

        $order->update(['executor_id' => null]);

        /** @var Conversation $conversation */
        $conversation = $this->conversations->getForOrder($order);

        /** @var Message $message */
        $message = $conversation->messages()->create([
            'user_id' => $user->id,
            'type' => Message::TYPE_WARNING_NOTIFICATION,
            'message' => 'Предложение отклонено'
        ]);
        $message->load(['conversation', 'sender']);

        event(new MessageSent($order->user_id, $user->id, $message));

        return $message;
    }

    public function rejectByOwner(User $user, Order\Request $request)
    {
        /** @var Order $order */
        $order = $request->order;

        if(!$user->authorOf($order)) {
            throw new \DomainException('Вы не имеете права отклонять заявки.');
        }

        $request->setRejected();
    }

    private function checkAccess(Order $order, User $user)
    {
        if(!$order->isActive()) {
            throw new \DomainException('Объявление не активно.');
        }

        if(!$order->executor || $order->executor->id !== $user->id) {
            throw new \DomainException('Вы не являетесь исполнителем в текущем заказе.');
        }
    }
}

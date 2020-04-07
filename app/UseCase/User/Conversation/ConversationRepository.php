<?php

namespace App\UseCase\User\Conversation;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\Conversation\Conversation;
use App\Entity\User\User;
use SebastianBerc\Repositories\Repository;

class ConversationRepository extends Repository
{
    /*
     * this method is default method for repository package
     *
     * @return Conversation
     * */
    public function takeModel()
    {
        return Conversation::class;
    }

    public function getForOrder(Order $order): Conversation
    {
        return Conversation::where('order_id', $order->id)->first();
    }

    public function getByUserOrder(Order $order, User $user): ?Conversation
    {
        return Conversation::where('order_id', $order->id)->where(
            function ($query) use ($user) {
                $query->where('user_one', $user->id)->orWhere('user_two', $user->id);
            }
        )->first();
    }

    public function createByOrder(Order $order): Conversation
    {
        /** @var Conversation $conversation */
        $conversation = $this->create([
            'user_one' => $order->user->id,
            'user_two' => $order->executor->id,
            'status' => 0,
            'order_id' => $order->id,
            'theme' => $order->title,
        ]);

        return $conversation;
    }

    /*
     * check this given user is exists
     *
     * @param   int $id
     * @return  bool
     * */
    public function existsById($id)
    {
        $conversation = $this->find($id);
        if ($conversation) {
            return true;
        }

        return false;
    }

    /*
     * check this given two users is already make a conversation
     *
     * @param   int $user1
     * @param   int $user2
     * @return  int|bool
     * */
    public function isExistsAmongTwoUsers($user1, $user2)
    {
        $conversation = Conversation::where(
            function ($query) use ($user1, $user2) {
                $query->where(
                    function ($q) use ($user1, $user2) {
                        $q->where('user_one', $user1)
                            ->where('user_two', $user2);
                    }
                )
                    ->orWhere(
                        function ($q) use ($user1, $user2) {
                            $q->where('user_one', $user2)
                                ->where('user_two', $user1);
                        }
                    );
            }
        );

        if ($conversation->exists()) {
            return $conversation->first()->id;
        }

        return false;
    }

    /*
     * check this given user is involved with this given $conversation
     *
     * @param   int $conversationId
     * @param   int $userId
     * @return  bool
     * */
    public function isUserExists($conversationId, $userId)
    {
        $exists = Conversation::where('id', $conversationId)
            ->where(
                function ($query) use ($userId) {
                    $query->where('user_one', $userId)->orWhere('user_two', $userId);
                }
            )
            ->exists();

        return $exists;
    }

    /*
     * retrieve all message thread without soft deleted message with latest one message and
     * sender and receiver user model
     *
     * @param   int $user
     * @param   int $offset
     * @param   int $take
     * @return  collection
     * */
    public function threads($user, $order, $offset, $take)
    {
        $conv = new Conversation();
        $conv->authUser = $user;
        $msgThread = $conv->with(
            [
                'messages' => function ($q) use ($user) {
                    return $q->where(
                        function ($q) use ($user) {
                            $q->where('user_id', $user)
                                ->where('deleted_from_sender', 0);
                        }
                    )
                        ->orWhere(
                            function ($q) use ($user) {
                                $q->where('user_id', '!=', $user);
                                $q->where('deleted_from_receiver', 0);
                            }
                        )
                        ->latest();
                }, 'messages.sender', 'userone', 'usertwo', 'order.requests', 'company'
            ]
        )
            ->withCount(['unreadMessages' => function ($q) use($user) {
                $q->where('user_id', '!=', $user);
            }])
            ->where('user_one', $user)
            ->orWhere('user_two', $user)
            ->offset($offset)
            ->take($take)
            ->orderBy('updated_at', $order)
            ->get();

        $threads = [];

        foreach ($msgThread as $thread) {
            $collection = (object)null;
            $conversationWith = ($thread->userone->id == $user) ? $thread->usertwo : $thread->userone;
            $conversationWith->avatar = $conversationWith->getAvatar();
            $collection->thread = $thread->messages->first();
            $collection->withUser = $conversationWith;
            $collection->order = $thread->order;
            $collection->company = $thread->company;
            $collection->subject = $thread->order ? $thread->order->title : $thread->theme;
            $collection->unseen = $thread->unread_messages_count;
            $threads[] = $collection;
        }

        return collect($threads);
    }

    public function threadById($user, $id)
    {
        $conv = new Conversation();
        $conv->authUser = $user;
        $msgThread = $conv->with(
            [
                'messages' => function ($q) use ($user) {
                    return $q->where(
                        function ($q) use ($user) {
                            $q->where('user_id', $user)
                                ->where('deleted_from_sender', 0);
                        }
                    )
                        ->orWhere(
                            function ($q) use ($user) {
                                $q->where('user_id', '!=', $user);
                                $q->where('deleted_from_receiver', 0);
                            }
                        )
                        ->latest();
                }, 'messages.sender', 'userone', 'usertwo', 'order', 'order.requests', 'company'
            ]
        )
            ->where('id', $id)
            ->get();

        foreach ($msgThread as $thread) {
            $collection = (object)null;
            $conversationWith = ($thread->userone->id == $user) ? $thread->usertwo : $thread->userone;
            $conversationWith->avatar = $conversationWith->getAvatar();
            $collection->thread = $thread->messages->first();
            $collection->withUser = $conversationWith;
            $collection->order = $thread->order;
            $collection->company = $thread->company;
            $collection->subject = $thread->order ? $thread->order->title : $thread->theme;
        }

        return $collection ?? null;
    }

    /*
     * retrieve all message thread with latest one message and sender and receiver user model
     *
     * @param   int $user
     * @param   int $offset
     * @param   int $take
     * @return  collection
     * */
    public function threadsAll($user, $offset, $take)
    {
        $msgThread = Conversation::with(
            [
                'messages' => function ($q) use ($user) {
                    return $q->latest();
                }, 'userone', 'usertwo'
            ]
        )
            ->where('user_one', $user)->orWhere('user_two', $user)->offset($offset)->take($take)->get();

        $threads = [];

        foreach ($msgThread as $thread) {
            $conversationWith = ($thread->userone->id == $user) ? $thread->usertwo : $thread->userone;
            $message = $thread->messages->first();
            $message->user = $conversationWith;
            $threads[] = $message;
        }

        return collect($threads);
    }

    /*
     * get all conversations by given conversation id
     *
     * @param   int $conversationId
     * @param   int $userId
     * @param   int $offset
     * @param   int $take
     * @return  collection
     * */
    public function getMessagesById($conversationId, $userId, $offset, $take)
    {
        return Conversation::with(
            [
                'messages' => function ($query) use ($userId, $offset, $take) {
                    $query->where(
                        function ($qr) use ($userId) {
                            $qr->where('user_id', '=', $userId)
                                ->where('deleted_from_sender', 0);
                        }
                    )
                        ->orWhere(
                            function ($q) use ($userId) {
                                $q->where('user_id', '!=', $userId)
                                    ->where('deleted_from_receiver', 0);
                            }
                        );

                    $query->offset($offset)->take($take);

                }
            ]
        )->with(['userone', 'usertwo'])->find($conversationId);

    }

    /*
     * get all conversations with soft deleted message by given conversation id
     *
     * @param   int $conversationId
     * @param   int $offset
     * @param   int $take
     * @return  collection
     * */
    public function getMessagesAllById($conversationId, $offset, $take)
    {
        return $this->with(
            [
                'messages' => function ($q) use ($offset, $take) {
                    return $q->offset($offset)
                        ->take($take)
                        ->orderBy('created_at', 'DESC')
                    ;
                }, 'userone', 'usertwo'
            ]
        )->find($conversationId);
    }
}

<?php

namespace App\Entity\User\Conversation;

use App\Entity\Advert\Advert\Photo;
use Illuminate\Contracts\Config\Repository;
use App\UseCase\User\Conversation\ConversationRepository;
use App\Entity\User\Conversation\Broadcast;
use App\UseCase\User\Conversation\MessageRepository;

class Talk
{
    /**
     * configurations instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The ConversationRepository class instance.
     *
     * @var ConversationRepository
     */
    protected $conversation;

    /**
     * The MessageRepository class instance.
     *
     * @var MessageRepository
     */
    protected $message;

    /**
     * Broadcast class instance.
     *
     * @var Broadcast
     */
    protected $broadcast;

    /**
     * Currently loggedin user id.
     *
     * @var int
     */
    protected $authUserId;

    /**
     * Initialize and instantiate conversation and message repositories.
     *
     * @param ConversationRepository $conversation
     * @param MessageRepository           $message
     */
    public function __construct(Repository $config, Broadcast $broadcast, ConversationRepository $conversation, MessageRepository $message)
    {
        $this->config = $config;
        $this->conversation = $conversation;
        $this->message = $message;
        $this->broadcast = $broadcast;
    }

    /**
     * make two users as serialize with ascending order.
     *
     * @param int $user1
     * @param int $user2
     *
     * @return array
     */
    protected function getSerializeUser($user1, $user2)
    {
        $user = [];
        $user['one'] = ($user1 < $user2) ? $user1 : $user2;
        $user['two'] = ($user1 < $user2) ? $user2 : $user1;

        return $user;
    }

    /**
     * create a new message by using conversationId.
     *
     * @param int    $conversationId
     * @param string $message
     *
     * @return Message
     */
    protected function makeMessage($conversationId, $message, $attachments = [])
    {
        /** @var Message $message */
        $message = $this->message->create([
            'message' => $message,
            'conversation_id' => $conversationId,
            'user_id' => $this->authUserId,
            'is_seen' => 0,
            'type' => Message::TYPE_MESSAGE
        ]);

        $message->conversation->touch();

        if(count($attachments) > 0) {
            $attachments = Attachment::whereIn('id', $attachments)
                ->where('user_id', $this->authUserId)
                ->whereNull('message_id')
                ->get();

            $message->attachments()->saveMany($attachments);
        }

        return $message;
    }

    /*
     * Make new message collections to response with formatted data
     *
     *@param \Talk\Conversations\Conversation $conversations
     *@return object|bool
     */
    protected function makeMessageCollection($conversations)
    {
        if (!$conversations) {
            return false;
        }

        $collection = (object) null;
        if ($conversations->user_one == $this->authUserId || $conversations->user_two == $this->authUserId) {
            $withUser = ($conversations->userone->id === $this->authUserId) ? $conversations->usertwo : $conversations->userone;
            $collection->withUser = $withUser;
            $collection->messages = $conversations->messages;

            return $collection;
        }

        return false;
    }

    /**
     * make new conversation the given receiverId with currently loggedin user.
     *
     * @param int $receiverId
     *
     * @return int
     */
    protected function newConversation($receiverId)
    {
        $conversationId = $this->isConversationExists($receiverId);
        $user = $this->getSerializeUser($this->authUserId, $receiverId);

        if ($conversationId === false) {
            $conversation = $this->conversation->create([
                'user_one' => $user['one'],
                'user_two' => $user['two'],
                'status' => 1,
            ]);

            if ($conversation) {
                return $conversation->id;
            }
        }

        return $conversationId;
    }

    /**
     * set currently authenticated user id for global usage.
     *
     * @param int $id
     *
     * @return int|bool
     */
    public function setAuthUserId($id = null)
    {
        if (!is_null($id)) {
            return $this->authUserId = $id;
        }

        return false;
    }

    /*
     * its set user id instantly when you fetch or access data. if you you haven't
     * set authenticated user id globally or you want to fetch work with
     * instant users information, you may use it
     *
     * @param   int $id
     * @return  Talk|bool
     * */
    public function user($id = null)
    {
        if ($this->setAuthUserId($id)) {
            return $this;
        }

        return false;
    }

    /**
     * make sure is this conversation exist for this user with currently loggedin user.
     *
     * @param int $userId
     *
     * @return bool|int
     */
    public function isConversationExists($userId)
    {
        if (empty($userId)) {
            return false;
        }

        $user = $this->getSerializeUser($this->authUserId, $userId);

        return $this->conversation->isExistsAmongTwoUsers($user['one'], $user['two']);
    }

    /**
     * check the given user exist for the given conversation.
     *
     * @param int $conversationId
     * @param int $userId
     *
     * @return bool
     */
    public function isAuthenticUser($conversationId, $userId)
    {
        if ($conversationId && $userId) {
            return $this->conversation->isUserExists($conversationId, $userId);
        }

        return false;
    }

    /**
     * send a message by using converstionid.
     *
     * @param int    $conversationId
     * @param string $message
     *
     * @return Message|bool
     */
    public function sendMessage($conversatonId, $message, $attachments = [])
    {
        if ($conversatonId && $message) {
            if ($this->conversation->existsById($conversatonId)) {
                $message = $this->makeMessage($conversatonId, $message, $attachments);

                return $message;
            }
        }

        return false;
    }

    /**
     * create a new message by using receiverid.
     *
     * @param int    $receiverId
     * @param string $message
     *
     * @return Message
     */
    public function sendMessageByUserId($receiverId, $message)
    {
        if ($conversationId = $this->isConversationExists($receiverId)) {
            $message = $this->makeMessage($conversationId, $message);

            return $message;
        }

        $convId = $this->newConversation($receiverId);
        $message = $this->makeMessage($convId, $message);

        return $message;
    }

    /**
     * fetch all inbox for currently loggedin user with pagination.
     *
     * @param int $offset
     * @param int $take
     *
     * @return array
     */
    public function getInbox($order = 'desc', $offset = 0, $take = 20)
    {
        return $this->conversation->threads($this->authUserId, $order, $offset, $take);
    }

    public function getThreadById($id)
    {
        return $this->conversation->threadById($this->authUserId, $id);
    }

    /**
     * fetch all inbox with soft deleted message for currently loggedin user with pagination.
     *
     * @param int $offset
     * @param int $take
     *
     * @return array
     */
    public function getInboxAll($order = 'desc', $offset = 0, $take = 20)
    {
        return $this->conversation->threadsAll($this->authUserId, $order, $offset, $take);
    }

    /**
     * its a alias of getInbox method.
     *
     * @param int $offset
     * @param int $take
     *
     * @return array
     */
    public function threads($order = 'desc', $offset = 0, $take = 20)
    {
        return $this->getInbox($order, $offset, $take);
    }

    /**
     * its a alias of getInboxAll method.
     *
     * @param int $offset
     * @param int $take
     *
     * @return array
     */
    public function threadsAll($order = 'desc', $offset = 0, $take = 20)
    {
        return $this->getInboxAll($order, $offset, $take);
    }

    /**
     * fetch all conversation by using coversation id.
     *
     * @param int $conversationId
     * @param int $offset         = 0
     * @param int $take           = 20
     *
     * @return Message
     */
    public function getConversationsById($conversationId, $offset = 0, $take = 20)
    {
        $conversations = $this->conversation->getMessagesById($conversationId, $this->authUserId, $offset, $take);

        return $this->makeMessageCollection($conversations);
    }

    /**
     * fetch all conversation with soft deleted messages by using coversation id.
     *
     * @param int $conversationId
     * @param int $offset         = 0
     * @param int $take           = 20
     *
     * @return Message
     */
    public function getConversationsAllById($conversationId, $offset = 0, $take = 20)
    {
        $conversations = $this->conversation->getMessagesAllById($conversationId, $offset, $take);

        return $this->makeMessageCollection($conversations);
    }

    /**
     * create a new message by using sender id.
     *
     * @param int $senderId
     * @param int $offset   = 0
     * @param int $take     = 20
     *
     * @return Message|bool
     */
    public function getConversationsByUserId($senderId, $offset = 0, $take = 20)
    {
        $conversationId = $this->isConversationExists($senderId, $this->authUserId);
        if ($conversationId) {
            return $this->getConversationsById($conversationId, $offset, $take);
        }

        return false;
    }

    /**
     * create a new message by using sender id.
     *
     * @param int $senderId
     * @param int $offset   = 0
     * @param int $take     = 20
     *
     * @return Message|bool
     */
    public function getConversationsAllByUserId($senderId, $offset = 0, $take = 20)
    {
        $conversationId = $this->isConversationExists($senderId, $this->authUserId);
        if ($conversationId) {
            return $this->getConversationsAllById($conversationId, $offset, $take);
        }

        return false;
    }

    /**
     * its an alias of getConversationById.
     *
     * @param int $conversationId
     *
     * @return Message|bool
     */
    public function getMessages($conversationId, $offset = 0, $take = 20)
    {
        return $this->getConversationsById($conversationId, $offset, $take);
    }

    public function getMessagesUnseenCount()
    {
        return $this->message->totalUnseenCount($this->authUserId);
    }

    /**
     * its an alias of getConversationAllById.
     *
     * @param int $conversationId
     *
     * @return Message|bool
     */
    public function getMessagesAll($conversationId, $offset = 0, $take = 20)
    {
        return $this->getConversationsAllById($conversationId, $offset, $take);
    }

    /**
     * its an alias by getConversationByUserId.
     *
     * @param int $senderId
     *
     * @return Message|bool
     */
    public function getMessagesByUserId($userId, $offset = 0, $take = 20)
    {
        return $this->getConversationsByUserId($userId, $offset, $take);
    }

    /**
     * its an alias by getConversationAllByUserId.
     *
     * @param int $senderId
     *
     * @return Message|bool
     */
    public function getMessagesAllByUserId($userId, $offset = 0, $take = 20)
    {
        return $this->getConversationsAllByUserId($userId, $offset, $take);
    }

    /**
     * read a single message by message id.
     *
     * @param int $messageId
     *
     * @return Message|bool
     */
    public function readMessage($messageId = null)
    {
        if (!is_null($messageId)) {
            $message = $this->message->with(['sender', 'conversation'])->find($messageId);

            if ($message->coversation->user_one == $this->authUserId || $message->coversation->user_two == $this->authUserId) {
                return $message;
            }
        }

        return false;
    }

    /**
     * make a message as seen.
     *
     * @param int $messageId
     *
     * @return bool
     */
    public function makeSeen($messageId)
    {
        $seen = $this->message->update($messageId, ['is_seen' => 1]);
        if ($seen) {
            return true;
        }

        return false;
    }

    public function makeSeenConversation($conversationId, $forUser)
    {
        $this->message->seenForConversation($conversationId, $forUser);
    }

    /**
     * get receiver information for this conversation.
     *
     * @param int $conversationId
     *
     * @return UserModel
     *
     * @deprecated since version 2.0.0 Remove it from version 2.0.2
     */
    public function getReceiverInfo($conversationId)
    {
        $conversation = $this->conversation->find($conversationId);
        $receiver = '';
        if ($conversation->user_one == $this->authUserId) {
            $receiver = $conversation->user_two;
        } else {
            $receiver = $conversation->user_one;
        }

        $userModel = $this->config('talk.user.model');
        $user = new $userModel();

        return $user->find($receiver);
    }

    /**
     * delete a specific message, its a softdelete process. All message stored in db.
     *
     * @param int $messageId
     *
     * @return bool
     */
    public function deleteMessage($messageId)
    {
        return $this->message->softDeleteMessage($messageId, $this->authUserId);
    }

    /**
     * permanently delete message for this id.
     *
     * @param int $messageId
     *
     * @return bool
     */
    public function deleteForever($messageId)
    {
        $deleteMessage = $this->message->delete($messageId);
        if ($deleteMessage) {
            return true;
        }

        return false;
    }

    /**
     * delete message threat or conversation by conversation id.
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteConversations($id)
    {
        $deleteConversation = $this->conversation->delete($id);
        if ($deleteConversation) {
            return $this->message->deleteMessages($id);
        }

        return false;
    }

    /**
     * its an alias of deleteConversations.
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteThread($id = null)
    {
        return $this->deleteConversations($id);
    }
}

<?php

namespace App\Http\Controllers\Cabinet\Conversation;

use Illuminate\Http\Request;
use App\UseCase\User\Conversation\Facades\Mercurius;
use App\UseCase\User\Conversation\MessageRepository;
use App\UseCase\User\Conversation\UserRepository;

class MessagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index all messages
     *
     * @return mixed
     */
    public function index()
    {
        return view('app.users.conversation.mercurius');
    }

    public function test()
    {
        return view('app.users.conversation.test');
    }

    /**
     * Send a message from the current user.
     *
     * @param MessageRepository $repo
     * @param Request           $request
     *
     * @return array
     */
    public function send(Request $request, MessageRepository $msg, UserRepository $user)
    {
        $request->validate([
            'recipient' => 'required|string',
            'message'   => 'required|string',
        ]);
        $from = $request->user();
        $receiver = $user->find($request->recipient);
        $message = $request->message;

        return response($msg->send($from, $receiver, $message));
    }

    /**
     * Delete message for the current user.
     *
     * @param int               $message
     * @param MessageRepository $repo
     * @param Request           $request
     *
     * @return array
     */
    public function destroy($message, MessageRepository $repo, Request $request, UserRepository $user)
    {
        $msg = Mercurius::model('message')->findOrFail($message);

        return $repo->delete($msg, $request->user()->id);
    }
}

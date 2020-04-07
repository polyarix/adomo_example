<?php

namespace App\Http\Controllers\Cabinet\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Nahid\Talk\Facades\Talk;
use App\Entity\User\User;

class ChatController extends Controller
{
    public function index($id = null)
    {
        Talk::setAuthUserId(Auth::user()->id);

        $thread = null;
        if($id) {
            $thread = Talk::getThreadById($id);
        }

        return view('app.users.conversation.index', [
            'active' => $thread,
        ]);
    }

    public function chatHistory($id)
    {
        $conversations = Talk::getMessagesByUserId($id, 0, 5);
        $user = '';
        $messages = [];
        if(!$conversations) {
            $user = User::find($id);
        } else {
            $user = $conversations->withUser;
            $messages = $conversations->messages;
        }
        if (count($messages) > 0) {
            $messages = $messages->sortBy('id');
        }
        return view('messages.conversations', compact('messages', 'user'));
    }

    public function ajaxSendMessage(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'message-data'=>'required',
                '_id'=>'required'
            ];
            $this->validate($request, $rules);
            $body = $request->input('message-data');
            $userId = $request->input('_id');
            if ($message = Talk::sendMessageByUserId($userId, $body)) {
                $html = view('ajax.newMessageHtml', compact('message'))->render();
                return response()->json(['status'=>'success', 'html'=>$html], 200);
            }
        }
    }

    public function ajaxDeleteMessage(Request $request, $id)
    {
        if ($request->ajax()) {
            if(Talk::deleteMessage($id)) {
                return response()->json(['status'=>'success'], 200);
            }
            return response()->json(['status'=>'errors', 'msg'=>'something went wrong'], 401);
        }
    }

    public function tests()
    {
        dd(Talk::channel());
    }
}

<?php

namespace App\Http\Controllers\Cabinet\Conversation;

class PagesController extends Controller
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
    public function notificationPageSample()
    {
        return View('app.users.conversation.example');
    }

}

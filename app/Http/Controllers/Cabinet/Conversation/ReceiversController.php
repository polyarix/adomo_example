<?php

namespace App\Http\Controllers\Cabinet\Conversation;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\UseCase\User\Conversation\UserRepository;

class ReceiversController extends Controller
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
     * Search for receivers.
     *
     * @param Request        $request
     * @param UserRepository $userRepository
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function search(Request $request, UserRepository $userRepository)
    {
        if (($query = $request->input('q')) === null) {
            return response([
                'hits'  => [],
                'total' => 0,
            ]);
        }

        try {
            $paginator = $userRepository->search($query);

            $result = [
                'total' => $paginator->total(),
                'hits'  => $paginator->items(),
            ];

            return response($result);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}

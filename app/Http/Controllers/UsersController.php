<?php

namespace App\Http\Controllers;

use App\Entity\User\Portfolio\Album;
use App\Entity\User\User;
use App\UseCase\User\Profile\PortfolioService;
use App\UseCase\User\UserService;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var PortfolioService
     */
    private $portfolioService;

    public function __construct(UserService $userService, PortfolioService $portfolioService)
    {
        $this->userService = $userService;
        $this->portfolioService = $portfolioService;
    }

    public function details(User $user)
    {
        $userCategories = [];
        $userPriceList = [];

        if($workData = $user->workData()->with(['districts', 'categories.dimension'])->first()) {
            $workCategories = $workData->categories()->with('dimension')->get()->groupBy('parent_id');
            $userCategories = $this->userService->groupWorkDataCategories($workCategories);
            $userPriceList = $this->userService->groupCategoriesPriceList($workCategories);
        }

        $reviewsRating = $this->userService->buildReviewsForView($user);
        $albums = $this->userService->getAlbums($user);
        $certificates = $this->userService->getCertificates($user);

        $this->userService->incrementView($user, Auth::user());

        $ordersCount = $user->isExecutor() ? $user->services()->active()->count() : $user->orders()->displayable()->count();

        return view('app.users.details', [
            'user' => $user,
            'userCategories' => $userCategories,
            'userPriceList' => $userPriceList,
            'reviewsRating' => $reviewsRating,
            'albums' => $albums,
            'certificates' => $certificates,
            'ordersCount' => $ordersCount,
            'workData' => $workData
        ]);
    }

    public function banned()
    {
        $user = \Auth::user();

        if(!$user->isUnderBan()) {
            return redirect('/');
        }

        return view('app.users.banned', compact('user'));
    }

    public function albumsList(User $user)
    {
        return view('app.users.albums.index', compact('user'));
    }

    public function albumShow(User $user, Album $album)
    {
        list($prev, $next) = $this->portfolioService->getClosestAlbums($album);

        return view('app.users.albums.show', compact('user', 'album', 'prev', 'next'));
    }
}

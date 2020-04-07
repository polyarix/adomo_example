<?php

namespace App\Http\Controllers\Cabinet;

use App\Entity\User\Portfolio\Album;
use App\Entity\User\User;
use App\Http\Controllers\Controller;

class PortfolioController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = \Auth::user();

        return view('app.users.cabinet.portfolio.index', compact('user'));
    }

    public function create()
    {
        /** @var User $user */
        $user = \Auth::user();

        return view('app.users.cabinet.portfolio.create', compact('user'));
    }

    public function edit(Album $portfolio)
    {
        /** @var User $user */
        $user = \Auth::user();

        $portfolio->load(['photos', 'videos']);

        return view('app.users.cabinet.portfolio.edit', [
            'user' => $user,
            'album' => $portfolio,
        ]);
    }
}

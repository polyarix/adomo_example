<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Advert\Advert\Order;
use Illuminate\Routing\Controller;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.dashboard', [

        ]);
    }
}

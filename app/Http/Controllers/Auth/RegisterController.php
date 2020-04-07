<?php

namespace App\Http\Controllers\Auth;

use App\Entity\Advert\Category;
use App\Entity\User\User;
use App\Http\Controllers\Controller;
use App\UseCase\Advert\Location\CitiesService;
use App\UseCase\User\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';
    /**
     * @var CitiesService
     */
    private $citiesService;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(CitiesService $citiesService, UserService $userService)
    {
        $this->middleware('guest')->except(['workData', 'categories']);
        $this->citiesService = $citiesService;
        $this->userService = $userService;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function workData()
    {
        /** @var User $user */
        $user = \Auth::user();

        if($user->isCustomer()) {
            return redirect()->route('home');
        }

        $cities = $this->citiesService->getCities();

        $workData = $user->workData()->with('districts')->first();

        return view('auth.work_data', ['user' => $user, 'cities' => $cities, 'workData' => $workData]);
    }

    public function categories()
    {
        /** @var User $user */
        $user = \Auth::user();
        if($user->isCustomer()) {
            return redirect()->route('home');
        }

        if(!$user->workData) {
            return redirect()->route('sign-up.work-data');
        }

        $categories = Category::withDepth()
            ->defaultOrder()
            ->having('depth', '=', 1)
            ->select(['id', 'name', 'depth'])
            ->with(['children' => function($q) {
                $q->with(['dimension'])->select(['id', 'icon', 'dimension_id', 'icon_work_category', 'image', 'name', 'parent_id', 'slug']);
            }])
            ->get()
            ->toArray();

        $workCategories = $this->userService->getUserWorkCategories($user);

        return view('auth.categories', ['user' => $user, 'categories' => $categories, 'workCategories' => $workCategories]);
    }

    public function showRegistrationForm()
    {
        $defaultUserType = null;

        return view('auth.register', ['type' => $defaultUserType]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}

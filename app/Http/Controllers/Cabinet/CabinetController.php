<?php

namespace App\Http\Controllers\Cabinet;

use App\Entity\Location\City;
use App\Entity\User\Verification\Document;
use App\Entity\User\User;
use App\Events\User\Document\SuccessfulPayed;
use App\Helpers\Factory\Payment\Builder\PaymentInfoFactory;
use App\Helpers\Factory\Payment\Handler\PaymentHandlerFactory;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\Cabinet\DocumentResource;
use App\Http\Resources\User\UserCabinetResource;
use App\Http\Resources\User\UserVerificationResource;
use App\UseCase\Advert\Category\CategoryService;
use App\UseCase\Advert\Location\CitiesService;
use App\UseCase\User\PaymentService;
use App\UseCase\User\Profile\ServicesService;
use App\UseCase\User\UserService;
use Illuminate\Http\Request;
use YandexCheckout\Model\Notification\NotificationSucceeded;
use YandexCheckout\Model\Notification\NotificationWaitingForCapture;
use YandexCheckout\Model\NotificationEventType;
use YandexCheckout\Model\PaymentStatus;

class CabinetController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var ServicesService
     */
    private $servicesService;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var PaymentService
     */
    private $paymentService;
    /**
     * @var CitiesService
     */
    private $citiesService;

    public function __construct(CategoryService $categoryService, ServicesService $servicesService, UserService $userService, PaymentService $paymentService, CitiesService $citiesService)
    {
        $this->categoryService = $categoryService;
        $this->servicesService = $servicesService;
        $this->userService = $userService;
        $this->paymentService = $paymentService;
        $this->citiesService = $citiesService;
    }

    public function payHandle(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        \Log::info('Яндекс callback:');
        \Log::info($request->getContent());

        try {
            $notification = ($data['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
                ? new NotificationSucceeded($data)
                : new NotificationWaitingForCapture($data);
        } catch (\Exception $e) {
            \Log::error($e);
        }

        $payment = $notification->getObject();

        if ($payment->getStatus() === PaymentStatus::SUCCEEDED) {
            $paymentHandler = PaymentHandlerFactory::make($payment);

            event(new SuccessfulPayed($payment));
        }
    }

    public function pay(Request $request)
    {
        $paymentInfo = PaymentInfoFactory::make($request);

        try {
            $response = $this->paymentService->createPayment(
                $paymentInfo->getType(),
                $paymentInfo->getId(),
                $paymentInfo->getAmount(),
                $paymentInfo->getDescription(),
                $paymentInfo->getRedirectUrl(),
                $paymentInfo->getMetaData()
            );

            return redirect($response->confirmation->_confirmationUrl);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reviews()
    {
        /** @var User $user */
        $user = \Auth::user();

        $reviewsRating = $this->userService->buildReviewsForView($user);

        return view('app.users.cabinet.reviews', [
            'user' => $user,
            'reviewsRating' => $reviewsRating,
        ]);
    }

    public function tasks()
    {
        /** @var User $user */
        $user = \Auth::user();

        return view('app.users.cabinet.tasks', [
            'user' => $user,
        ]);
    }

    public function mainInfo()
    {
        /** @var User $user */
        $user = \Auth::user();

        $userInfo = UserCabinetResource::make($user);
        $cities = $this->citiesService->getCities();

        return view('app.users.cabinet.main_info', [
            'userInfo' =>  $userInfo,
            'cities' => $cities
        ]);
    }

    public function verification()
    {
        /** @var User $user */
        $user = \Auth::user();

        $documents = DocumentResource::collection($user->documents);
        $userInfo = UserVerificationResource::make($user);

        return view('app.users.cabinet.verification', [
            'userInfo' =>  $userInfo,
            'documents' => $documents
        ]);
    }

    public function workCategories()
    {
        /** @var User $user */
        $user = \Auth::user();

        if(!$user->isExecutor()) {
            abort(404);
        }

        $workCategories = $this->userService->getUserWorkCategories($user);

        return view('app.users.cabinet.work_categories', [
            'categories' => $this->categoryService->buildForTree(),
            'user' =>  $user,
            'workCategories' => $workCategories,
        ]);
    }
}

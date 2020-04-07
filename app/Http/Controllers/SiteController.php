<?php

namespace App\Http\Controllers;

use App\Entity\Advert\Category;
use App\Entity\Common\FaqQuestion;
use App\Entity\Common\Page;
use App\Entity\Common\Variable;
use App\Entity\Location\City;
use App\Entity\User\Verification\Document;
use App\Entity\User\User;
use App\Service\Main\StatsService;
use App\UseCase\Advert\Advert\AdvertService;
use App\UseCase\Advert\Category\CategoryService;
use App\UseCase\Advert\Location\CitiesService;
use App\UseCase\Site\SliderService;
use App\UseCase\User\Location\LocationService;
use App\UseCase\User\Profile\VerificationService;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * @var VerificationService
     */
    private $verificationService;
    /**
     * @var SliderService
     */
    private $sliderService;
    /**
     * @var StatsService
     */
    private $statsService;
    /**
     * @var AdvertService
     */
    private $advertService;
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var LocationService
     */
    private $locationService;
    /**
     * @var CitiesService
     */
    private $citiesService;

    public function __construct(VerificationService $verificationService, SliderService $sliderService, StatsService $statsService, AdvertService $advertService, CategoryService $categoryService, LocationService $locationService, CitiesService $citiesService)
    {
        $this->verificationService = $verificationService;
        $this->sliderService = $sliderService;
        $this->statsService = $statsService;
        $this->advertService = $advertService;
        $this->categoryService = $categoryService;
        $this->locationService = $locationService;
        $this->citiesService = $citiesService;
    }

    public function index()
    {
        /** @var User $user */
        $user = \Auth::user();

        $configs = Variable::mainPage()->get()->keyBy('key')->pluck('value', 'key');

        $city = City::where('name', $this->locationService->getCity())->first();

        return view('app.main.index', [
            'configs'           => $configs,
            'rootCategories'    => $this->advertService->getAdvertsList($user, $city->id),
            'slides'            => $this->sliderService->mainPage(),
            'successDealsCount' => $this->statsService->successDealsCount(),
            'reviewsCount'      => $this->statsService->reviewsCount(),
            'categories'        => $this->categoryService->buildForTree()
        ]);
    }

    public function setCity(Request $request)
    {
        $city = City::findOrFail($request->get('city'));

        $this->locationService->setCity($city->name);

        return redirect()->back();
    }

    public function autofit()
    {
        $cities = $this->citiesService->getCities();

        $categories = $this->categoryService->buildForTree();

        return view('app.advert.autofit', compact('cities', 'categories'));
    }

    public function pick(Request $request)
    {
        $category = $this->categoryService->getById($request->get('category'));

        $tags = explode(',', $request->get('tags'));

        $orders = $this->categoryService->getServicesByCategoryTag($category, $tags);

        return $orders;
    }

    public function slug(Page $page)
    {
        if($page->isFaq()) {
            return $this->faq();
        }
        if($page->isAbout()) {
            return $this->about();
        }
        if($page->isContacts()) {
            return $this->contacts();
        }

        return abort(404);
    }

    public function search(Request $request)
    {
        $query = trim($request->get('q'));

        /** @var User $user */
        $user = \Auth::user();

        return response()->json($this->advertService->search($query, $user));
    }

    public function faq()
    {
        $questions = FaqQuestion::orderBy('lft', 'ASC')->get();
        $groups = FaqQuestion::select('group_title', 'group')->distinct()->get()->keyBy('group')->pluck('group_title', 'group');
        $configs = Variable::faqPage()->get()->keyBy('key')->pluck('value', 'key');

        return view('app.main.faq', compact('questions', 'groups', 'configs'));
    }

    public function about()
    {
        $configs = Variable::aboutPage()->orWhere('key', 'main_1_count')->get()->keyBy('key')->pluck('value', 'key');

        return view('app.main.about', [
            'configs'           => $configs,
            'successDealsCount' => $this->statsService->successDealsCount(),
            'reviewsCount'      => $this->statsService->reviewsCount(),
            'daily_visitors'    => $configs['main_1_count'] ?? $this->statsService->dailyVisitorsCount(),
            'customers_count'   => $this->statsService->customersCount()
        ]);
    }

    public function contacts()
    {
        $configs = Variable::contactsPage()->orWhere('key')->get()->keyBy('key')->pluck('value', 'key');

        return view('app.main.contacts', compact('configs'));
    }

    public function doc(Document $document)
    {
        /** @var User $user */
        $user = \Auth::user();

        if($document->isPrivate()) {
            if(!$user) {
                abort(404);
            }

            try {
                $this->verificationService->checkDocumentOwning($user, $document);
            } catch (\Exception $e) {
                abort(404);
            }
        }

        return response()->file(storage_path($document->getPath()));
    }

    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move(public_path('images'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName);
            $msg = 'Image uploaded successfully';

            return response("<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>")
                ->header('Content-type', 'text/html; charset=utf-8');
        }

        return abort(404);
    }
}

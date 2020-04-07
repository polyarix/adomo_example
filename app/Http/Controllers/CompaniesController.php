<?php

namespace App\Http\Controllers;

use App\Entity\Advert\Category;
use App\Entity\Blog\Comment;
use App\Entity\Contact\Contact;
use App\Entity\User\Company\Article;
use App\Entity\User\Company\Company;
use App\Entity\Blog\Category as BlogCategory;
use App\Entity\User\Company\Portfolio\Work;
use App\Entity\User\User;
use App\UseCase\User\Company\CompanyService;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * @var CompanyService
     */
    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function create()
    {
        /** @var User $user */
        $user = \Auth::user();

        if(!$user) {
            return redirect()->back();
        }

        $categories = Category::withDepth()
            ->defaultOrder()
            ->having('depth', '=', 1)
            ->select(['id', 'name', 'depth'])
            ->with(['children.dimension'])
            ->get()
            ->toArray();

        return view('app.companies.company.create', compact('user', 'categories'));
    }

    public function about(Company $company)
    {
        if(\Gate::denies('edit-company-about', $company)) {
            return redirect()->back()->with('error', 'You dont have permissions to see the page.');
        }

        /** @var User $user */
        $user = \Auth::user();

        return view('app.companies.company.about', compact('user', 'company'));
    }

    public function contacts(Company $company)
    {
        if(\Gate::denies('edit-company-contacts', $company)) {
            return redirect()->back()->with('error', 'You dont have permissions to see the page.');
        }

        /** @var User $user */
        $user = \Auth::user();

        /** @var Contact $contacts */
        $contacts = $company->contacts;

        return view('app.companies.company.contacts', compact('user', 'company', 'contacts'));
    }

    public function categories(Company $company)
    {
        if(\Gate::denies('edit-company-categories', $company)) {
            return redirect()->back()->with('error', 'You dont have permissions to see the page.');
        }

        /** @var User $user */
        $user = \Auth::user();

        $categories = Category::withDepth()
            ->defaultOrder()
            ->having('depth', '=', 1)
            ->select(['id', 'name', 'depth'])
            ->with(['children.dimension'])
            ->get()
            ->toArray();

        $workCategories = $company->categories()->withPivot('price')->get()->pluck('pivot.price', 'id')->toArray();

        return view('app.companies.company.categories', compact('user', 'company', 'categories', 'workCategories'));
    }

    public function index(Category $category = null)
    {
        $totalCompanies = $this->companyService->getCount($category);

        return view('app.companies.index', compact('totalCompanies', 'category'));
    }

    public function show(Company $company)
    {
        $categories = $this->companyService->getCompanyCategories($company);

        $articles = $company->articles()->orderBy('created_at', 'DESC')->limit(2)->get();

        $contacts = $company->contacts;
        $works = $company->works()->orderBy('created_at', 'DESC')->limit(2)->get();

        return view('app.companies.show', compact('company', 'categories', 'articles', 'contacts', 'works'));
    }

    public function album(Company $company, Work $album)
    {
        list($prev, $next) = $this->companyService->getClosestWorks($company, $album);

        return view('app.companies.works.show', compact('company', 'album', 'next', 'prev'));
    }

    public function createAlbum(Company $company)
    {
        return view('app.companies.works.create', compact('company'));
    }

    public function editAlbum(Company $company, Work $album)
    {
        $album->load('videos');

        return view('app.companies.works.edit', compact('company', 'album'));
    }

    public function blog(Company $company)
    {
        if(\Gate::denies('edit-company-blog', $company)) {
            abort(403);
        }
        $categories = BlogCategory::select(['id', 'name'])->get();

        return view('app.companies.blog.create', compact('company', 'categories'));
    }

    public function articleEdit(Company $company, Article $article)
    {
        if(\Gate::denies('edit-company-blog', $company)) {
            abort(403);
        }
        $categories = BlogCategory::select(['id', 'name'])->get();

        $article->load(['categories']);

        return view('app.companies.blog.edit', compact('company', 'article', 'categories'));
    }

    public function albums(Company $company)
    {
        return view('app.companies.works.index', compact('company'));
    }

    public function articles(Company $company, BlogCategory $category)
    {
        $categories = BlogCategory::all();

        return view('app.companies.blog.index', compact('company', 'category', 'categories'));
    }

    public function article(Company $company, Article $article)
    {
        $article->load(['categories', 'comments.user']);

        $comments = $article->comments;
        $similarArticles = $company->articles()
            ->where('id', '!=', $article->id)
            ->whereHas('categories', function($q) use($article) {
                $q->whereIn('category_id', $article->categories->pluck('id'));
            })
            ->limit(2)
            ->get()
        ;

        $article->increment('views');

        return view('app.companies.blog.show', compact('company', 'article', 'comments', 'similarArticles'));
    }

    public function comment(Company $company, Article $article, Request $request)
    {
        /** @var User $user */
        $user = \Auth::user();

        $comment = $article->comments()->create([
            'text' => $request->get('text'),
            'user_id' => $user->id,
            'type' => BlogCategory::TYPE_COMPANY,
            'status' => Comment::STATUS_ACTIVE
        ]);

        return response()->json(['success' => true, 'data' => $comment]);
    }
}

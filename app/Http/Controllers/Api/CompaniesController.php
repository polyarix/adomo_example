<?php

namespace App\Http\Controllers\Api;

use App\Entity\Advert\Category;
use App\Entity\User\Company\Article;
use App\Entity\User\Company\Company;
use App\Entity\User\Company\Portfolio\Work;
use App\Entity\User\Company\Portfolio\Photo;
use App\Entity\User\User;
use App\Helpers\Http\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Advert\Order\PhotoUploadRequest;
use App\Http\Requests\Api\Company\Article\StoreRequest;
use App\Http\Requests\Api\Company\Company\CoverRequest;
use App\Http\Requests\Api\Company\Company\LogoRequest;
use App\Http\Requests\Api\Company\Company\UpdateRequest;
use App\Http\Requests\Api\User\Cabinet\WorkCategories\CategoryPriceRequest;
use App\Http\Resources\Blog\ArticlesResource;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\User\AlbumResource;
use App\UseCase\User\Company\CompanyService;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Company\Company\StoreRequest as StoreCompanyRequest;
use Storage;

class CompaniesController extends Controller
{
    use ResponsesTrait;

    /**
     * @var CompanyService
     */
    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function uploadLogo(Request $request)
    {
        $photo = $this->companyService->uploadPhoto($request->file('logo'), 'companies/logos', 150);

        return $this->success(['relative_url' => $photo->path]);
    }

    public function updateCategoryPrice(CategoryPriceRequest $request, Company $company)
    {
        try {
            $this->companyService->updateCategoryPrice($company, $request);

            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function createCompany(StoreCompanyRequest $request)
    {
        try {
            /** @var User $user */
            $user = \Auth::user();

            $company = \DB::transaction(function() use($request, $user) {
                if(($logoPath = $request->get('logo')) && !Storage::disk('public')->exists($logoPath)) {
                    $logoPath = null;
                }

                /** @var Company $company */
                $company = Company::create([
                    'name' => $name = $request->get('name'),
                    'slug' => SlugService::createSlug(Company::class, 'slug', $name),
                    'workers_count' => $request->get('workers_count'),
                    'description' => $request->get('description'),
                    'city_id' => $request->get('city_id'),
                    'logo' => $logoPath,
                    'user_id' => $user->id,
                ]);

                @list($lat, $long) = $request->get('coords');
                $company->contacts()->create([
                    'address' => $request->get('address'),
                    'contacts' => $request->get('contacts'),
                    'schedule' => $request->get('schedule'),
                    'map_long' => $long,
                    'map_lat' => $lat,
                ]);

                $categories = Category::whereIn('id', array_unique(array_keys($categoriesList = $request->get('categories'))))->get();

                $data = [];
                foreach ($categories as $category) {
                    $data[$category->id] = ['company_id' => $company->id, 'price' => $categoriesList[$category->id] ?? null];
                }
                $company->categories()->attach($data);

                return $company;
            });

            $company->load(['contacts', 'categories']);

            return $this->success($company);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $companies = $this->companyService->getCompanies(Category::where('id', $request->get('category_id'))->first());

        return CompanyResource::collection($companies);
    }

    public function about(Company $company, UpdateRequest $request)
    {
        if(\Gate::denies('edit-company-about', $company)) {
            abort(403);
        }

        $company->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'workers_count' => $request->get('workers_count'),
        ]);

        return $this->success($company);
    }

    public function logoUpdate(Company $company, LogoRequest $request)
    {
        if(\Gate::denies('edit-company-about', $company)) {
            abort(403);
        }

        $photo = $this->companyService->uploadPhoto($request->file('logo'), 'companies/logos');

        $company->update(['logo' => $photo->path]);

        return $this->success(['relative_url' => $photo->path]);
    }

    public function createArticle(Company $company, StoreRequest $request)
    {
        /** @var User $user */
        $user = \Auth::user();

        try {
            $article = \DB::transaction(function() use($request, $company, $user) {
                /** @var Article $article */
                $article = Article::create([
                    'title' => $request->get('title'),
                    'slug' => SlugService::createSlug(Article::class, 'slug', $request->get('title')),
                    'content' => $request->get('content'),
                    'company_id' => $company->id,
                    'user_id' => $user->id,
                    'image' => $this->companyService->uploadPhoto($request->file('preview'), 'company/articles')->path,
                ]);

                $article->categories()->detach();
                array_map(function($categoryId) use($article) {
                    $article->categories()->attach($categoryId, ['article_id' => $article->id]);
                }, $request->get('categories'));

                return $article;
            });

            return $this->success($article);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function uploadPhoto(Company $company, PhotoUploadRequest $request)
    {
        if(\Gate::denies('edit-company-works', $company)) {
            abort(403);
        }

        $file = $this->companyService->uploadPhoto($request->file('file'), 'companies/works');

        $photo = Photo::create([
            'path' => $file->path, 'crop' => $file->crop, 'work_id' => null
        ]);

        return response()->json([
            'data' => $photo->path, 'code' => 200, 'id' => $photo->id, 'msg' => ''
        ]);

    }

    public function updateAlbum(Company $company, Work $album, Request $request)
    {
        if(\Gate::denies('edit-company-works', $company)) {
            abort(403);
        }

        /** @var User $user */
        $user = \Auth::user();

        try {
            /** @var Work $work */
            $album->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'price' => $request->get('price'),
                'duration' => $request->get('duration'),
                'duration_type' => $request->get('duration_type'),
            ]);

            $album->photos()->update(['work_id' => null]);

            $photos = Photo::whereIn('id', $request->get('photos'))->whereNull('work_id')->get();
            $album->photos()->saveMany($photos);

            $album->videos()->delete();
            if($videos = $request->get('videos')) {
                foreach ($videos as $url) {
                    // updateOrCreate - for save unique video urls
                    $album->videos()->updateOrCreate(['url' => $url, 'morph_id' => $album->id, 'morph_type' => Work::class]);
                }
            }

            return $this->success($album);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function createAlbum(Company $company, Request $request)
    {
        if(\Gate::denies('edit-company-works', $company)) {
            abort(403);
        }

        /** @var User $user */
        $user = \Auth::user();

        try {
            /** @var Work $work */
            $work = Work::create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'price' => $request->get('price'),
                'duration' => $request->get('duration'),
                'duration_type' => $request->get('duration_type'),
                'company_id' => $company->id,
                'user_id' => $user->id,
            ]);

            $photos = Photo::whereIn('id', $request->get('photos'))->whereNull('work_id')->get();
            $work->photos()->saveMany($photos);

            if($videos = $request->get('videos')) {
                foreach ($videos as $url) {
                    // updateOrCreate - for save unique video urls
                    $work->videos()->updateOrCreate(['url' => $url, 'morph_id' => $work->id, 'morph_type' => Work::class]);
                }
            }

            return $this->success($work);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function articleUpdate(Company $company, Article  $article, Request $request)
    {
        if(\Gate::denies('edit-company-blog', $company)) {
            abort(403);
        }
        if($request->hasFile('preview')) {
            $image = $this->companyService->uploadPhoto($request->file('preview'), 'company/articles')->path;
        } else {
            $image = $article->image;
        }

        $article->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'image' => $image,
        ]);

        $article->categories()->detach();
        array_map(function($categoryId) use($article) {
            $article->categories()->attach($categoryId, ['article_id' => $article->id]);
        }, $request->get('categories'));

        return $this->success($article);
    }

    public function coverUpdate(Company $company, CoverRequest $request)
    {
        if(\Gate::denies('edit-company-about', $company)) {
            abort(403);
        }

        $photo = $this->companyService->uploadPhoto($request->file('image'), 'companies/covers');

        $company->update(['cover' => $photo->path]);

        return $this->success(['url' => $photo->path]);
    }

    public function works(Company $company, Request $request)
    {
        $q = $company->works()->withCount('photos')->orderBy('created_at', 'DESC');

        return AlbumResource::collection($q->paginate(Work::PER_PAGE));
    }

    public function attachCategory(Company $company, Request $request)
    {
        $categoryId = $request->get('category_id');

        try {
            if(\Gate::denies('edit-company-categories', $company)) {
                throw new \DomainException('Operation not permitted.');
            }

            if($company->categories()->where('category_id', $categoryId)->exists()) {
                return $this->success([]);
            }

            $company->categories()->attach($categoryId, ['company_id' => $company->id]);

            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function detachCategory(Company $company, Request $request)
    {
        $categoryId = $request->get('category_id');

        try {
            if(\Gate::denies('edit-company-categories', $company)) {
                throw new \DomainException('Operation not permitted.');
            }

            $company->categories()->detach($categoryId);

            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function contacts(Company $company, Request $request)
    {
        @list($lat, $long) = $request->get('coords', []);

        try {
            if(\Gate::denies('edit-company-contacts', $company)) {
                throw new \DomainException('You don\t have permissions to update the information.');
            }

            $data = [
                'address' => $request->get('address'),
                'contacts' => $request->get('contacts'),
                'schedule' => $request->get('schedule'),
                'map_lat' => $lat,
                'map_long' => $long,
            ];

            if($company->contacts) {
                $company->contacts->update($data);
            } else {
                $company->contacts->create($data);
            }


            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function articles(Company $company, Request $request)
    {
        $q = $company->articles()->orderBy('created_at', 'DESC');

        if($categoryId = $request->get('category')) {
            $q->whereHas('categories', function($q) use($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        return ArticlesResource::collection($q->paginate(Article::PER_PAGE));
    }
}

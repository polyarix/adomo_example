<?php

namespace App\Http\Controllers\Admin\Companies;

use App\Entity\User\AdminUser as User;
use App\Entity\User\Company\Article;
use App\Entity\User\Company\Company;
use App\Entity\User\Company\Portfolio\Photo;
use App\Entity\User\Company\Portfolio\Work;
use App\UseCase\User\Company\CompanyService;
use App\UseCase\User\UserService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Company\Work\StoreRequest;
use App\Http\Requests\Admin\Company\Work\UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Cviebrock\EloquentSluggable\Services\SlugService;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;

/**
 * Class CompanyWorksController
 * @package App\Http\Controllers\Admin\Companies
 * @property-read CrudPanel $crud
 */
class CompanyWorksController extends CrudController
{
    /**
     * @var CompanyService
     */
    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        parent::__construct();
        $this->companyService = $companyService;
    }

    public function setup()
    {
        $this->crud->setModel(Work::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/company/works');
        $this->crud->setEntityNameStrings('работу', 'работ');

        $this->crud->addFilter(['type' => 'text', 'name' => 'id', 'label'=> 'ID'],
        false,
        function($value) {
            $this->crud->addClause('where', 'id', $value);
        });

        $this->crud->addFilter(['type' => 'text', 'name' => 'company_id', 'label'=> 'ID компании'],
        false,
        function($value) {
            $this->crud->addClause('where', 'company_id', $value);
        });

        $this->crud->addFilter(['type' => 'text', 'name' => 'user_id', 'label'=> 'ID пользователя'],
        false,
        function($value) {
            $this->crud->addClause('where', 'user_id', $value);
        });

        $this->crud->disableResponsiveTable();

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'title', 'label' => 'Заголовок'],
            ['name' => 'company_id', 'label' => 'Компания', 'type' => 'model_function', 'function_name' => 'getCompanyWithLink', 'limit' => -1],
            ['name' => 'user_id', 'label' => 'Автор', 'type' => 'model_function', 'function_name' => 'getUserWithLink', 'limit' => -1]
        ]);

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'update');

        // common fields
        $this->crud->addFields([
            ['name' => 'title', 'label' => 'Заголовок'],
            ['name' => 'description', 'type' => 'ckeditor', 'label' => 'Описание', 'options' => [
                'filebrowserUploadUrl' => route('ckeditor.upload'),
                'filebrowserUploadMethod' => 'form'
            ]],

            ['name' => 'price', 'label' => 'Стоимость'],
            ['name' => 'duration', 'label' => 'Длительность'],
            ['name' => 'duration_type', 'label' => 'Формат длительности', 'type' => 'select_from_array', 'options' => Work::getDurationTypes()],
            [
                'name' => 'company_id',
                'type' => 'select2',
                'label' => 'Компания',
                'attribute' => 'name',
                'entity' => 'company',
                'model' => Company::class,
            ],
            [
                'name' => 'user_id',
                'type' => 'select2',
                'label' => 'Автор',
                'attribute' => 'email',
                'entity' => 'user',
                'model' => User::class,
            ],
            [
                'label' => 'Фото',
                'type' => 'upload_multiple',
                'name' => 'photos',
                'attribute' => 'path',
                'upload' => true,
            ],
        ]);
    }

    public function store(StoreRequest $request)
    {
        $slug = $request->get('slug') ?? SlugService::createSlug(Article::class, 'slug', $request->get('title'));

        $request->merge(['slug' => $slug]);

        $redirect_location = parent::storeCrud($request);

        $this->handlePhotos($request);

        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        $this->handlePhotos($request);
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    protected function handlePhotos(Request $request)
    {
        /** @var Work $entity */
        $entity = $this->crud->entry;

        $entity->photos()->delete();

        if($photos = $request->photos) {
            foreach ($photos as $photo) {
                if(is_null($photo) || $photo instanceof UploadedFile) {
                    continue;
                }

                $photo = $this->companyService->uploadPhoto($photo, 'companies/works', Photo::MAX_ALLOWED_WIDTH);

                $entity->photos()->create([
                    'path' => $photo->path,
                    'crop' => $photo->crop,
                ]);
            }
        }
    }
}

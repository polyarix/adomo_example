<?php

namespace App\Http\Controllers\Admin\Companies;

use App\Entity\Blog\Category;
use App\Entity\User\AdminUser as User;
use App\Entity\User\Company\Article;
use App\Entity\User\Company\Company;
use App\Helpers\Services\Infrastructure\Seo\SeoHelper;
use App\UseCase\User\UserService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Company\Article\StoreRequest;
use App\Http\Requests\Admin\Company\Article\UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Cviebrock\EloquentSluggable\Services\SlugService;

/**
 * Class CompanyArticlesController
 * @package App\Http\Controllers\Admin\Companies
 * @property-read CrudPanel $crud
 */
class CompanyArticlesController extends CrudController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function setup()
    {
        $this->crud->setModel(Article::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/company/articles');
        $this->crud->setEntityNameStrings('статью', 'статей');

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

        $this->crud->addFilter(['type' => 'text', 'name' => 'slug', 'label'=> 'Slug'],
        false,
        function($value) {
            $this->crud->addClause('where', 'slug', $value);
        });

        $this->crud->addFilter(['name' => 'role', 'type' => 'select2', 'label'=> 'Статус'], function() {
            return ['Черновик', 'Опубликовано'];
        }, function($value) {
            $this->crud->addClause('where', 'is_visible', $value);
        });

        $this->crud->disableResponsiveTable();

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'title', 'label' => 'Заголовок'],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ['name' => 'user_id', 'label' => 'Автор', 'type' => 'model_function', 'function_name' => 'getUserWithLink', 'limit' => -1],
            ['name' => 'is_visible', 'label' => 'Отображается', 'type' => 'boolean', 'options' => [0 => 'Нет', 1 => 'Да']],
            ['name' => 'company_id', 'label' => 'Компания', 'type' => 'model_function', 'function_name' => 'getCompanyWithLink', 'limit' => -1]
        ]);

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'update');

        $this->crud->orderBy('id', 'DESC');

        // common fields
        $this->crud->addFields([
            ['name' => 'title', 'label' => 'Заголовок', 'tab' => 'Основное'],
            ['name' => 'content', 'type' => 'ckeditor', 'label' => 'Статья', 'tab' => 'Основное', 'options' => [
                'filebrowserUploadUrl' => route('ckeditor.upload'),
                'filebrowserUploadMethod' => 'form'
            ]],
            [
                'name' => 'categories',
                'type' => 'select2_multiple',
                'label' => 'Категории',
                'tab' => 'Основное',
                'attribute' => 'name',
                'entity' => 'categories',
                'model' => Category::class,
                'pivot' => true,
                'table' => 'company_article_categories',
            ],
            ['name' => 'slug', 'label' => 'Slug', 'tab' => 'Основное'],
            [
                'name' => 'company_id',
                'type' => 'select2',
                'label' => 'Компания',
                'tab' => 'Основное',
                'attribute' => 'name',
                'entity' => 'company',
                'model' => Company::class,
            ],
            [
                'name' => 'user_id',
                'type' => 'select2',
                'label' => 'Автор',
                'tab' => 'Основное',
                'attribute' => 'email',
                'entity' => 'user',
                'model' => User::class,
            ],
            [
                'label' => 'Превью',
                'name' => 'image',
                'type' => 'upload',
                'upload' => true,
                'crop' => false,
                'aspect_ratio' => 0,
                'disk' => 'public',
                'tab' => 'Основное'
            ],
            ['name' => 'is_visible', 'type' => 'boolean', 'label' => 'Отображается', 'options' => ['Нет', 'Да'], 'tab' => 'Основное'],
        ]);

        // seo fields
        SeoHelper::controller($this->crud, [SeoHelper::FIELD_SEO_TEXT, SeoHelper::FIELD_BREADCRUMB_NAME]);
    }

    public function store(StoreRequest $request)
    {
        $slug = $request->get('slug') ?? SlugService::createSlug(Article::class, 'slug', $request->get('title'));

        $request->merge(['slug' => $slug]);

        $redirect_location = parent::storeCrud($request);
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

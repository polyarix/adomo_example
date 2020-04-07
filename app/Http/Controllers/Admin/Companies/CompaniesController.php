<?php

namespace App\Http\Controllers\Admin\Companies;

use App\Entity\Advert\Category;
use App\Entity\Location\City;
use App\Entity\User\AdminUser as User;
use App\Entity\User\Company\Company;
use App\UseCase\User\UserService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Company\Company\StoreRequest;
use App\Http\Requests\Admin\Company\Company\StoreRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

/**
 * Class CompaniesController
 * @package App\Http\Controllers\Admin\Companies
 * @property-read CrudPanel $crud
 */
class CompaniesController extends CrudController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * CompaniesController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     *
     */
    public function setup()
    {
        $this->crud->setModel(Company::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/companies');
        $this->crud->setEntityNameStrings('компанию', 'компаний');

        $this->crud->addFilter(['type' => 'text', 'name' => 'id', 'label'=> 'ID'],
        false,
        function($value) {
            $this->crud->addClause('where', 'id', $value);
        });

        $this->crud->disableResponsiveTable();
        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'name', 'label' => 'Название'],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ['name' => 'user_id', 'title' => 'id', 'type' => 'model_function', 'entity' => 'user', 'attribute' => 'email', 'model' => User::class, 'label' => 'Пользователь', 'function_name' => 'getUserWithLink', 'limit' => -1],
            ['name'  => 'city_id', 'label' => 'Город', 'type'  => 'select2', 'attribute' => 'name', 'model' => City::class, 'entity' => 'city'],
        ]);

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'update');

        $this->crud->allowAccess('show');

        $this->crud->addFields([
            ['name' => 'name', 'label' => 'Название', 'tab' => 'Основное'],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'tab' => 'Основное'],
            ['name' => 'user_id', 'title' => 'id', 'type' => 'select2', 'entity' => 'user', 'attribute' => 'email', 'model' => User::class, 'label' => 'Пользователь', 'tab' => 'Основное'],
            ['name'  => 'city_id', 'label' => 'Город', 'type'  => 'select2', 'attribute' => 'name', 'model' => City::class, 'entity' => 'city', 'tab' => 'Основное'],
            ['name' => 'description', 'label' => 'О компании', 'type' => 'textarea', 'tab' => 'Основное'],
            [
                'label' => 'Категории',
                'type' => 'select2_multiple',
                'name' => 'categories',
                'entity' => 'categories',
                'attribute' => 'name_with_parent',
                'model' => Category::class,
                'pivot' => true,
                'tab' => 'Основное',
                'table' => 'company_article_categories',
            ],
            ['name'  => 'logo', 'label' => 'Логотип', 'type' => 'image', 'width' => '50px', 'upload' => true, 'crop' => false, 'disk' => 'public', 'tab' => 'Основное'],
            ['name'  => 'cover', 'label' => 'Фоновая картинка', 'type' => 'image', 'width' => '1000px', 'upload' => true, 'crop' => false, 'disk' => 'public', 'tab' => 'Основное'],
            ['name'  => 'workers_count', 'label' => 'К-во работников', 'type' => 'text', 'tab' => 'Основное'],
            ['name' => 'subscription_option', 'label' => 'Доступы компании', 'type' => 'checkbox','tab' => 'Основное']
        ]);

        $this->crud->addFields([
            ['name' => 'contact.address', 'label' => 'Адрес', 'type' => 'textarea', 'tab' => 'Контакты'],
            ['name' => 'contact.contacts', 'label' => 'Связь', 'type' => 'textarea', 'tab' => 'Контакты',  'fake' => true],
            ['name' => 'contact.schedule', 'label' => 'График работы', 'type' => 'textarea', 'tab' => 'Контакты'],
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $slug = $request->get('slug') ?? SlugService::createSlug(Company::class, 'slug', $request->get('name'));

        $request->merge(['slug' => $slug]);

        $redirect_location = parent::storeCrud($request);

        $this->handleContacts($this->crud->entry, $request);

        return $redirect_location;
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);

        $this->handleContacts($this->crud->entry, $request);

        return $redirect_location;
    }

    /**
     * @param int $id
     * @return \Backpack\CRUD\app\Http\Controllers\Operations\Response
     */
    public function edit($id)
    {
        $company = $this->getCompany($id);

        $contacts = $company->contacts;

        $this->crud->addFields([
            ['name' => 'contact.address', 'label' => 'Адрес', 'type' => 'textarea', 'tab' => 'Контакты', 'value' => data_get($contacts, 'address')],
            ['name' => 'contact.contacts', 'label' => 'Связь', 'type' => 'textarea', 'tab' => 'Контакты',  'fake' => true, 'value' => data_get($contacts, 'contacts')],
            ['name' => 'contact.schedule', 'label' => 'График работы', 'type' => 'textarea', 'tab' => 'Контакты', 'value' => data_get($contacts, 'schedule')],
        ]);

        return parent::edit($id);
    }

    /**
     * @param int $id
     * @return \Backpack\CRUD\app\Http\Controllers\Operations\Response
     */
    public function show($id)
    {
        $this->crud->addColumn(['name' => 'description', 'label' => 'Описание', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'logo', 'label' => 'Логотип', 'type' => 'image', 'prefix' => '/storage/']);
        $this->crud->addColumn(['name' => 'cover', 'label' => 'Фоновая картинка', 'type' => 'image', 'prefix' => '/storage/']);
        $this->crud->addColumn(['name' => 'workers_count', 'label' => 'К-во рабоников', 'type' => 'text']);

        $this->crud->addColumn(['name' => 'contacts.address', 'label' => 'Адрес', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'contacts.contacts', 'label' => 'Контакты', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'contacts.schedule', 'label' => 'График работы', 'type' => 'text']);

        $this->crud->addColumn(['name' => 'subscription_option', 'label' => 'Доступы компании', 'type' => 'check']);
        $this->crud->addColumn(['name' => 'subscription_date_to', 'label' => 'Подписка до:', 'type' => 'datetime']);

        $this->crud->addColumn([
            'name' => 'works',
            'label' => 'Работы',
            'type' => 'view',
            'columns' => ['id' => 'ID', 'title' => 'Заголовок'],
            'routes' => ['title' => 'crud.company/works.edit'],
            'view' => 'vendor.backpack.crud.columns.table_relation',
        ]);

        $this->crud->addColumn([
            'name' => 'articles',
            'label' => 'Статьи',
            'type' => 'view',
            'columns' => ['id' => 'ID', 'title' => 'Заголовок'],
            'routes' => ['title' => ['name' => 'crud.company/articles.edit', 'attribute' => 'id']],
            'view' => 'vendor.backpack.crud.columns.table_relation',
        ]);

        $content =  parent::show($id);

        return $content;
    }

    /**
     * @param Company $company
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function handleContacts(Company $company, Request $request)
    {
        $data = [
            'address' => $request->get('contact_address'),
            'contacts' => $request->get('contact_contacts'),
            'schedule' => $request->get('contact_schedule'),
        ];

        if(!$company->hasFillContacts()) {
            return $company->contacts()->create($data);
        }

        return $company->contacts->update($data);
    }

    /**
     * @param $id
     * @return Company
     */
    private function getCompany($id): Company
    {
        return Company::find($id);
    }
}

<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Service;
use App\Entity\Advert\Category;
use App\Entity\Advert\Tag;
use App\Entity\Location\City;
use App\Entity\User\User;
use App\Helpers\Services\Infrastructure\Seo\SeoHelper;
use App\Http\Requests\Admin\Advert\RejectRequest;
use App\UseCase\Advert\Advert\Order\OrderService;
use App\UseCase\Advert\Advert\Service\ServicesService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Advert\Service\StoreRequest;
use App\Http\Requests\Admin\Advert\Service\StoreRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class ServicesController
 * @package App\Http\Controllers\Admin\Adverts
 * @property-read CrudPanel $crud
 */
class ServicesController extends CrudController
{
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(ServicesService $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }

    public function setup()
    {
        $this->crud->setModel(Service::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/advert/services');
        $this->crud->setEntityNameStrings('service', 'services');

        $this->crud->addFilter(['name' => 'status', 'type' => 'dropdown', 'label'=> 'Статус'], Order::getStatusList(),
        function($value) {
            $this->crud->addClause('where', 'status', $value);
        });

        $this->crud->addFilter([
            'name' => 'user_id', 'type' => 'text', 'label'=> 'Пользователь', 'placeholder'=> 'Пользователь',
        ], false,
        function($value) {
            $this->crud->addClause('where', 'user_id', $value);
        });

        $this->crud->addFilter([
            'name' => 'city', 'type' => 'select2', 'label'=> 'Город', 'placeholder'=> 'Город',
        ], function () {
            return City::select(['id', 'name'])->get()->keyBy('id')->map(function($item) {return $item->name;})->toArray();
        },
            function($value) {
                $this->crud->addClause('where', 'city_id', $value);
            });

        $this->crud->disableResponsiveTable();

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'title', 'label' => 'Заголовок'],
            //['name' => 'category.name', 'label' => 'Категория', 'type' => 'text'],
            ['name' => 'city.name', 'label' => 'Город', 'type' => 'text'],
            'slug',
            ['name' => 'created_at', 'label' => 'Дата публикации'],
            ['name' => 'status', 'type' => 'radio', 'label' => 'Статус', 'options' => Service::getStatusList()],
        ]);

        $this->crud->addFields([
            ['name' => 'title', 'label' => 'Заголовок', 'tab' => 'Основное'],
            ['name' => 'description', 'type' => 'textarea', 'label' => 'Описание услуги', 'tab' => 'Основное'],
            ['name' => 'user_id', 'entity' => 'user', 'attribute' => 'email', 'label' => 'Пользователь', 'type' => 'select2', 'placeholder' => 'Пользователь', 'minimum_input_length' => 1, 'data_source' => url('admin/users'), 'model' => User::class, 'tab' => 'Основное'],
            [
                'name' => 'city_id',
                'entity' => 'city',
                'attribute' => 'name',
                'label' => 'Город',
                'type' => 'select2',
                'placeholder' => 'Город',
                'minimum_input_length' => 1,
                'data_source' => url('admin/cities'),
                'model' => City::class,
                'tab' => 'Основное'
            ],
            [
                'label' => 'Категории',
                'type' => 'select2_multiple',
                'name' => 'categories',
                'entity' => 'categories',
                //'attribute' => 'name_with_parent',
                'attribute' => 'name',
                'model' => Category::class,
                'pivot' => true,
                'options' => (function ($query) {
                    return $query->orderBy('name', 'ASC')->where('depth', 2)->get();
                }),
                'tab' => 'Основное'
            ],
            [
                'label' => 'Теги',
                'type' => 'select2_multiple',
                'name' => 'tags',
                'entity' => 'tags',
                'attribute' => 'name',
                'model' => Tag::class,
                'pivot' => true,
                'readonly' => true,
                'tab' => 'Основное'
            ],
            ['name' => 'price_type', 'label' => 'Тип цены', 'type' => 'radio', 'options' => Service::getPriceTypes(), 'tab' => 'Основное'],
            ['name' => 'price', 'label' => 'Цена', 'type' => 'number', 'tab' => 'Основное'],
            ['name' => 'status', 'type' => 'select_from_array', 'label' => 'Статус', 'options' => Service::getStatusList(), 'tab' => 'Основное'],
//            ['name' => 'slug', 'label' => 'Slug', 'tab' => 'Seo'],
        ]);

        SeoHelper::controller($this->crud, [SeoHelper::FIELD_SEO_TEXT, SeoHelper::FIELD_BREADCRUMB_NAME]);

        $this->crud->orderBy(\DB::raw("FIELD(status, '" . Order::STATUS_MODERATION . "')"), 'DESC');
        $this->crud->orderBy('created_at', 'DESC');

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'update');

        $this->crud->allowAccess('show');

        $this->crud->addButtonFromView('line', 'reject', 'reject', 'beginning');
        $this->crud->addButtonFromView('line', 'moderate', 'moderate', 'beginning');
        $this->crud->addButtonFromView('line', 'close', 'close', 'beginning');
        $this->crud->addButtonFromView('line', 'status', 'status', 'beginning');

        $this->crud->setListView('admin.advert.order.list');
        //$this->crud->setShowView('admin.advert.order.show');
    }

    public function moderate($orderId)
    {
        $order = $this->getOrder($orderId);

        try {
            $this->orderService->moderate($order);

            \Alert::success('Order successful moderated.')->flash();

            return redirect()->route('crud.services.index');
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function rejectForm($orderId)
    {
        $order = $this->getOrder($orderId);

        if(!$order->isOnModeration()) {
            \Alert::error('Only new orders you can moderate.')->flash();

            return redirect()->back();
        }

        $options = Arr::only(Order::getStatusList(), [Order::STATUS_SPAM, Order::STATUS_REJECTED]);

        return view('admin.advert.services.reject', [
            'crud' => $this->crud,
            'entry' => $order,
            'options' => $options,
        ]);
    }

    public function close($orderId)
    {
        $order = $this->getOrder($orderId);

        try {
            $this->orderService->close($order);

            \Alert::success('Order successful closed.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function open($orderId)
    {
        $order = $this->getOrder($orderId);

        try {
            $this->orderService->open($order);

            \Alert::success('Order successful opened.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function reject(RejectRequest $request, $orderId)
    {
        $order = $this->getOrder($orderId);

        try {
            $this->orderService->reject($order, $request->get('status'), $request->get('reason'));

            \Alert::success('Order successful rejected.')->flash();

            return redirect()->route('crud.services.index');
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function show($id)
    {
        $this->crud->addColumn(['name' => 'description', 'label' => 'Описание', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'price', 'label' => 'Цена', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'price_type', 'label' => 'Тип цены', 'type' => 'select_from_array', 'options' => Order::getPriceTypes()]);

        $this->crud->addColumn(['name' => 'user_id', 'label' => 'Пользователь', 'type' => 'model_function', 'function_name' => 'getUserWithLink']);

        $content =  parent::show($id);

        $this->crud->removeColumns(['map_address', 'close_reason', 'closed_at', 'moderated_at']);

        return $content;
    }

    public function store(StoreRequest $request)
    {
        $slug = $request->get('slug') ?? SlugService::createSlug(Category::class, 'slug', $request->get('title'));

        $request->merge(['slug' => $slug]);

        $redirect_location = parent::storeCrud($request);

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);

        return $redirect_location;
    }

    private function getOrder($id): Service
    {
        $order = Service::findOrFail($id);

        return $order;
    }
}

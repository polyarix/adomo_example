<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Photo;
use App\Entity\Advert\Category;
use App\Entity\Advert\Tag;
use App\Entity\Location\City;
use App\Entity\User\User;
use App\Http\Requests\Admin\Advert\RejectRequest;
use App\UseCase\Advert\Advert\AdvertService;
use App\UseCase\Advert\Advert\Order\OrderService;
use App\UseCase\Advert\Category\CategoryService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Advert\Order\StoreRequest;
use App\Http\Requests\Admin\Advert\Order\StoreRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Cviebrock\EloquentSluggable\Services\SlugService;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class OrdersController
 * @package App\Http\Controllers\Admin\Adverts
 * @property-read CrudPanel $crud
 */
class OrdersController extends CrudController
{
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var AdvertService
     */
    private $advertService;

    public function __construct(OrderService $orderService, CategoryService $categoryService, AdvertService $advertService)
    {
        parent::__construct();
        $this->orderService = $orderService;
        $this->categoryService = $categoryService;
        $this->advertService = $advertService;
    }

    public function setup()
    {
        $this->crud->setModel(Order::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/advert/orders');
        $this->crud->setEntityNameStrings('order', 'orders');

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
            'name' => 'category', 'type' => 'select2', 'label'=> 'Категория', 'placeholder'=> 'Категория',
        ], function () {
            return Category::select(['id', 'name'])->get()->keyBy('id')->map(function($item) {return $item->name;})->toArray();
        },
        function($value) {
            $this->crud->addClause('where', 'category_id', $value);
        });

        $this->crud->addFilter([
            'name' => 'city', 'type' => 'select2', 'label'=> 'Город', 'placeholder'=> 'Город',
        ], function () {
            return City::select(['id', 'name'])->get()->keyBy('id')->map(function($item) {return $item->name;})->toArray();
        },
        function($value) {
            $this->crud->addClause('where', 'city_id', $value);
        });

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'title', 'label' => 'Заголовок'],
            ['name' => 'category.name', 'label' => 'Категория', 'type' => 'text'],
            'slug',
            ['name' => 'created_at', 'label' => 'Дата публикации'],
            ['name' => 'photos', 'label' => 'Фотографии', 'type' => 'images_multiple', 'visibleInTable' => false, 'attribute' => 'path'],
            ['name' => 'status', 'type' => 'radio', 'label' => 'Статус', 'options' => Order::getStatusList()],
        ]);

        $this->crud->addFields([
            ['name' => 'title', 'label' => 'Заголовок'],
            ['name' => 'category_id', 'entity' => 'category', 'attribute' => 'name', 'label' => 'Категория', 'type' => 'select2_nested'],
            ['name' => 'user_id', 'entity' => 'user', 'attribute' => 'email', 'label' => 'Пользователь', 'type' => 'select2', 'placeholder' => 'Пользователь', 'minimum_input_length' => 1, 'data_source' => url('admin/users'), 'model' => User::class],
            ['name' => 'city_id', 'entity' => 'city', 'attribute' => 'name', 'label' => 'Город', 'type' => 'select2', 'placeholder' => 'Город', 'minimum_input_length' => 1, 'data_source' => url('admin/cities'), 'model' => City::class],
            'slug',
            //['name' => 'status', 'type' => 'select_from_array', 'label' => 'Статус', 'options' => Order::getStatusList()],
            ['name' => 'description', 'type' => 'textarea', 'label' => 'Описание'],
            ['name' => 'address', 'type' => 'text', 'label' => 'Адрес'],
            ['name' => 'price_type', 'label' => 'Тип цены', 'type' => 'radio', 'options' => Order::getPriceTypes()],
            ['name' => 'price', 'label' => 'Цена', 'type' => 'number'],
            ['name' => 'time_type', 'label' => 'Время', 'type' => 'radio', 'options' => Order::getTimeTypes()],
            [
                'label' => 'Теги',
                'type' => 'select2_multiple',
                'name' => 'tags',
                'entity' => 'tags',
                'attribute' => 'name',
                'model' => Tag::class,
                'pivot' => true,
                'readonly' => true,
            ],
            //['name' => 'beginning_date', 'label' => 'Начать до', 'type' => 'datetime'],
            [
                'label' => 'Фото',
                'type' => 'upload_multiple_morph',
                'name' => 'photos',
                'attribute' => 'path',
                'upload' => true,
            ],
            //['name' => 'map_lat', 'label' => 'Широта', 'type' => 'text'],
            //['name' => 'map_long', 'label' => 'Долгота', 'type' => 'text'],
            ['name' => 'house_provision', 'label' => 'Предоставление жилья', 'type' => 'boolean', 'options' => ['Нет', 'Да']],
            ['name' => 'materials_provision', 'label' => 'Материалы заказчика', 'type' => 'boolean', 'options' => ['Нет', 'Да']],
        ]);

        $this->crud->disableResponsiveTable();

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
        $this->crud->setShowView('admin.advert.order.show');
    }

    public function moderate($orderId)
    {
        $order = $this->getOrder($orderId);

        try {
            $this->orderService->moderate($order);

            \Alert::success('Order successful moderated.')->flash();

            return redirect()->route('crud.orders.index');
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

        return view('admin.advert.advert.reject', [
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

            return redirect()->route('crud.orders.index');
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function show($id)
    {
        $this->crud->addColumn(['name' => 'address', 'label' => 'Адрес', 'type' => 'text']);
        $this->crud->removeColumns(['map_address']);
        //$this->crud->addColumn(['name' => 'map_address', 'label' => 'Адрес на карте', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'description', 'label' => 'Описание', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'price', 'label' => 'Цена', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'price_type', 'label' => 'Тип цены', 'type' => 'select_from_array', 'options' => Order::getPriceTypes()]);
        $this->crud->addColumn(['name' => 'beginning_date', 'label' => 'Начать до', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'map_lat', 'label' => 'Широта', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'map_long', 'label' => 'Долгота', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'house_provision', 'label' => 'Предоставление жилья', 'type' => 'boolean', 'options' => ['Нет', 'Да']]);
        $this->crud->addColumn(['name' => 'materials_provision', 'label' => 'Материалы заказчика', 'type' => 'boolean', 'options' => ['Нет', 'Да']]);

        $this->crud->addColumn(['name' => 'user_id', 'label' => 'Пользователь', 'type' => 'model_function', 'function_name' => 'getUserWithLink']);
        $this->crud->addColumn(['name' => 'category_id', 'label' => 'Категория', 'type' => 'model_function', 'function_name' => 'getCategoryWithLink', 'limit' => -1]);
        $this->crud->addColumn(['name' => 'city_id', 'label' => 'Город', 'type' => 'model_function', 'function_name' => 'getCityWithLink', 'limit' => -1]);

        $content =  parent::show($id);

        $this->crud->removeColumns(['map_address', 'close_reason', 'closed_at', 'moderated_at']);

        return $content;
    }

    public function store(StoreRequest $request)
    {
        $slug = $request->get('slug') ?? SlugService::createSlug(Order::class, 'slug', $request->get('title'));

        $request->merge(['slug' => $slug]);

        $redirect_location = parent::storeCrud($request);

        if($photos = $request->photos) {
            foreach ($photos as $photo) {
                if(is_null($photo) || $photo instanceof UploadedFile) {
                    continue;
                }

                $photo = $this->advertService->uploadPhoto($photo, $this->data['entry']->id);
            }
        }

        return $redirect_location;
    }

    public function update(UpdateRequest $request, $id)
    {
        if($clearPhotoIds = $request->get('clear_photos')) {
            Photo::whereIn('id', $clearPhotoIds)->update(['morph_id' => null]);
        }

        // new uploaded photos
        if($photos = $request->photos) {
            foreach ($photos as $photo) {
                if(is_null($photo) || $photo instanceof UploadedFile) {
                    continue;
                }

                $photo = $this->advertService->uploadPhoto($photo, $id);
            }
        }

        $redirect_location = parent::updateCrud($request);

        return $redirect_location;
    }

    private function getOrder($id): Order
    {
        $order = Order::findOrFail($id);

        return $order;
    }
}

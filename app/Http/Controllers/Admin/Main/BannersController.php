<?php

namespace App\Http\Controllers\Admin\Main;

use App\Entity\Common\Banner;
use App\UseCase\Site\BannerService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Main\Banner\StoreRequest;
use App\Http\Requests\Admin\Main\Banner\StoreRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class BannersController
 * @package App\Http\Controllers\Admin\Main
 * @property-read CrudPanel $crud
 */
class BannersController extends CrudController
{
    /**
     * @var BannerService
     */
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        parent::__construct();
        $this->bannerService = $bannerService;
    }

    public function setup()
    {
        $this->crud->setModel(Banner::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/banners');
        $this->crud->setEntityNameStrings('banner', 'banners');

        $this->crud->addColumns([
            ['name' => 'name', 'label' => 'Название (не выводится на сайте)'],
            ['name' => 'image', 'label' => 'Изображение', 'type' => 'image', 'prefix' => 'storage/'],
            ['name' => 'url', 'label' => 'Ссылка', 'type' => 'text'],
            ['name' => 'views', 'label' => 'Просмотров', 'type' => 'number'],
            ['name' => 'is_visible', 'type' => 'boolean', 'label' => 'Отображается', 'options' => ['Нет', 'Да']],
        ]);

        $this->crud->addFields([
            ['name' => 'name', 'label' => 'Название (не выводится на сайте)'],
            ['name' => 'url', 'label' => 'Ссылка'],
            [
                'label' => 'Баннер',
                'name' => 'image',
                'type' => 'upload',
                'upload' => true,
                'crop' => false,
                'aspect_ratio' => 0,
                'disk' => 'public',
            ],
            ['name' => 'is_visible', 'type' => 'boolean', 'label' => 'Отображается', 'options' => ['Нет', 'Да']],
        ]);

        $this->crud->orderBy('is_visible', 'DESC');

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->addButtonFromView('line', 'slider_actions', 'slider_actions', 'beginning');
    }

    public function visible($id)
    {
        $slider = $this->bannerService->get($id);

        try {
            $this->bannerService->setVisible($slider);

            \Alert::success('Banner set as visible.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function hide($id)
    {
        $slider = $this->bannerService->get($id);

        try {
            $this->bannerService->setHidden($slider);

            \Alert::success('Banner set as hidden.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

<?php

namespace App\Http\Controllers\Admin\Main;

use App\Entity\Common\Slider;
use App\UseCase\Site\SliderService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Main\Slider\StoreRequest;
use App\Http\Requests\Admin\Main\Slider\UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class SlidersController
 * @package App\Http\Controllers\Admin\Main
 * @property-read CrudPanel $crud
 */
class SlidersController extends CrudController
{
    /**
     * @var SliderService
     */
    private $sliderService;

    public function __construct(SliderService $sliderService)
    {
        parent::__construct();
        $this->sliderService = $sliderService;
    }

    public function setup()
    {
        $this->crud->setModel(Slider::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sliders');
        $this->crud->setEntityNameStrings('slider', 'sliders');

        $this->crud->enableReorder('name');
        $this->crud->allowAccess('reorder');

        $this->crud->addColumns([
            ['name' => 'name', 'label' => 'Название (не выводится на сайте)'],
            ['name' => 'title', 'label' => 'Заголовок'],
            ['name' => 'image', 'label' => 'Изображение', 'type' => 'image', 'prefix' => 'storage/'],
            //['name' => 'sort_num', 'label' => 'Номер сортировки'],
            ['name' => 'is_visible', 'type' => 'boolean', 'label' => 'Отображается', 'options' => ['Нет', 'Да']],
        ]);

        $this->crud->addFields([
            ['name' => 'name', 'label' => 'Название (не выводится на сайте)'],
            ['name' => 'title', 'label' => 'Заголовок'],
            [
                'label' => 'Картинка',
                'name' => 'image',
                'type' => 'upload',
                'upload' => true,
                'crop' => false,
                'aspect_ratio' => 0,
                'disk' => 'public',
            ],
            ['name' => 'url', 'label' => 'Ссылка'],
            ['name' => 'delay', 'label' => 'Задержка слайда (секунд)', 'type' => 'number'],
            ['name' => 'buttons_disabled', 'type' => 'boolean', 'label' => 'Кнопки отключены (автоподбор, поиск)', 'options' => ['Нет', 'Да']],
            ['name' => 'is_visible', 'type' => 'boolean', 'label' => 'Отображается', 'options' => ['Нет', 'Да']],
        ]);

        $this->crud->orderBy('is_visible', 'DESC');
        $this->crud->orderBy('lft', 'ASC');

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->addButtonFromView('line', 'slider_actions', 'slider_actions', 'beginning');
    }

    public function visible($id)
    {
        $slider = $this->sliderService->get($id);

        try {
            $this->sliderService->setVisible($slider);

            \Alert::success('Slider set as visible.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function hide($id)
    {
        $slider = $this->sliderService->get($id);

        try {
            $this->sliderService->setHidden($slider);

            \Alert::success('Slider set as hidden.')->flash();

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

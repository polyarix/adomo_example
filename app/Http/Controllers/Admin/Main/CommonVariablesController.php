<?php

namespace App\Http\Controllers\Admin\Main;

use App\Entity\Common\Variable;
use App\UseCase\Site\BannerService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Main\Config\Variables\StoreRequest;
use App\Http\Requests\Admin\Main\Config\Variables\StoreRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class CommonVariablesController
 * @package App\Http\Controllers\Admin\Main
 * @property-read CrudPanel $crud
 */
class CommonVariablesController extends CrudController
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
        $this->crud->setModel(Variable::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/variables');
        $this->crud->setEntityNameStrings('variable', 'variables');

        $this->crud->addColumns([
            ['name' => 'name', 'label' => 'Название'],
            ['name' => 'key', 'label' => 'Ключ'],
            ['name' => 'value', 'label' => 'Значение'],
        ]);

        $this->crud->addFields([
            ['name' => 'name', 'label' => 'Название'],
            ['name' => 'key', 'label' => 'Ключ'],
            ['name' => 'value', 'label' => 'Значение', 'type' => 'textarea'],
        ]);

        $this->crud->addClause('where', 'type', Variable::TYPE_COMMON);

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $request->merge(['type' => Variable::TYPE_COMMON]);
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

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Tariff;

use App\Entity\Tariff\Service;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Tariff\Service\StoreRequest;

/**
 * Class ServiceCrudController
 *
 * @package App\Http\Controllers\Admin\Tariff
 */
class ServiceCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Service::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tariff_service');
        $this->crud->setEntityNameStrings('услуга', 'услуги');

        $this->crud->addColumns([
            ['label' => 'Название', 'name' => 'name'],
            ['label' => 'Иконка', 'name' => 'icon', 'type' => 'image', 'height' => '150px', 'width' => '150px'],
        ]);

        $this->crud->addFields([
            ['label' => 'Название', 'name' => 'name'],
            ['label' => 'Иконка', 'name' => 'icon', 'type' => 'browse'],
        ]);

        foreach (['create', 'update'] as $action) {
            $this->crud->setRequiredFields(StoreRequest::class, $action);
        }
    }

    public function store(StoreRequest $request)
    {
        $redirect_location = parent::storeCrud($request);

        return $redirect_location;
    }

    public function update(StoreRequest $request)
    {
        $redirect_location = parent::updateCrud($request);

        return $redirect_location;
    }
}

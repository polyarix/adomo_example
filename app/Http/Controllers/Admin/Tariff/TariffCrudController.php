<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Tariff;

use App\Entity\Tariff\Service;
use App\Entity\Tariff\Tariff;
use App\Http\Requests\Admin\Tariff\StoreRequest;
use App\Service\Tariff\Dto\ServiceList;
use App\Service\Tariff\TariffCrudService;
use App\Service\Tariff\TariffCrudServiceInterface;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class TariffCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Tariff::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tariff');
        $this->crud->setEntityNameStrings('тариф', 'тарифы');

        $this->crud->addColumns([
            ['label' => 'Название', 'name' => 'name'],
            ['label' => 'Цена', 'name' => 'price']
        ]);

        $this->crud->addFields([
            ['label' => 'Название', 'name' => 'name', 'tab' => 'Основное'],
            ['label' => 'Доп. сообщение', 'name' => 'hint', 'tab' => 'Основное'],
            ['label' => 'Цена', 'name' => 'price', 'type' => 'number', 'tab' => 'Основное'],

            [
                'label' => 'Услуги тарифа',
                'name' => 'services',
                'type' => 'tariff_services_table',
                'tab' => 'Услуги тарифа',
                'all_services' => Service::all(),
            ],
            ['type' => 'hidden', 'name' => 'id']
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

    public function update(StoreRequest $request, TariffCrudService $tariff_service)
    {
        $service_list = new ServiceList(
            (int)$request->input('id'),
            (array)$request->input('services')
        );
        $request->request->remove('services');

        $redirect_location = parent::updateCrud($request);

        $this->crud->entry->services()->delete();

        try {
            $tariff_service->saveTariffServices($service_list->getList());
        } catch (\PDOException $exception) {
            \Alert::error($exception->getMessage())->flash();
            return redirect()->back()->withInput();
        }

        return $redirect_location;
    }
}

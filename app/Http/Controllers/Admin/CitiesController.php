<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Location\City;
use App\Entity\Location\District;
use App\Http\Requests\Admin\Location\City\StoreRequest;
use App\Http\Requests\Admin\Location\City\UpdateRequest;
use App\Service\Main\Location\CityCoordinatesDetectorInterface;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\CrudPanel;
use Cviebrock\EloquentSluggable\Services\SlugService;

// VALIDATION: change the requests to match your own file names if you need form validation

/**
 * Class CityCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CitiesController extends CrudController
{
    /** @var CityCoordinatesDetectorInterface */
    private $coordinatesDetector;

    public function __construct(CityCoordinatesDetectorInterface $coordinatesDetector)
    {
        $this->coordinatesDetector = $coordinatesDetector;
        return parent::__construct();
    }

    public function setup()
    {
        $this->crud->setModel(City::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/cities');
        $this->crud->setEntityNameStrings('город', 'города');

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'name', 'label' => 'Имя'],
            'slug',
        ]);

        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'Название города']);
        $this->crud->addField(['name' => 'slug', 'type' => 'text', 'label' => 'Slug']);

        $this->crud->addField([ // Table
            'name' => 'districts',
            'label' => 'Районы',
            'type' => 'table',
            'entity_singular' => 'район', // used on the "Add X" button
            'columns' => [
                'name' => 'Название',
                'slug' => 'Slug',
            ],
            'max' => 500, // maximum rows allowed in the table
            'min' => 0, // minimum rows allowed in the table
            'sort_enabled' => false
        ]);

        // add asterisk for fields that are required in CityRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function edit($id)
    {
        $this->crud->addField(['name' => 'slug', 'type' => 'text', 'label' => 'Slug']);

        return parent::edit($id);
    }

    public function store(StoreRequest $request)
    {
        $coordinates = $this->coordinatesDetector->detect($request->get('name'));

        $request->merge(['map_long' => $coordinates->getLong(), 'map_lat' => $coordinates->getLat()]);
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry

        /** @var City $city */
        $city = $this->crud->entry;

        if ($request->get('districts') !== null) {
            foreach (json_decode($request->get('districts'), true) as $district) {
                if (empty($district['name'])) {
                    continue;
                }

                $city->districts()->create([
                    'name' => $district['name'],
                    'slug' => SlugService::createSlug(District::class, 'slug', $district['slug']
                        ?? $district['name'])
                ]);
            }
        }

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or

        /** @var City $city */
        $city = $this->crud->entry;
        $touched = [];

        if ($request->get('districts') !== null) {
            foreach (json_decode($request->get('districts'), true) as $district) {
                if (empty($district['name'])) {
                    continue;
                }

                if (!isset($district['id']) || empty($district['id'])) {
                    // create new
                    $district = $city->districts()->create([
                        'name' => $district['name'],
                        'slug' => SlugService::createSlug(District::class, 'slug',
                            $district['slug'] ?? $district['name'])
                    ]);
                    $touched[] = $district->id;
                    continue;
                }

                $city->districts()->find($district['id'])->update([
                    'name' => $district['name'],
                    'slug' => $district['slug']
                ]);
                $touched[] = $district['id'];
            }
        }

        $city->districts()->whereNotIn('id', $touched)->delete();

        return $redirect_location;
    }
}

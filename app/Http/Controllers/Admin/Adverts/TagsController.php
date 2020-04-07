<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Entity\Advert\Tag;
use App\Helpers\Services\Infrastructure\Seo\SeoHelper;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Advert\Tag\StoreRequest;
use App\Http\Requests\Admin\Advert\Tag\UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class TagsController
 * @package App\Http\Controllers\Admin\Adverts
 * @property-read CrudPanel $crud
 */
class TagsController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Tag::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/category/tags');
        $this->crud->setEntityNameStrings('tag', 'tags');

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'name', 'label' => 'Имя'],
            ['name' => 'slug', 'label' => 'Slug'],
        ]);

        $this->crud->orderBy('id', 'DESC');

        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'Название тега', 'tab' => 'Основное']);
        $this->crud->addField(['name' => 'slug', 'type' => 'text', 'label' => 'Slug', 'tab' => 'Основное']);
        $this->crud->addField([ // image
            'label' => 'Картинка тега',
            'name' => 'image',
            'type' => 'upload',
            'upload' => true,
            'crop' => false,
            'aspect_ratio' => 0,
            'tab'   => 'Основное',
            'disk' => 'public',
        ]);
        SeoHelper::controller($this->crud);

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        $redirect_location = parent::storeCrud($request);

        if($request->ajax()) {
            return response()->json($this->crud->entry);
        }

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

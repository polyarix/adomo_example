<?php

namespace App\Http\Controllers\Admin\Main;

use App\Entity\Common\FaqQuestion;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Main\Config\Faq\StoreRequest;
use App\Http\Requests\Admin\Main\Config\Faq\StoreRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Str;

/**
 * Class CommonVariablesController
 * @package App\Http\Controllers\Admin\Main
 * @property-read CrudPanel $crud
 */
class FaqController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(FaqQuestion::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/faq');
        $this->crud->setEntityNameStrings('question', 'questions');

        $this->crud->addColumns([
            ['name' => 'title', 'label' => 'Вопрос'],
            ['name' => 'text', 'label' => 'Ответ'],
            ['name' => 'group_title', 'label' => 'Группа'],
        ]);

        $options = FaqQuestion::select('group_title')->distinct()->get()->pluck('group_title', 'group_title');

        $this->crud->addFields([
            ['name' => 'title', 'label' => 'Вопрос'],
            ['name' => 'text', 'type' => 'wysiwyg', 'label' => 'Ответ'],
            ['name' => 'group_title', 'type' => 'select2_from_array_tags', 'label' => 'Группа', 'options' => $options, 'allows_null' => true],
        ]);

        $this->crud->enableReorder('title', 1);
        $this->crud->allowAccess('reorder');

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        $request->merge(['group' => Str::slug($request->get('group_title'))]);
        $redirect_location = parent::storeCrud($request);
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $request->merge(['group' => Str::slug($request->get('group_title'))]);
        $redirect_location = parent::updateCrud($request);
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

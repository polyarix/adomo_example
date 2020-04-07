<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Entity\Blog\Category;
use App\Helpers\Services\Infrastructure\Seo\SeoHelper;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Blog\Category\StoreRequest;
use App\Http\Requests\Admin\Blog\Category\UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Cviebrock\EloquentSluggable\Services\SlugService;

/**
 * Class CategoriesController
 * @package App\Http\Controllers\Admin\Blog\CategoriesController
 * @property-read CrudPanel $crud
 */
class CategoriesController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Category::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/blog/categories');
        $this->crud->setEntityNameStrings('category', 'categories');

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'name', 'label' => 'Название'],
            'slug',
            ['name' => 'is_visible', 'label' => 'Отображается', 'type' => 'boolean', 'options' => [0 => 'Нет', 1 => 'Да']],
        ]);

        $this->crud->orderBy('created_at', 'DESC');

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'update');

        $this->crud->allowAccess('show');

        // common fields
        $this->crud->addFields([
            ['name' => 'name', 'label' => 'Название', 'tab' => 'Основное'],
            ['name' => 'slug', 'label' => 'Slug', 'tab' => 'Основное'],
            ['name' => 'is_visible', 'type' => 'boolean', 'label' => 'Отображается', 'options' => ['Нет', 'Да'], 'tab' => 'Основное'],
        ]);

        // images fields
        $this->crud->addFields([
            [
                'label' => 'Превью',
                'name' => 'image',
                'type' => 'upload',
                'upload' => true,
                'crop' => false,
                'aspect_ratio' => 0,
                'disk' => 'public',
                'tab' => 'Изображения',
            ],
        ]);

        // seo fields
        SeoHelper::controller($this->crud);
    }

    /*public function show($id)
    {
        $this->crud->setShowView('admin.advert.category.show');

        $content = parent::show($id);

        $this->crud->addColumn(['name' => 'meta_title', 'label' => 'Meta title']);
        $this->crud->addColumn(['name' => 'seo_text', 'label' => 'SEO текст']);
        $this->crud->removeColumn('lft');
        $this->crud->removeColumn('rgt');

        return $content;
    }*/

    public function store(StoreRequest $request)
    {
        $slug = $request->get('slug') ?? SlugService::createSlug(Category::class, 'slug', $request->get('name'));

        $request->merge(['slug' => $slug]);

        $redirect_location = parent::storeCrud($request);
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Entity\Advert\Category;
use App\Entity\Advert\Dimension;
use App\Entity\Advert\Tag;
use App\Events\Advert\Category\CategoryUpdated;
use App\Events\Advert\Category\HideCategory;
use App\Events\Advert\Category\SetVisibleCategory;
use App\UseCase\Advert\Category\CategoryService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Advert\Category\StoreRequest;
use App\Http\Requests\Admin\Advert\Category\UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin\Adverts
 * @property-read CrudPanel $crud
 */
class CategoriesController extends CrudController
{
    /**
     * @var
     */
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        return parent::__construct();
    }

    public function setup()
    {
        $this->crud->setModel(Category::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/categories');
        $this->crud->setEntityNameStrings('category', 'categories');
        $this->crud->setEditView('admin.advert.category.edit');

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'name', 'label' => 'Имя'],
            ['name' => 'parent.name', 'label' => 'Родительская категория', 'type' => 'text'],
            'slug',
            ['name' => 'dimension.label', 'label' => 'Единица измерения', 'type' => 'text'],
            ['name' => 'is_visible', 'label' => 'Отображается', 'type' => 'boolean', 'options' => [0 => 'Нет', 1 => 'Да']],
        ]);

        $this->crud->orderBy('is_visible', 'ASC');
        $this->crud->orderBy('created_at', 'DESC');

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'update');

        $this->crud->enableReorder('name', 5);
        $this->crud->allowAccess('reorder');
        $this->crud->allowAccess('show');

        $this->crud->addButtonFromView('line', 'blog_actions', 'blog_actions', 'beginning');

        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Имя категории',
            'tab'   => 'Основное',
        ]);
        $this->crud->addField([
            'name' => 'meta_title',
            'type' => 'text',
            'label' => 'Meta-title',
            'tab'   => 'Основное',
        ]);
        $this->crud->addField([
            'name' => 'meta_description',
            'type' => 'text',
            'label' => 'Meta-description',
            'tab'   => 'Основное',
        ]);
        $this->crud->addField([
            'name' => 'meta_keywords',
            'type' => 'text',
            'label' => 'Meta-keywords',
            'tab'   => 'Основное',
        ]);
        $this->crud->addField([
            'name' => 'slug',
            'type' => 'text',
            'label' => 'Slug',
            'tab'   => 'Основное',
        ]);
        $this->crud->addField([
            'name' => 'breadcrumb_name',
            'type' => 'text',
            'label' => 'Название хлебной крошки',
            'tab'   => 'Основное',
        ]);
        $this->crud->addField([
            'name' => 'is_visible',
            'type' => 'checkbox',
            'label' => 'Отображать на сайте',
            'tab'   => 'Основное',
        ]);
        $this->crud->addField([
            'name' => 'parent_id',
            'label' => 'Родительская категория',
            'type' => 'select2_nested',
            'entity' => 'parent',
            'model' => Category::class,
            'attribute' => 'name',
            'pivot' => false,
            'tab'   => 'Основное',
        ]);
        $this->crud->addField([
            'label' => 'Теги',
            'type' => 'select2_multiple',
            'name' => 'tags', // the method that defines the relationship in your Model
            'entity' => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => Tag::class,
            'pivot' => true,
            'tab'   => 'Основное',
        ]);
        $this->crud->addField([
            'label' => 'Ед.измерения',
            'type' => 'select2_dimension',
            'name' => 'dimension_id',
            'entity' => 'dimension',
            'attribute' => 'label',
            'model' => Dimension::class,
            'tab' => 'Основное',
            'store_url' => route('advert.category.create_dimension')
        ]);
        $this->crud->addField([ // image
            'label' => 'Картинка категории',
            'name' => 'image',
            'type' => 'upload',
            'upload' => true,
            'crop' => false,
            'aspect_ratio' => 0,
            'tab'   => 'Картинки',
            'disk' => 'public',
        ]);
        $this->crud->addField([
            'label' => 'Иконка категории',
            'name' => 'icon',
            'type' => 'upload',
            'upload' => true,
            'crop' => false,
            'aspect_ratio' => 0,
            'tab'   => 'Картинки',
            'disk' => 'public',
        ]);
        $this->crud->addField([
            'label' => 'Иконка категории в "категориях работ"',
            'name' => 'icon_work_category',
            'type' => 'upload',
            'upload' => true,
            'crop' => false,
            'aspect_ratio' => 0,
            'tab'   => 'Картинки',
            'disk' => 'public',
        ]);

        $this->crud->addFields([
            [
                'name'  => 'meta_title',
                'label' => 'Meta Title',
                'type'  => 'text',
                'tab'   => 'Meta-теги',
            ],
            [
                'name'  => 'meta_description',
                'label' => 'Meta Description',
                'type'  => 'text',
                'tab'   => 'Meta-теги',
            ],
            [
                'name'  => 'meta_keywords',
                'label' => 'Meta Keywords',
                'type'  => 'text',
                'tab'   => 'Meta-теги',
            ],
            [
                'name' => 'seo_text',
                'type' => 'ckeditor',
                'label' => 'Сео текст',
                'tab'   => 'Meta-теги',
                'simplemdeAttributes' => [
                    'spellChecker' => false,
                    'forceSync' => true,
                ],
            ]
        ]);
    }

    public function createDimension(Request $request)
    {
        return Dimension::create(['label' => $request->get('name')]);
    }

    public function show($id)
    {
        $this->crud->setShowView('admin.advert.category.show');

        $content = parent::show($id);

        $this->crud->addColumn(['name' => 'meta_title', 'label' => 'Meta title']);
        $this->crud->addColumn(['name' => 'seo_text', 'label' => 'SEO текст']);
        $this->crud->addColumn([
            'label' => 'Теги',
            'type' => 'select_multiple',
            'name' => 'tags', // the method that defines the relationship in your Model
            'entity' => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => Tag::class,
            'pivot' => true,
        ]);
        $this->crud->removeColumn('lft');
        $this->crud->removeColumn('rgt');

        return $content;
    }

    public function store(StoreRequest $request)
    {
        $slug = $request->get('slug') ?? SlugService::createSlug(Category::class, 'slug', $request->get('name'));

        $request->merge(['slug' => $slug]);

        $this->handleTags($request);

        $redirect_location = parent::storeCrud($request);

        /** @var Category $category */
        $category = $this->crud->entry;

        if($category->isVisible()) {
            event(new SetVisibleCategory($category));
        }

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $this->handleTags($request);

        $redirect_location = parent::updateCrud($request);

        /** @var Category $category */
        $category = $this->crud->entry;

        if($category->isVisible()) {
            event(new CategoryUpdated($category));
        } else {
            event(new HideCategory($category));
        }

        return $redirect_location;
    }

    public function visible($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        try {
            $this->categoryService->setVisible($category);

            \Alert::success('Category set as visible.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function hide($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        try {
            $this->categoryService->setHidden($category);

            \Alert::success('Category set as hidden.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    protected function handleTags(Request &$request)
    {
        if($tags = $request->get('tags')) {
            $data = [];

            foreach ($tags as $tag) {
                if(intval($tag) > 0) {
                    $data[] = $tag;
                    // it's entity id
                    continue;
                }

                // create new tag
                $tag = Tag::create([
                    'name' => $tag, 'slug' => SlugService::createSlug(Tag::class, 'slug', $tag)
                ]);

                $data[] = $tag->id;
            }

            $request->merge(['tags' => $data]);
        }
    }
}

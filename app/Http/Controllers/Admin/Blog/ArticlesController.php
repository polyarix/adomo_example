<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Entity\Blog\Category;
use App\Entity\Blog\Article;
use App\Helpers\Services\Infrastructure\Seo\SeoHelper;
use App\Service\Main\Upload\ImageUploader;
use App\UseCase\Site\BlogService;
use App\UseCase\Site\SliderService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Blog\Article\StoreRequest;
use App\Http\Requests\Admin\Blog\Article\UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Cviebrock\EloquentSluggable\Services\SlugService;

/**
 * Class ArticlesController
 * @package App\Http\Controllers\Admin\ArticlesController
 * @property-read CrudPanel $crud
 */
class ArticlesController extends CrudController
{
    /**
     * @var BlogService
     */
    private $blogService;
    /**
     * @var ImageUploader
     */
    private $imageUploader;

    public function __construct(BlogService $blogService, ImageUploader $imageUploader)
    {
        parent::__construct();
        $this->blogService = $blogService;
        $this->imageUploader = $imageUploader;
    }

    public function setup()
    {
        $this->crud->setModel(Article::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/blog/articles');
        $this->crud->setEntityNameStrings('article', 'article');

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'title', 'label' => 'Заголовок'],
            //['name' => 'parent.name', 'label' => 'Родительская категория', 'type' => 'text'],
            'slug',
            ['name' => 'is_visible', 'label' => 'Отображается', 'type' => 'boolean', 'options' => [0 => 'Нет', 1 => 'Да']],
        ]);

        // in the top show draft posts
        $this->crud->orderBy('is_visible', 'ASC');
        $this->crud->orderBy('updated_at', 'DESC');

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'update');

        $this->crud->allowAccess('show');

        $this->crud->addButtonFromView('line', 'blog_actions', 'blog_actions', 'beginning');

        // common fields
        $this->crud->addFields([
            ['name' => 'title', 'label' => 'Заголовок', 'tab' => 'Основное'],
            ['name' => 'content', 'type' => 'ckeditor', 'label' => 'Статья', 'tab' => 'Основное', 'options' => [
                'filebrowserUploadUrl' => route('ckeditor.upload'),
                'filebrowserUploadMethod' => 'form'
            ]],
            ['name' => 'slug', 'label' => 'Slug', 'tab' => 'Основное'],
            [
                'name' => 'categories',
                'type' => 'select2_multiple',
                'label' => 'Категории',
                'tab' => 'Основное',
                'attribute' => 'name',
                'entity' => 'categories',
                'model' => Category::class,
                'pivot' => true,
                'table' => 'blog_article_categories',
            ],
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

    public function visible($id)
    {
        $article = $this->blogService->getArticleById($id);

        try {
            $this->blogService->setVisibleArticle($article);

            \Alert::success('Article set as visible.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function hide($id)
    {
        $article = $this->blogService->getArticleById($id);

        try {
            $this->blogService->setHiddenArticle($article);

            \Alert::success('Article set as hidden.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function store(StoreRequest $request)
    {
        $slug = $request->get('slug') ?? SlugService::createSlug(Category::class, 'slug', $request->get('title'));

        $request->merge(['slug' => $slug . rand(10000, 1000000)]);

        // use $this->data['entry'] or $this->crud->entry
        $redirect_location = parent::storeCrud($request);

        if($request->hasFile('image')) {
            // create crop...
            $path = $this->imageUploader->crop($request->file('image'), Article::STORAGE_PATH);

            $this->crud->entry->update(['crop' => $path->crop]);
        }

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);

        if($request->hasFile('image')) {
            $path = $this->imageUploader->crop($request->file('image'), Article::STORAGE_PATH);

            $this->crud->entry->update(['crop' => $path->crop]);
        }

        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Entity\Blog\Article;
use App\Entity\Blog\Comment;
use App\Entity\User\User;
use App\UseCase\Site\BlogService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Blog\Comment\UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Http\Request;

/**
 * Class CommentsController
 * @package App\Http\Controllers\Admin\CommentsController
 * @property-read CrudPanel $crud
 */
class CommentsController extends CrudController
{
    /**
     * @var BlogService
     */
    private $blogService;

    public function __construct(BlogService $blogService)
    {
        parent::__construct();
        $this->blogService = $blogService;
    }

    public function setup()
    {
        $this->crud->setModel(Comment::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/blog/comments');
        $this->crud->setEntityNameStrings('comment', 'comment');

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'text', 'label' => 'Комментарий'],
            ['name' => 'article.title', 'label' => 'Пост', 'type' => 'text'],
            ['name' => 'user_id', 'label' => 'Пользователь', 'type' => 'select2', 'entity' => 'user', 'attribute' => 'email', 'model' => User::class],
            ['name' => 'status', 'label' => 'Статус', 'type' => 'select_from_array', 'options' => Comment::getStatusesList()],
        ]);

        $this->crud->orderBy('created_at', 'DESC');

        //$this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'update');

        $this->crud->allowAccess('show');
        $this->crud->denyAccess('create');

        $this->crud->addButtonFromView('line', 'blog_comment_actions', 'blog_comment_actions', 'beginning');

        // common fields
        $this->crud->addFields([
            ['name' => 'text', 'label' => 'Комментарий', 'type' => 'textarea'],
            ['name' => 'user_id', 'label' => 'Пользователь', 'type' => 'select2_from_ajax', 'entity' => 'user', 'attribute' => 'email', 'placeholder' => 'Пользователь', 'minimum_input_length' => 2, 'data_source' => url('admin/blog/comments/user'), 'model' => User::class],
            ['name' => 'article_id', 'label' => 'Статья', 'type' => 'select2_from_ajax', 'entity' => 'article', 'attribute' => 'title', 'placeholder' => 'Статья', 'minimum_input_length' => 3, 'data_source' => url('admin/blog/comments/article'), 'model' => Article::class],
            ['name' => 'status', 'label' => 'Статус', 'type' => 'select_from_array', 'options' => Comment::getStatusesList()],
        ]);
    }

    public function searchUser(Request $request)
    {
        return ['data' => User::where('email', 'LIKE', "%{$request->get('q')}%")->get()];
    }

    public function searchArticle(Request $request)
    {
        return ['data' => Article::where('title', 'LIKE', "%{$request->get('q')}%")->get()];
    }

    public function moderate($id)
    {
        $comment = $this->blogService->getCommentById($id);

        try {
            $this->blogService->moderateComment($comment);

            \Alert::success('Comment is already moderated.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function store(StoreRequest $request)
    {
        // use $this->data['entry'] or $this->crud->entry
        return parent::storeCrud($request);
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

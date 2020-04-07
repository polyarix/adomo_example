<?php

namespace App\Http\Controllers\Blog;

use App\Entity\Blog\Article;
use App\Entity\Blog\Category;
use App\Entity\User\User;
use App\Http\Controllers\Controller;
use App\UseCase\Site\BlogService;

class BlogController extends Controller
{
    /**
     * @var BlogService
     */
    private $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index(?Category $category = null)
    {
        $categories = $this->blogService->getCategories();

        return view('app.blog.index', compact('category', 'categories'));
    }

    public function show($articleSlug)
    {
        $article = $this->blogService->getArticleBySlug($articleSlug);

        if(!$article->isVisible()) {
            abort(404);
        }

        /** @var User $user */
        $user = \Auth::user();

        $comments = $this->blogService->getArticleCommentsForUser($article, $user);

        $this->blogService->incrementView($article);

        $similarArticles = $this->blogService->similarArticlesFor($article);

        return view('app.blog.show', compact('article', 'similarArticles', 'comments'));
    }
}

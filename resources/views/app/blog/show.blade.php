@extends('layouts.frontend')

@section('app_class', '')
@section('main_class', 'article')

@section('title', meta_title_helper($article->meta_title, "Статья {$article->title}"))

@section('meta')
    {!! meta_helper_renderer($article) !!}
@endsection

@section('main_header')
    <div class="container">
        <div class="breadcrumbs-section">
            <ul class="breadcrumbs">
                <li class="breadcrumbs-item">
                    <a href="{{ url('/') }}">Adomo</a>
                </li>
                <li class="breadcrumbs-item"><a href="{{ route('blog.index') }}">Блог</a></li>
                @if($mainCategory = $article->getMainCategory())
                    <li class="breadcrumbs-item"><a href="{{ route('blog.index', $mainCategory) }}">{{ $mainCategory->name }}</a></li>
                @endif
                <li class="breadcrumbs-item active"> <span>{{ $article->title }}</span></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="article-baner"><img src="{{ asset($article->getPreview()) }}" alt=""></div>
        <div class="container-inner-small">
            <div class="article-content">
                <h1 class="article-title">{{ $article->title }}</h1>

                {!! $article->content !!}
            </div>
            <div class="article-meta">
                <div class="article-meta-categories">
                    <ul>
                        @foreach($article->categories as $category)
                            <li> <a class="article-category" href="{{ route('blog.index', $category) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="article-meta-data">
                    <span class="post-card-watch">
                        <svg class="eye">
                          <use xlink:href="{{ asset('images/sprite-inline.svg#eye') }}"></use>
                        </svg>
                        <span>{{ $article->views }}</span>
                    </span>

                    <span class="post-card-date">
                        <time datetime="{{ $article->updated_at->format('Y-m-d') }}">{{ $article->updated_at->format('d.m.Y') }}</time>
                    </span>
                </div>
            </div>
            <div class="sharing-column">
                <div class="sharing">
                    <div class="sharing-item"><a class="sharing-link" id="fb-share" href="#"><img src="{{ asset('images/facebook-icon-sharing.svg') }}" alt=""></a></div>
                    <div class="sharing-item"><a class="sharing-link" id="vk-share" href="#"><img src="{{ asset('images/vk-icon-sharing.svg') }}" alt=""></a></div>
                    <div class="sharing-item"><a class="sharing-link" id="tw-share" href="#"><img src="{{ asset('images/twitter-icon-sharing.svg') }}" alt=""></a></div>
                </div>
            </div>

            <div class="article-comments">
                <h2 data-count="{{ $article->visible_comments_count }}">{{ $article->visible_comments_count }} Комментария</h2>

                @foreach($comments as $comment)
                    <div class="comment{{ $comment->isOnModeration() ? ' comment-moderation' : '' }}">
                        @if($comment->isOnModeration())
                            <span class="moderation-label">На модерации</span>
                        @endif

                        <div class="comment-author">
                            <div class="comment-author-avatar">
                                <img src="{{ asset($comment->user->getAvatar()) }}" alt="">
                            </div>
                            <a class="comment-author-link" href="{{ route('user.details',  $comment->user) }}">
                                {{ $comment->user->getName() }}
                            </a>
                            <span>{{ $comment->created_at->format('d.m.Y') }}</span>
                        </div>
                        <div class="comment-content">{{ $comment->text }}</div>
                    </div>
                @endforeach

                @auth
                    <blog-articles-comment-form article-id="{{ $article->slug }}" />
                @endauth
            </div>

            @if($similarArticles->count() > 0)
                <h2>Похожие статьи</h2>
                <div class="similar-articles">
                    @foreach($similarArticles as $similarArticle)
                        <article class="post-card">
                            <a class="post-card-image-link" href="{{ route('blog.show', $similarArticle) }}">
                                <img class="lazy" data-src="{{ $similarArticle->hasCrop() ?  $similarArticle->getCrop() : $similarArticle->getPreview() }}" alt="" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">
                                <div class="post-card-category">
                                    @php $similarArticleCategory = $similarArticle->getMainCategory(); @endphp

                                    @if($similarArticleCategory)
                                        <span class="article-category">{{ $similarArticleCategory->name }}</span>
                                    @endif
                                </div>
                            </a>

                            <div class="post-card-content">
                                <a class="post-card-content-link" href="{{ route('blog.show', $similarArticle) }}">
                                    <header>
                                        <h2 class="post-card-title">{{ $similarArticle->title }}</h2>
                                    </header>
                                    <section>
                                        <p>{{ $similarArticle->getDescription() }}</p>
                                    </section>
                                </a>
                                <footer>
                                    <ul>
                                        <li>
                                            <span class="post-card-watch">
                                                <svg class="eye">
                                                    <use xlink:href="{{ asset('images/sprite-inline.svg#eye') }}"></use>
                                                </svg>
                                                <span>{{ $similarArticle->views }}</span>
                                            </span>
                                        </li>

                                        <li>
                                            <span class="post-card-date">
                                                <time datetime="{{ $article->updated_at->format('Y-m-d') }}">{{ $article->updated_at->format('d.m.Y') }}</time>
                                            </span>
                                        </li>
                                    </ul>
                                </footer>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/soc-share.js') }}"></script>

    <script>
        // social sharing
        $('#fb-share').on('click', function(e) {
            e.preventDefault();
            {!! SocialShare::facebook(['app_id' => config('services.facebook.client_id'), 'title' => $article->title, 'description' => $article->getDescription(), 'image' => $article->getpreview()])->getJs() !!}
        });
        $('#vk-share').on('click', function(e) {
            e.preventDefault();
            {!! SocialShare::vk(['title' => $article->title, 'description' => $article->getDescription(), 'image' => $article->getpreview()])->getJs() !!}
        });
        $('#tw-share').on('click', function(e) {
            e.preventDefault();
            {!! SocialShare::twitter(['text' => $article->title])->getJs() !!}
        });
        // end social sharing

        $('.lazy').lazy({
            effect: "fadeIn",
            effectTime: 1000,
            threshold: 0
        });
    </script>
@endsection

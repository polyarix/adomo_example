@extends('layouts.frontend')

@section('body_class', 'category-page')

@section('title', meta_title_helper($category->meta_title, $category->name))

@section('meta')
    {!! meta_helper_renderer($category) !!}
@endsection

@section('main_header')
    <header class="category-heading" style="background-image:url('{{ asset($category->getImage()) }}')">
        <div class="container">
            <div class="breadcrumbs-section">
                <ul class="breadcrumbs">
                    <li class="breadcrumbs-item"> <a href="{{ url('/') }}">Adomo</a></li>

                    @foreach($category->ancestors as $ancestor)
                        <li class="breadcrumbs-item"> <a href="{{ route('category.show', $ancestor) }}">{{ $ancestor->getBreadcrumbName() }}</a></li>
                    @endforeach

                    <li class="breadcrumbs-item active"> <span>{{ $category->getBreadcrumbName() }}</span></li>
                </ul>
            </div>

            <h1 class="category-heading-title">{{ $category->getBreadcrumbName() }}</h1>
            <p class="category-heading-subtitle">{!! $category->seo_text !!}</p>

            @if($category->hasChildren())
                <a class="btn btn-large btn-yellow" href="{{ route('advert.order.create', $category) }}">Заказать услугу</a>
            @endif
        </div>
    </header>
@endsection

@section('content')
    <div class="row">
        <div class="col category-body">
            @if($category->isRootCategory() && $popularCategories->count() > 0)
                <div class="headline">Выберите категорию {{ mb_strtolower($category->name) }}</div>
                <div class="category-box-container">
                    @foreach($popularCategories as $popularCategory)
                        <a class="category-box-item" href="{{ route('category.show', $popularCategory) }}">
                            <div class="category-box-item-icon"><img src="{{ asset($popularCategory->getIcon()) }}" alt=""></div>
                            <div class="category-box-item-value">{{ $popularCategory->descendants_services_count }}</div>
                            <div class="category-box-item-name">{{ $popularCategory->name }}</div>
                        </a>
                    @endforeach
                </div>
            @endif

            <div>
                <category-orders-component
                    :category='@json($category)'
                    :premium='@json($premium)'
                />
            </div>

            @if(!$category->isRootCategory())
                <div>
                    @if($category->recommendedExecutors()->count() > 0)
                        <category-executors-recommended-component :category='@json($category)' />
                    @endif
                </div>

                <div>
                    @if($category->executors()->count() > 0)
                        <category-executors-component :category='@json($category)'>
                            <div class="headline">Специалисты </div>
                        </category-executors-component>
                    @endif
                </div>
            @endif
        </div>

        <div class="col category-sidebar">
            <!-- can .sticky-->
            <div class="category-sidebar-btn">
                <div class="category-sidebar-btn-inner"><img src="{{ asset('images/category-burger.svg') }}" alt=""><span>Категории</span></div>
            </div>

            <div class="category-sidebar-inner">
                <div class="category-sidebar-container">
                    <div class="category-executors">
                        <div class="category-executors-value">{{ $totalExecutors }} </div>
                        <div class="category-executors-discr">{{ num_decline($totalExecutors, ['исполнитель', 'исполнителя', 'исполнителей']) }}<br> в этой категории</div>
                    </div>
                    <div class="hr-2"></div>
                    <div class="sidebar-title">Категории</div>
                    <div class="category-list">
                        <ul class="category-list-main">
                            @foreach($category->ancestors()->visible()->get() as $ancestor)
                                <li> <a href="{{ route('category.show', $ancestor) }}">{{ $ancestor->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="category-list">
                        <ul class="category-list-main">
                            <li class="current">
                                <a href="#">{{ $category->name }}</a>

                                <ul class="category-list-child">
                                    @foreach($category->children()->visible()->get() as $children)
                                        <li> <a href="{{ route('category.show', $children) }}">{{ $children->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>

                            <li style="padding-left: 15px">
                                <ul>
                                    @foreach($category->getSiblings() as $sibling)
                                        <li> <a href="{{ route('category.show', $sibling) }}">{{ $sibling->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="hr-2"></div>

                    @if($tags->count() > 0)
                        <div class="sidebar-title">Похожие запросы</div>
                        <div class="related-searches">
                            @foreach($tags as $tag)
                                <a class="related-searches-item" href="{{ route('category.tag', $tag) }}">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="promotion"><banner-component :category-id='{{ $category->id }}' :init-delay="1" /></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // category sidebar
        $( document ).ready(function(){
            if( $(window).width() < 1280 ){
                var sidebar_btn = $(".category-sidebar-btn");
                var sidebar_tl = gsap.timeline({ paused: true, reversed: true});
                var sidebar = $(".category-sidebar");
                var sidebar_time = 0.5;
                var sidebar_start = {
                    xPercent: 100
                };
                var sidebar_end = {
                    xPercent: 0,
                    ease: Power4.easeInOut
                };
                sidebar_tl.fromTo(sidebar, sidebar_time, sidebar_start, sidebar_end);
                sidebar_btn.on("click",function(){
                    sidebar_tl.reversed() ? sidebar_tl.play() : sidebar_tl.reverse();
                });
            }
        });
        // end category sidebar
    </script>
@endsection

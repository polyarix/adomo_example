@extends('layouts.frontend')

@section('body_class', 'category-page')

@section('title', meta_title_helper($tag->meta_title, "Тег: {$tag->name}"))

@section('meta')
    {!! meta_helper_renderer($tag) !!}
@endsection

@section('main_header')
    <header class="category-heading" style="background-image:url('{{ asset($tag->getImage()) }}')">
        <div class="container">
            <div class="breadcrumbs-section">
                <ul class="breadcrumbs">
                    <li class="breadcrumbs-item"> <a href="{{ url('/') }}">Adomo</a></li>

                    <li class="breadcrumbs-item active"> <span>{{ $tag->getBreadcrumbName() }}</span></li>
                </ul>
            </div>

            <h1 class="category-heading-title">{{ $tag->getBreadcrumbName() }}</h1>
            <p class="category-heading-subtitle">{!! $tag->seo_text !!}</p>
        </div>
    </header>
@endsection

@section('content')
    <div class="row">
        <div class="col category-body">
            <div>
                <tag-orders-component :tag='@json($tag)' />
            </div>

            <div>
                <tag-executors-component :tag='@json($tag)' ><div class="headline">Специалисты</div></tag-executors-component>
            </div>
        </div>

        <div class="col category-sidebar">
            <div class="category-sidebar-inner">
                <div class="category-sidebar-container">
                    <div class="sidebar-title">Похожие запросы</div>
                    <div class="related-searches">
                        @foreach($similarTags as $similarTag)
                            <a class="related-searches-item" href="{{ route('category.tag', $similarTag) }}">{{ $similarTag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="promotion"><banner-tag-component :tag-id='{{ $tag->id }}' :init-delay="1" /></div>
        </div>
    </div>
@endsection

@extends('layouts.frontend')

@section('app_class', '')
@section('main_class', 'blog')

@section('title', meta_title_helper($category ? ($category->meta_title ?? $category->name) : null, 'Статьи'))

@section('meta')
    @if($category)
        {!! meta_helper_renderer($category) !!}
    @endif
@endsection

@section('main_header')
    <div class="container">
        <div class="breadcrumbs-section">
            <ul class="breadcrumbs">
                <li class="breadcrumbs-item">
                    <a href="{{ url('/') }}">Adomo</a>
                </li>
                <li class="breadcrumbs-item active"> <span>Блог</span></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="super-select">
            <a class="@if(!$category) active @endif super-select__item" href="{{ route('blog.index') }}">Все новости</a>

            @foreach($categories as $categoryItem)
                <a class="super-select__item {{ $category && $category->id === $categoryItem->id ? ' active' : '' }}" href="{{ route('blog.index', $categoryItem) }}">{{ $categoryItem->name }}</a>
            @endforeach
        </div>
    </div>

    <blog-articles-component :category='@json($category)' base-url="{{ route('api.blog.index') }}" />
@endsection

@section('scripts')
    <script>
        $( document ).ready(function() {
            $(".super-select").on("click",function(){
                $(window).width() < 768 ? $(this).toggleClass("open"): false;
            });
            $(".super-select__item").on("click",function(){
                $(".super-select__item").removeClass("active");
                $(this).addClass("active");
            })
        });
    </script>
@endsection

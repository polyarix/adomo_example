@extends('layouts.frontend')

@section('body_class', 'category-page')
@section('main_class', 'role-workman')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endsection

@section('title', meta_title_helper($category->meta_title, $category->name))

@section('meta')
    {!! meta_helper_renderer($category) !!}
@endsection

@section('main_header')
    <div class="container">
        <div class="breadcrumbs-section">
            <ul class="breadcrumbs">
                <li class="breadcrumbs-item"> <a href="{{ url('/') }}">Adomo</a></li>
                <li class="breadcrumbs-item"> <a href="{{ route('tasks.index') }}">Все категории услуг</a></li>

                @foreach($category->ancestors as $ancestor)
                    <li class="breadcrumbs-item">
                        <a href="{{ route('tasks.category', $ancestor) }}">{{ $ancestor->getBreadcrumbName() }}</a>
                    </li>
                @endforeach

                <li class="breadcrumbs-item active"> <span>{{ $category->getBreadcrumbName() }}</span></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col category-body">
            <div class="tabs">
                @include('app.advert.task._partials._tabs', ['page' => 'all'])

                <div class="tabs-content active">
                    <h1 class="category-title">{{ $category->name }}</h1>

                    @if($category->children->count() > 0)
                        <div class="workman-category-list">
                            @foreach($category->children as $child)
                                <a href="{{ route('tasks.category', $child) }}">{{ $child->name }}</a>
                            @endforeach
                        </div>
                    @endif

                    <div class="category-task-container">
                        <tasks-component :category='@json($category)' url="{{ route('api.advert.task.index') }}" :premium='@json($premium)'/>
                    </div>

                    <div class="category-task-container" style="text-align: left;">
                        <p>{!! nl2br($category->seo_text) !!}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col category-sidebar">
            <!-- can .sticky-->
            <div class="category-sidebar-inner sticky">
                <tasks-filter :cities='@json($cities)' />
            </div>
        </div>
    </div>
@endsection

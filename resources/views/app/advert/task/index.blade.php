@extends('layouts.frontend')

@section('body_class', 'category-page')
@section('main_class', 'role-workman')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endsection

@section('title', meta_title_helper('Все категории услуг'))

@section('main_header')
    <div class="container">
        <div class="breadcrumbs-section">
            <ul class="breadcrumbs">
                <li class="breadcrumbs-item"> <a href="{{ url('/') }}">Adomo</a></li>
                <li class="breadcrumbs-item active"> <span>Все категории услуг</span></li>
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
                    <h1 class="category-title">Все категории услуг</h1>

                    <div class="workman-category-list">
                        @foreach($categories as $category)
                            <a href="{{ route('tasks.category', $category) }}">{{ $category->name }}</a>
                        @endforeach
                    </div>

                    <div class="category-task-container">
                        <tasks-component url="{{ route('api.advert.task.index') }}" :premium='@json($premium)'/>
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

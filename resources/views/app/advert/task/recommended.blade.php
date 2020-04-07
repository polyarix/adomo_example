@extends('layouts.frontend')

@section('body_class', 'category-page')
@section('main_class', 'role-workman')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endsection

@section('title', meta_title_helper('Рекомендуемые заказы'))

@section('main_header')
    <div class="container">
        <div class="breadcrumbs-section">
            <ul class="breadcrumbs">
                <li class="breadcrumbs-item"> <a href="{{ url('/') }}">Adomo</a></li>
                <li class="breadcrumbs-item active"> <span>Рекомендации</span></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col category-body">
            <div class="tabs">
                @include('app.advert.task._partials._tabs', ['page' => 'recommended'])

                <div class="tabs-content active">
                    <div class="category-task-container">
                        <div class="headline">Рекомендации</div>

                        <tasks-component url="{{ route('api.advert.task.recommendations') }}" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col category-sidebar">
            <!-- can .sticky-->
            <div class="category-sidebar-inner sticky">
                <tasks-filter :cities='@json($cities)' :with-button="true" />
            </div>
        </div>
    </div>
@endsection

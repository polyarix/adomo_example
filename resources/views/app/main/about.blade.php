@extends('layouts.frontend')

@section('main_class', 'about-page')
@section('app_class', 'container')

@section('title', meta_title_helper(data_get($configs, 'about_meta_title', 'О сервисе')))

@section('meta')
    {!! meta_description_renderer(data_get($configs, 'about_meta_description', 'О сервисе')) !!}
    {!! meta_keywords_renderer(data_get($configs, 'about_meta_keywords', 'О сервисе')) !!}
@endsection

@section('main_header')
    <div class="about-page-header" style="background-image: url('{{ asset(data_get($configs, 'about_bg', 'images/about-head.jpg')) }}')">
        <span>{{ data_get($configs, 'about_label', 'О проекте') }}</span>
        <h1>
            <span>{{ data_get($configs, 'about_title', 'Adomo.com') }}</span>
            <span>{{ data_get($configs, 'about_text', 'Онлайн сервис поиска частных специалистов') }}</span>
        </h1>
    </div>
@endsection

@section('content')
    <div class="container-inner-small">
        {!!  data_get($configs, 'about_top_text') !!}

        <div class="about-page-number">
            <div class="number-item">
                <div class="number-item-value">{{ $daily_visitors }}</div>
                <div class="number-item-title">{{ num_decline($reviewsCount, ['Посетитель', 'Посетителя', 'Посетителей']) }} в день</div>
            </div>
            <div class="number-item">
                <div class="number-item-value">{{ $successDealsCount }}</div>
                <div class="number-item-title">{{ num_decline($reviewsCount, ['Удачная сделка', 'Удачных сделок', 'Удачных сделок']) }}</div>
            </div>
            <div class="number-item">
                <div class="number-item-value">{{ $reviewsCount }}</div>
                <div class="number-item-title">Реальных {{ num_decline($reviewsCount, ['отзыв', 'отзыва', 'отзывов']) }} </div>
            </div>
            <div class="number-item">
                <div class="number-item-value">{{ $customers_count }}</div>
                <div class="number-item-title">{{ num_decline($reviewsCount, ['ЗАКАЗЧИК', 'ЗАКАЗЧИКА', 'ЗАКАЗЧИКОВ']) }}</div>
            </div>
        </div>

        {!!  data_get($configs, 'about_bottom_text') !!}
    </div>
    <div class="about-page-action">
        <div class="container-inner-small">
            <h3>{{ data_get($configs, 'about_action_title', 'Найдите исполнителя или выполняйте задания на Adomo.com') }}</h3>
            <a class="btn btn-big btn-yellow" href="{{ url('/') }}">Найти исполнителя</a>
            <a class="btn btn-big btn-dark" href="{{ route('register') }}">Стать исполнителем</a>
        </div>
    </div>
@endsection

@extends('layouts.frontend')

@section('main_class', 'contact-page')
@section('app_class', 'container')

@section('title', meta_title_helper(data_get($configs, 'contacts_meta_title', 'Контакты')))

@section('meta')
    {!! meta_description_renderer(data_get($configs, 'contacts_meta_description', 'О сервисе')) !!}
    {!! meta_keywords_renderer(data_get($configs, 'contacts_meta_keywords', 'О сервисе')) !!}
@endsection

@section('content')
    <h1>{{ data_get($configs, 'contacts_title', 'Контакты') }}</h1>
    <div class="row">
        <div class="col contact-page-left">
            <contact-form-component
                admin-phone="{{ main_config('phone1', '8 (800) 500-77-00') }}"
                admin-email="{{ main_config('email', 'info@adomo.ru') }}"
                description="{{ data_get($configs, 'contacts_text') }}"
            />
        </div>
        <div class="col contact-page-right">
            <offer-form-component title="{{ data_get($configs, 'contacts_title', 'Контакты') }}" />
        </div>
    </div>
@endsection

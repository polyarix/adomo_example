@extends('layouts.frontend')

@section('main_class', 'autofit-page')

@section('title', meta_title_helper(null, 'Создание задания'))

@section('css')
{{--    <link rel="stylesheet" href="http://front.polyarix.space/adomo/css/jquery-ui.min.css">--}}
@endsection

@section('content')
    <auto-fit-full-page-component :cities='@json($cities)' :categories='@json($categories)' />
@endsection

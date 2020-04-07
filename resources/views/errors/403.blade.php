@extends('layouts.frontend')

@section('main_class', 'page404')
@section('main_styles', 'background-image: url(' . asset('images/404-bg.jpg') . ')')

@section('content')
  <div class="page404-box">
    <div class="page404-404"> <span>403</span></div>
    <h1>Доступ запрещен</h1>
    <a class="btn btn-big btn-yellow" href="{{ url('/') }}">На главную</a>
  </div>
@endsection
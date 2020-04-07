@extends('layouts.frontend')

@section('main_class', 'thank-page')

@section('title', meta_title_helper('Успешное завершение проекта'))

@section('content')
    <div class="thank-page-box">
        <div class="thank-page-title">Вы успешно закрыли задачу</div>
        <div class="thank-page-subtitle">Спасибо, что воспользовались нашей платформой</div>

        @if($user->isExecutor())
            <a class="btn btn-big btn-dark" href="{{ route('category.show', $order->category) }}">Найти похожую</a>
        @else
            <a class="btn btn-big btn-yellow" href="{{ url('/') }}">Создать новую задачу</a>
        @endif
    </div>
@endsection

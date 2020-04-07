@extends('layouts.frontend')

@section('main_class', 'order-feedback')

@section('title', meta_title_helper("Обмен отзывами по заказу {$order->title}"))

@section('content')
    <div class="container-inner-small">
        @php $isAuthor = $user->authorOf($order); @endphp

        <div class="headline">{{ $isAuthor ? 'Вы завершили проект' : 'Вы выполнили задачу' }}</div>

        <div class="order-feedback-head">
            <div class="user-avatar">
                <img src="{{ asset($target->getAvatar()) }}" alt=""/>
            </div>

            <div class="user-info">
                <a class="user-info-name" href="{{ route('user.details', $target) }}" target="_blank">{{ $target->getName() }}</a>
                <div class="user-info-task">{{ $order->title }}</div>
            </div>
        </div>
        <div class="headline">Оставьте свой отзыв {{ $isAuthor ? 'об исполнителе' : 'о заказчике' }}</div>

        <order-review-component :order='@json($order)' />
    </div>
@endsection

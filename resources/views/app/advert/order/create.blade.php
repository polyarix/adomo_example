@extends('layouts.frontend')

@section('body_class', 'task-page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endsection

@section('title', meta_title_helper(null, 'Создание задания'))

@section('meta')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@%5E0.3.0/dist/vue-treeselect.css">
@endsection

@section('content')
    <create-order-component
        :category='@json($category)'
        :categories='@json($categories)'
        :cities='@json($cities)'
        executor="{{ $user ? $user->id : null }}"
        :show-recommended="{{ $user ? 'false' : 'true' }}"
        @if(isset($order) && !empty($order))
        :order='@json($order)'
        @endif
    >
        @if($user)
            <div class="col task-page-sidebar">
                <!-- can .sticky-->
                <div class="task-page-sidebar-inner sticky">
                    <div class="task-page-user">
                        <div class="task-page-user-main">
                            <div class="task-page-user-avatar"><img src="/{{ $user->getAvatar() }}" alt=""></div>
                            <div class="task-page-user-info">
                                <a class="task-page-user-name" href="{{ route('user.details', $user) }}">{{ $user->getName() }}</a>
                                <p>
                                    @if(($age = $user->getAge()) > 0)
                                        <span class="task-page-user-age">{{ $age }} {{ num_decline($age, ['год', 'года', 'лет']) }}</span>
                                    @endif

                                    @if($user->workData && $user->workData->city)
                                        <span class="task-page-user-city">{{ $user->workData->city->name }}</span>
                                    @endif
                                </p>

                                <p>Отзывов: <span class="task-page-user-reviews">{{ $user->reviews_count }}</span></p>
                                <p>Положительных: <span class="task-page-user-like">{{ $user->getPositiveReviewsPercent() }} %</span></p>
                            </div>
                        </div>
                        <div class="hr-1"></div>

                        @if($user->isConfirmed())
                            <div class="task-page-user-title">
                                <div class="user-certified" style="background-image:url(/images/shield-true.svg)"></div>
                                <p>Проверенный исполнитель</p>
                            </div>

                            <ul>
                                <li>Проверены паспортные данные</li>
                            </ul>

                            <div class="hr-1"></div>
                        @endif

                        <div class="task-page-user-title">
                            <div class="user-reviews-icon" style="background-image:url(/images/review-icon.svg)"></div>
                            <p>Последние отзывы</p>
                        </div>

                        <div class="task-page-user-reviews">
                            <!--mixin review-item-->
                            @foreach($reviews as $review)
                                <div class="review-item">
                                    <div class="review-item-header">
                                        <a class="review-item-name" href="{{ route('user.details', $review->user) }}" target="_blank">{{ $review->user->first_name }}</a>
                                        <div class="review-item-avatar">
                                            <img src="{{ asset($review->user->getAvatar()) }}" alt="">
                                        </div>

                                        <div class="review-item-rate">
                                            <div class="user-rating">
                                                <div class="user-rating-stars" data-star="{{ $review->getStarRating() }}">
                                                    @for($i = 0; $i < 5; $i++)
                                                        <svg class="star">
                                                            <use xlink:href="/images/sprite-inline.svg#star"></use>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <div class="user-rating-rate">
                                                    <span>{{ normalize_status($review->avg) }}</span>
                                                </div>
                                            </div>

                                            @include('app.main._partials._review_rate', ['review' => $review])
                                        </div>
                                    </div>
                                    <div class="review-item-body">
                                        <div class="review-item-text">
                                            <truncate-component
                                                show-button="Показать отзыв"
                                                hide-button="Скрыть "
                                                :max-length="100"
                                                text="{{ $review->text }}" />
                                        </div>
                                    </div>
                                    @if($review->order)
                                        <div class="review-item-footer">
                                            <p>Отзыв по заданию: <a href="{{ route('advert.order.show', $review->order) }}">{{ $review->order->title }}</a></p>
                                        </div>
                                    @endif
                                </div>
                        @endforeach
                        <!--mixin review-item-->
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </create-order-component>

    <div class="row">
        <div class="col task-page-body">

        </div>
    </div>
@endsection

@extends('layouts.frontend')

@section('body_class', 'task-page advert-page')

@section('title', meta_title_helper($order->meta_title, $order->title))

@section('meta')
    {!! meta_helper_renderer($order) !!}
@endsection

@section('meta')
    <style>
        .alert {
            position: relative;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-heading {
            color: inherit;
        }

        .alert-link {
            font-weight: 700;
        }

        .alert-dismissible {
            padding-right: 4rem;
        }

        .alert-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 0.75rem 1.25rem;
            color: inherit;
        }

        .alert-primary {
            color: #004085;
            background-color: #cce5ff;
            border-color: #b8daff;
        }

        .alert-primary hr {
            border-top-color: #9fcdff;
        }

        .alert-primary .alert-link {
            color: #002752;
        }

        .alert-secondary {
            color: #383d41;
            background-color: #e2e3e5;
            border-color: #d6d8db;
        }

        .alert-secondary hr {
            border-top-color: #c8cbcf;
        }

        .alert-secondary .alert-link {
            color: #202326;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-success hr {
            border-top-color: #b1dfbb;
        }

        .alert-success .alert-link {
            color: #0b2e13;
        }

        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }

        .alert-info hr {
            border-top-color: #abdde5;
        }

        .alert-info .alert-link {
            color: #062c33;
        }

        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }

        .alert-warning hr {
            border-top-color: #ffe8a1;
        }

        .alert-warning .alert-link {
            color: #533f03;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-danger hr {
            border-top-color: #f1b0b7;
        }

        .alert-danger .alert-link {
            color: #491217;
        }

        .alert-light {
            color: #818182;
            background-color: #fefefe;
            border-color: #fdfdfe;
        }

        .alert-light hr {
            border-top-color: #ececf6;
        }

        .alert-light .alert-link {
            color: #686868;
        }

        .alert-dark {
            color: #1b1e21;
            background-color: #d6d8d9;
            border-color: #c6c8ca;
        }

        .alert-dark hr {
            border-top-color: #b9bbbe;
        }

        .alert-dark .alert-link {
            color: #040505;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col task-page-body">
            <div class="task-page-body-inner">
                <div class="advert">
                    <div class="advert-header">
                        <div class="advert-header-title">{{ $order->title }}</div>
                        <div class="advert-header-price">
                            @if($order->isDiscussPriceType())
                                Обсуждаемо
                            @else
                                {{ $order->price }} ₽
                            @endif
                        </div>
                    </div>
                    {{--<div class="advert-city">
                        <div class="place-icon" style="background-image:url(./images/place-icon.svg)"> </div><span>г Москва</span>
                    </div>--}}

                    @if($tags = $order->tags)
                        <div class="advert-tags">
                            @foreach($tags as $tag)
                                <a href="#" style="background: rgba(227, 250, 253, 0.3);">#{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    @endif

                    <div class="hr-1"></div>

                    <p>{!! $order->description !!}</p>

                    @if(Auth::guest() || Auth::user()->isCustomer())
                        <a href="{{ route('advert.order.create', ['category' => $order->categories->first(), 'user' => $user]) }}" class="btn btn-big btn-yellow">Предложить работу</a>
                    @endif

                    @if(Auth::user() && Auth::user()->authorOfService($order) && $order->isActive())
                       <div>
                           <catch-up-service-component :order='@json(\App\Http\Resources\Advert\AdvertResource::make($order))' />
                       </div>
                    @endif

                    <div class="advert-gallery">
                        @foreach($order->photos as $photo)
                            <a class="advert-gallery-item" href="{{ asset($photo->getPath()) }}" data-fancybox="gallery">
                                <div class="advert-gallery-item-img">
                                    <img class="lazy" alt="" src="{{ $photo->getCrop() }}" style="">
                                </div>
                            </a>
                        @endforeach

                        @foreach($order->videos as $video)
                            <a class="advert-gallery-item advert-gallery-item--video" data-fancybox href="{{ $video->getUrl() }}">
                                <div class="advert-gallery-item-img" style="">
                                    <img class="lazy" alt="" src="{{ $video->getCrop() }}" style="">
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

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

                                @if(data_get($user->workData, 'city.name'))
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
    </div>
@endsection

@section('scripts')
    <script>
        var res = $('.lazy').lazy({
            effect: "fadeIn",
            effectTime: 2000,
            threshold: 0
        });
    </script>
@endsection

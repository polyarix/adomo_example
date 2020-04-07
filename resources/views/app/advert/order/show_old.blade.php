@extends('layouts.frontend')

@section('body_class', 'task-page')

@section('meta')
    <meta name="title" content="{{ $order->meta_title }}">
    <meta name="description" content="{{ $order->meta_description}}">
    <meta name="keywords" content="{{ $order->meta_keywords }}">

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
                @if(!$order->isActive())
                    <div class="advert-header text-center" style="margin: auto; float: right; clear: both; font-size: .9em;
">
                        @if($order->isOnModeration())
                            <div class="alert alert-primary">Объявление на модерации</div>
                        @endif
                        @if($order->isRejected())
                            <div class="alert alert-danger">Объявление отклонено по причине {{ $order->close_reason }}</div>
                        @endif
                        @if($order->isSpam())
                            <div class="alert alert-danger">Объявление помечено как спам</div>
                        @endif
                        @if($order->isClosed())
                            <div class="alert alert-default">Объявление закрыто по причине {{ $order->close_reason }}</div>
                        @endif
                    </div>
                    <div style="clear: both"></div>
                @endif

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
                    <div class="advert-city">
                        <div class="place-icon" style="background-image:url(/images/place-icon.svg)"> </div><span>{{ $order->address }}</span>
                    </div>
                    <div class="hr-1"></div>
                    <p>{!! nl2br($order->description) !!}</p>

                    <div class="advert-gallery">
                        @foreach($order->photos as $photo)
                            <a class="advert-gallery-item" href="{{ asset($photo->getPath()) }}" data-fancybox="gallery">
                                <div class="advert-gallery-item-img">
                                    <img class="lazy" alt="" src="{{ $photo->getCrop() }}" style="">
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
                        <div class="task-page-user-avatar">
                            <img src="{{ asset($order->user->getAvatar()) }}" alt="">
                        </div>
                        <div class="task-page-user-info">
                            <a class="task-page-user-name" href="{{ route('user.details', $order->user) }}">{{ $order->user->getName() }}</a>

                            <p> <span class="task-page-user-age">{{ $order->user->getAge() }} года</span><span class="task-page-user-city">{{ $order->user->city ? $order->user->getCity() : '' }}</span></p>
                            <p>Отзывов: <span class="task-page-user-reviews">14</span></p>
                            <p>Положительных: <span class="task-page-user-like">97 %</span></p>
                        </div>
                    </div>
                    <div class="hr-1"></div>

                    <div class="task-page-user-reviews">
                        <!--mixin review-item-->
                        <div class="review-item">
                            <div class="review-item-header">
                                <a class="review-item-name" href="#">Создано:</a>
                                <div class="review-item-date">{{ $order->created_at }}</div>
                                <div class="review-item-rate">
                                    @php $isExecutor = (bool)rand(0, 1); @endphp

                                    <order-map
                                        :coords='@json($order->getFakeCoordinates())'
                                        address="{{ $isExecutor ? $order->address : $order->getFakeAddress() }}"
                                        :radius="500"
                                        :allowed="{{ $isExecutor ? 'true' : 'false' }}"
                                    />
                                </div>

                                <div class="advert-city">
                                    <div class="place-icon" style="background-image:url(/images/place-icon.svg)"> </div>
                                    <span>{{ $isExecutor ? $order->address : $order->getFakeAddress() }}</span>
                                </div>
                            </div>
                        </div>
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

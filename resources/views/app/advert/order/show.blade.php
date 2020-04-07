@extends('layouts.frontend')

@section('main_class', 'order-page')

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

        .order-request-accepted {
            border-left: 4px solid green !important;
        }
        .order-request-rejected {
            border-left: 4px solid red !important;
            opacity: .5;
        }
    </style>
@endsection

@section('content')
    <div class="row order-page-row">
        <div class="col order-page-main">
            @if($order->isRejected())
                <div class="info-rejection">
                    <div class="info-rejection__title">Объявление отклонено</div>
                    <div class="info-rejection__text">{{ $order->close_reason }}</div>
                </div>
            @endif

            <div class="order-card">
                <div class="order-card-header">
                    <div class="order-card-header-title">{{ $order->title }}</div>
                    <div class="order-card-header-price">
                        @if($order->isDiscussPriceType())
                            Обсуждаемо
                        @else
                            {{ $order->price }} ₽
                        @endif
                    </div>
                </div>
                <div class="order-card-status">
                    <div class="order-date">
                        <div class="date-icon" style="background-image:url(/images/clock-icon.svg)"></div>
                        <span>Выполнить {{ localized_date($order->beginning_date, 'd F') }}, {{ Str::lower($order->getTimeType()) }}</span>
                    </div>

                    @include('app.advert._status_label', ['order' => $order])

                    @if($user && $user->id === $order->user->id)
                        <a href="#requests" id="advert_requests_count">{{ $order->requests->count() }} {{ num_decline($order->requests->count(), ['предложение', 'предложения', 'предложений']) }}</a>
                    @endif
                </div>

                <div class="advert-tags">
                    @foreach($order->tags as $tag)
                        <a href="{{ route('category.tag', $tag) }}">{{ $tag->name }}</a>
                    @endforeach
                </div>

                <div class="order-card-body">
                    <p>{!! nl2br($order->description) !!}</p>
                    <p style="margin-top: 10px;">Предоставление жилья: {{ $order->house_provision ? 'Да' : 'Нет' }}</p>
                    <p>Материалы: {{ $order->materials_provision ? 'Предоставляет заказчик' : 'Нужна закупка исполнителем' }}</p>
                    <p style="margin-top: 10px;">Выполнить нужно в: {{ $order->address }}</p>
                    <div class="order-gallery">
                        @foreach($order->photos as $photo)
                            <a class="order-gallery-item" href="{{ asset($photo->getPath()) }}" data-fancybox="gallery">
                                <div class="order-gallery-item-img">
                                    <img class="lazy" alt="" src="{{ $photo->getCrop() }}" style="">
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                @if(Auth::check() && Gate::allows('show-order', $order))
                    @can('review-order', $order)
                        <a class="btn btn-big btn-yellow" href="{{ route('advert.order.review', $order) }}">Оставить отзыв</a>
                    @else
                        <order-actions-component :order='@json($order)' :requested="{{ $leftRequest ? 'true' : 'false' }}" />
                    @endcan
                @endif
            </div>

            @if($user && $user->authorOf($order) && $requests->count() > 0)
                <div class="order-card lk-tasks" id="requests">
                    <div class="order-card-header-title">Предложения</div>
                    <div class="order-card-body">
                        @foreach($requests as $request)
                            <div class="task-card order-request-{{ $request->status }}" style="border: 1px dashed silver">
                                <div class="task-card-inner">
                                    <span class="task-card-name">{{ $request->message }}</span>

                                    <div class="task-card-info">
                                        <a class="task-card-info-who" href="{{ route('user.details', $request->user) }}" target="_blank">{{ $request->user->first_name }} {{ $request->user->last_name }}</a>
                                    </div>

                                    @if($order->isActive() && $request->isWaiting() && $request->isExecutorRequest())
                                        <div>
                                            <form action="{{ route('advert.order.set_executor', $request->id) }}" method="POST" style="display: inline-block">
                                                @csrf
                                                <button class="btn btn-small btn-green">Выбрать исполнителем</button>
                                            </form>

                                            <form action="{{ route('advert.order.reject_executor', $request->id) }}" method="POST" style="display: inline-block">
                                                @csrf
                                                <button class="btn btn-small btn-yellow">Отклонить</button>
                                            </form>
                                        </div>
                                    @endif

                                    <div style="margin-top: 10px;">
                                        <write-user-message-component
                                            :user='@json($request->user)'
                                            locked-subject="Заказ: {{ $order->title }}"
                                            :order-id="{{ $order->id }}"
                                            button-label="Обсудить заказ"
                                            :key="{{ $request->user->id }}"
                                        />
                                    </div>

                                    <div class="task-card-absolute">
                                        <div class="task-card-status">
                                            @if($request->isRejected())
                                                Отклонён
                                            @endif
                                            @if($request->isAccepted())
                                                Выбран исполнителем
                                            @endif
                                            @if($request->isCustomerInvite())
                                                Предложено сотрудничество
                                                <br>
                                            @endif
                                            @if($request->isWaiting())
                                                Ожидает
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!$user || $user->isExecutor())
                <similar-adverts-component :category='@json($order->category)' :order='@json($order)' />
            @endif
        </div>

        <div class="col order-user">
            <div class="order-user-header">
                <div class="avatar"> <img src="{{ asset($order->user->getAvatar()) }}" alt=""></div>
                <div class="user-info">
                    <a class="user-info-name" href="{{ route('user.details', $order->user) }}">{{ $order->user->getName() }}</a>
                    <div class="user-info-reviews">
                        <p>Отзывов: <span>{{ $order->user->reviews->count() }}</span></p>
                    </div>
                    <div class="user-info-like">
                        <p>Положительных: <span>{{ $user->getPositiveReviewsPercent() }}</span>% </p>
                    </div>
                </div>
            </div>
            <div class="order-user-body">
                <div class="order-date-create">
                    <svg class="calendar-icon">
                        <use xlink:href="/images/sprite-inline.svg#calendar-icon"></use>
                    </svg>
                    <p>Создано: <span>{{ localized_date($order->created_at, 'd F, G:i') }}</span></p>
                </div>
                <div class="order-map">
                    @php $address = $showCoordinates ? trim("{$order->address}, {$order->comment}", ', ') : $order->getFakeAddress(); @endphp

                    <order-map
                        :coords='@json($showCoordinates ? $order->getCoordinates() : $order->getFakeCoordinates())'
                        address="{{ $address }}"
                        :radius="500"
                        :allowed="{{ $showCoordinates ? 'true' : 'false' }}"
                    />
                </div>
                <div class="order-place">
                    <p>{{ $address }}</p>
                </div>

                @if($order->hasDistrict())
                    <div class="order-place">
                        <p>Район: {{ $order->district->name }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($order->isOnModeration())
        <div class="modal modal-message" style="display: none;" id="moderation-modal">
            <div class="modal-message-inner">
                <div class="modal-message-icon"><img src="{{ asset('images/moderate-icon.svg') }}" alt=""/></div>
                <div class="modal-message-text">
                    <div class="modal-title">Заказ на модерации</div>
                    <p>Он будет доступен после проверки администратором</p>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        var res = $('.lazy').lazy({
            effect: "fadeIn",
            effectTime: 2000,
            threshold: 0
        });

        @if($order->isOnModeration())
            $.fancybox.open($("#moderation-modal"));
        @endif
    </script>
@endsection

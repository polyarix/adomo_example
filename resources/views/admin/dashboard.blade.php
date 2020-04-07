@extends('backpack::layout')

@inject('order', 'App\Entity\Advert\Advert\Order')
@inject('service', 'App\Entity\Advert\Advert\Service')
@inject('user', 'App\Entity\User\User')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::base.dashboard') }}
        </h1>

        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    @php
                        /** @var $order App\Entity\Advert\Advert\Order */
                    @endphp
                    <h3>{{ $order::getTotalCount() }}</h3>
                    <h3>{{ num_decline($order::getTotalCount(), __('admin.num_orders')) }}</h3>
                    <p>
                        <a href="{{ route('crud.orders.index', ['status' => $order::STATUS_ACTIVE]) }}">
                            <i class="fa fa-arrow-circle-right text-light"></i>
                        </a>
                        {{ $order::getStatusList()[$order::STATUS_ACTIVE] }} - {{ $order::getActiveCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.orders.index', ['status' => $order::STATUS_COMPLETED]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $order::getStatusList()[$order::STATUS_COMPLETED] }} - {{ $order::getCompletedCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.orders.index', ['status' => $order::STATUS_FINISHED]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $order::getStatusList()[$order::STATUS_FINISHED] }} - {{ $order::getFinishedCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.orders.index', ['status' => $order::STATUS_MODERATION]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $order::getStatusList()[$order::STATUS_MODERATION] }} - {{ $order::getModerationCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.orders.index', ['status' => $order::STATUS_REJECTED]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $order::getStatusList()[$order::STATUS_REJECTED] }} - {{ $order::getRejectedCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.orders.index', ['status' => $order::STATUS_EXPIRED]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $order::getStatusList()[$order::STATUS_EXPIRED] }} - {{ $order::getExpiredCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.orders.index', ['status' => $order::STATUS_CLOSED]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $order::getStatusList()[$order::STATUS_CLOSED] }} - {{ $order::getClosedCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.orders.index', ['status' => $order::STATUS_SPAM]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $order::getStatusList()[$order::STATUS_SPAM] }} - {{ $order::getSpamCount() }}
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-cart-arrow-down"></i>
                </div>
                <a href="{{ route('crud.orders.index') }}"
                   class="small-box-footer"> {{ __('admin.orders') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="small-box bg-green">
                <div class="inner">
                    @php
                        /** @var $service App\Entity\Advert\Advert\Service */
                    @endphp
                    <h3>{{ $service::getTotalCount() }}</h3>
                    <h3>{{ num_decline($service::getTotalCount(), __('admin.num_services')) }}</h3>
                    <p>
                        <a href="{{ route('crud.services.index', ['status' => $order::STATUS_ACTIVE]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $service::getStatusList()[$service::STATUS_ACTIVE] }} - {{ $service::getActiveCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.services.index', ['status' => $order::STATUS_COMPLETED]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $service::getStatusList()[$service::STATUS_COMPLETED] }} - {{ $service::getCompletedCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.services.index', ['status' => $order::STATUS_FINISHED]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $service::getStatusList()[$service::STATUS_FINISHED] }} - {{ $service::getFinishedCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.services.index', ['status' => $order::STATUS_MODERATION]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $service::getStatusList()[$service::STATUS_MODERATION] }} - {{ $service::getModerationCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.services.index', ['status' => $order::STATUS_REJECTED]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $service::getStatusList()[$service::STATUS_REJECTED] }} - {{ $service::getRejectedCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.services.index', ['status' => $order::STATUS_EXPIRED]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $service::getStatusList()[$service::STATUS_EXPIRED] }} - {{ $service::getExpiredCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.services.index', ['status' => $order::STATUS_CLOSED]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $service::getStatusList()[$service::STATUS_CLOSED] }} - {{ $service::getClosedCount() }}
                    </p>
                    <p>
                        <a href="{{ route('crud.services.index', ['status' => $order::STATUS_SPAM]) }}">
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        {{ $service::getStatusList()[$service::STATUS_SPAM] }} - {{ $service::getSpamCount() }}
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-cart-arrow-down"></i>
                </div>
                <a href="{{ route('crud.orders.index') }}"
                   class="small-box-footer"> {{ __('admin.services') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-blue">
                <div class="inner">
                    @php
                        /** @var $user App\Entity\User\User */
                    @endphp
                    <h3>{{ $user::getTotalCount() }}</h3>
                    <h3>{{ num_decline($user::getTotalCount(), ['пользователь', 'пользователя', 'пользователей']) }}</h3>
                    <p>
                        {{ $user::getTypes()[$user::TYPE_CUSTOMER] }} - {{ $user::getCustomersCount() }}
                    </p>
                    <p>{{ $user::getTypes()[$user::TYPE_EXECUTOR] }} - {{ $user::getExecutorsCount() }}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('crud.users.index') }}"
                   class="small-box-footer"> {{ __('admin.users') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection

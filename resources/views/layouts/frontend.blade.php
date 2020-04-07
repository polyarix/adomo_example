<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    @yield('meta')

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="format-detection" content="telephone=no"/>

    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>

    <style>
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #dc3545;
        }
        .invalid-tooltip {
            position: absolute;
            top: 100%;
            z-index: 5;
            display: none;
            max-width: 100%;
            padding: 0.25rem 0.5rem;
            margin-top: .1rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #fff;
            background-color: rgba(220, 53, 69, 0.9);
            border-radius: 0.25rem;
        }
        .was-validated .form-control:invalid, .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E");
            background-repeat: no-repeat;
            background-position: center right calc(0.375em + 0.1875rem);
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        .was-validated .form-control:invalid:focus, .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        .was-validated .form-control:invalid ~ .invalid-feedback,
        .was-validated .form-control:invalid ~ .invalid-tooltip, .form-control.is-invalid ~ .invalid-feedback,
        .form-control.is-invalid ~ .invalid-tooltip {
            display: block;
        }
        .was-validated textarea.form-control:invalid, textarea.form-control.is-invalid {
            padding-right: calc(1.5em + 0.75rem);
            background-position: top calc(0.375em + 0.1875rem) right calc(0.375em + 0.1875rem);
        }
        .was-validated .custom-select:invalid, .custom-select.is-invalid {
            border-color: #dc3545;
            padding-right: calc((1em + 0.75rem) * 3 / 4 + 1.75rem);
            background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right 0.75rem center/8px 10px, url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E") #fff no-repeat center right 1.75rem/calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        .was-validated .custom-select:invalid:focus, .custom-select.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        .was-validated .custom-select:invalid ~ .invalid-feedback,
        .was-validated .custom-select:invalid ~ .invalid-tooltip, .custom-select.is-invalid ~ .invalid-feedback,
        .custom-select.is-invalid ~ .invalid-tooltip {
            display: block;
        }
        .was-validated .form-control-file:invalid ~ .invalid-feedback,
        .was-validated .form-control-file:invalid ~ .invalid-tooltip, .form-control-file.is-invalid ~ .invalid-feedback,
        .form-control-file.is-invalid ~ .invalid-tooltip {
            display: block;
        }
        .was-validated .form-check-input:invalid ~ .form-check-label, .form-check-input.is-invalid ~ .form-check-label {
            color: #dc3545;
        }
        .was-validated .form-check-input:invalid ~ .invalid-feedback,
        .was-validated .form-check-input:invalid ~ .invalid-tooltip, .form-check-input.is-invalid ~ .invalid-feedback,
        .form-check-input.is-invalid ~ .invalid-tooltip {
            display: block;
        }
        .was-validated .custom-control-input:invalid ~ .custom-control-label, .custom-control-input.is-invalid ~ .custom-control-label {
            color: #dc3545;
        }
        .was-validated .custom-control-input:invalid ~ .custom-control-label::before, .custom-control-input.is-invalid ~ .custom-control-label::before {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
        }
        .alert {
            position: relative;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .vs-noti-top-right {
            margin-top: 80px;
        }
        .avatar-cropper-btn {
            text-align: center;
        }
    </style>

    @yield('css')

    <script>
        window.user = @json(Auth::user());
        window.city = @json($currentCity);
    </script>
</head>

<body class="@yield('body_class')">
<header class="header {{ Auth::check() ? 'authorised' : '' }}">
    <div class="header-additional">
        <div class="container">
            <div class="row">
                <div class="col header-additional-city">
                    <a class="city-select-btn" href="javascript:;" data-fancybox data-src="#select-city-modal">
                        <svg class="place-icon">
                            <use xlink:href="{{ asset('images/sprite-inline.svg#place-icon') }}"></use>
                        </svg>
                        <span>Ваш город: </span>
                        <span class="city-current">{{ $city }}</span>
                        <div class="triangle"></div>
                    </a>
                </div>

                <div class="col header-additional-menu">
                    <nav>
                        <a class="menu-item" href="{{ about_path() }}">О сервисе</a>
                        <a class="menu-item" href="{{ route('companies.index') }}">Строительные компании</a>
                        <a class="menu-item" href="{{ route('blog.index') }}">Статьи</a>
                        <a class="menu-item" href="{{ faq_path() }}">FAQ</a>
                        <a class="menu-item" href="{{ contacts_path() }}">Контакты</a>

                        @if(Auth::user() && Auth::user()->isExecutor())
                            <a class="menu-item" href="{{ route('tasks.index') }}">Задания</a>
                        @endif
                    </nav>
                </div>

                <div class="col header-additional-phone">
                    <a class="phone-link" href="tel:+{{ sanitize_phone(main_config('phone1', '8 (800) 700-17-71')) }}">
                        <svg class="phone-icon">
                            <use xlink:href="{{ asset('images/sprite-inline.svg#phone-icon') }}"></use>
                        </svg>
                        <span>{{ main_config('phone1', '8 (800) 700-17-71') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-main">
        <div class="container">
            <div class="row">
                <div class="col header-main-left">
                    <button class="burger" id="burger-btn">
                        <svg class="burger-icon">
                            <use xlink:href="{{ asset('images/sprite-inline.svg#burger-icon') }}"></use>
                        </svg>
                    </button>
                    <a class="brand" href="{{ url('/') }}"> <img src="{{ asset('images/logo-black.svg') }}" alt=""/></a>

                    @if(Auth::guest() || (Auth::user() && Auth::user()->isCustomer()))
                        <a class="btn btn-small btn-yellow" href="{{ route('advert.order.create') }}"><span>Создать задание</span></a>
                    @endif
                </div>
                <a class="brand brand-for-device" href="/">
                    <img src="{{ asset('images/logo-black.svg') }}" alt="">
                    <img class="for-authorised" src="{{ asset('images/logo-cut.svg') }}" alt="">
                </a>

                <div class="col header-main-center" id="smart-search">
                    <smart-search />
                </div>

                @guest
                    <div class="col header-main-right">
                        <a class="header-button header-button-for-device" href="#">
                            <svg class="plus-device">
                                <use xlink:href="{{ asset('images/sprite-inline.svg#plus-device') }}"></use>
                            </svg>
                        </a>

                        <!-- if login is false-->
                        <div class="login-button">
                            <svg class="profile-icon">
                                <use xlink:href="{{ asset('images/sprite-inline.svg#profile-icon') }}"></use>
                            </svg>
                            <div class="login-button-inner">
                                <a class="login-button-link" href="{{ route('login') }}">Вход </a><span>/</span>
                                <a class="login-button-link" href="{{ route('register') }}">Регистрация</a>
                            </div>
                        </div>

                        <a class="header-button header-button-for-device" href="{{ route('login') }}">
                            <svg class="account-device">
                                <use xlink:href="{{ asset('images/sprite-inline.svg#account-device') }}"></use>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="col header-main-right">
                        <a class="header-button" href="{{ Auth::user()->isExecutor() ? route('cabinet.services.create') : route('advert.order.create') }}">
                            <svg class="task">
                                <use xlink:href="{{ asset('images/sprite-inline.svg#task') }}"></use>
                            </svg>
                        </a>

                        <a class="header-button header-button_messages" href="{{ route('cabinet.chat.index') }}">
                            <svg class="draft">
                                <use xlink:href="{{ asset('images/sprite-inline.svg#draft') }}"></use>
                            </svg>
                            @if($totalUnseenMessages > 0)
                                <span id="unseen_messages_count">{{ $totalUnseenMessages }}</span>
                            @endif
                        </a>

                        <div class="header-profile">
                            <button class="header-profile-button">
                                <div class="header-profile-button_avatar"><img src="{{ asset(Auth::user()->getAvatar()) }}" alt=""></div>
                                <div class="header-profile-button_type"><span>профиль</span><span>{{ Auth::user()->getType() }}</span></div>
                                <div class="triangle"></div>
                            </button>

                            <div class="header-profile-menu">
                                <div class="header-profile-menu_head">
                                    <div class="header-profile-menu_head-info">
                                        <span>{{ Auth::user()->first_name }}</span>
                                        <span>{{ Auth::user()->email }}</span>

                                        @if(Auth::user()->hasPremium())
                                            <span style="color: #fec62b; padding-top: 10px;">
                                                PRO аккаунт до: <em style="font-weight: bold;">{{ Auth::user()->premium_to->format('d.m.Y G:i') }}</em>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="header-profile-menu_body">
                                    <ul>
                                        @can('admin-panel')
                                            <li> <a class="header-profile-menu-link" href="{{ route('backpack.dashboard') }}">Админка</a></li>
                                        @endcan

                                        <li> <a class="header-profile-menu-link" href="{{ route('cabinet.tasks') }}">Мои задания ({{ $totalPendingRequests }})</a></li>
                                        <li> <a class="header-profile-menu-link" href="{{ route('cabinet.chat.index') }}">Личные сообщения</a></li>

                                        <li>
                                            <a class="header-profile-menu-link lk-dropdown" href="javascript:;">Личный кабинет</a>

                                            <ul class="header-lk-list" style="display: none;">
                                                <li> <a class="header-lk-list-item" href="{{ route('cabinet.main_info') }}">Основная информация</a></li>

                                                @if(Auth::user()->isExecutor())
                                                    <li> <a class="header-lk-list-item" href="{{ route('cabinet.portfolio.index') }}">Портфолио</a></li>
                                                @endif

                                                <li> <a class="header-lk-list-item" href="{{ route('cabinet.verification') }}">Данные верификации</a></li>
                                                <li> <a class="header-lk-list-item" href="{{ route('cabinet.reviews') }}">Ваши отзывы</a></li>
                                                <li> <a class="header-lk-list-item" href="{{ route('cabinet.tasks') }}">Мои задания</a></li>

                                                @if(Auth::user()->isExecutor())
                                                    <li> <a class="header-lk-list-item" href="{{ route('cabinet.work_categories') }}">Категории работ</a></li>
                                                    <li> <a class="header-lk-list-item" href="{{ route('cabinet.services.index') }}">Услуги</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="header-profile-menu_footer">
                                    <a class="btn-logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Выход
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
    <div class="burger-menu">
        <div class="burger-menu-inner">
            <button class="burger-menu-close"></button>
            <div class="burger-menu-header">
                @auth
                    <div class="burger-menu-profile">
                        <div class="burger-menu-profile_avatar"><img src="{{ asset(Auth::user()->getAvatar()) }}" alt=""></div>
                        <div class="burger-menu-profile_type"><span>профиль</span><span>{{ Auth::user()->isExecutor() ? 'Исполнителя' : 'Заказчика' }}</span></div>
                    </div>
                @else
                    <a class="brand" href="/"><img src="{{ asset('images/logo-white.svg') }}" alt=""></a>
                @endauth
            </div>

            <div class="burger-menu-body">
                <a class="city-select-btn" href="javascript:;" data-fancybox data-src="#select-city-modal">
                    <svg class="place-icon">
                        <use xlink:href="{{ asset('images/sprite-inline.svg#place-icon') }}"></use>
                    </svg>
                    <span>Ваш город: </span>
                    <span class="city-current">{{ $city }}</span>
                    <div class="triangle"></div>
                </a>

                <ul class="burger-menu-list">
                    <li><a class="burger-menu-list-link" href="{{ about_path() }}">О сервисе</a></li>
                    <li><a class="burger-menu-list-link" href="{{ route('companies.index') }}">Строительные компании</a></li>
                    <li><a class="burger-menu-list-link" href="{{ route('blog.index') }}">Статьи</a></li>
                    <li><a class="burger-menu-list-link" href="{{ faq_path() }}">FAQ</a></li>
                    <li><a class="burger-menu-list-link" href="{{ contacts_path() }}">Контакты</a></li>

                    @if(userecho_enabled())
                        <li> <a class="burger-menu-list-link" href="{{ route('support') }}">Саппорт</a></li>
                    @endif
                </ul>
            </div>
            <div class="burger-menu-footer">
                <a class="btn btn-big btn-yellow btn-auto" href="{{ route('advert.order.create') }}">Создать задание</a>
                <a class="phone" href="tel:+{{ sanitize_phone(main_config('phone2', '8 (800) 500-77-00')) }}"><strong>{{ main_config('phone2', '8 (800) 500-77-00') }}</strong></a>
            </div>
        </div>
        <div class="burger-menu-mask"></div>
    </div>
</header>
<main style="@yield('main_styles')" class="@yield('main_class')" id="app">
    @yield('main_header')

    <div class="@yield('app_class', 'container')">
        @include('layouts.partials.flash')
        @yield('content')

        <div id="213123"></div>
        {{ csrf_field() }}

        <select-city-component :cities='@json($cities)' current-city="{{ $city }}" />
    </div>

    <div class="burger-menu">
        <div class="burger-menu-inner">
            <button class="burger-menu-close"></button>
            <div class="burger-menu-header">
                @auth
                    <div class="burger-menu-profile">
                        <div class="burger-menu-profile_avatar"><img src="{{ asset(Auth::user()->getAvatar()) }}" alt=""></div>
                        <div class="burger-menu-profile_type"><span>профиль</span><span>{{ Auth::user()->isExecutor() ? 'Исполнителя' : 'Заказчика' }}</span></div>
                    </div>
                @else
                    <a class="brand" href="/"><img src="{{ asset('images/logo-white.svg') }}" alt=""></a>
                @endauth
            </div>

            <div class="burger-menu-body">
                <a class="city-select-btn" href="javascript:;" data-fancybox data-src="#select-city-modal">
                    <svg class="place-icon">
                        <use xlink:href="{{ asset('images/sprite-inline.svg#place-icon') }}"></use>
                    </svg>
                    <span>Ваш город: </span>
                    <span class="city-current">{{ $city }}</span>
                    <div class="triangle"></div>
                </a>

                <ul class="burger-menu-list">
                    <li><a class="burger-menu-list-link" href="{{ about_path() }}">О сервисе</a></li>
                    <li><a class="burger-menu-list-link" href="{{ route('companies.index') }}">Строительные компании</a></li>
                    <li><a class="burger-menu-list-link" href="{{ route('blog.index') }}">Статьи</a></li>
                    <li><a class="burger-menu-list-link" href="{{ faq_path() }}">FAQ</a></li>
                    <li><a class="burger-menu-list-link" href="{{ contacts_path() }}">Контакты</a></li>
                </ul>
            </div>
            <div class="burger-menu-footer">
                @auth
                    @if(Auth::user()->isExecutor())
                        <a class="btn btn-big btn-yellow btn-auto" href="{{ route('cabinet.services.create') }}">Создать услугу</a>
                    @else
                        <a class="btn btn-big btn-yellow btn-auto" href="{{ route('advert.order.create') }}">Создать задание</a>
                    @endif
                @endauth

                <a class="phone" href="tel:+{{ sanitize_phone(main_config('phone1', '8 (800) 500-77-00')) }}"><strong>{{ main_config('phone1', '8 (800) 500-77-00') }}</strong></a>
            </div>
        </div>
        <div class="burger-menu-mask"></div>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col footer-logo">
                <a class="footer-logo_logo" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-white.svg') }}" alt="">
                    <p>Сервис заказа услуг</p>
                </a>

                <a class="terms-of-use" href="#">Пользовательское соглашение</a>
            </div>

            <div class="col footer-menu">
                <ul class="footer-menu-nav">
                    <li> <a href="{{ about_path() }}">О сервисе</a></li>
                    <li> <a href="{{ route('companies.index') }}">Строительные компании</a></li>
                    <li> <a href="{{ route('blog.index') }}">Статьи</a></li>
                    <li> <a href="{{ faq_path() }}">FAQ</a></li>
                    <li> <a href="{{ contacts_path() }}">Контакты</a></li>

                    @if(userecho_enabled())
                        <li> <a href="{{ route('support') }}">Саппорт</a></li>
                    @endif
                </ul>
            </div>

            <div class="col footer-phone">
                <div class="footer-phone-item">
                    <span>Бесплатный звонок</span>
                    <a href="tel:+{{ sanitize_phone(main_config('phone1', '8 (800) 500-77-00')) }}"><strong>{{ main_config('phone1', '8 (800) 500-77-00') }}</strong></a>
                </div>

                <div class="footer-phone-item">
                    <span>Офис в Москве</span>
                    <a href="tel:+{{ sanitize_phone(main_config('phone1', '8 (800) 500-77-00')) }}"> <strong>{{ main_config('phone1', '8 (800) 500-77-00') }}</strong></a>
                </div>
            </div>
            <div class="col footer-social">
                <div class="footer-social-links">
                    <p>Присоединяйтесь</p>
                    <div class="footer-social-links-cont">
                        <a href="{{ url(main_config('vk_url', '#')) }}" target="_blank"><img src="{{ asset('images/vk-icon.svg') }}" alt=""></a>
                        <a href="{{ url(main_config('ok_url', '#')) }}" target="_blank"><img src="{{ asset('images/odnoklassniki-icon.svg') }}" alt=""></a>
                        <a href="{{ url(main_config('facebook_url', '#')) }}" target="_blank"><img src="{{ asset('images/youtube-icon.svg') }}" alt=""></a>
                    </div>
                </div>
                <div class="footer-copy">
                    <p>© {{ date('Y') }}. Сайт бесплатных объявлений «Adomo™».</p>
                    <p>Все права защищены.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>

@yield('scripts')
</body>
</html>

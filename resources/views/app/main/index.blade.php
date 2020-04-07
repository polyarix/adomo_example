@extends('layouts.frontend')

@section('app_class', '')

@section('title', meta_title_helper(data_get($configs, 'main_meta_title', 'Adomo')))

@section('meta')
    {!! meta_description_renderer(data_get($configs, 'main_meta_description', 'Adomo')) !!}
    {!! meta_keywords_renderer(data_get($configs, 'main_meta_keywords', 'Adomo')) !!}
@endsection

@section('content')
    @if($slides->count() > 0)
        <section>
            <div class="swiper-container" id="main-slider">
                <div class="swiper-wrapper">
                    @foreach($slides as $slide)
                        <div class="swiper-slide" data-swiper-autoplay="{{ $slide->getDelay() }}">
                            <div class="swiper-slide-img">
                                <picture><img src="{{ asset($slide->getPath()) }}" alt=""/></picture>
                            </div>

                            @if($slide->hasUrl())
                                <a href="{{ $slide->url }}" target="_blank">
                            @endif
                                <div class="swiper-slide-inner">
                                    <div class="container">
                                        <div class="swiper-slide-inner-text">{{ $slide->title }}</div>

                                        @if($slide->isButtonsEnabled())
                                            <div class="swiper-slide-inner-buttons">
                                                <a class="btn btn-big btn-yellow" href="{{ Auth::user() && Auth::user()->isExecutor() ? route('cabinet.services.create') : route('advert.order.create') }}">Начать сейчас</a>
                                                <button class="btn btn-big btn-white" @click="showAutoFit">Автоподбор</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @if($slide->hasUrl())
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- screen 2-->
    <section class="section-service-categories">
        <div class="container">
            <h2 class="title">Все категории услуг  </h2>
            <div class="row categories-container">
                @foreach($rootCategories as $category)
                    <div class="category-box-wrapper">
                        <div class="category-box {{ $category->children->count() <= 6 ? 'static' : '' }}">
                            <a class="category-box-head" href="{{ route('category.show', $category) }}">
                                <div class="category-box-head-icon"><img src="{{ $category->getIcon() }}" alt=""/></div>
                                <div class="category-box-head-name">{{ $category->name }}</div>
                            </a>
                            <ul class="category-box-list">
                                @foreach($category->children as $child)
                                    @if($child->isHidden())
                                        @continue
                                    @endif
                                    <li class="category-box-list-item">
                                        <a href="{{ route('category.show', $child) }}">{{ $child->name }}</a>
                                        <span>({{ !Auth::check() || Auth::user()->isCustomer() ? $child->descendants_services_count : $child->orders_count }})</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="category-box-footer">
                                <button class="btn-category-box-toggle">
                                    <svg class="arrow-down-yellow">
                                        <use xlink:href="/images/sprite-inline.svg#arrow-down-yellow"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="auto-selection-container">
            <a class="btn btn-big btn-yellow" href="#" @click="showAutoFit" @close="autoFitDisplayed = false">Автоподбор</a>
        </div>
    </section>
    <!-- screen 3-->
    <section class="free-your-time" style="background-image:url({{ asset(data_get($configs, 'main_1_bg', '/images/section-3-bg.jpg')) }})">
        <div class="container-inner-small">
            <h3 class="title">{{ data_get($configs, 'main_1_title') }}</h3>
            <div class="free-your-time-text">
                <p>{!! implode('<p>', explode("\n", data_get($configs, 'main_1_text'))) !!}</p>
            </div>
            <div class="free-your-time-number">
                <div class="number-item">
                    <div class="number-item-value">{{ data_get($configs, 'main_1_count') }}</div>
                    <div class="number-item-title">Посетителей в день</div>
                </div>
                <div class="number-item">
                    <div class="number-item-value">{{ $successDealsCount }}</div>
                    <div class="number-item-title">Удачных сделок</div>
                </div>
                <div class="number-item">
                    <div class="number-item-value">{{ $reviewsCount }}</div>
                    <div class="number-item-title">Реальных отзывов </div>
                </div>
            </div>
            <div class="free-your-time-buttons">
                <a class="btn btn-big btn-yellow" href="{{ about_path() }}">Подробнее о проекте</a>

                @if(Auth::guest() || (Auth::user() && Auth::user()->isCustomer()))
                    <a class="btn btn-big btn-white" href="{{ route('advert.order.create') }}">Создать задание</a>
                @endif
            </div>
        </div>
    </section>
    <!-- screen 4          -->
    <section class="advantages">
        <div class="container">
            <div class="row advantages-container">
                <div class="advantages-item advantages-item_yellow">
                    <div class="advantages-item-icon"><img src="{{ asset(data_get($configs, 'main_2_1_image', '/images/advantages-icon-1.svg')) }}" alt=""/></div>
                    <div class="advantages-item-title">{{ data_get($configs, 'main_2_1_title', 'Автоподбор мастера') }}</div>
                    <div class="advantages-item-text">{{ data_get($configs, 'main_2_1_text', 'Выбор исполнителя может занять немало времени. ADOMO.ru поможет вам упростить эту задачу, просто воспользуйтесь услугой!') }}</div>
                    <div class="advantages-item-action">
                        <a class="btn btn-big btn-white" @click="showAutoFit" href="#">{{ data_get($configs, 'main_2_1_button', 'Подобрать автоматически') }}</a>
                    </div>
                </div>
                <div class="advantages-item advantages-item_white">
                    <div class="advantages-item-part">
                        <div class="advantages-item-icon"><img src="{{ asset(data_get($configs, 'main_2_2_image', '/images/advantages-icon-2-1.svg')) }}" alt=""/></div>
                        <div class="advantages-item-title">{{ data_get($configs, 'main_2_2_title', 'Онлайн оплата') }}</div>
                        <div class="advantages-item-text">{{ data_get($configs, 'main_2_2_text', 'Дополнительные услуги на сайте ADOMO.ru вы можете оплатить онлайн, быстро и не выходя из дома.') }}</div>
                    </div>
                    <div class="advantages-item-part">
                        <div class="advantages-item-icon"><img src="{{ asset(data_get($configs, 'main_2_3_image', '/images/advantages-icon-2-2.svg')) }}" alt=""/></div>
                        <div class="advantages-item-title">{{ data_get($configs, 'main_2_3_title', 'Честный рейтинг') }}</div>
                        <div class="advantages-item-text">{{ data_get($configs, 'main_2_3_text', 'На нашем сайте можно оставить отзыв или поставить оценку только после выполнения согласованных работ.') }}</div>
                    </div>
                </div>
                <div class="advantages-item advantages-item_yellow">
                    <div class="advantages-item-icon"><img src="{{ asset(data_get($configs, 'main_2_4_image', '/images/advantages-icon-3.svg')) }}" alt=""/></div>
                    <div class="advantages-item-title">{{ data_get($configs, 'main_2_4_title', 'Обратная связь') }}</div>
                    <div class="advantages-item-text">{{ data_get($configs, 'main_2_4_text', 'Благодаря вашей обратной связи, мы постоянно улучшаем наш сервис. Напишите ваши пожелания и мы обязательно их учтем.') }}</div>
                    <div class="advantages-item-action"><a class="btn btn-big btn-white" href="{{ contacts_path() }}">{{ data_get($configs, 'main_2_4_button', 'Предложить улучшение') }}</a></div>
                </div>
            </div>
        </div>
    </section>
    <!-- screen 5          -->
    <section class="technical-supervision" style="background-image:url({{ asset(data_get($configs, 'main_3_bg', '/images/section-5-bg.jpg')) }})">
        <div class="container-inner-small">
            <div class="technical-supervision-row">
                <div class="technical-supervision-left">
                    <div class="title">{{ data_get($configs, 'main_3_title', 'Уникальная услуга “Технадзор”') }}</div>
                    <p>{!! data_get($configs, 'main_3_text', 'На нашем сервисе вы можете воспользоваться услугой ТЕХНАДЗОР. Она предназначена для тех, кто не разбирается в стройке и ремонте или для тех, у кого нет времени контролировать работу. Таким образом, вы можете заказать услуги профессионала, который проконтролирует работу ваших мастеров на разных этапах. Если что-то пойдет не так, то это будет отражено в акте технадзора и вашим мастерам придется исправлять недочеты.') !!}</p>
                </div>
                <div class="technical-supervision-right">
                    <ul class="technical-supervision-list">
                        {!! implode(array_map(function($item) {return "<li> <span>{$item}</span></li>";}, explode("\n", data_get($configs, 'main_3_benefits')))) !!}
                    </ul>
                </div>

                @if(Auth::guest() || (Auth::user() && Auth::user()->isCustomer()))
                    <div class="technical-supervision-bottom"><a class="btn btn-big btn-yellow" href="{{ route('advert.order.create') }}">Заказать услугу </a></div>
                @endif
            </div>
        </div>
    </section>

    <div id="autofit-modal">
        <auto-fit-component :categories='@json($categories)' v-if="autoFitDisplayed" />
    </div>
@endsection

@section('scripts')
    <script>
        var mainSlider = new Swiper('#main-slider', {
            loop:true,
            speed: 500,
            autoplay: {
                delay: 4000,
            },
        });
        $(".btn-category-box-toggle").on("click",function(e){
            var parent = $(this).parent().parent();
            if(parent.hasClass("open")){
                parent.removeClass("open");
            }else{
                $(".category-box").removeClass("open");
                parent.addClass("open");
            }
        });
    </script>
@endsection

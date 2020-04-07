@extends('layouts.frontend')

{{--@section('content')
    <div class="row" style="padding-top: 50px;">
        <div class="col category-body" style="text-align: center; margin: 0 auto">
            <div class="category-body-title" style="text-align: center">Выберите категорию</div>
            <div class="category-box-container">
                @foreach(\App\Entity\Advert\Category::defaultOrder()->visible()->withDepth()->withCount('descendants')->having('depth', '=', 0)->get() as $category)
                    <a class="category-box-item" href="{{ route('category.show', $category) }}">
                        <div class="category-box-item-icon"><img src="{{ asset('images/wrench-icon.svg') }}" alt=""></div>
                        <div class="category-box-item-value">{{ $category->descendants_count }}</div>
                        <div class="category-box-item-name">{{ $category->name }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection--}}

@section('app_class', '')

@section('content')
    <section>
        <div class="swiper-container" id="main-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <picture><img src="./images/slides/slide-1.jpg" alt=""/></picture>
                    </div>
                    <div class="swiper-slide-inner">
                        <div class="container">
                            <div class="swiper-slide-inner-text">ADOMO.ru – крупнейшая онлайн биржа строительно-ремонтных и бытовых услуг в г.Улан-Удэ с расширенным функционалом</div>
                            <div class="swiper-slide-inner-buttons">
                                <button class="btn btn-big btn-yellow">Начать сейчас</button>
                                <button class="btn btn-big btn-white">Автоподбор</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <picture><img src="./images/slides/slide-2.jpg" alt=""/></picture>
                    </div>
                    <div class="swiper-slide-inner">
                        <div class="container">
                            <div class="swiper-slide-inner-text">Мастера на сервисе АДОМО проходят тщательную проверку предоставленной ими информации при регистрации (в том числе, проверка по наличию/отсутствию судимости)</div>
                            <div class="swiper-slide-inner-buttons">
                                <button class="btn btn-big btn-yellow">Начать сейчас</button>
                                <button class="btn btn-big btn-white">Автоподбор</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <picture><img src="./images/slides/slide-3.jpg" alt=""/></picture>
                    </div>
                    <div class="swiper-slide-inner">
                        <div class="container">
                            <div class="swiper-slide-inner-text">Здесь заказчик всегда найдет исполнителя, а исполнитель всегда найдет заказ</div>
                            <div class="swiper-slide-inner-buttons">
                                <button class="btn btn-big btn-yellow">Начать сейчас</button>
                                <button class="btn btn-big btn-white">Автоподбор</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <picture><img src="./images/slides/slide-4.jpg" alt=""/></picture>
                    </div>
                    <div class="swiper-slide-inner">
                        <div class="container">
                            <div class="swiper-slide-inner-text">На сервисе ADOMO.ru собрались мастера по стройке и ремонту, а также мастера по оказанию бытовых услуг</div>
                            <div class="swiper-slide-inner-buttons">
                                <button class="btn btn-big btn-yellow">Начать сейчас</button>
                                <button class="btn btn-big btn-white">Автоподбор</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <picture><img src="./images/slides/slide-5.jpg" alt=""/></picture>
                    </div>
                    <div class="swiper-slide-inner">
                        <div class="container">
                            <div class="swiper-slide-inner-text">Найти мастера или бригаду за один день – это легко! Воспользуйтесь сервисом ADOMO.ru</div>
                            <div class="swiper-slide-inner-buttons">
                                <button class="btn btn-big btn-yellow">Начать сейчас</button>
                                <button class="btn btn-big btn-white">Автоподбор</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <picture><img src="./images/slides/slide-6.jpg" alt=""/></picture>
                    </div>
                    <div class="swiper-slide-inner">
                        <div class="container">
                            <div class="swiper-slide-inner-text">Не можете проконтролировать работу мастера и оценить результат работы – воспользуйтесь услугой - тех.надзор</div>
                            <div class="swiper-slide-inner-buttons">
                                <button class="btn btn-big btn-yellow">Начать сейчас</button>
                                <button class="btn btn-big btn-white">Автоподбор</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- screen 2-->
    <section class="section-service-categories">
        <div class="container">
            <h2 class="title">Все категории услуг  </h2>
            <div class="row categories-container">
                <div class="category-box-wrapper">
                    <div class="category-box"><a class="category-box-head" href="#">
                            <div class="category-box-head-icon"><img src="./images/tools-2.svg" alt=""/></div>
                            <div class="category-box-head-name">Клининговые услуги</div></a>
                        <ul class="category-box-list">
                            <li class="category-box-list-item"><a href="#">Уборка квартир</a><span>(566)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Генеральная уборка</a><span>(62)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Уборка после ремонта</a><span>(962)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Уборка офисов</a><span>(389)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Мойка окон</a><span>(544)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Химчистка</a><span>(105)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Уборка ресторанов</a><span>(388)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Дезинсекция</a><span>(637)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Уборка коттеджей и домов</a><span>(896)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Эко-уборка</a><span>(899)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Уборка магазинов</a><span>(233)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Уборка прилегающих территорий</a><span>(906)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Дезинфекция помещений</a><span>(602)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Мойка фасадов</a><span>(819)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Дератизация</a><span>(913)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Уборка после потопов и пожаров</a><span>(872)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Уборка производственных помещений</a><span>(543)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Другая уборка</a><span>(199)</span>
                            </li>
                        </ul>
                        <div class="category-box-footer">
                            <button class="btn-category-box-toggle">
                                <svg class="arrow-down-yellow">
                                    <use xlink:href="./images/sprite-inline.svg#arrow-down-yellow"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="category-box-wrapper">
                    <div class="category-box"><a class="category-box-head" href="#">
                            <div class="category-box-head-icon"><img src="./images/tools-2.svg" alt=""/></div>
                            <div class="category-box-head-name">Отделочные работы</div></a>
                        <ul class="category-box-list">
                            <li class="category-box-list-item"><a href="#">Ремонт квартир</a><span>(899)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Укладка плитки</a><span>(419)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Штукатурные работы</a><span>(515)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Монтаж гипсокартона</a><span>(452)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Малярные работы</a><span>(407)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Поклейка обоев</a><span>(924)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Напольные работы</a><span>(935)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и ремонт дверей</a><span>(723)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Полировка мрамора</a><span>(866)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и ремонт окон</a><span>(430)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Демонтажные работы</a><span>(593)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Фасадные работы</a><span>(941)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Потолочные работы</a><span>(682)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Работа со стеклом</a><span>(89)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Звукоизоляция</a><span>(246)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Монтаж вагонки</a><span>(116)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Другие ремонтные работы</a><span>(78)</span>
                            </li>
                        </ul>
                        <div class="category-box-footer">
                            <button class="btn-category-box-toggle">
                                <svg class="arrow-down-yellow">
                                    <use xlink:href="./images/sprite-inline.svg#arrow-down-yellow"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="category-box-wrapper">
                    <div class="category-box"><a class="category-box-head" href="#">
                            <div class="category-box-head-icon"><img src="./images/tools-2.svg" alt=""/></div>
                            <div class="category-box-head-name">Работа в Интернете</div></a>
                        <ul class="category-box-list">
                            <li class="category-box-list-item"><a href="#">Копирайтинг</a><span>(378)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Сбор, поиск информации</a><span>(807)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Наполнение сайтов</a><span>(470)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Набор текста</a><span>(452)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Рерайтинг</a><span>(845)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Ввод данных</a><span>(534)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Расшифровка интервью</a><span>(781)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Создание презентаций</a><span>(512)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Другая онлайн работа</a><span>(564)</span>
                            </li>
                        </ul>
                        <div class="category-box-footer">
                            <button class="btn-category-box-toggle">
                                <svg class="arrow-down-yellow">
                                    <use xlink:href="./images/sprite-inline.svg#arrow-down-yellow"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="category-box-wrapper">
                    <div class="category-box static"><a class="category-box-head" href="#">
                            <div class="category-box-head-icon"><img src="./images/tools-2.svg" alt=""/></div>
                            <div class="category-box-head-name">Мелкие бытовые услуги</div></a>
                        <ul class="category-box-list">
                            <li class="category-box-list-item"><a href="#">Сантехник</a><span>(252)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Электрик</a><span>(460)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Муж на час</a><span>(257)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Столяр</a><span>(157)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Слесарь</a><span>(736)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка бытовой техники</a><span>(303)</span>
                            </li>
                        </ul>
                        <div class="category-box-footer">
                            <button class="btn-category-box-toggle">
                                <svg class="arrow-down-yellow">
                                    <use xlink:href="./images/sprite-inline.svg#arrow-down-yellow"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="category-box-wrapper">
                    <div class="category-box"><a class="category-box-head" href="#">
                            <div class="category-box-head-icon"><img src="./images/tools-2.svg" alt=""/></div>
                            <div class="category-box-head-name">Логистические и складские услуги</div></a>
                        <ul class="category-box-list">
                            <li class="category-box-list-item"><a href="#">Грузоперевозки</a><span>(411)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Услуги грузчиков</a><span>(778)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Вывоз строительного мусора</a><span>(234)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Перевозка мебели и техники</a><span>(724)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Переезд квартиры или офиса</a><span>(768)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Услуги такси</a><span>(802)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Трезвый водитель</a><span>(547)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Пассажирские перевозки</a><span>(459)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Междугородняя перевозка</a><span>(589)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Упаковка и сортировка</a><span>(658)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Услуги склада</a><span>(856)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Международная перевозка</a><span>(436)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Вывоз снега</a><span>(308)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Таможенное оформление</a><span>(194)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Услуги экспедитора</a><span>(161)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Другие логистические и складские услуги</a><span>(952)</span>
                            </li>
                        </ul>
                        <div class="category-box-footer">
                            <button class="btn-category-box-toggle">
                                <svg class="arrow-down-yellow">
                                    <use xlink:href="./images/sprite-inline.svg#arrow-down-yellow"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="category-box-wrapper">
                    <div class="category-box"><a class="category-box-head" href="#">
                            <div class="category-box-head-icon"><img src="./images/tools-2.svg" alt=""/></div>
                            <div class="category-box-head-name">Сантехнические работы</div></a>
                        <ul class="category-box-list">
                            <li class="category-box-list-item"><a href="#">Устранение течи</a><span>(142)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и ремонт унитазов</a><span>(176)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Прочистка канализации</a><span>(831)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и ремонт смесителя</a><span>(609)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и ремонт крана</a><span>(817)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Монтаж и ремонт водопровода</a><span>(482)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и ремонт душевой кабины</a><span>(787)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и замена радиаторов</a><span>(662)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Монтаж отопления</a><span>(670)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Реставрация ванн</a><span>(425)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и замена фильтров для воды</a><span>(232)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и замена сифона</a><span>(90)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и ремонт раковины</a><span>(197)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Монтаж канализации</a><span>(490)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и замена полотенцесушителя</a><span>(399)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Врезка и установка мойки</a><span>(434)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка и замена счетчиков воды</a><span>(467)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка ванны</a><span>(850)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Другие услуги сантехника</a><span>(981)</span>
                            </li>
                        </ul>
                        <div class="category-box-footer">
                            <button class="btn-category-box-toggle">
                                <svg class="arrow-down-yellow">
                                    <use xlink:href="./images/sprite-inline.svg#arrow-down-yellow"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="category-box-wrapper">
                    <div class="category-box"><a class="category-box-head" href="#">
                            <div class="category-box-head-icon"><img src="./images/tools-2.svg" alt=""/></div>
                            <div class="category-box-head-name">Строительные работы</div></a>
                        <ul class="category-box-list">
                            <li class="category-box-list-item"><a href="#">Разнорабочие</a><span>(876)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Сварочные работы</a><span>(988)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Токарные работы</a><span>(68)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Плотник</a><span>(572)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Кладка кирпича</a><span>(426)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Установка заборов и ворот</a><span>(994)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Кровельные работы</a><span>(586)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Бетонные работы</a><span>(362)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Буровые работы</a><span>(235)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Фундаментные работы</a><span>(847)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Строительство домов</a><span>(867)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Гидроизоляция</a><span>(692)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Строительство мелких конструкций</a><span>(574)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Ландшафтные работы</a><span>(314)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Архитектура и проектирование</a><span>(769)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Составление смет</a><span>(744)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Земляные работы</a><span>(215)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Монтаж вентиляции</a><span>(843)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Промышленный альпинизм</a><span>(877)</span>
                            </li>
                            <li class="category-box-list-item"><a href="#">Другие стройработы</a><span>(649)</span>
                            </li>
                        </ul>
                        <div class="category-box-footer">
                            <button class="btn-category-box-toggle">
                                <svg class="arrow-down-yellow">
                                    <use xlink:href="./images/sprite-inline.svg#arrow-down-yellow"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="auto-selection-container"><a class="btn btn-big btn-yellow" href="#">Автоподбор</a></div>
    </section>
    <!-- screen 3-->
    <section class="free-your-time" style="background-image:url(./images/section-3-bg.jpg)">
        <div class="container-inner-small">
            <h3 class="title">Мы освободим вам время в поиске строительных услуг</h3>
            <div class="free-your-time-text">
                <p>Вам нужно сделать натяжной потолок, поставить межкомнатные двери или сделать ремонт квартиры под ключ? На ADOMO.ru найдутся мастера для выполнения любой задачи!</p>
                <p>Регистрируйтесь на сайте ADOMO.ru и все мастера станут доступны онлайн. Смотрите портфолио, читайте отзывы, выбирайте мастера и договаривайтесь о цене не выходя из дома!</p>
                <p>ADOMO.ru – первая и единственная строительно-ремонтная и бытовая онлайн биржа с представленным функционалом в Улан-Удэ! С такими возможностями вы сэкономите массу времени и нервов.</p>
            </div>
            <div class="free-your-time-number">
                <div class="number-item">
                    <div class="number-item-value">1234567</div>
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
            <div class="free-your-time-buttons"><a class="btn btn-big btn-yellow" href="{{ about_path() }}">Подробнее о проекте</a><a class="btn btn-big btn-white" href="#">Создать задание</a></div>
        </div>
    </section>
    <!-- screen 4          -->
    <section class="advantages">
        <div class="container">
            <div class="row advantages-container">
                <div class="advantages-item advantages-item_yellow">
                    <div class="advantages-item-icon"><img src="./images/advantages-icon-1.svg" alt=""/></div>
                    <div class="advantages-item-title">Автоподбор мастера</div>
                    <div class="advantages-item-text">
                        Выбор исполнителя может занять немало времени. ADOMO.ru поможет вам упростить эту задачу, просто воспользуйтесь услугой!</div>
                    <div class="advantages-item-action">  <a class="btn btn-big btn-white" href="#">Подобрать автоматически</a></div>
                </div>
                <div class="advantages-item advantages-item_white">
                    <div class="advantages-item-part">
                        <div class="advantages-item-icon"><img src="./images/advantages-icon-2-1.svg" alt=""/></div>
                        <div class="advantages-item-title">Онлайн оплата</div>
                        <div class="advantages-item-text">Дополнительные услуги на сайте ADOMO.ru вы можете оплатить онлайн, быстро и не выходя из дома.</div>
                    </div>
                    <div class="advantages-item-part">
                        <div class="advantages-item-icon"><img src="./images/advantages-icon-2-2.svg" alt=""/></div>
                        <div class="advantages-item-title">Честный рейтинг</div>
                        <div class="advantages-item-text">На нашем сайте можно оставить отзыв или поставить оценку только после выполнения согласованных работ.</div>
                    </div>
                </div>
                <div class="advantages-item advantages-item_yellow">
                    <div class="advantages-item-icon"><img src="./images/advantages-icon-3.svg" alt=""/></div>
                    <div class="advantages-item-title">Обратная связь</div>
                    <div class="advantages-item-text">
                        Благодаря вашей обратной связи, мы постоянно улучшаем наш сервис. Напишите ваши пожелания и мы обязательно их учтем.</div>
                    <div class="advantages-item-action">  <a class="btn btn-big btn-white" href="#">Предложить улучшение</a></div>
                </div>
            </div>
        </div>
    </section>
    <!-- screen 5          -->
    <section class="technical-supervision" style="background-image:url(./images/section-5-bg.jpg)">
        <div class="container-inner-small">
            <div class="technical-supervision-row">
                <div class="technical-supervision-left">
                    <div class="title">Уникальная услуга “Технадзор” </div>
                    <p>На нашем сервисе вы можете воспользоваться услугой ТЕХНАДЗОР. Она предназначена для тех, кто не разбирается в стройке и ремонте или для тех, у кого нет времени контролировать работу. Таким образом, вы можете заказать услуги профессионала, который проконтролирует работу ваших мастеров на разных этапах. Если что-то пойдет не так, то это будет отражено в акте технадзора и вашим мастерам придется исправлять недочеты.</p>
                </div>
                <div class="technical-supervision-right">
                    <ul class="technical-supervision-list">
                        <li> <span>Качественное выполнение работ</span></li>
                        <li> <span>Честная стоимость материалов</span></li>
                        <li> <span>Экономия вашего времени</span></li>
                        <li> <span>Официальная документация</span></li>
                    </ul>
                </div>
                <div class="technical-supervision-bottom"><a class="btn btn-big btn-yellow" href="#">Заказать услугу </a></div>
            </div>
        </div>
    </section>
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
        $(".category-box").focusout(function(){
            $(".category-box").removeClass("open");
        });
    </script>
@endsection

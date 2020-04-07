<?php
    /** @var $entry \App\Entity\User\AdminUser */
?>

@if($entry->isExecutor())
<div style="width: 600px">
    <table>
        {{--styles for td, tr in public/vendor/backpack/crud/css/show.css --}}
        <tr>
            <td>Активных:</td>
            <td>Выполнено:</td>
            <td>В работе:</td>
            <td>На модерации:</td>
            <td>Завершено:</td>
            <td>Отклонено:</td>
            <td>Истекло:</td>
            <td>Закрыто:</td>
            <td>Спам:</td>
        </tr>
        <tr>
            <td>{{ $entry->getExecutorsActiveOrdersCount() }}</td>
            <td>{{ $entry->getExecutorsCompletedOrdersCount() }}</td>
            <td>{{ $entry->getExecutorsWorkingOrdersCount() }}</td>
            <td>{{ $entry->getExecutorsModerationOrdersCount() }}</td>
            <td>{{ $entry->getExecutorsFinishedOrdersCount() }}</td>
            <td>{{ $entry->getExecutorsRejectedOrdersCount() }}</td>
            <td>{{ $entry->getExecutorsExpiredOrdersCount() }}</td>
            <td>{{ $entry->getExecutorsClosedOrdersCount() }}</td>
            <td>{{ $entry->getExecutorsSpamOrdersCount() }}</td>
        </tr>
    </table>

    <p style="margin:10px 0;">Количество откликов на заказы: {{ $entry->getExecutorOrdersCount() }}</p>
    <div>
        <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#multiCollapseExample1"
                aria-expanded="false" aria-controls="multiCollapseExample1"
        >Список заказов:
        </button>
        <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#multiCollapseExample2"
                aria-expanded="false" aria-controls="multiCollapseExample2"
                style="margin: 5px 0;"
        >Список услуг:
        </button>
        <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#multiCollapseExample3"
                aria-expanded="false" aria-controls="multiCollapseExample3">Список категорий:
        </button>
    </div>

    <div class="collapse multi-collapse" id="multiCollapseExample1">
        <h3>Отклики на заказы:</h3>
        @if($entry->performOrders->count())
            @foreach($entry->performOrders as $order)
                <div class="card" style="width: 100%; word-wrap: break-word; background-color: whitesmoke; padding: 5px 10px 0px 10px; margin: 10px 0; border-radius: 0 30px 30px 0;">
                    <div class="card-body">
                        <h6 style="width: max-content; border-radius: 10px; padding: 4px" class="alert-{{ \App\Entity\Advert\Advert\BaseAdvertModel::getStatusClasses()[$order->status] ?? '' }}">
                            {{ \App\Entity\Advert\Advert\BaseAdvertModel::getStatusList()[$order->status] ?? '' }}

                        </h6>
                        <h4 class="card-title"><i class="fa fa-folder-open-o"></i> {{ $order->title }}</h4>
                        <a href="{{ route('crud.orders.show', ['order' => $order->id]) }}" target="_blank" class="btn-sm btn-primary">Перейти к заказу</a>
                    </div>
                    <hr>
                </div>
            @endforeach
        @else
            <h4>Пусто</h4>
        @endif
    </div>

    <div class="collapse multi-collapse" id="multiCollapseExample2">
        <h3>Услуги:</h3>
        @if($entry->services->count())
            @foreach($entry->services as $service)
                <div class="card" style="width: 100%; word-wrap: break-word; background-color: whitesmoke; padding: 5px 10px 0px 10px; margin: 10px 0; border-radius: 0 30px 30px 0;">
                    <div class="card-body">
                        <h6 style="width: max-content; border-radius: 10px; padding: 4px" class="alert-{{ \App\Entity\Advert\Advert\BaseAdvertModel::getStatusClasses()[$service->status] ?? '' }}">
                            {{ \App\Entity\Advert\Advert\BaseAdvertModel::getStatusList()[$service->status] ?? '' }}

                        </h6>
                        <h4 class="card-title"><i class="fa fa-folder-open-o"></i> {{ $service->title }}</h4>
                        <a href="{{ route('crud.services.show', ['service' => $service->id]) }}" target="_blank" class="btn-sm btn-primary">Перейти к услуге</a>
                    </div>
                    <hr>
                </div>
            @endforeach
        @else
            <h4>Пусто</h4>
        @endif
    </div>

    <div class="collapse multi-collapse" id="multiCollapseExample3">
        <h3>Категории:</h3>
        @if($entry->workData && $entry->workData->categories->count())
            @foreach($entry->workData->categories as $category)
                <div class="card" style="width: 100%; word-wrap: break-word; background-color: whitesmoke; padding: 5px 10px 0px 10px; margin: 10px 0; border-radius: 0 30px 30px 0;">
                    <div class="card-body">
                        <h4 class="card-title"><i class="fa fa-tag"></i> {{ $category->name }}</h4>
                        <a href="{{ backpack_url('categories/'.$category->id) }}" target="_blank" class="btn-sm btn-primary">Перейти к категории</a>
                    </div>
                    <hr>
                </div>
            @endforeach
        @else
            <h4>Пусто</h4>
        @endif
    </div>

</div>
@endif
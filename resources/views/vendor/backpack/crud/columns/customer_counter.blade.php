<?php
    /** @var $entry \App\Entity\User\AdminUser */
?>

@if($entry->isCustomer())
<div style="width: 600px">
    <table>
        {{--styles for td, tr in public/vendor/backpack/crud/css/show.css --}}
        <tr>
            <td>Активных:</td>
            <td>Выполнено:</td>
            <td>На модерации:</td>
            <td>Завершено:</td>
            <td>Отклонено:</td>
            <td>Истекло:</td>
            <td>Закрыто:</td>
            <td>Спам:</td>
        </tr>
        <tr>
            <td>{{ $entry->getCustomersActiveOrdersCount() }}</td>
            <td>{{ $entry->getCustomersCompletedOrdersCount() }}</td>
            <td>{{ $entry->getCustomersModerationOrdersCount() }}</td>
            <td>{{ $entry->getCustomersFinishedOrdersCount() }}</td>
            <td>{{ $entry->getCustomersRejectedOrdersCount() }}</td>
            <td>{{ $entry->getCustomersExpiredOrdersCount() }}</td>
            <td>{{ $entry->getCustomersClosedOrdersCount() }}</td>
            <td>{{ $entry->getCustomersSpamOrdersCount() }}</td>
        </tr>
    </table>
    <p style="margin:10px 0;">Количество созданых заказов: {{ $entry->getCustomerOrdersCount() }}</p>
    <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#multiCollapseExample1"
            aria-expanded="false" aria-controls="multiCollapseExample1">Список заказов:
    </button>
    <div class="collapse multi-collapse" id="multiCollapseExample1">
        <h3>Заказы:</h3>
        @if($entry->orders->count())
            @foreach($entry->orders as $order)
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
</div>
@endif
@if($order->isActive())
    <div class="order-status">В ожидании</div>
@endif
@if($order->isWorking())
    <div class="order-status">В работе</div>
@endif
@if($order->isClosed())
    <div class="order-status">Закрыто</div>
@endif
@if($order->isRejected())
    <div class="order-status">{{ $order->isSpam() ? 'Спам' : 'Отклонено' }}</div>
@endif
@if($order->isCompleted() || $order->isFinished())
    <div class="order-status">Завершено</div>
@endif
@if($order->isOnModeration())
    <div class="order-status">На модерации</div>
@endif

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

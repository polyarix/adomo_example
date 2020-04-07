@if ($crud->hasAccess('update'))
    @if($entry->isActive())
        <a href="{{ url($crud->route.'/'.$entry->getKey().'/ban') }}" class="btn btn-xs btn-danger"><i class="fa fa-edit"></i> Забанить</a>

        @if($entry->hasPremium())
            <a href="{{ url($crud->route.'/'.$entry->getKey().'/strip_premium') }}" class="btn btn-xs btn-github"><i class="fa fa-edit"></i> Лишить приемиума</a>
        @endif

        <a href="{{ url($crud->route.'/'.$entry->getKey().'/premium') }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Продлить приемиум</a>
    @endif

    @if($entry->isBanned())
        <form action="{{ url($crud->route.'/'.$entry->getKey().'/unban') }}" method="POST" class="inline">
            @csrf

            <button class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Разбанить</button>
        </form>
    @endif

    @if($entry->isNew())
        <form action="{{ url($crud->route.'/'.$entry->getKey().'/activate') }}" method="POST" class="inline">
            @csrf

            <button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Активировать</button>
        </form>
    @endif
@endif

@isset($entry->status)
    <div data-status="{{ $entry->status }}" style="display: none"></div>
    <div data-documents="{{ $entry->unverified_documents_count }}" style="display: none"></div>
@endisset

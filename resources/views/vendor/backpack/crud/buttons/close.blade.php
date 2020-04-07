@if ($crud->hasAccess('update'))
    @if($entry->isActive())
        <form action="{{ url($crud->route.'/'.$entry->getKey().'/close') }}" method="POST" class="inline">
            @csrf

            <button class="btn btn-xs btn-danger"><i class="fa fa-edit"></i> Закрыть</button>
        </form>
    @endif
    @if($entry->isClosed())
        <form action="{{ url($crud->route.'/'.$entry->getKey().'/open') }}" method="POST" class="inline">
            @csrf

            <button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Опубликовать</button>
        </form>
    @endif
@endif

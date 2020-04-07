@if ($crud->hasAccess('update'))
    @if($entry->isNew())
        <a class="btn btn-xs btn-success" href="{{ url($crud->route.'/'.$entry->getKey().'/respond') }}"><i class="fa fa-edit"></i> Закрыть</a>
    @endif

    @if($entry->isViewed() === false)
        <a class="btn btn-xs btn-warning" href="{{ url($crud->route.'/'.$entry->getKey().'/view') }}"><i class="fa fa-edit"></i> Пометить прочитанным</a>
        <br>
    @endif
@endif

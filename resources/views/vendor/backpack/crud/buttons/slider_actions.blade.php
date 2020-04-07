@if ($crud->hasAccess('update'))
    @if($entry->isHidden())
        <a href="{{ url($crud->route.'/'.$entry->getKey().'/set_visible') }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Отобразить</a>
    @endif

    @if($entry->isVisible())
        <a href="{{ url($crud->route.'/'.$entry->getKey().'/set_hidden') }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Скрыть</a>
    @endif
@endif

@if ($crud->hasAccess('update'))
    @if($entry->isOnModeration())
        <a href="{{ url($crud->route.'/'.$entry->getKey().'/moderate') }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Опубликовать</a>
    @endif
@endif

@if ($crud->hasAccess('update'))
    @if($entry->isOnModeration())
        <a href="{{ url($crud->route.'/'.$entry->getKey().'/reject') }}" class="btn btn-xs btn-danger"><i class="fa fa-edit"></i> Отклонить</a>
    @endif
@endif

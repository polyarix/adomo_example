@if ($crud->hasAccess('update'))
    @if($entry->isOnModeration())
        <form action="{{ url($crud->route.'/'.$entry->getKey().'/moderate') }}" method="POST" class="inline">
            @csrf

            <button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Опубликовать</button>
        </form>
    @endif
@endif

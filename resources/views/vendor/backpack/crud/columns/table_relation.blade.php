@php
	$items = data_get($entry, $column['name']);

	$columns = $column['columns'];

    $routes = isset($column['routes']) && is_array($column['routes']) ? $column['routes'] : [];
@endphp

<span>
	@if ($items && count($columns))
	<table class="table table-bordered table-condensed table-striped m-b-0">
		<thead>
			<tr>
				@foreach($columns as $tableColumnKey => $tableColumnLabel)
				<th>{{ $tableColumnLabel }}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach ($items as $tableRow)
			<tr>
				@foreach($columns as $tableColumnKey => $tableColumnLabel)
					<td>
						@if( is_array($tableRow) && isset($tableRow[$tableColumnKey]) )

                            {{ $tableRow[$tableColumnKey] }}

                        @else
                            @if(array_key_exists($tableColumnKey, $routes))
                                @php
                                    if(is_array($column['routes'][$tableColumnKey])) {
                                        $options = $column['routes'][$tableColumnKey];

                                        $url = route($options['name'], $tableRow->{$options['attribute']});
                                    } else {
                                         $url = route($column['routes'][$tableColumnKey], $tableRow);
                                    }
                                @endphp

                                <a href="{{ $url }}">{{ $tableRow->{$tableColumnKey} }}</a>
                            @else
                                {{ $tableRow->{$tableColumnKey} }}
                            @endif
                        @endif

					</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
	@endif
</span>

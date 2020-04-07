@php
    $value = data_get($entry, $column['name']);
@endphp
<div class="images-grid">
    @if ($value && count($value))
        @foreach ($value as $file_path)
            <img src="{{ asset($file_path->getPath()) }}" class="col-sm-6" style="max-height: 300px;">
        @endforeach
    @else
        -
    @endif
</div>
<style>
    .images-grid {
        column-count: 2;
        column-gap: 5px;
    }
    .images-grid img {
        width: 100% !important;
        height: auto !important;
        margin-bottom: 15px;
    }
</style>

@php
    $items = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? [];
    $relation_name = $field['name'];
@endphp

<div id="serviceTable">
    <service-table-component :all-services="{{ $field['all_services'] }}"
                             :item-name="`{{ $relation_name }}`"
                             :items='@json($items)'>
    </service-table-component>
</div>

@push('crud_fields_scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
@endpush

<!-- html5 date input -->

<?php
// if the column has been cast to Carbon or Date (using attribute casting)
// get the value as a date string
if (isset($field['value']) && ($field['value'] instanceof \Carbon\CarbonInterface)) {
    $field['value'] = $field['value']->toDateString();
}
?>

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <input
        type="text"
        name="{{ $field['name'] }}"
        value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
        @include('crud::inc.field_attributes')
        >
</div>

@push('crud_fields_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/flatpickr/flatpickr.min.css') }}">
@endpush

@push('crud_fields_scripts')
    <script src="{{ asset('vendor/backpack/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('vendor/backpack/flatpickr/ru.js') }}"></script>

    <script>
        $("[name='{{ $field['name'] }}']").flatpickr({
            locale: "ru",
            dateFormat:"d-m-Y"
        });
    </script>
@endpush

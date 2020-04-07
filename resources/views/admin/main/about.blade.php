@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">Настройки страницы "О сервисе"</span>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li><a href="{{ backpack_url('main_page') }}" class="text-capitalize">Контент на странице "О сервисе"</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row m-t-20">
        <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
            <form method="post" action="{{ backpack_url('about_page') }}" enctype="multipart/form-data">
                @csrf

                <div class="col-md-12">
                    <div class="row display-flex-wrap">
                        <div class="tab-container col-xs-12">
                            <div class="nav-tabs-custom" id="form_tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#tab_common" aria-controls="tab_common" role="tab" tab_name="common" data-toggle="tab" class="tab_toggler" aria-expanded="true">Основное</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#tab_seo" aria-controls="tab_seo" role="tab" tab_name="seo" data-toggle="tab" class="tab_toggler" aria-expanded="true">Meta-теги</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content panel col-md-12">
                            <div role="tabpanel" class="tab-pane active" id="tab_common">
                                <div class="form-group col-xs-12 required">
                                    <label>URL адрес</label>
                                    <input type="text" name="slug" value="{{ $slug ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Верхняя надпись</label>
                                    <input type="text" name="about_label" value="{{ $data['about_label'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Заголовок</label>
                                    <input type="text" name="about_title" value="{{ $data['about_title'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Текст</label>
                                    <input type="text" name="about_text" value="{{ $data['about_text'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Фоновая картинка</label>
                                    @if($src = @$data['about_bg'])
                                        Текущая картинка: <img src="{{ asset($src) }}" style="max-height: 100px">
                                    @endif
                                    <input type="file" id="about_bg" name="about_bg" class="form-control">
                                </div>

                                @include('backpack::crud.fields.ckeditor', ['field' => ['name' => 'about_top_text', 'label' => 'Текст над счётчиком', 'type' => 'tinymce', 'value' => $data['about_top_text'] ?? '']])
                                @include('backpack::crud.fields.ckeditor', ['field' => ['name' => 'about_bottom_text', 'label' => 'Текст под счётчиком', 'type' => 'tinymce', 'value' => $data['about_bottom_text'] ?? '']])

                                <div class="form-group col-xs-12 required">
                                    <label>Заголовок нижнего блока</label>
                                    <input type="text" name="about_action_title" value="{{ $data['about_action_title'] ?? '' }}" class="form-control">
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="tab_seo">
                                <div class="form-group col-xs-12 required">
                                    <label>Meta title</label>
                                    <input type="text" name="about_meta_title" value="{{ $data['about_meta_title'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Meta Description</label>
                                    <input type="text" name="about_meta_description" value="{{ $data['about_meta_description'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Meta keywords</label>
                                    <input type="text" name="about_meta_keywords" value="{{ $data['about_meta_keywords'] ?? '' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="current_tab" value="osnovnoe">
                    </div><!-- /.box-body -->
                    <div class="">
                        <div id="saveActions" class="form-group">
                            <input type="hidden" name="save_action" value="save_and_back">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">
                                    <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                    <span data-value="save_and_back">Сохранить и выйти</span>
                                </button>

                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">▼</span>
                                </button>

                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0);" data-value="save_and_edit">Сохранить и продолжить редактирование</a></li>
                                    <li><a href="javascript:void(0);" data-value="save_and_new">Сохранить и создать</a></li>
                                </ul>

                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Отменить</a>
                        </div>

                    </div><!-- /.box-footer-->

                </div><!-- /.box -->
            </form>
        </div>
    </div>
@endsection

@section('after_styles')
    <!-- DATA TABLES -->
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}">

    <!-- CRUD LIST CONTENT - crud_list_styles stack -->
    @stack('crud_list_styles')
@endsection

@section('after_scripts')
    @include('crud::inc.datatables_logic')

    <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/form.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/list.js') }}"></script>

    <script src="{{ asset('vendor/backpack/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/backpack/ckeditor/adapters/jquery.js') }}"></script>

    <script>
        @php $fields = [
            ['name' => 'about_top_text', 'extra_plugins' => ['oembed', 'widget']],
            ['name' => 'about_bottom_text', 'extra_plugins' => ['oembed', 'widget']]
        ]; @endphp

        @foreach($fields as $field)
            jQuery(document).ready(function($) {
                $('#ckeditor-{{ $field['name'] }}').ckeditor({
                    "filebrowserBrowseUrl": "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                    "extraPlugins" : '{{ isset($field['extra_plugins']) ? implode(',', $field['extra_plugins']) : 'oembed,widget' }}'
                    @if (isset($field['options']) && count($field['options']))
                    {!! ', '.trim(json_encode($field['options']), "{}") !!}
                    @endif
                });
            });
        @endforeach
    </script>

    <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
    @stack('crud_list_scripts')
@endsection

{{--FOR SIMPLEMDE--}}
{{--<link rel="stylesheet" href="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <style type="text/css">
        .CodeMirror-fullscreen, .editor-toolbar.fullscreen {
            z-index: 9999 !important;
        }
        .CodeMirror{
            min-height: auto !important;
        }
    </style>

    <script src="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
--}}

{{--
<script>
        @php $simplemdeFields = [['name' => 'test1234']]; @endphp

        @foreach($simplemdeFields as $field)
    var simplemde_{{ $field['name'] }} = new SimpleMDE({
            element: $("#simplemde_{{ $field['name'] }}")[0],

    @if(isset($field['simplemdeAttributes']))
    @foreach($field['simplemdeAttributes'] as $index => $value)
    {{$index}} : @if(is_bool($value)) {{ ($value?'true':'false') }} @else {!! '"'.$value.'"' !!} @endif,
    @endforeach
    @endif
    {!! isset($field['simplemdeAttributesRaw']) ? $field['simplemdeAttributesRaw'] : "" !!}
    });

    simplemde_{{ $field['name'] }}.options.minHeight = simplemde_{{ $field['name'] }}.options.minHeight || "300px";
    simplemde_{{ $field['name'] }}.codemirror.getScrollerElement().style.minHeight = simplemde_{{ $field['name'] }}.options.minHeight;
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        setTimeout(function() { simplemde_{{ $field['name'] }}.codemirror.refresh(); }, 10);
    });
    @endforeach
</script>--}}

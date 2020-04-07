@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">Настройки FAQ</span>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li><a href="{{ backpack_url('main_page') }}" class="text-capitalize">Контент на странице FAQ</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row m-t-20">
        <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
            <form method="post" action="{{ backpack_url('faq_page') }}" enctype="multipart/form-data">
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
                                        <a href="#tab_seo" aria-controls="tab_seo" role="tab" tab_name="seo" data-toggle="tab" aria-expanded="true">Meta-теги</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content panel col-md-12">
                            <div class="tab-content panel col-md-12">
                                <div role="tabpanel" class="tab-pane active" id="tab_common">
                                    <div class="form-group col-xs-12 required">
                                        <label>URL адрес</label>
                                        <input type="text" name="slug" value="{{ $slug ?? '' }}" class="form-control">
                                    </div>

                                    <div class="form-group col-xs-12 required">
                                        <label>Название хлебной крошки</label>
                                        <input type="text" name="faq_breadcrumb" value="{{ $data['faq_breadcrumb'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="form-group col-xs-12 required">
                                        <label>Заголовок</label>
                                        <input type="text" name="faq_title" value="{{ $data['faq_title'] ?? '' }}" class="form-control">
                                    </div>

                                    @include('backpack::crud.fields.ckeditor', ['field' => ['name' => 'faq_text', 'label' => 'Текст', 'type' => 'tinymce', 'value' => $data['faq_text'] ?? '']])
                                </div>

                                <div role="tabpanel" class="tab-pane" id="tab_seo">
                                    <div class="form-group col-xs-12 required">
                                        <label>Meta title</label>
                                        <input type="text" name="faq_meta_title" value="{{ $data['faq_meta_title'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="form-group col-xs-12 required">
                                        <label>Meta Description</label>
                                        <input type="text" name="faq_meta_description" value="{{ $data['faq_meta_description'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="form-group col-xs-12 required">
                                        <label>Meta keywords</label>
                                        <input type="text" name="faq_meta_keywords" value="{{ $data['faq_meta_keywords'] ?? '' }}" class="form-control">
                                    </div>
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
            ['name' => 'faq_text', 'extra_plugins' => ['oembed', 'widget']],
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

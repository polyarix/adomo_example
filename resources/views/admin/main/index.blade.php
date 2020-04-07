@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">Настройки главной страницы</span>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li><a href="{{ backpack_url('main_page') }}" class="text-capitalize">Контент на главной</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row m-t-20">
        <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
            <form method="post" action="{{ backpack_url('main_page') }}" enctype="multipart/form-data">
                @csrf

                <div class="col-md-12">
                    <div class="row display-flex-wrap">
                        <div class="tab-container col-xs-12">
                            <div class="nav-tabs-custom" id="form_tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#tab_section1" aria-controls="tab_section1" role="tab" tab_name="section1" data-toggle="tab" class="tab_toggler" aria-expanded="true">Секция 1</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#tab_section2" aria-controls="tab_section2" role="tab" tab_name="section2" data-toggle="tab" class="tab_toggler" aria-expanded="true">Секция 2</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#tab_section3" aria-controls="tab_section3" role="tab" tab_name="section3" data-toggle="tab" class="tab_toggler" aria-expanded="true">Секция 3</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#tab_seo" aria-controls="tab_seo" role="tab" tab_name="seo" data-toggle="tab" class="tab_toggler" aria-expanded="true">Meta-теги</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content panel col-md-12">
                            <div role="tabpanel" class="tab-pane active" id="tab_section1">
                                <div class="form-group col-xs-12 required">
                                    <label>Заголовок</label>
                                    <input type="text" name="main_1_title" value="{{ $data['main_1_title'] ?? '' }}" class="form-control">
                                </div>

                                @include('backpack::crud.fields.ckeditor', ['field' => ['name' => 'main_1_text', 'label' => 'Текст', 'type' => 'tinymce', 'value' => $data['main_1_text'] ?? '']])

                                <div class="form-group col-xs-12 required">
                                    <label>Счётчик посетителей в день</label>
                                    <input type="text" name="main_1_count" value="{{ $data['main_1_count'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Фоновая картинка</label>
                                    @if($src = $data['main_1_bg'])
                                        Текущая картинка: <img src="{{ asset($src) }}" style="max-height: 100px">
                                    @endif
                                    <input type="file" id="icon_block1" name="main_1_bg" class="form-control">
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="tab_section2">
                                <div class="form-group col-xs-12 required">
                                    <label>Заголовок блока 1</label>
                                    <input type="text" name="main_2_1_title" value="{{ $data['main_2_1_title'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Текст блока 1</label>
                                    <textarea name="main_2_1_button" class="form-control">{{ $data['main_2_1_text'] ?? '' }}</textarea>
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Текст кнопки 1</label>
                                    <input type="text" name="main_2_1_button" value="{{ $data['main_2_1_button'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Иконка блока 1</label>
                                    @if($src = $data['main_2_1_image'])
                                        <div>Текущая картинка: <img src="{{ asset($src) }}" style="max-height: 100px"></div>
                                    @endif
                                    <input type="file" id="icon_block1" name="main_2_1_image" value="{{ $data['main_2_1_image'] ?? '' }}" class="form-control">
                                </div>

                                <hr style="width: 100%; color: black; height: 1px; background-color:black; opacity: .1" />

                                {{-- Услуга 2 --}}
                                <div class="form-group col-xs-12 required">
                                    <label>Заголовок блока 2</label>
                                    <input type="text" name="main_2_2_title" value="{{ $data['main_2_2_title'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Текст блока 2</label>
                                    <textarea name="main_2_2_text" class="form-control">{{ $data['main_2_2_text'] ?? '' }}</textarea>
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Иконка услуги 2</label>

                                    @if($src = $data['main_2_2_image'])
                                        <div>Текущая картинка: <img src="{{ asset($src) }}" style="max-height: 100px"></div>
                                    @endif

                                    <input type="file" id="icon_block1" name="main_2_2_image" value="" class="form-control">
                                </div>

                                <hr style="width: 100%; color: black; height: 1px; background-color:black; opacity: .1" />

                                {{--Секция 2, блок 2--}}
                                <div class="form-group col-xs-12 required">
                                    <label>Заголовок блока 3</label>
                                    <input type="text" name="main_2_3_title" value="{{ $data['main_2_3_title'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Текст блока 3</label>
                                    <textarea name="main_2_3_text" class="form-control">{{ $data['main_2_3_text'] ?? '' }}</textarea>
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Иконка услуги 3</label>

                                    @if($src = $data['main_2_3_image'])
                                        <div>Текущая картинка: <img src="{{ asset($src) }}" style="max-height: 100px"></div>
                                    @endif

                                    <input type="file" id="icon_block1" name="main_2_3_image" class="form-control">
                                </div>

                                <hr style="width: 100%; color: black; height: 1px; background-color:black; opacity: .1" />

                                {{--Секция 3--}}
                                <div class="form-group col-xs-12 required">
                                    <label>Заголовок блока 4</label>
                                    <input type="text" name="main_2_4_title" value="{{ $data['main_2_4_title'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Текст блока 4</label>
                                    <textarea name="main_2_4_text" class="form-control">{{ $data['main_2_4_text'] ?? '' }}</textarea>
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Текст кнопки 4</label>
                                    <input type="text" name="main_2_4_button" value="{{ $data['main_2_4_button'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Иконка блока 4</label>

                                    @if($src = $data['main_2_4_image'])
                                        <div>Текущая картинка: <img src="{{ asset($src) }}" style="max-height: 100px"></div>
                                    @endif
                                    <input type="file" id="icon_block1" name="main_2_4_image" class="form-control">
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="tab_section3">
                                <div class="form-group col-xs-12 required">
                                    <label>Заголовок</label>
                                    <input type="text" name="main_3_title" value="{{ $data['main_3_title'] ?? '' }}" class="form-control">
                                </div>

                                @include('backpack::crud.fields.ckeditor', ['field' => ['name' => 'main_3_text', 'label' => 'Текст', 'type' => 'tinymce', 'value' => nl2br($data['main_3_text'] ?? '')]])

                                <div class="form-group col-xs-12 required">
                                    <label>Список преимуществ</label>
                                    <textarea name="main_3_benefits" rows="5" class="form-control">{{ $data['main_3_benefits'] ?? '' }}</textarea>
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Фоновая картинка</label>
                                    @if($src = $data['main_3_bg'])
                                        <div>Текущая картинка: <img src="{{ asset($src) }}" style="max-height: 100px"></div>
                                    @endif
                                    <input type="file" id="icon_block1" name="main_3_bg" class="form-control">
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="tab_seo">
                                <div class="form-group col-xs-12 required">
                                    <label>Meta title</label>
                                    <input type="text" name="main_meta_title" value="{{ $data['main_meta_title'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Meta Description</label>
                                    <input type="text" name="main_meta_description" value="{{ $data['main_meta_description'] ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group col-xs-12 required">
                                    <label>Meta keywords</label>
                                    <input type="text" name="main_meta_keywords" value="{{ $data['main_meta_keywords'] ?? '' }}" class="form-control">
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

                            <a href="{{ backpack_url('blog/categories') }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Отменить</a>
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
            ['name' => 'main_1_text', 'extra_plugins' => ['oembed', 'widget']],
            ['name' => 'main_3_text', 'extra_plugins' => ['oembed', 'widget']]
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

@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
      </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>

        <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>

        <li><a href="{{ backpack_url("contact_requests/{$entry->id}") }}" class="text-capitalize">#{{ $entry->id }}</a></li>
	    <li class="active">Ответ на обращение</li>
	  </ol>
	</section>
@endsection

@section('content')
@if ($crud->hasAccess('list'))
	<a href="{{ url($crud->route) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a>
@endif
<div class="row">
	<div class="{{ $crud->getShowContentClass() }}">

	<!-- Default box -->
	  <div class="m-t-20">
	    <div class="box no-padding no-border">
			<div class="card p-4" style="padding: 15px">
                <div class="card-header">
                    <h3>Ответ на обращение пользователя #{{ $entry->id }}</h3>
                </div>
                <div class="card-body">
                    @if($errors->count() > 0)
                        <div class="callout callout-danger">
                            <h4>Please fix the following errors:</h4>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('crud.contact_requests.respond', $entry->id) }}" method="POST">
                        @csrf
                        <div class="form-group col-xs-12 @error('reason') has-error @enderror">
                            <label for="response_text">Сообщение</label>
                            <textarea name="response_text" class="form-control" id="response_text" cols="4" rows="4">{{ old('response_text') }}</textarea>

                            @error('response_text')
                                <div class="help-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="submit" class="btn btn-success pull-right" value="Отправить">
                    </form>
                </div>
            </div>
            <div class="clearfix" style="padding-bottom: 20px;"></div>
	    </div>
	  </div>
	</div>
</div>
@endsection

@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
	<script src="{{ asset('vendor/backpack/crud/js/show.js') }}"></script>

    <script>
        var iso = (new Date()).toISOString();
        $('#to').prop('min', iso.substring(0, iso.length-5));
    </script>
@endsection

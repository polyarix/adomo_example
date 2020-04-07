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

        <li><a href="{{ route('crud.users.show', $entry->id) }}" class="text-capitalize">#{{ $entry->id }}</a></li>
	    <li class="active">Ban</li>
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
                    <h3>Бан пользователя: {{ $entry->email ? "\"{$entry->email}\"" : '' }} #{{ $entry->id }}</h3>
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

                    <form action="{{ route('crud.users.ban', $entry->id) }}" method="POST">
                        @csrf
                        <div class="form-group col-xs-12 @error('to') has-error @enderror">
                            <label for="to">Забанить до</label>
                            <input type="date" class="form-control" name="to" id="to" value="{{ old('to') }}">

                            @error('to')
                                <div class="help-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>


                        <div class="form-group col-xs-12 @error('reason') has-error @enderror">
                            <label for="reason">Причина бана</label>
                            <textarea name="reason" class="form-control" id="reason" cols="4" rows="4">{{ old('reason') }}</textarea>

                            @error('reason')
                                <div class="help-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="submit" class="btn btn-danger" value="Забанить">
                    </form>
                </div>
            </div>
	    </div><!-- /.box-body -->
	  </div><!-- /.box -->
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

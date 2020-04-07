@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
      </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>

        @php $parents = $entry->category->ancestors()->orderBy('lft')->get(); @endphp
        @foreach($parents as $parent)
          <li><a href="{{ route('crud.categories.show', $parent->id) }}" class="text-capitalize">{{ $parent->name }}</a></li>
        @endforeach

        <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>

        <li><a href="{{ route('crud.orders.show', $entry->id) }}" class="text-capitalize">{{ $entry->title }}</a></li>
	    <li class="active">Rejecting</li>
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
                    <h3>Отклонение заказа: "{{ $entry->title }}"</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('crud.orders.reject', $entry->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="status">Статус</label>
                            <select name="status" id="status" class="form-control">
                                @foreach($options as $value => $option)
                                    <option value="{{ $value }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="reason">Причина отклонения</label>
                            <textarea name="reason" class="form-control" id="reason" cols="4" rows="4"></textarea>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Отклонить">
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
@endsection

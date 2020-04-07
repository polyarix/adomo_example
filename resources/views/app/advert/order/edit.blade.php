@extends('layouts.frontend')

@section('body_class', 'task-page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endsection

@section('meta')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@%5E0.3.0/dist/vue-treeselect.css">
@endsection

@section('content')
    <div class="row">
        <div class="col task-page-body">
            <edit-order-component :order='@json($order)' :categories='@json($categories)' :cities='@json($cities)' />
        </div>
    </div>
@endsection

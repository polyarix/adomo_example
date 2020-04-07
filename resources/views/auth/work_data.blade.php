@extends('layouts.frontend')

@section('content')
    <profile-work-data-form :user='@json($user)' :work-data='@json($workData)' :cities='@json($cities)' />
@endsection

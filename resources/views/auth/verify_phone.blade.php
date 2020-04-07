@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endsection

@section('content')
    <profile-details-form
        :user='@json($user)'
        :cities='@json($cities)'
        avatar-upload-url="{{ route('api.user.sign-up.avatar_upload') }}"
    />
@endsection

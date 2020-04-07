@extends('layouts.frontend')

@section('body_class', 'login-page')

@section('content')
    <reset-password-change token="{{ $token }}" email="{{ $email }}" />
@endsection

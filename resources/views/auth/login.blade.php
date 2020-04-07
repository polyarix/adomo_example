@extends('layouts.frontend')

@section('body_class', 'login-page')
@section('main_styles', 'background-image:url(' . asset('images/reg-bg.jpg') . ');')

@section('content')
    <login-component
        facebook-url="{{ route('login.network', ['network' => 'facebook', 'type' => '']) }}"
        vk-url="{{ route('login.network', ['network' => 'vkontakte', 'type' => '']) }}"
        odnoklassniki-url="{{ route('login.network', ['network' => 'odnoklassniki', 'type' => '']) }}"
    />
@endsection

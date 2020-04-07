@extends('layouts.frontend')

@section('body_class', 'login-page')
@section('main_styles', 'background-image:url(' . asset('images/reg-bg.jpg') . ');')

@section('content')
    <signup-component
        facebook-url="{{ route('login.network', ['network' => 'facebook', 'type' => $type]) }}"
        vk-url="{{ route('login.network', ['network' => 'vkontakte', 'type' => $type]) }}"
        odnoklassniki-url="{{ route('login.network', ['network' => 'odnoklassniki', 'type' => $type]) }}"
    />
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            //$('input#phone').mask('+7 (99) 999-99-99')
            $('input#phone').mask('+38(099)999-9999')
        });
    </script>
@endsection

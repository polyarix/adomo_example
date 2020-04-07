@extends('layouts.frontend')

@section('content')
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif

    <email-verification user-mail="{{ $user->email }}" :user='@json($user)' />
@endsection

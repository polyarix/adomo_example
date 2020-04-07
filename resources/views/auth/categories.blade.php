@extends('layouts.frontend')

@section('content')
    <profile-categories-form
        :user='@json($user)'
        :categories='@json($workCategories)'
        :categories-list='@json($categories)'
        :categories-limit="{{ $user->hasPremium() ? -1 : 2 }}"
    />
@endsection

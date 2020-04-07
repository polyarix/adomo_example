@extends('layouts.frontend')

@section('content')
    <div class="row registration-part">
        @include('app.users.cabinet._navbar', ['page' => ''])

        <div class="col questionnaire-outer">
            <div class="questionnaire">
                <div class="questionnaire-heading">Профиль</div>
                <div class="questionnaire-subtitle">
                    <h2>{{ Auth::user()->getName() }} <small class="btn btn-small btn-yellow" style="float: right">{{ Auth::user()->getType() }}</small></h2>

                    <a href="{{ route('user.details', Auth::user()) }}">Профиль</a>
                </div>
            </div>

        </div>
    </div>
@endsection

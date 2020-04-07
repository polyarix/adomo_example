@extends('emails.layouts.main')

@section('title', 'Новый запрос из контактной формы')

@section('content')
    <table class="body-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#F2F2F2;padding-top:17px;padding-bottom:17px;padding-right:30px;padding-left:30px;">
        <tbody><tr>
            <td style="padding-bottom:20px;">
                <h1 style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-size:24px;font-weight:normal;color:#000000;">Новый запрос из контактной формы</h1>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;">
                <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">От пользователь <b>{{ $contact->name }}</b></p>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;">
                <table class="info-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#fff;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;border-radius:6px;">
                    <tbody><tr>
                        <td style="width:100px;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" colspan="4">
                            @if($phone = $contact->phone) <p>Телефон: {{ $contact->phone }}</p> @endif
                            @if($email = $contact->email)
                                <p>Email: {{ $email }}</p>
                            @endif

                            <p style="color:#000000;font-style:normal;font-weight:normal;font-size:14px;line-height:19px;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">
                                Тип: <b>{{ $contact->isOffer() ? 'Предложение' : 'Вопрос' }}</b>
                            </p>
                            <br>
                            <h2 style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-weight:inherit;font-size:18px;line-height:21px;color:#323232;">С текстом: {{ $contact->text }}</h2>
                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>
        </tbody></table>
@endsection

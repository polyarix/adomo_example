@extends('emails.layouts.main')

@section('title', 'Adomo - подтверждение контактов.')

@section('content')
    <table class="body-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#F2F2F2;padding-top:17px;padding-bottom:17px;padding-right:30px;padding-left:30px;">
        <tbody><tr>
            <td style="padding-bottom:20px;">
                <h1 style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-size:24px;font-weight:normal;color:#000000;">Подтвердите вашу почту</h1>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;">
                <table class="info-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#fff;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;border-radius:6px;">
                    <tbody><tr>
                        <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                            <p style="color:#000000;font-style:normal;font-weight:normal;font-size:14px;line-height:19px;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">Для подтверждения почты введите код в форме на странице регистрации</p>
                            <p style="color:#323232;font-style:normal;font-weight: bold;font-size: 20px;line-height: 29px;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">{{ $code }}</p>
                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>
        </tbody></table>
@endsection

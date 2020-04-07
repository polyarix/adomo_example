@extends('emails.layouts.main')

@section('title', 'Adomo - объявление отклонено.')
@section('createTaskUrl', $createTaskUrl)

@section('content')
    <table class="body-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#F2F2F2;padding-top:17px;padding-bottom:17px;padding-right:30px;padding-left:30px;">
        <tbody><tr>
            <td style="padding-bottom:20px;">
                <h1 style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-size:24px;font-weight:normal;color:#000000;">Ваше объявление было отклонено!</h1>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;">
                <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">Причина отклонения: <b>{{ $order->isSpam() ? 'Спам' : $order->close_reason }}</b></p>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;"> <a class="btn-yellow" href="{{ route('advert.order.show', $order) }}" style="text-decoration:none;height:40px;background-color:#FEC62B;padding-left:15px;padding-right:15px;vertical-align:middle;text-align:center;display:inline-block;font-weight:500;font-size:14px;line-height:40px;color:#323232;border-radius:3px;">Смотреть объявление на сайте</a></td>
        </tr>
        </tbody></table>
@endsection

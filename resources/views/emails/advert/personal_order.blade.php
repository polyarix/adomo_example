@extends('emails.layouts.main')

@section('title', 'Adomo - персональное объявление.')
@section('createTaskUrl', $createTaskUrl)

@section('content')
    <table class="body-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#F2F2F2;padding-top:17px;padding-bottom:17px;padding-right:30px;padding-left:30px;">
        <tbody><tr>
            <td style="padding-bottom:20px;">
                <h1 style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-size:24px;font-weight:normal;color:#000000;">Вам предложили работу!</h1>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;">
                <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">Ознакомьтесь с задачей, хотите стать исполнителем?</p>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;">
                <table class="info-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#fff;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;border-radius:6px;">
                    <tbody><tr>
                        <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                            <h2 style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-weight:inherit;font-size:18px;line-height:21px;color:#323232;">{{ $order->title }}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                            <p style="color:#777777;font-style:normal;font-weight:normal;font-size:14px;line-height:19px;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">
                                {{ $order->city ? $order->city->name : ''  }},
                                Выполнить {{ localized_date($order->beginning_date, 'd F') }} {{ Str::lower($order->getTimeType()) }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                            <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">{{ Str::words($order->description) }}.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;"> <a class="btn-yellow" href="{{ route('advert.order.show', $order) }}" style="text-decoration:none;height:40px;background-color:#FEC62B;padding-left:15px;padding-right:15px;vertical-align:middle;text-align:center;display:inline-block;font-weight:500;font-size:14px;line-height:40px;color:#323232;border-radius:3px;">Смотреть задачу на сайте</a></td>
        </tr>
        </tbody></table>
@endsection

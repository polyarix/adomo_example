@extends('emails.layouts.main')

@section('title', 'Adomo - восстановление пароля.')
@section('createTaskUrl', $createTaskUrl)

@section('content')
    <table class="body-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#F2F2F2;padding-top:17px;padding-bottom:17px;padding-right:30px;padding-left:30px;">
        <tbody><tr>
            <td style="padding-bottom:20px;">
                <h1 style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-size:24px;font-weight:normal;color:#000000;">Поздравляем!</h1>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;">
                <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">Вы успешно зарегистрировались на сайте <a href="//{{ $siteUrl }}" style="text-decoration:none;color:#0277BD;word-break:break-all;">{{ $siteUrl }} </a>как:</p>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;">
                <table class="info-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#fff;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;border-radius:6px;">
                    <tbody><tr>
                        <td style="width:100px;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                            <img src="{{ $avatar }}" alt="" style="border-radius:50%;max-width:80px;max-height:80px;">
                        </td>

                        <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                            <p style="color:#000000;font-style:normal;font-weight:normal;font-size:14px;line-height:19px;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">{{ $type }}</p>
                            <h2 style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-weight:inherit;font-size:18px;line-height:21px;color:#323232;">{{ $name }}</h2>
                            <p style="color:#323232;font-style:normal;font-weight:normal;font-size:14px;line-height:19px;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">Логин для входа: {{ $email }}</p>
                            {{--<p style="color:#323232;font-style:normal;font-weight:normal;font-size:14px;line-height:19px;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">Пароль: {{ $password }}</p>--}}
                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>
        {{--<tr>
            <td style="padding-bottom:20px;">
                <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">Для подтверждения регистрации используйте ссылку <br></p>
                <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;"> <a href="#" style="text-decoration:none;color:#0277BD;word-break:break-all;">http://internetopros.ru/Account/ConfirmActivation/1d4aa420b5154c819d8d56088cda273e?token=dn5j1Kb2l2S1yjHYbaGAPQ2</a></p>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;">
                <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;">Данная ссылка действительна в течении 7 дней, после чего неподтвержденная регистрация будет удалена.</p>
            </td>
        </tr>--}}
        </tbody></table>
@endsection

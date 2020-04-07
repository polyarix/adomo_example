@extends('emails.layouts.main')

@section('title', 'Adomo - восстановление пароля.')
@section('createTaskUrl', $createTaskUrl)


@section('content')
    <table class="body-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#F2F2F2;padding-top:17px;padding-bottom:17px;padding-right:30px;padding-left:30px;" >
        <tr>
            <td style="padding-bottom:20px;" >
                <h1 style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-size:24px;font-weight:normal;color:#000000;" >Здравствуйте, {{ $name }}!</h1>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;" >
                <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;" >
                    Вы получили это письмо, так как попытались восстановить доступ к профилю на
                    <a href="//{{ $siteUrl }}" style="text-decoration:none;color:#0277BD;word-break:break-all;" >{{ $siteUrl }}</a>
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;" >
                <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;" >
                    Для восстановления доступа к профилю перейдите по этой
                    <a href="{{ $recoveryUrl }}" style="text-decoration:none;color:#0277BD;word-break:break-all;" >ссылке </a>или нажмите на кнопку ниже.
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;" >
                <a class="btn-yellow" href="{{ $recoveryUrl }}" style="text-decoration:none;height:40px;background-color:#FEC62B;padding-left:15px;padding-right:15px;vertical-align:middle;text-align:center;display:inline-block;font-weight:500;font-size:14px;line-height:40px;color:#323232;border-radius:3px;" >Восстановить пароль</a>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:20px;" >
                <p style="font-style:normal;font-weight:normal;font-size:14px;line-height:19px;color:#000000;margin-top:5px;margin-bottom:5px;margin-right:0;margin-left:0;" >
                    При возникновении проблем с доступом к вашему профилю обращайтесь в службу поддержки по адресу
                    <a href="#" style="text-decoration:none;color:#0277BD;word-break:break-all;" >{{ main_config('email_support', 'support@adomo.com') }}</a>
                </p>
            </td>
        </tr>
    </table>
@endsection

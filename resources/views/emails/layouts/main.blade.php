<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>@yield('title', 'Adomo')</title>
</head>
<style>
    a{
        text-decoration: none;
    }
    ul,
    ol {
        padding: 0;
        margin: 0;
        list-style-type: none;
    }
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin: 0;
        font-size: inherit;
        font-weight: inherit;
    }
    table{
        width: 100%;
        font-family: 'Open Sans', sans-serif;
    }
    .main-table{
        width: 100%;
        max-width: 600px;
        margin:0 auto;
    }
    .header-table{
        background-color: #fff;
    }
    .body-table{
        background-color: #F2F2F2;
        padding: 17px 30px;

    }
    .footer-table{
        background-color: #fff;
        font-size: 12px;
        color: #979797;
    }
    .header-table,
    .footer-table{
        padding: 26px 30px;
    }

    .btn-yellow{
        height: 40px;
        background-color: #FEC62B;
        padding-left: 15px;
        padding-right: 15px;
        vertical-align: middle;
        text-align: center;
        display: inline-block;
        font-weight: 500;
        font-size: 14px;
        line-height: 40px;
        color:#323232;
        border-radius:3px;
        font-weight: 500;
    }
    .tel{
        color: #979797;
    }
    h1{
        font-size: 24px;
        font-weight: normal;
        color: #000000;
    }
    p{
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 19px;
        color: #000000;
        margin: 5px 0;
    }
    p>a{
        color: #0277BD;
        word-break: break-all;
    }
    .body-table td {
        padding-bottom: 20px;
    }
    .info-table{
        background-color: #fff;
        padding: 20px;
        border-radius: 6px;
    }
    .info-table td{
        padding: 0;
    }
    .info-table p{
        margin: 5px 0;
    }
    .info-table img{
        border-radius: 50%;
        max-width: 80px;
        max-height: 80px;
    }
    h2{
        font-size: 18px;
        line-height: 21px;
        color: #323232;
    }

</style>
<body style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
<table class="main-table" cellpadding="0" cellspacing="0" style="font-family:'Open Sans', sans-serif;width:100%;max-width:600px;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;" >
    <tbody>
    <tr>
        <td>
            <table class="header-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#fff;padding-top:26px;padding-bottom:26px;padding-right:30px;padding-left:30px;" >
                <tr>
                    <td> <a href="#" style="text-decoration:none;" ><img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjQ2IiB2aWV3Qm94PSIwIDAgMTIwIDQ2IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik01NS43ODQ1IDEyLjYwNTRINTkuNjAxNEw2My41MTQ5IDMyLjI0OTNINjAuMjA1M0w1OS40MzIzIDI3LjcxNDNINTYuMDI2MUw1NS4yMjg5IDMyLjI0OTNINTEuODcxTDU1Ljc4NDUgMTIuNjA1NFpNNTkuMDQ1OCAyNS40MzQ2TDU3LjcxNzEgMTcuMTg4OUw1Ni4zODg0IDI1LjQzNDZINTkuMDQ1OFoiIGZpbGw9IiMzMjMyMzIiLz48cGF0aCBkPSJNNjUuNDgyOCAxMi42MDU0SDcwLjA5NjlDNzEuNjc1MiAxMi42MDU0IDcyLjkxNTMgMTIuODIzNiA3My44MTcyIDEzLjI2MDJDNzQuNzE5MSAxMy42ODA1IDc1LjM1NTIgMTQuMzM1MyA3NS43MjU2IDE1LjIyNDZDNzYuMTEyMSAxNi4wOTc2IDc2LjMwNTQgMTcuMjYxNyA3Ni4zMDU0IDE4LjcxNjhWMjUuODcxMUM3Ni4zMDU0IDI3LjM1ODYgNzYuMTEyMSAyOC41NjMxIDc1LjcyNTYgMjkuNDg0NkM3NS4zNTUyIDMwLjQwNjIgNzQuNzI3MSAzMS4xMDE0IDczLjg0MTMgMzEuNTcwM0M3Mi45NTU1IDMyLjAyMyA3MS43NTU3IDMyLjI0OTMgNzAuMjQxOCAzMi4yNDkzSDY1LjQ4MjhWMTIuNjA1NFpNNzAuMTQ1MiAyOS43NTE0QzcwLjkzNDQgMjkuNzUxNCA3MS41MDYxIDI5LjYxNCA3MS44NjA0IDI5LjMzOTFDNzIuMjE0NyAyOS4wNjQzIDcyLjQ0MDIgMjguNjg0MyA3Mi41MzY4IDI4LjE5OTNDNzIuNjMzNCAyNy42OTgxIDcyLjY4MTggMjYuOTYyNCA3Mi42ODE4IDI1Ljk5MjRWMTguNDc0M0M3Mi42ODE4IDE3LjYwMTIgNzIuNjI1NCAxNi45MzgzIDcyLjUxMjcgMTYuNDg1NkM3Mi4zOTk5IDE2LjAzMjkgNzIuMTU4NCAxNS43MDE1IDcxLjc4NzkgMTUuNDkxM0M3MS40MzM2IDE1LjI2NSA3MC44Njk5IDE1LjE1MTggNzAuMDk2OSAxNS4xNTE4SDY5LjAzNFYyOS43NTE0SDcwLjE0NTJaIiBmaWxsPSIjMzIzMjMyIi8+PHBhdGggZD0iTTg0LjI2ODcgMzIuNTE2MUM4Mi4yMzk1IDMyLjUxNjEgODAuNzkgMzEuOTc0NSA3OS45MjA0IDMwLjg5MTJDNzkuMDUwNyAyOS43OTE4IDc4LjYxNTggMjguMTkxMiA3OC42MTU4IDI2LjA4OTRWMTguNzE2OEM3OC42MTU4IDE2LjYzMTIgNzkuMDUwNyAxNS4wNTQ4IDc5LjkyMDQgMTMuOTg3N0M4MC43OSAxMi45MjA2IDgyLjIzOTUgMTIuMzg3MSA4NC4yNjg3IDEyLjM4NzFDODYuMjgxOCAxMi4zODcxIDg3LjcyMzIgMTIuOTIwNiA4OC41OTI5IDEzLjk4NzdDODkuNDYyNiAxNS4wNTQ4IDg5Ljg5NzQgMTYuNjMxMiA4OS44OTc0IDE4LjcxNjhWMjYuMDg5NEM4OS44OTc0IDI4LjE3NSA4OS40NTQ1IDI5Ljc2NzYgODguNTY4OCAzMC44NjdDODcuNjk5MSAzMS45NjY0IDg2LjI2NTcgMzIuNTE2MSA4NC4yNjg3IDMyLjUxNjFaTTg0LjI2ODcgMjkuODcyN0M4NS4wNTc5IDI5Ljg3MjcgODUuNTg5MyAyOS42MjIxIDg1Ljg2MzEgMjkuMTIwOUM4Ni4xMzY5IDI4LjYxOTcgODYuMjczOCAyNy44OTIxIDg2LjI3MzggMjYuOTM4MlYxNy44OTIzQzg2LjI3MzggMTYuOTM4MyA4Ni4xMzY5IDE2LjIxODkgODUuODYzMSAxNS43MzM4Qzg1LjYwNTQgMTUuMjQ4OCA4NS4wNzQgMTUuMDA2MyA4NC4yNjg3IDE1LjAwNjNDODMuNDYzNSAxNS4wMDYzIDgyLjkyMzkgMTUuMjU2OSA4Mi42NTAyIDE1Ljc1ODFDODIuMzc2NCAxNi4yNDMxIDgyLjIzOTUgMTYuOTU0NSA4Mi4yMzk1IDE3Ljg5MjNWMjYuOTM4MkM4Mi4yMzk1IDI3Ljg5MjEgODIuMzc2NCAyOC42MTk3IDgyLjY1MDIgMjkuMTIwOUM4Mi45MjM5IDI5LjYyMjEgODMuNDYzNSAyOS44NzI3IDg0LjI2ODcgMjkuODcyN1oiIGZpbGw9IiMzMjMyMzIiLz48cGF0aCBkPSJNOTIuODMyIDEyLjYwNTRIOTYuNTI4MUw5OS4zMDYyIDI2LjIxMDZMMTAyLjE4MSAxMi42MDU0SDEwNS43OEwxMDYuMTQzIDMyLjI0OTNIMTAzLjQ4NUwxMDMuMTk2IDE4LjU5NTZMMTAwLjQxNyAzMi4yNDkzSDk4LjI2NzRMOTUuNDQxIDE4LjU0NzFMOTUuMTc1MyAzMi4yNDkzSDkyLjQ5MzhMOTIuODMyIDEyLjYwNTRaIiBmaWxsPSIjMzIzMjMyIi8+PHBhdGggZD0iTTExNC4zNzEgMzIuNTE2MUMxMTIuMzQyIDMyLjUxNjEgMTEwLjg5MyAzMS45NzQ1IDExMC4wMjMgMzAuODkxMkMxMDkuMTUzIDI5Ljc5MTggMTA4LjcxOCAyOC4xOTEyIDEwOC43MTggMjYuMDg5NFYxOC43MTY4QzEwOC43MTggMTYuNjMxMiAxMDkuMTUzIDE1LjA1NDggMTEwLjAyMyAxMy45ODc3QzExMC44OTMgMTIuOTIwNiAxMTIuMzQyIDEyLjM4NzEgMTE0LjM3MSAxMi4zODcxQzExNi4zODQgMTIuMzg3MSAxMTcuODI2IDEyLjkyMDYgMTE4LjY5NSAxMy45ODc3QzExOS41NjUgMTUuMDU0OCAxMjAgMTYuNjMxMiAxMjAgMTguNzE2OFYyNi4wODk0QzEyMCAyOC4xNzUgMTE5LjU1NyAyOS43Njc2IDExOC42NzEgMzAuODY3QzExNy44MDIgMzEuOTY2NCAxMTYuMzY4IDMyLjUxNjEgMTE0LjM3MSAzMi41MTYxWk0xMTQuMzcxIDI5Ljg3MjdDMTE1LjE2IDI5Ljg3MjcgMTE1LjY5MiAyOS42MjIxIDExNS45NjYgMjkuMTIwOUMxMTYuMjM5IDI4LjYxOTcgMTE2LjM3NiAyNy44OTIxIDExNi4zNzYgMjYuOTM4MlYxNy44OTIzQzExNi4zNzYgMTYuOTM4MyAxMTYuMjM5IDE2LjIxODkgMTE1Ljk2NiAxNS43MzM4QzExNS43MDggMTUuMjQ4OCAxMTUuMTc3IDE1LjAwNjMgMTE0LjM3MSAxNS4wMDYzQzExMy41NjYgMTUuMDA2MyAxMTMuMDI3IDE1LjI1NjkgMTEyLjc1MyAxNS43NTgxQzExMi40NzkgMTYuMjQzMSAxMTIuMzQyIDE2Ljk1NDUgMTEyLjM0MiAxNy44OTIzVjI2LjkzODJDMTEyLjM0MiAyNy44OTIxIDExMi40NzkgMjguNjE5NyAxMTIuNzUzIDI5LjEyMDlDMTEzLjAyNyAyOS42MjIxIDExMy41NjYgMjkuODcyNyAxMTQuMzcxIDI5Ljg3MjdaIiBmaWxsPSIjMzIzMjMyIi8+PHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0yMi44Mzg3IDQ1LjY3NzRDMzUuNDUyMiA0NS42Nzc0IDQ1LjY3NzQgMzUuNDUyMiA0NS42Nzc0IDIyLjgzODdDNDUuNjc3NCAxMC4yMjUyIDM1LjQ1MjIgMCAyMi44Mzg3IDBDMTAuMjI1MiAwIDAgMTAuMjI1MiAwIDIyLjgzODdDMCAzNS40NTIyIDEwLjIyNTIgNDUuNjc3NCAyMi44Mzg3IDQ1LjY3NzRaIiBmaWxsPSIjRkVDNjJCIi8+PHBhdGggZD0iTTIwLjk0MTggMTAuMDY0NUgyNS41MDk4TDMwLjE5MzUgMzMuMjkwM0gyNi4yMzI2TDI1LjMwNzQgMjcuOTI4M0gyMS4yMzA5TDIwLjI3NjggMzMuMjkwM0gxNi4yNTgxTDIwLjk0MTggMTAuMDY0NVpNMjQuODQ0OSAyNS4yMzNMMjMuMjU0NyAxNS40ODM5TDIxLjY2NDYgMjUuMjMzSDI0Ljg0NDlaIiBmaWxsPSIjMzIzMjMyIi8+PC9zdmc+"/></a></td>
                    <td style="text-align:right;" >
                        <a class="btn-yellow" href="@yield('createTaskUrl', route('advert.order.create'))" style="text-decoration:none;height:40px;background-color:#FEC62B;padding-left:15px;padding-right:15px;vertical-align:middle;text-align:center;display:inline-block;font-weight:500;font-size:14px;line-height:40px;color:#323232;border-radius:3px;">Создать задание</a>
                    </td>
                </tr>
            </table>

            @yield('content')

            <table class="footer-table" cellpadding="0" cellspacing="0" style="width:100%;font-family:'Open Sans', sans-serif;background-color:#fff;font-size:12px;color:#979797;padding-top:26px;padding-bottom:26px;padding-right:30px;padding-left:30px;" >
                <tr>
                    <td>С уважением, <br>Администрация сайта {{ $siteUrl }}</td>
                    <td style="text-align:right;" >
                        <ul style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;list-style-type:none;" >
                            <li>
                                <a class="tel" href="tel:+{{ sanitize_phone(main_config('phone1', '8 (800) 500-77-00')) }}" style="text-decoration:none;color:#979797;" >
                                    {{ main_config('phone1', '8 (800) 500-77-00') }}
                                </a>
                            </li>

                            <li>
                                <a class="tel" href="tel:+{{ sanitize_phone(main_config('phone1', '8 (800) 500-77-00')) }}" style="text-decoration:none;color:#979797;" >
                                    {{ main_config('phone2', '8 (800) 500-77-00') }}
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>

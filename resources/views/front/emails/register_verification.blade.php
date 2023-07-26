<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    {{-- <style media="all" type="text/css">
        @media only screen and (max-width: 620px) {
            .span-2,
            .span-3 {
                max-width: none !important;
                width: 100% !important;
            }
            .span-2 > table,
            .span-3 > table {
                max-width: 100% !important;
                width: 100% !important;
            }
        }

        @media all {
            .btn-primary table td:hover {
                background-color: #34495e !important;
            }

            .btn-primary a:hover {
                background-color: #34495e !important;
                border-color: #34495e !important;
            }
        }

        @media all {
            .btn-secondary a:hover {
                border-color: #34495e !important;
                color: #34495e !important;
            }
        }

        @media only screen and (max-width: 620px) {
            h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            h2 {
                font-size: 22px !important;
                margin-bottom: 10px !important;
            }

            h3 {
                font-size: 16px !important;
                margin-bottom: 10px !important;
            }

            p,
            ul,
            ol,
            td,
            span,
            a {
                font-size: 16px !important;
            }

            .wrapper,
            .article {
                padding: 10px !important;
            }

            .content {
                padding: 0 !important;
            }

            .container {
                padding: 0 !important;
                width: 100% !important;
            }

            .header {
                margin-bottom: 10px !important;
            }

            .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            .btn table {
                width: 100% !important;
            }

            .btn a {
                width: 100% !important;
            }

            .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }

            .alert td {
                border-radius: 0 !important;
                padding: 10px !important;
            }

            .receipt {
                width: 100% !important;
            }
        }

        @media all {
            .ExternalClass {
                width: 100%;
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }
        }
    </style> --}}

    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
</head>

<body >
<div style="text-align:center;min-width:640px;width:100%;height:100%;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;margin:0;padding:0" bgcolor="#fafafa">

<table border="0" cellpadding="0" cellspacing="0" style="text-align:center;min-width:640px;width:100%;margin:0;padding:0" bgcolor="#fafafa">
<tbody>
<tr>
<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;height:4px;font-size:4px;line-height:4px" bgcolor="#6b4fbb"></td>
</tr>
<tr>
<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 30px;line-height: -3.4;color:#5c5c5c;display: flex;text-align: center;margin: 22px 388px 2px;color: #d3b459;margin-bottom: 15px;">
<img src="{{getLogoImage()}}" class="main-logo" alt="logo" width="55" height="50" class="CToWUd"><span>{{getCompanyName()}}</span>
</td>
</tr>
<tr>
<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif">
<table border="0" cellpadding="0" cellspacing="0" class="m_-475921313878443882wrapper" style="width:640px;border-collapse:separate;border-spacing:0;margin:0 auto">
<tbody>
<tr>
<td class="m_-475921313878443882wrapper-cell" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;border-radius:3px;overflow:hidden;padding:18px 25px;border:1px solid #ededed" align="left" bgcolor="#fff">
<table border="0" cellpadding="0" cellspacing="0" style="width:100%;border-collapse:separate;border-spacing:0">
<tbody>
<tr>
<td style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#333333;font-size:15px;font-weight:400;line-height:1.4;padding:15px 5px" align="center">
<h1 style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#333333;font-size:18px;font-weight:400;line-height:1.4;margin:0;padding:0" align="center">Hello!</h1>
<p>Welcome to Grand Community and thanks for registering an account with us.</p>
<p>To activate your account, please verify your email address by clicking on the link below. Your account will be created as soon as you’ve confirmed your email address.</p>

<div>
    <strong class="card-text">
{{--        <a href="{{url("/account-confirm/".$user['forget_code']."?email=".$user['email'])}}"  target="_blank" type="button" class="btn btn-primary">Confirm Your Account</a>--}}
    {{$user['forget_code']}}
    </strong>
</div>

</td>
</tr>

</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>


<tr>
<td style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:13px;line-height:1.6;color:#5c5c5c">

<div>

        @if(!empty(settings()) && !empty(settings()->facebook))  <a  style="color:#3777b0;text-decoration:none" href="{{settings()->facebook}}" target="_blank">Facebook  - </a>     @endif
        @if(!empty(settings()) && !empty(settings()->twitter))  <a   style="color:#3777b0;text-decoration:none" href="{{settings()->twitter}}" target="_blank">Twitter  -  </a>     @endif
        @if(!empty(settings()) && !empty(settings()->instagram))  <a  style="color:#3777b0;text-decoration:none" href="{{settings()->instagram}}" target="_blank">Instagram  -  </a>    @endif
        @if(!empty(settings()) && !empty(settings()->snapchat))  <a  style="color:#3777b0;text-decoration:none" href="{{settings()->snapchat}}" target="_blank">Snapchat -  </a>  @endif
        @if(!empty(settings()) && !empty(settings()->linkedin))  <a  style="color:#3777b0;text-decoration:none" href="{{settings()->linkedin}}" target="_blank">linkedin   </a>  @endif

</div>
</td>
</tr>

<tr>
<td style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-size:13px;line-height:1.6;color:#5c5c5c;padding:25px 0">

</td>
</tr>
</tbody>
</table><div class="yj6qo"></div><div class="adL">
</div></div>
</body>
</html>


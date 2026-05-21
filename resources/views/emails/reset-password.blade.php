<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Your Password - INSPIN</title>
</head>
<body style="margin:0;padding:0;background-color:#0a0a0a;font-family:'Helvetica Neue',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#0a0a0a;padding:40px 20px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">

                {{-- Logo --}}
                <tr>
                    <td align="center" style="padding-bottom:28px;">
                        <img src="https://inspin.com/images/inspin-logo.png" alt="INSPIN" height="40" style="height:40px;width:auto;">
                    </td>
                </tr>

                {{-- Card --}}
                <tr>
                    <td style="background:#161616;border:1px solid rgba(255,255,255,.08);border-radius:16px;overflow:hidden;">

                        {{-- Gold top bar --}}
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr><td style="height:4px;background:linear-gradient(90deg,#FDB515,#f59e0b);"></td></tr>
                        </table>

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:36px 40px;">

                                    {{-- Icon --}}
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" style="padding-bottom:24px;">
                                                <div style="width:64px;height:64px;background:rgba(253,181,21,.1);border:1px solid rgba(253,181,21,.3);border-radius:16px;display:inline-block;line-height:64px;text-align:center;font-size:28px;">🔑</div>
                                            </td>
                                        </tr>
                                    </table>

                                    {{-- Heading --}}
                                    <h1 style="margin:0 0 10px;font-size:24px;font-weight:700;color:#ffffff;text-align:center;">
                                        Reset Your Password
                                    </h1>

                                    <p style="margin:0 0 28px;font-size:15px;color:rgba(255,255,255,.5);text-align:center;line-height:1.7;">
                                        Hi <strong style="color:#fff;">{{ $userName }}</strong>, we received a request to reset your INSPIN account password.<br>
                                        Click the button below to choose a new one.
                                    </p>

                                    {{-- Button --}}
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" style="padding-bottom:28px;">
                                                <a href="{{ $resetUrl }}"
                                                   style="display:inline-block;padding:15px 44px;background:#FDB515;color:#000000;font-size:15px;font-weight:700;text-decoration:none;border-radius:50px;">
                                                    🔓 &nbsp; Reset My Password
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    {{-- Divider --}}
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr><td style="height:1px;background:rgba(255,255,255,.07);"></td></tr>
                                    </table>

                                    {{-- Expiry notice --}}
                                    <p style="margin:20px 0 0;font-size:13px;color:rgba(255,255,255,.35);text-align:center;line-height:1.6;">
                                        ⏱ This reset link expires in <strong style="color:#FDB515;">60 minutes</strong>.
                                    </p>

                                    <p style="margin:10px 0 20px;font-size:13px;color:rgba(255,255,255,.25);text-align:center;line-height:1.6;">
                                        If you did not request a password reset, no action is needed — your account remains secure.
                                    </p>

                                    {{-- Divider --}}
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr><td style="height:1px;background:rgba(255,255,255,.07);"></td></tr>
                                    </table>

                                    {{-- Fallback --}}
                                    <p style="margin:16px 0 0;font-size:11px;color:rgba(255,255,255,.2);text-align:center;line-height:1.6;">
                                        Button not working? Copy and paste this link into your browser:<br>
                                        <a href="{{ $resetUrl }}" style="color:#FDB515;word-break:break-all;font-size:11px;">{{ $resetUrl }}</a>
                                    </p>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td align="center" style="padding:24px 0 0;">
                        <p style="margin:0;font-size:12px;color:rgba(255,255,255,.2);">
                            © {{ date('Y') }} INSPIN. All rights reserved.<br>
                            <a href="https://inspin.com" style="color:rgba(255,255,255,.3);text-decoration:none;">inspin.com</a>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>

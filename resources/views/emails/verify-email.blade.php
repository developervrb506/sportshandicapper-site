<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify Your Email | Sportshandicapper</title>
</head>
<body style="margin:0;padding:0;background-color:#0a0a0a;font-family:'Helvetica Neue',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#0a0a0a;padding:40px 20px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">

                {{-- Logo --}}
                <tr>
                    <td align="center" style="padding-bottom:28px;">
                        <img src="https://sportshandicapper.com/images/sh-logo.png" alt="Sportshandicapper" height="40" style="height:40px;width:auto;">
                    </td>
                </tr>

                {{-- Card --}}
                <tr>
                    <td style="background:#161616;border:1px solid rgba(255,255,255,.08);border-radius:16px;overflow:hidden;">

                        {{-- Gold top bar --}}
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr><td style="height:4px;background:linear-gradient(90deg,#6366F1,#818CF8);"></td></tr>
                        </table>

                        {{-- Body --}}
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:36px 40px;">

                                    {{-- Icon --}}
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" style="padding-bottom:24px;">
                                                <div style="width:64px;height:64px;background:rgba(99,102,241,.1);border:1px solid rgba(99,102,241,.3);border-radius:16px;display:inline-block;line-height:64px;text-align:center;font-size:28px;">📧</div>
                                            </td>
                                        </tr>
                                    </table>

                                    {{-- Heading --}}
                                    <h1 style="margin:0 0 12px;font-size:24px;font-weight:700;color:#ffffff;text-align:center;line-height:1.3;">
                                        Verify Your Email Address
                                    </h1>

                                    {{-- Subheading --}}
                                    <p style="margin:0 0 24px;font-size:15px;color:rgba(255,255,255,.5);text-align:center;line-height:1.7;">
                                        Hi <strong style="color:#fff;">{{ $userName }}</strong>, welcome to Sportshandicapper!<br>
                                        Click the button below to activate your account and start accessing expert picks.
                                    </p>

                                    {{-- Button --}}
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" style="padding:8px 0 28px;">
                                                <a href="{{ $verificationUrl }}"
                                                   style="display:inline-block;padding:15px 40px;background:#6366F1;color:#ffffff;font-size:15px;font-weight:700;text-decoration:none;border-radius:50px;letter-spacing:.3px;">
                                                    ✓ &nbsp; Verify Email Address
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    {{-- Divider --}}
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr><td style="height:1px;background:rgba(255,255,255,.07);margin-bottom:24px;"></td></tr>
                                    </table>

                                    {{-- What you get --}}
                                    <table width="100%" cellpadding="0" cellspacing="0" style="margin:20px 0;">
                                        <tr>
                                            <td style="padding:4px 0;font-size:13px;color:rgba(255,255,255,.4);">
                                                ⭐ &nbsp;Access to exclusive expert picks
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:4px 0;font-size:13px;color:rgba(255,255,255,.4);">
                                                📊 &nbsp;Live betting consensus & trends
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:4px 0;font-size:13px;color:rgba(255,255,255,.4);">
                                                📰 &nbsp;In-depth game analysis articles
                                            </td>
                                        </tr>
                                    </table>

                                    {{-- Fallback URL --}}
                                    <p style="margin:20px 0 0;font-size:12px;color:rgba(255,255,255,.25);text-align:center;line-height:1.6;">
                                        If the button doesn't work, copy and paste this link into your browser:<br>
                                        <a href="{{ $verificationUrl }}" style="color:#818CF8;word-break:break-all;">{{ $verificationUrl }}</a>
                                    </p>

                                    <p style="margin:16px 0 0;font-size:12px;color:rgba(255,255,255,.2);text-align:center;">
                                        If you did not create an account, you can safely ignore this email.
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
                            © {{ date('Y') }} Sportshandicapper. All rights reserved.<br>
                            <a href="https://sportshandicapper.com" style="color:rgba(255,255,255,.3);text-decoration:none;">sportshandicapper.com</a>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>

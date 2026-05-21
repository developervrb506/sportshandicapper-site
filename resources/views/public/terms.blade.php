@extends('layouts.public')
@section('title', 'Terms of Service - INSPIN')

@section('content')
<div style="background:#171818;min-height:60vh;padding:60px 0;">
<div style="max-width:860px;margin:0 auto;padding:0 24px;">

    <h1 style="font-family:'Clash Display',sans-serif;font-size:2rem;font-weight:500;color:#FFFCEE;margin-bottom:8px;">Terms of Service</h1>
    <p style="color:#6e6e6e;font-size:13px;margin-bottom:40px;border-bottom:1px solid rgba(255,252,238,.08);padding-bottom:20px;">Last updated: December 2024</p>

    @php
    $sections = [
        ['Welcome to Inspin.com. The following terms of service (the "TOS") apply to your use of these Websites, including access to the Services (as defined below) and Content (as defined below) available through the Website. Please read these terms and conditions carefully before using the Website, accessing the Content and/or using the Services.', null],
        ['BY USING THE WEBSITE, THE SERVICES, OR THE CONTENT, YOU ARE CONSENTING TO THE TERMS AND CONDITIONS IN THIS TERMS OF SERVICE AGREEMENT AS THEY APPLY TO YOU AND YOUR USAGE AND ACCESS.', null],
        ['Your use of the Website, the Content, and the Services is also subject to all applicable laws and regulations. If you do not agree to any of the terms of service in this agreement, you should not use the Website, the Services, or the Content.', null],
        ['1. Terms of Service', 'Inspin.com provides the Website, the Content, and the Services to you subject to the following Terms of Service ("TOS"). The TOS may be updated by us from time to time without notice to you. We suggest that from time to time you review the TOS for possible changes.'],
        ['2. Services and Content', 'Inspin.com currently provides users with various features and services, including statistical review, contests, handicapper picks, and other interactive and non-interactive features, all of which may be updated, deleted, or otherwise modified from time to time at the discretion of Inspin.com. The Website, the Services, and the Content are provided for your non-commercial entertainment and enjoyment.'],
        ['3. Disclaimer of Warranties', 'YOUR USE OF THE WEBSITE, THE SERVICES AND THE CONTENT IS AT YOUR SOLE RISK. THE WEBSITE, THE SERVICES AND THE CONTENT ARE PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS. INSPIN.COM EXPRESSLY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO THE IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT.'],
        ['4. Limitation of Liability', 'YOU EXPRESSLY UNDERSTAND AND AGREE THAT INSPIN.COM SHALL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL OR EXEMPLARY DAMAGES, INCLUDING BUT NOT LIMITED TO DAMAGES FOR LOSS OF PROFITS, GOODWILL, USE, DATA OR OTHER INTANGIBLE LOSSES RESULTING FROM YOUR USE OF THE WEBSITE, THE SERVICES, OR THE CONTENT.'],
        ['5. Access to Services', 'In order to use the Website or the Services or access the Content, you must obtain access to the World Wide Web and pay any service fees associated with such access.'],
        ['6. Registration & Background Information', 'In order to use the Services, you may be required to register with Inspin.com by providing certain information about yourself, including your name and e-mail address. You agree to provide true, accurate, current and complete information about yourself as requested.'],
        ['7. Access by Minors', 'You must be at least 18 years old to register at Inspin.com. If you are under 18 years of age, you are not permitted to use the Websites or the Services or to access the Content.'],
        ['8. Member Password and Security', 'You will receive a password upon completing the registration process for use of the Services. You are responsible for maintaining the confidentiality of the password, and are fully responsible for all activities that occur under your password.'],
        ['9. Member Conduct', 'You agree to use the Website and Services lawfully and not to transmit harmful, abusive, defamatory, or unlawful content. You agree not to interfere with or disrupt the Website, the Services, or related servers or networks.'],
        ['10. Indemnity', 'You agree to indemnify, defend and hold harmless Inspin.com, its directors, owners, employees, and agents from and against any claim or demand, including reasonable attorneys\' fees, arising out of your use of the Website or the Services, or your violation of the TOS.'],
        ['11. Modifications to Website', 'Inspin.com reserves the right at any time and from time to time to modify or discontinue, temporarily or permanently, the Website or Services (or any part thereof) with or without notice.'],
        ['12. Termination', 'Inspin.com may, in its sole discretion, terminate your password or use of the Website and/or the Services, and remove and discard any content within the Services, for any reason, including, without limitation, for lack of use or if Inspin.com believes that you have violated the letter or spirit of the TOS.'],
    ];
    @endphp

    @foreach($sections as $s)
    <div style="margin-bottom:28px;">
        @if($s[1])
        <h2 style="font-family:'Clash Display',sans-serif;font-size:1.1rem;font-weight:500;color:#FDB515;margin-bottom:10px;">{{ $s[0] }}</h2>
        <p style="color:#c0c0c0;font-size:14.5px;line-height:1.8;">{{ $s[1] }}</p>
        @else
        <p style="color:#c0c0c0;font-size:14.5px;line-height:1.8;">{{ $s[0] }}</p>
        @endif
    </div>
    @endforeach

    <div style="margin-top:48px;padding-top:24px;border-top:1px solid rgba(255,252,238,.08);color:#6e6e6e;font-size:13px;">
        Questions? Contact us at <a href="mailto:support@inspin.com" style="color:#FDB515;">support@inspin.com</a> or call <a href="tel:18554926003" style="color:#FDB515;">1-855-492-6003</a>.
    </div>

</div>
</div>
@endsection

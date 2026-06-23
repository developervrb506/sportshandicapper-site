@extends('layouts.public')
@section('title', 'Privacy Policy | Sportshandicapper')

@section('content')
<div style="background:#0A0F1E;min-height:60vh;padding:60px 0;">
<div style="max-width:860px;margin:0 auto;padding:0 24px;">

    <h1 style="font-family:'Exo 2',sans-serif;font-size:2rem;font-weight:700;color:#F0F0FF;margin-bottom:8px;">Privacy Policy</h1>
    <p style="color:#475569;font-size:13px;margin-bottom:40px;border-bottom:1px solid rgba(255,255,255,.08);padding-bottom:20px;font-family:'Inter',sans-serif;">Last updated: March 2025</p>

    @php
    $sections = [
        ['We Respect the Importance of Your Privacy', 'The Sportshandicapper.com Privacy Policy applies to Personal Information of non-employee persons who interact with Sportshandicapper.com — including viewers, readers, subscribers, advertisers, contest participants, customers, and Internet users. This Privacy Policy applies to the management of Personal Information in any form whether oral, electronic or written. Sportshandicapper.com reserves the right to amend this Privacy Policy from time to time.'],
        ['Purposes for Collection of Personal Information', 'Sportshandicapper.com collects Personal Information to: establish and maintain responsible commercial relations with individuals and provide ongoing service; understand individual needs; enhance, develop, market or provide products and services; and meet legal or regulatory requirements.'],
        ['Obtaining Consent', 'Sportshandicapper.com will make a reasonable effort to ensure persons understand how their Personal Information will be used. Sportshandicapper.com will obtain consent from persons before or when it collects or uses the Personal Information and will not attempt to deceive persons into giving consent.'],
        ['Internet Protocol Address (IP Address)', 'When your web browser requests a web page, it automatically provides that computer with your IP address. Sportshandicapper.com may use your IP Address to diagnose technical problems, display more appropriate content and advertising, and estimate user traffic from specific countries or organizations.'],
        ['Cookies', 'A cookie is a small text file sent to your browser from a web site\'s computers and stored on your hard drive. Sportshandicapper.com may use cookies to improve the operation and performance of our services, measure aggregate user traffic and demographic statistics, and display advertisements. Most browsers are set to accept cookies by default — you can adjust your browser settings to refuse cookies.'],
        ['Security Safeguards', 'Sportshandicapper.com shall protect Personal Information by security safeguards appropriate to the sensitivity of the information — including protection against loss or theft, unauthorized access, disclosure, copying, use, modification or destruction, through appropriate security measures.'],
        ['Access to Personal Information', 'Upon request, Sportshandicapper.com shall afford a person a reasonable opportunity to review the Personal Information in the person\'s file. Personal Information shall be provided in understandable form within a reasonable time and at minimal or no cost to the person.'],
        ['Links to Other Sites', 'An Sportshandicapper.com website may contain links to other websites and services. Sportshandicapper.com is not responsible for the content of, or the privacy practices employed by, other companies or websites. This Privacy Policy applies only to Sportshandicapper.com services.'],
        ['Refusing or Withdrawing Consent', 'Subject to legal and contractual requirements, a person can refuse to consent to Sportshandicapper.com\'s collection, use or disclosure of Personal Information, or may withdraw consent at any time in the future by giving Sportshandicapper.com reasonable notice. If a person refuses or withdraws consent, Sportshandicapper.com may not be able to provide certain products, services or information.'],
        ['Challenging Compliance', 'A person shall be able to address a challenge concerning compliance with the above principles to the designated person accountable for compliance. Sportshandicapper.com shall maintain procedures for addressing and responding to all inquiries or complaints.'],
    ];
    @endphp

    @foreach($sections as $s)
    <div style="margin-bottom:28px;">
        <h2 style="font-family:'Exo 2',sans-serif;font-size:1.1rem;font-weight:700;color:#1E90FF;margin-bottom:10px;">{{ $s[0] }}</h2>
        <p style="color:#94A3B8;font-size:14.5px;line-height:1.8;font-family:'Inter',sans-serif;">{{ $s[1] }}</p>
    </div>
    @endforeach

    <div style="margin-top:48px;padding-top:24px;border-top:1px solid rgba(255,255,255,.08);color:#475569;font-size:13px;font-family:'Inter',sans-serif;">
        Questions? Contact us at <a href="mailto:help@sportshandicapper.com" style="color:#1E90FF;">help@sportshandicapper.com</a> or call <a href="tel:+16104715405" style="color:#1E90FF;">(610) 471-5405</a>.
        <br>You can also write to: Sportshandicapper.com, Bryn Mawr, PA.
    </div>

</div>
</div>
@endsection

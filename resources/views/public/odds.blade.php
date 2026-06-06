@extends('layouts.public')
@section('title', 'Live Odds | Sportshandicapper')
@section('meta', 'Real time odds across every major sportsbook. Launching soon.')

@push('styles')
<style>
.cs-grad-text {
    background: linear-gradient(to right, #67e8f9, #7dd3fc, #a5b4fc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
@endpush

@section('content')
<div class="container-x" style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding-top:96px;padding-bottom:96px;">
    <div style="position:relative;max-width:576px;width:100%;text-align:center;">
        <div style="position:absolute;inset:-80px;background:radial-gradient(ellipse at 40% 40%,rgba(34,211,238,0.1) 0%,transparent 55%,rgba(99,102,241,0.1) 100%);filter:blur(64px);border-radius:9999px;pointer-events:none;"></div>

        <div style="position:relative;">
            <div style="margin:0 auto;width:64px;height:64px;border-radius:16px;background:rgba(34,211,238,0.1);border:1px solid rgba(34,211,238,0.2);display:flex;align-items:center;justify-content:center;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#67e8f9" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="2"/><path d="M16.24 7.76a6 6 0 010 8.49m-8.48-.01a6 6 0 010-8.49m11.31-2.82a10 10 0 010 14.14m-14.14 0a10 10 0 010-14.14"/>
                </svg>
            </div>

            <div style="display:inline-flex;align-items:center;margin-top:32px;padding:4px 14px;border-radius:9999px;border:1px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.03);font-size:10px;text-transform:uppercase;letter-spacing:0.3em;color:#94a3b8;font-weight:600;font-family:'Inter',sans-serif;">
                Live Odds
            </div>

            <h1 style="margin-top:24px;font-size:clamp(2.8rem,7vw,3.75rem);font-weight:900;color:white;line-height:1.05;font-family:'Exo 2',sans-serif;letter-spacing:-0.01em;">
                Live Odds<br>
                <span class="cs-grad-text">Coming Soon</span>
            </h1>

            <p style="margin-top:24px;color:#94a3b8;line-height:1.7;font-size:15px;">
                A unified live odds board across every major US sportsbook. Coming soon.
            </p>

            <div style="margin-top:40px;">
                <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:8px;font-size:14px;color:#cbd5e1;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#cbd5e1'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                    Back to home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

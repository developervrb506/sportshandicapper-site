@extends('layouts.auth')
@section('title', 'Forgot Password | Sportshandicapper')

@section('content')

<style>
    .auth-icon-circle {
        width:56px;height:56px;border-radius:14px;
        background:rgba(30,144,255,0.1);border:1px solid rgba(30,144,255,0.25);
        display:flex;align-items:center;justify-content:center;
        color:#1E90FF;margin-bottom:20px;
    }
    .auth-icon-circle.success { background:rgba(74,222,128,0.1);border-color:rgba(74,222,128,0.25);color:#4ade80; }
    .auth-resend-note {
        background:rgba(30,144,255,0.06);border:1px solid rgba(30,144,255,0.18);
        border-radius:10px;padding:14px;margin:20px 0;font-size:12.5px;
        color:#94A3B8;text-align:left;line-height:1.6;
    }
    .auth-resend-note strong { color:#1E90FF;display:block;margin-bottom:4px; }
    .auth-submit-outline {
        display:flex;align-items:center;justify-content:center;gap:8px;
        width:100%;padding:12px 20px;border-radius:9999px;
        background:transparent;color:white;border:1px solid rgba(255,255,255,0.15);
        cursor:pointer;font-size:14px;font-weight:700;font-family:'Exo 2',sans-serif;
        text-transform:uppercase;letter-spacing:0.06em;
        transition:all .15s;
    }
    .auth-submit-outline:hover { background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.3); }
</style>

<img src="{{ asset('images/Sports-Handicappers2.png') }}" alt="Sportshandicapper" class="auth-logo">

@if(session('status'))
{{-- Email sent state --}}
<div style="text-align:center;">
    <div class="auth-icon-circle success" style="margin:0 auto 20px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"/><path d="M22 6l-10 7L2 6"/></svg>
    </div>
    <h1 class="auth-heading">Check Your Email</h1>
    <p class="auth-subtext">
        We sent a password reset link to<br>
        <strong style="color:#fff;">{{ old('email', request('email')) }}</strong>
    </p>

    <div class="auth-resend-note">
        <strong>Didn't receive it?</strong>
        Check your spam or junk folder. The link expires in 60 minutes.
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="hidden" name="email" value="{{ old('email', request('email')) }}">
        <button type="submit" class="auth-submit-outline">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
            Resend Reset Link
        </button>
    </form>
</div>

@else
{{-- Normal state --}}
<div class="auth-icon-circle">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/>
    </svg>
</div>

<div class="auth-eyebrow">Account Recovery</div>
<h1 class="auth-heading">Forgot your password?</h1>
<p class="auth-subtext">No worries — enter your email address and we'll send you a link to reset it right away.</p>

@if($errors->any())
<div class="auth-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="field-wrap">
        <label class="field-label" for="email">Email Address</label>
        <div class="field-inner">
            <input class="field-input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" autocomplete="email" required autofocus>
        </div>
    </div>

    <button type="submit" class="auth-submit">
        Send Reset Link
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </button>
</form>
@endif

<div class="auth-switch" style="margin-top:16px;">
    Remember your password? <a href="{{ route('login') }}">Back to sign in</a>
</div>
@endsection

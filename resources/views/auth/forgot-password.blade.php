@extends('layouts.auth')
@section('title', 'Forgot Password - INSPIN')

@section('content')

@if(session('status'))
{{-- Email sent state --}}
<div style="text-align:center;padding:8px 0;">
    <div style="width:64px;height:64px;background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.25);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 20px;">📧</div>
    <h1 style="color:#fff;font-size:1.4rem;font-weight:800;margin-bottom:8px;">Check Your Email</h1>
    <p style="color:rgba(255,255,255,.4);font-size:13.5px;line-height:1.7;margin-bottom:20px;">
        We sent a password reset link to<br>
        <strong style="color:#fff;">{{ old('email', request('email')) }}</strong>
    </p>
    <div style="background:rgba(253,181,21,.06);border:1px solid rgba(253,181,21,.15);border-radius:10px;padding:14px;margin-bottom:20px;font-size:12.5px;color:rgba(255,255,255,.4);text-align:left;">
        <strong style="color:#FDB515;display:block;margin-bottom:4px;">📬 Didn't receive it?</strong>
        Check your <strong style="color:#fff;">spam or junk folder</strong>. The link expires in 60 minutes.
    </div>

    {{-- Resend form --}}
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="hidden" name="email" value="{{ old('email', request('email')) }}">
        <button type="submit" class="btn-secondary" style="margin-bottom:12px;">
            ↺ &nbsp; Resend Reset Link
        </button>
    </form>
</div>

@else
{{-- Normal state --}}
<div class="auth-form-header">
    <div class="auth-icon">
        <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/>
        </svg>
    </div>
    <h1>Forgot Password?</h1>
    <p>No worries — enter your email address and we'll send you a link to reset your password right away.</p>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <svg style="flex-shrink:0;width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
    </div>
    <button type="submit" class="btn-submit">Send Reset Link →</button>
</form>

@endif

<div class="auth-footer" style="margin-top:18px;">
    Remember your password? <a href="{{ route('home') }}">Back to sign in</a>
</div>
@endsection

@extends('layouts.public')
@section('title', 'Verify Your Email - INSPIN')

@section('content')
<div style="min-height:60vh;display:flex;align-items:center;justify-content:center;padding:40px 20px;">
    <div style="max-width:480px;width:100%;background:#161616;border:1px solid rgba(255,255,255,.08);border-radius:16px;padding:40px;text-align:center;">
        <div style="font-size:3rem;margin-bottom:16px;">📧</div>
        <h1 style="font-size:1.4rem;font-weight:700;color:#fff;margin-bottom:10px;">Check Your Email</h1>
        <p style="color:rgba(255,255,255,.5);font-size:14px;line-height:1.7;margin-bottom:24px;">
            We sent a verification link to <strong style="color:#fff;">{{ auth()->user()->email }}</strong>.<br>
            Click the link in that email to activate your account.
        </p>

        @if(session('success'))
        <div style="background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.2);border-radius:10px;padding:12px;margin-bottom:20px;font-size:13px;color:#00D15B;">
            ✓ {{ session('success') }}
        </div>
        @endif

        <div style="background:rgba(253,181,21,.05);border:1px solid rgba(253,181,21,.15);border-radius:10px;padding:16px;margin-bottom:24px;font-size:13px;color:rgba(255,255,255,.5);text-align:left;">
            <strong style="color:#FDB515;display:block;margin-bottom:6px;">Didn't receive it?</strong>
            Check your spam/junk folder first. If it's not there, click the button below to resend.
        </div>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" style="width:100%;padding:13px;background:var(--gold,#FDB515);color:#000;border:none;border-radius:50px;font-weight:700;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top:14px;">
            @csrf
            <button type="submit" style="background:none;border:none;color:rgba(255,255,255,.35);font-size:13px;cursor:pointer;font-family:'Inter',sans-serif;">
                Use a different account → Logout
            </button>
        </form>
    </div>
</div>
@endsection

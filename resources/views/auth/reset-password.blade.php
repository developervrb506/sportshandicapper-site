@extends('layouts.auth')
@section('title', 'Reset Password | Sportshandicapper')

@section('content')

@if(session('status') === 'passwords.reset')
{{-- Success state --}}
<div style="text-align:center;padding:8px 0;">
    <div style="width:64px;height:64px;background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.25);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 20px;">✅</div>
    <h1 style="color:#fff;font-size:1.4rem;font-weight:800;margin-bottom:8px;">Password Changed!</h1>
    <p style="color:rgba(255,255,255,.4);font-size:13.5px;line-height:1.7;margin-bottom:24px;">
        Your password has been updated successfully.<br>You can now log in with your new password.
    </p>
    <a href="{{ route('home') }}" class="btn-submit" style="display:block;text-align:center;text-decoration:none;">
        Go to Login →
    </a>
</div>

@else

@if($errors->any())
<div class="alert alert-danger">
    <svg style="flex-shrink:0;width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ $errors->first() }}
</div>
@endif

<div class="auth-form-header">
    <div class="auth-icon">
        <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
        </svg>
    </div>
    <h1>Set New Password</h1>
    <p>Choose a strong password you haven't used before. Minimum 8 characters.</p>
</div>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" readonly
               style="cursor:not-allowed;opacity:.6;background:rgba(255,255,255,.03);" required>
        <div style="font-size:11px;color:rgba(255,255,255,.25);margin-top:4px;">This is the email linked to your account.</div>
    </div>

    <div class="form-group">
        <label for="password">New Password</label>
        <div class="pw-wrap">
            <input type="password" id="password" name="password" placeholder="Minimum 8 characters" required minlength="8">
            <button type="button" class="pw-toggle" onclick="togglePw('password', this)" title="Show password">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
    </div>

    <div class="form-group" style="margin-bottom:24px;">
        <label for="password_confirmation">Confirm New Password</label>
        <div class="pw-wrap">
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your new password" required minlength="8">
            <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)" title="Show password">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
    </div>

    <button type="submit" class="btn-submit">Update Password</button>
</form>

@endif

<div class="auth-footer" style="margin-top:18px;">
    Remember your password? <a href="{{ route('home') }}">Back to sign in</a>
</div>

<script>
function togglePw(id, btn) {
    var el = document.getElementById(id);
    var isHidden = el.type === 'password';
    el.type = isHidden ? 'text' : 'password';
    btn.style.color = isHidden ? '#FDB515' : 'rgba(255,255,255,.3)';
}
</script>
@endsection

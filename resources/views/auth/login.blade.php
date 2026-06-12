@extends('layouts.auth')
@section('title', 'Sign In | Sportshandicapper')

@section('content')

<img src="{{ asset('images/logo01.svg') }}" alt="Sportshandicapper" class="auth-logo">

<div class="auth-eyebrow">Member Access</div>
<h1 class="auth-heading">Sign in to your account</h1>
<p class="auth-subtext">Access today's board and your tracked bankroll.</p>

{{-- Tab switcher --}}
<div class="auth-tabs">
    <span class="auth-tab active">Log In</span>
    <a href="{{ route('register') }}" class="auth-tab inactive">Join</a>
</div>

@if ($errors->any())
<div class="auth-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('login') }}" id="loginForm">
    @csrf

    <div class="field-wrap">
        <label class="field-label" for="email">Email</label>
        <div class="field-inner">
            <input class="field-input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" autocomplete="email" required autofocus>
        </div>
    </div>

    <div class="field-wrap">
        <label class="field-label" for="password">Password</label>
        <div class="field-inner">
            <input class="field-input" type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
            <div class="field-trailing">
                <button type="button" class="pw-toggle" onclick="togglePw('password',this)" tabindex="-1" aria-label="Show password">
                    <svg id="eye-login" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="field-options">
        <label class="check-label" onclick="toggleCheck('remember','rememberBox')">
            <span class="check-box checked" id="rememberBox">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <input type="checkbox" name="remember" id="remember" checked>
            Remember me
        </label>
        <a href="{{ route('password.request') }}">Forgot password?</a>
    </div>

    <button type="submit" class="auth-submit">
        Log In
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </button>
</form>

<div class="auth-switch" style="margin-top:16px;">
    No account? <a href="{{ route('register') }}">Join now</a>
</div>

<script>
function togglePw(id, btn) {
    var inp = document.getElementById(id);
    var show = inp.type === 'text';
    inp.type = show ? 'password' : 'text';
    btn.querySelector('svg').innerHTML = show
        ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
        : '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19M1 1l22 22"/>';
}
function toggleCheck(inputId, boxId) {
    var inp = document.getElementById(inputId);
    var box = document.getElementById(boxId);
    inp.checked = !inp.checked;
    if (inp.checked) {
        box.classList.add('checked');
        box.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>';
    } else {
        box.classList.remove('checked');
        box.innerHTML = '';
    }
}
</script>
@endsection

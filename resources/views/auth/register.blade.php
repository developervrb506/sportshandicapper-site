@extends('layouts.auth')
@section('title', 'Create Account | Sportshandicapper')

@section('content')

<img src="{{ asset('images/Sports-Handicappers2.png') }}" alt="Sportshandicapper" class="auth-logo">

<div class="auth-eyebrow">Join the Edge</div>
<h1 class="auth-heading">Create your account</h1>
<p class="auth-subtext">Start a free trial. Cancel anytime.</p>

{{-- Tab switcher --}}
<div class="auth-tabs">
    <a href="{{ route('login') }}" class="auth-tab inactive">Log In</a>
    <span class="auth-tab active">Join</span>
</div>

@if ($errors->any())
<div class="auth-error">
    <ul class="auth-error-list">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('register') }}" id="registerForm">
    @csrf

    <div class="field-wrap">
        <label class="field-label" for="name">Name</label>
        <div class="field-inner">
            <input class="field-input" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Full name" autocomplete="name" required autofocus>
        </div>
    </div>

    <div class="field-wrap">
        <label class="field-label" for="email">Email</label>
        <div class="field-inner">
            <input class="field-input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" autocomplete="email" required>
        </div>
    </div>

    <div class="field-wrap">
        <label class="field-label" for="password">Password</label>
        <div class="field-inner">
            <input class="field-input" type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password" required minlength="8">
            <div class="field-trailing">
                <button type="button" class="pw-toggle" onclick="togglePw('password',this)" tabindex="-1" aria-label="Show password">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="field-wrap">
        <label class="field-label" for="password_confirmation">Confirm Password</label>
        <div class="field-inner">
            <input class="field-input" type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" autocomplete="new-password" required minlength="8">
            <div class="field-trailing">
                <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation',this)" tabindex="-1" aria-label="Show password">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>
    </div>

    <label class="check-label" onclick="toggleCheck('terms','termsBox',this)" style="margin-bottom:4px;">
        <span class="check-box" id="termsBox"></span>
        <input type="checkbox" name="terms" id="terms" required>
        <span>I agree to the <a href="{{ route('terms') }}" target="_blank" style="color:#22D3EE;text-decoration:none;font-weight:600;">Terms</a> and <a href="{{ route('privacy') }}" target="_blank" style="color:#22D3EE;text-decoration:none;font-weight:600;">Privacy Policy</a>.</span>
    </label>

    <button type="submit" class="auth-submit" id="submitBtn" disabled>
        Create Account
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </button>
</form>

<div class="auth-switch" style="margin-top:16px;">
    Already a member? <a href="{{ route('login') }}">Log in</a>
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
    var btn = document.getElementById('submitBtn');
    if (inp.checked) {
        box.classList.add('checked');
        box.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>';
        if (btn) btn.disabled = false;
    } else {
        box.classList.remove('checked');
        box.innerHTML = '';
        if (btn) btn.disabled = true;
    }
}
</script>
@endsection

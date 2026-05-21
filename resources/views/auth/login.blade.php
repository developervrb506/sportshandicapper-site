@extends('layouts.auth')

@section('title', 'Sign In - INSPIN')

@section('content')
<div class="auth-form-header">
    <div class="auth-icon">
        <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
        </svg>
    </div>
    <h1>Welcome back</h1>
    <p>Sign in to access your picks, packages, and account.</p>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <svg style="flex-shrink:0;width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <div class="form-options">
        <label>
            <input type="checkbox" id="remember" name="remember">
            Remember me
        </label>
        <a href="{{ route('password.request') }}">Forgot password?</a>
    </div>
    <button type="submit" class="btn-submit">Sign In</button>
</form>

<div class="auth-footer">
    Don't have an account? <a href="{{ route('register') }}">Create one now</a>
</div>
@endsection

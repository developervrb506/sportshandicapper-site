@extends('admin.layouts.admin')
@section('title', 'Edit User - INSPIN Admin')
@section('page-title', 'Edit User')

@section('content')
<div style="max-width:600px;">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <h2>{{ $user->name }}</h2>
                <span style="font-size:13px;color:#64748b;">Joined {{ $user->created_at->format('M d, Y') }}</span>
            </div>
            <div class="card-body">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Full Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-0000">
                    </div>
                    <div class="form-group">
                        <label>Role <span class="required">*</span></label>
                        <select name="role" class="form-control">
                            @foreach(['free','member','vip','admin'] as $r)
                                <option value="{{ $r }}" {{ old('role', $user->role) === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                            @endforeach
                        </select>
                        @error('role')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group full">
                        <label>New Password <span class="form-hint" style="font-weight:400;">(leave blank to keep current)</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 8 characters">
                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                Save Changes
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection

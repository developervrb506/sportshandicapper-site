@extends('admin.layouts.admin')
@section('title', 'Users - INSPIN Admin')
@section('page-title', 'Users')

@section('content')
<div class="page-header">
    <h1>Users <span style="font-size:14px;font-weight:500;color:#64748b;margin-left:8px;">{{ $users->total() }} total</span></h1>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="search-bar">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search name or email…">
            <select name="role" class="form-control" style="width:auto;">
                <option value="">All Roles</option>
                @foreach(['free','member','vip','admin'] as $r)
                    <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-ghost">Search</button>
            @if($search || request('role'))<a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Clear</a>@endif
        </form>
    </div>

    <div class="table-wrap">
        @if($users->count())
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Joined</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                @php
                    $roleClass = match($user->role) {
                        'admin'  => 'badge-danger',
                        'vip'    => 'badge-purple',
                        'member' => 'badge-info',
                        default  => 'badge-neutral',
                    };
                @endphp
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:32px;height:32px;border-radius:50%;background:#4f46e5;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;flex-shrink:0;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                            <div style="font-weight:600;font-size:14px;">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td style="font-size:13px;color:#475569;">{{ $user->email }}</td>
                    <td><span class="badge {{ $roleClass }}">{{ ucfirst($user->role) }}</span></td>
                    <td style="font-size:13px;color:#64748b;">{{ $user->phone ?? '—' }}</td>
                    <td style="font-size:13px;color:#64748b;">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="td-actions" style="justify-content:flex-end;">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-ghost btn-sm">Edit</a>
                            @if(auth()->id() !== $user->id)
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete user {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <h3>No users found</h3>
            <p>{{ $search ? 'Try a different search.' : 'Users will appear here after registration.' }}</p>
        </div>
        @endif
    </div>

    @if($users->hasPages())
    <div class="card-body" style="padding-top:0;">
        {{ $users->appends(request()->query())->links('vendor.pagination.simple-bootstrap-4') }}
    </div>
    @endif
</div>
@endsection

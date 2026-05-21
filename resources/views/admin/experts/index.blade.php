@extends('admin.layouts.admin')
@section('title', 'Experts - INSPIN Admin')
@section('page-title', 'Experts')

@section('content')
<div class="page-header">
    <h1>Experts</h1>
    <a href="{{ route('admin.experts.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        New Expert
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="search-bar">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search name or specialty…">
            <button type="submit" class="btn btn-ghost">Search</button>
            @if($search)<a href="{{ route('admin.experts.index') }}" class="btn btn-ghost">Clear</a>@endif
        </form>
    </div>

    <div class="table-wrap">
        @if($experts->count())
        <table>
            <thead>
                <tr>
                    <th>Expert</th>
                    <th>Specialty</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($experts as $expert)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            @if($expert->avatar)
                                <img src="{{ asset('storage/'.$expert->avatar) }}" style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:1px solid #e2e8f0;">
                            @else
                                <div style="width:38px;height:38px;border-radius:50%;background:#4f46e5;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;">{{ strtoupper(substr($expert->name,0,1)) }}</div>
                            @endif
                            <div>
                                <div style="font-weight:600;font-size:14px;">{{ $expert->name }}</div>
                                @if($expert->bio)<div style="font-size:12px;color:#94a3b8;">{{ Str::limit($expert->bio, 60) }}</div>@endif
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px;color:#475569;">{{ $expert->specialty ?? '—' }}</td>
                    <td><span class="badge {{ $expert->is_active ? 'badge-success' : 'badge-neutral' }}">{{ $expert->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <div class="td-actions" style="justify-content:flex-end;">
                            <a href="{{ route('admin.experts.edit', $expert) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.experts.destroy', $expert) }}" onsubmit="return confirm('Delete expert {{ $expert->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <h3>No experts found</h3>
            <p>{{ $search ? 'Try a different search.' : 'Add your first expert analyst.' }}</p>
        </div>
        @endif
    </div>

    @if($experts->hasPages())
    <div class="card-body" style="padding-top:0;">
        {{ $experts->appends(request()->query())->links('vendor.pagination.simple-bootstrap-4') }}
    </div>
    @endif
</div>
@endsection

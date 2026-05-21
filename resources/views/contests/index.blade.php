@extends('admin.layouts.admin')
@section('title', 'Contests - INSPIN Admin')
@section('page-title', 'Contests')

@section('content')
<div class="page-header">
    <h1>Contests</h1>
    <a href="{{ route('contests.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        New Contest
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="search-bar">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search contests…">
            <select name="status" class="form-control" style="width:auto;">
                <option value="">All Statuses</option>
                @foreach(['draft','active','paused','inactive','completed'] as $s)
                    <option value="{{ $s }}" {{ ($statusFilter ?? '') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-ghost">Filter</button>
            @if(($search ?? '') || ($statusFilter ?? ''))<a href="{{ route('contests.index') }}" class="btn btn-ghost">Clear</a>@endif
        </form>
    </div>

    <div class="table-wrap">
        @if($contests->count())
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Starts</th>
                    <th>Ends</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contests as $contest)
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:14px;">{{ $contest->name }}</div>
                        @if($contest->description)<div style="font-size:12px;color:#94a3b8;">{{ Str::limit($contest->description, 60) }}</div>@endif
                    </td>
                    <td style="font-size:13px;color:#475569;">{{ $contest->contest_type ?? '—' }}</td>
                    <td>
                        @php
                            $statusClass = match($contest->status) {
                                'active'    => 'badge-success',
                                'draft'     => 'badge-neutral',
                                'paused'    => 'badge-warning',
                                'completed' => 'badge-info',
                                default     => 'badge-neutral',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($contest->status) }}</span>
                    </td>
                    <td style="font-size:13px;color:#475569;">{{ $contest->starts_at ? \Carbon\Carbon::parse($contest->starts_at)->format('M d, Y') : '—' }}</td>
                    <td style="font-size:13px;color:#475569;">{{ $contest->ends_at ? \Carbon\Carbon::parse($contest->ends_at)->format('M d, Y') : '—' }}</td>
                    <td>
                        <div class="td-actions" style="justify-content:flex-end;">
                            <a href="{{ route('contests.show', $contest) }}" class="btn btn-ghost btn-sm">View</a>
                            <a href="{{ route('contests.edit', $contest) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('contests.destroy', $contest) }}" onsubmit="return confirm('Delete this contest?')">
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
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            <h3>No contests found</h3>
            <p>{{ ($search || $statusFilter) ? 'Try different filters.' : 'Create your first contest.' }}</p>
        </div>
        @endif
    </div>

    @if($contests->hasPages())
    <div class="card-body" style="padding-top:0;">
        {{ $contests->appends(request()->query())->links('vendor.pagination.simple-bootstrap-4') }}
    </div>
    @endif
</div>
@endsection

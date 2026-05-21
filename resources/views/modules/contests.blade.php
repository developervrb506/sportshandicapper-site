@extends('admin.layouts.admin')
@section('title', 'Contests Module - INSPIN Admin')
@section('page-title', 'Contests Module')

@section('content')
<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="search-bar">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search name or type…">
            <button type="submit" class="btn btn-ghost">Search</button>
            @if($search)<a href="{{ route('modules.contests') }}" class="btn btn-ghost">Clear</a>@endif
        </form>
    </div>

    <div class="table-wrap">
        @if($contests->count())
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Dates</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contests as $contest)
                <tr>
                    <td style="color:#94a3b8;font-size:13px;">{{ $contest->id }}</td>
                    <td>
                        <div style="font-weight:600;font-size:14px;">{{ $contest->name }}</div>
                        @if($contest->description)<div style="font-size:12px;color:#94a3b8;">{{ Str::limit($contest->description, 50) }}</div>@endif
                    </td>
                    <td style="font-size:13px;color:#475569;">{{ $contest->contest_type ?? '—' }}</td>
                    <td>
                        <form method="POST" action="{{ route('modules.contests.status', $contest) }}" style="display:inline-flex;align-items:center;gap:6px;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="q" value="{{ $search }}">
                            <input type="hidden" name="page" value="{{ $contests->currentPage() }}">
                            <select name="status" class="form-control" style="padding:4px 8px;font-size:12px;height:auto;" onchange="this.form.submit()">
                                @foreach(['draft','active','paused','inactive','completed'] as $s)
                                    <option value="{{ $s }}" {{ $contest->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td style="font-size:12px;color:#64748b;">
                        @if($contest->starts_at){{ \Carbon\Carbon::parse($contest->starts_at)->format('M d') }}@endif
                        @if($contest->starts_at && $contest->ends_at) – @endif
                        @if($contest->ends_at){{ \Carbon\Carbon::parse($contest->ends_at)->format('M d, Y') }}@endif
                        @if(!$contest->starts_at && !$contest->ends_at)—@endif
                    </td>
                    <td>
                        <div class="td-actions" style="justify-content:flex-end;">
                            <a href="{{ route('contests.show', $contest) }}" class="btn btn-ghost btn-sm">View</a>
                            <a href="{{ route('contests.edit', $contest) }}" class="btn btn-ghost btn-sm">Edit</a>
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
            <p>{{ $search ? 'Try a different search.' : 'No contests imported yet.' }}</p>
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

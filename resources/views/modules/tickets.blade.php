@extends('admin.layouts.admin')
@section('title', 'Tickets Module - INSPIN Admin')
@section('page-title', 'Tickets Module')

@section('content')
<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="search-bar">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search subject or email…">
            <button type="submit" class="btn btn-ghost">Search</button>
            @if($search)<a href="{{ route('modules.tickets') }}" class="btn btn-ghost">Clear</a>@endif
        </form>
    </div>

    <div class="table-wrap">
        @if($tickets->count())
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr>
                    <td style="color:#94a3b8;font-size:13px;">{{ $ticket->id }}</td>
                    <td>
                        <div style="font-weight:600;font-size:14px;">{{ Str::limit($ticket->subject, 50) }}</div>
                        <div style="font-size:12px;color:#94a3b8;">{{ $ticket->customer_name }}</div>
                    </td>
                    <td style="font-size:13px;color:#475569;">{{ $ticket->customer_email }}</td>
                    <td>
                        <form method="POST" action="{{ route('modules.tickets.status', $ticket) }}" style="display:inline-flex;align-items:center;gap:6px;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="q" value="{{ $search }}">
                            <input type="hidden" name="page" value="{{ $tickets->currentPage() }}">
                            <select name="status" class="form-control" style="padding:4px 8px;font-size:12px;height:auto;" onchange="this.form.submit()">
                                @foreach(['open','pending','resolved','closed'] as $s)
                                    <option value="{{ $s }}" {{ $ticket->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td style="font-size:13px;color:#475569;">{{ $ticket->priority }}/5</td>
                    <td>
                        <div class="td-actions" style="justify-content:flex-end;">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-ghost btn-sm">View</a>
                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-ghost btn-sm">Edit</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            <h3>No tickets found</h3>
            <p>{{ $search ? 'Try a different search.' : 'No tickets imported yet.' }}</p>
        </div>
        @endif
    </div>

    @if($tickets->hasPages())
    <div class="card-body" style="padding-top:0;">
        {{ $tickets->appends(request()->query())->links('vendor.pagination.simple-bootstrap-4') }}
    </div>
    @endif
</div>
@endsection

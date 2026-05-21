@extends('admin.layouts.admin')
@section('title', 'Support Tickets - INSPIN Admin')
@section('page-title', 'Support Tickets')

@section('content')
<div class="page-header">
    <h1>Support Tickets</h1>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        New Ticket
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="search-bar">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search customer, subject…">
            <select name="status" class="form-control" style="width:auto;">
                <option value="">All Statuses</option>
                @foreach(['open','pending','resolved','closed'] as $s)
                    <option value="{{ $s }}" {{ ($statusFilter ?? '') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-ghost">Search</button>
            @if($search || $statusFilter)<a href="{{ route('tickets.index') }}" class="btn btn-ghost">Clear</a>@endif
        </form>
    </div>
    <div class="table-wrap">
        @if($tickets->count())
        <table>
            <thead><tr>
                <th>Customer</th><th>Subject</th><th>Status</th><th>Priority</th><th>Created</th><th style="text-align:right;">Actions</th>
            </tr></thead>
            <tbody>
                @foreach($tickets as $ticket)
                @php $statusClass = match($ticket->status) { 'open'=>'badge-danger','pending'=>'badge-warning','resolved'=>'badge-success',default=>'badge-neutral' }; @endphp
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px;">{{ $ticket->customer_name }}</div>
                        <div style="font-size:12px;color:#94a3b8;">{{ $ticket->customer_email }}</div>
                    </td>
                    <td style="font-size:13px;">{{ Str::limit($ticket->subject, 50) }}</td>
                    <td><span class="badge {{ $statusClass }}">{{ ucfirst($ticket->status) }}</span></td>
                    <td style="font-weight:700;font-size:14px;">P{{ $ticket->priority }}</td>
                    <td style="font-size:13px;color:#64748b;">{{ $ticket->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="td-actions" style="justify-content:flex-end;">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-ghost btn-sm">View</a>
                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" onsubmit="return confirm('Delete this ticket?')">
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
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            <h3>No tickets found</h3><p>No support tickets yet.</p>
        </div>
        @endif
    </div>
    @if($tickets->hasPages())
    <div class="card-body" style="padding-top:0;">{{ $tickets->appends(request()->query())->links('vendor.pagination.simple-bootstrap-4') }}</div>
    @endif
</div>
@endsection

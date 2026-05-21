@extends('admin.layouts.admin')
@section('title', 'Ticket #' . $ticket->id . ' - INSPIN Admin')
@section('page-title', 'Ticket #' . $ticket->id)

@section('content')
<div style="max-width:800px;">
    <div class="page-header">
        <div style="display:flex;align-items:center;gap:12px;">
            <span class="badge badge-{{ $ticket->status === 'open' ? 'info' : ($ticket->status === 'pending' ? 'warning' : ($ticket->status === 'resolved' ? 'success' : 'neutral')) }}">{{ ucfirst($ticket->status) }}</span>
            <span style="font-size:13px;color:#64748b;">Priority: {{ $ticket->priority }}/5</span>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Back to List</a>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><h2>Customer Info</h2></div>
        <div class="card-body">
            <div class="form-grid-2">
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Name</div>
                    <div style="font-size:14px;">{{ $ticket->customer_name }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Email</div>
                    <div style="font-size:14px;">{{ $ticket->customer_email }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Source System</div>
                    <div style="font-size:14px;">{{ $ticket->source_system ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">External ID</div>
                    <div style="font-size:14px;">{{ $ticket->external_id ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Created</div>
                    <div style="font-size:14px;">{{ $ticket->created_at?->format('M d, Y H:i') ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Last Updated</div>
                    <div style="font-size:14px;">{{ $ticket->updated_at?->format('M d, Y H:i') ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><h2>{{ $ticket->subject }}</h2></div>
        <div class="card-body">
            <div style="white-space:pre-wrap;font-size:14px;line-height:1.7;color:#334155;">{{ $ticket->message }}</div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-primary">Edit Ticket</a>
        <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" onsubmit="return confirm('Delete this ticket? This cannot be undone.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Back to List</a>
    </div>
</div>
@endsection

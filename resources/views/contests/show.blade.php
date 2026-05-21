@extends('admin.layouts.admin')
@section('title', $contest->name . ' - INSPIN Admin')
@section('page-title', $contest->name)

@section('content')
<div style="max-width:800px;">
    <div class="page-header">
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
        <div style="display:flex;gap:8px;">
            <a href="{{ route('contests.edit', $contest) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('contests.index') }}" class="btn btn-ghost">Back to List</a>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><h2>Contest Info</h2></div>
        <div class="card-body">
            <div class="form-grid-2" style="margin-bottom:16px;">
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Type</div>
                    <div style="font-size:14px;">{{ $contest->contest_type ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Status</div>
                    <span class="badge {{ $statusClass }}">{{ ucfirst($contest->status) }}</span>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Starts At</div>
                    <div style="font-size:14px;">{{ $contest->starts_at ? \Carbon\Carbon::parse($contest->starts_at)->format('M d, Y g:i A') : '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Ends At</div>
                    <div style="font-size:14px;">{{ $contest->ends_at ? \Carbon\Carbon::parse($contest->ends_at)->format('M d, Y g:i A') : '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Created</div>
                    <div style="font-size:14px;">{{ $contest->created_at?->format('M d, Y') ?? '—' }}</div>
                </div>
            </div>
            @if($contest->description)
            <div>
                <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:8px;">Description</div>
                <div style="font-size:14px;line-height:1.7;color:#334155;white-space:pre-wrap;">{{ $contest->description }}</div>
            </div>
            @endif
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('contests.edit', $contest) }}" class="btn btn-primary">Edit Contest</a>
        <form method="POST" action="{{ route('contests.destroy', $contest) }}" onsubmit="return confirm('Delete this contest? This cannot be undone.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('contests.index') }}" class="btn btn-ghost">Back to List</a>
    </div>
</div>
@endsection

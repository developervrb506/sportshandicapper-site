@extends('admin.layouts.admin')
@section('title', 'New Ticket - INSPIN Admin')
@section('page-title', 'New Ticket')

@section('content')
<div style="max-width:640px;">
    <form method="POST" action="{{ route('tickets.store') }}">
        @csrf

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Ticket Details</h2></div>
            <div class="card-body">
                <div class="form-grid-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label>Customer Name <span class="required">*</span></label>
                        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" placeholder="Full name">
                        @error('customer_name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Customer Email <span class="required">*</span></label>
                        <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" placeholder="email@example.com">
                        @error('customer_email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Subject <span class="required">*</span></label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="Brief description of the issue">
                    @error('subject')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Message <span class="required">*</span></label>
                    <textarea name="message" class="form-control" rows="6" placeholder="Detailed description…">{{ old('message') }}</textarea>
                    @error('message')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grid-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            @foreach(['open','pending','resolved','closed'] as $s)
                                <option value="{{ $s }}" {{ old('status','open') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Priority (1–5)</label>
                        <input type="number" name="priority" min="1" max="5" class="form-control" value="{{ old('priority', 3) }}">
                        <div class="form-hint">1 = lowest, 5 = highest</div>
                    </div>
                    <div class="form-group">
                        <label>Source System</label>
                        <input type="text" name="source_system" class="form-control" value="{{ old('source_system') }}" placeholder="e.g. email, chat">
                    </div>
                    <div class="form-group">
                        <label>External ID</label>
                        <input type="text" name="external_id" class="form-control" value="{{ old('external_id') }}" placeholder="Optional reference ID">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                Create Ticket
            </button>
            <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection

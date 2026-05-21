@extends('admin.layouts.admin')
@section('title', 'Edit Contest - INSPIN Admin')
@section('page-title', 'Edit Contest')

@section('content')
<div style="max-width:640px;">
    <form method="POST" action="{{ route('contests.update', $contest) }}">
        @csrf @method('PUT')

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <h2>{{ $contest->name }}</h2>
            </div>
            <div class="card-body">
                <div class="form-grid-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label>Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $contest->name) }}">
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Contest Type</label>
                        <input type="text" name="contest_type" class="form-control" value="{{ old('contest_type', $contest->contest_type) }}" placeholder="e.g. pick contest, bracket">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $contest->description) }}</textarea>
                </div>
                <div class="form-grid-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label>Starts At</label>
                        <input type="datetime-local" name="starts_at" class="form-control" value="{{ old('starts_at', $contest->starts_at ? \Carbon\Carbon::parse($contest->starts_at)->format('Y-m-d\TH:i') : '') }}">
                        @error('starts_at')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Ends At</label>
                        <input type="datetime-local" name="ends_at" class="form-control" value="{{ old('ends_at', $contest->ends_at ? \Carbon\Carbon::parse($contest->ends_at)->format('Y-m-d\TH:i') : '') }}">
                        @error('ends_at')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            @foreach(['draft','active','paused','inactive','completed'] as $s)
                                <option value="{{ $s }}" {{ old('status', $contest->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                Update Contest
            </button>
            <a href="{{ route('contests.show', $contest) }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection

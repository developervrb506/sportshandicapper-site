@extends('admin.layouts.admin')

@section('title', 'Create Pick - INSPIN Admin')
@section('page-title', 'Create Pick')
@section('breadcrumb')
    <a href="{{ route('modules.tips.index') }}">Picks</a>
    <span class="sep">/</span>
    <span>Create</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>New Pick</h2>
        <a href="{{ route('modules.tips.index') }}" class="btn btn-ghost">Back to Picks</a>
    </div>
    <form method="POST" action="{{ route('modules.tips.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="tip_title">Pick Title *</label>
                <input type="text" id="tip_title" name="tip_title" value="{{ old('tip_title') }}" placeholder="e.g., Chiefs -3.5" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="matchup">Matchup</label>
                    <input type="text" id="matchup" name="matchup" value="{{ old('matchup') }}" placeholder="e.g., Chiefs vs Bills">
                </div>
                <div class="form-group">
                    <label for="group_name">Sport / League</label>
                    <select id="group_name" name="group_name">
                        <option value="">Select</option>
                        @foreach(['NFL', 'NCAAF', 'NBA', 'NCAAB', 'NHL', 'MLB'] as $sport)
                            <option value="{{ $sport }}" {{ old('group_name') === $sport ? 'selected' : '' }}>{{ $sport }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="expert_name">Expert / Handicapper</label>
                    <input type="text" id="expert_name" name="expert_name" value="{{ old('expert_name') }}" placeholder="e.g., Sam Profeta">
                </div>
                <div class="form-group">
                    <label for="confidence">Confidence (1-5)</label>
                    <select id="confidence" name="confidence">
                        <option value="">None</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('confidence') == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'Star' : 'Stars' }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="tip_text">Pick Details</label>
                <textarea id="tip_text" name="tip_text" rows="3" placeholder="Spread, total, moneyline details...">{{ old('tip_text') }}</textarea>
            </div>

            <div class="form-group">
                <label for="analysis">Analysis / Reasoning</label>
                <textarea id="analysis" name="analysis" rows="4" placeholder="Why this pick...">{{ old('analysis') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="result">Result</label>
                    <select id="result" name="result">
                        <option value="">Pending</option>
                        <option value="win" {{ old('result') === 'win' ? 'selected' : '' }}>Win</option>
                        <option value="loss" {{ old('result') === 'loss' ? 'selected' : '' }}>Loss</option>
                        <option value="push" {{ old('result') === 'push' ? 'selected' : '' }}>Push</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="display_date">Display Date</label>
                    <input type="date" id="display_date" name="display_date" value="{{ old('display_date') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="display_yearly" style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                        <input type="checkbox" id="display_yearly" name="display_yearly" value="1" {{ old('display_yearly') ? 'checked' : '' }} style="width:auto;padding:0;">
                        Display Yearly
                    </label>
                </div>
                <div class="form-group">
                    <label for="is_active" style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width:auto;padding:0;">
                        Active (show on homepage)
                    </label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-actions" style="margin-top:0;padding-top:0;border-top:none;">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                    Save Pick
                </button>
                <a href="{{ route('modules.tips.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

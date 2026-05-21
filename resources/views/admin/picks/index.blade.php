@extends('admin.layouts.admin')
@section('title', 'Picks - INSPIN Admin')
@section('page-title', 'Picks')

@section('content')
<div class="page-header">
    <h1>Picks <span style="font-size:14px;font-weight:500;color:#64748b;margin-left:8px;">{{ $picks->total() }} total</span></h1>
    <a href="{{ route('admin.picks.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        New Pick
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="search-bar">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search teams, pick, expert…">
            <select name="sport" class="form-control" style="width:auto;">
                <option value="">All Sports</option>
                @foreach(['NFL','NCAAF','NBA','NCAAB','MLB','NHL'] as $s)
                    <option value="{{ $s }}" {{ request('sport') === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <select name="result" class="form-control" style="width:auto;">
                <option value="">All Results</option>
                <option value="pending" {{ request('result') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="win"     {{ request('result') === 'win'     ? 'selected' : '' }}>Win</option>
                <option value="loss"    {{ request('result') === 'loss'    ? 'selected' : '' }}>Loss</option>
                <option value="push"    {{ request('result') === 'push'    ? 'selected' : '' }}>Push</option>
            </select>
            <button type="submit" class="btn btn-ghost">Search</button>
            @if(request()->hasAny(['search','sport','result']))
                <a href="{{ route('admin.picks.index') }}" class="btn btn-ghost">Clear</a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        @if($picks->count())
        <table>
            <thead>
                <tr>
                    <th>Game</th>
                    <th>Sport</th>
                    <th>Date</th>
                    <th>Pick</th>
                    <th>Stars</th>
                    <th>Status</th>
                    <th>Result</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($picks as $pick)
                @php
                    $timeStr = $pick->game_time ? \Carbon\Carbon::parse($pick->game_time)->format('H:i:s') : '00:00:00';
                    $gameStart = \Carbon\Carbon::parse($pick->game_date->format('Y-m-d') . ' ' . $timeStr);
                    $status = $pick->result !== 'pending' ? 'GRADED' : ($gameStart->isPast() ? 'STARTED' : 'ACTIVE');
                    $statusClass = $status === 'ACTIVE' ? 'badge-success' : ($status === 'STARTED' ? 'badge-warning' : 'badge-neutral');
                @endphp
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px;">{{ $pick->team1_name }} vs {{ $pick->team2_name }}</div>
                        @if($pick->expert_name)<div style="font-size:12px;color:#94a3b8;">{{ $pick->expert_name }}</div>@endif
                    </td>
                    <td><span class="badge badge-{{ strtolower($pick->sport) }}">{{ $pick->sport }}</span></td>
                    <td style="white-space:nowrap;font-size:13px;">
                        {{ $pick->game_date->format('M d, Y') }}
                        @if($pick->game_time)<div style="font-size:11px;color:#94a3b8;">{{ \Carbon\Carbon::parse($pick->game_time)->format('g:i A') }}</div>@endif
                    </td>
                    <td style="max-width:200px;">
                        <div style="font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $pick->pick }}</div>
                        @if($pick->is_whale_exclusive)<span class="badge" style="background:#f59e0b;color:#fff;font-size:10px;">WHALE</span>@endif
                    </td>
                    <td style="color:#d97706;">{{ $pick->stars_display }}</td>
                    <td><span class="badge {{ $statusClass }}">{{ $status }}</span></td>
                    <td>
                        @if($pick->result !== 'pending')
                            <span class="badge badge-{{ $pick->result === 'win' ? 'success' : ($pick->result === 'loss' ? 'danger' : 'neutral') }}">{{ strtoupper($pick->result) }}</span>
                            @if($pick->units_result !== null)
                                <div style="font-size:11px;color:{{ $pick->result === 'win' ? '#16a34a' : '#dc2626' }};font-weight:600;">{{ $pick->result === 'win' ? '+' : '' }}{{ $pick->units_result }}u</div>
                            @endif
                        @else
                            <span style="color:#94a3b8;font-size:12px;">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="td-actions" style="justify-content:flex-end;">
                            <a href="{{ route('admin.picks.edit', $pick) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.picks.destroy', $pick) }}" onsubmit="return confirm('Delete this pick?')">
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
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            <h3>No picks found</h3>
            <p>{{ request('search') ? 'Try a different search.' : 'Create your first pick.' }}</p>
        </div>
        @endif
    </div>

    @if($picks->hasPages())
    <div class="card-body" style="padding-top:0;">
        {{ $picks->appends(request()->query())->links('vendor.pagination.simple-bootstrap-4') }}
    </div>
    @endif
</div>
@endsection

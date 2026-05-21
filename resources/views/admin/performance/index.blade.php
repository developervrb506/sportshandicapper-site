@extends('admin.layouts.admin')
@section('title', 'Performance - INSPIN Admin')
@section('page-title', 'Performance Tracking')

@section('content')

{{-- All-time summary cards --}}
<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-icon green">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <div>
            <div class="stat-value" style="color:{{ ($allTime->total_units ?? 0) >= 0 ? '#16a34a' : '#dc2626' }};">
                {{ $allTime->total_units !== null ? ($allTime->total_units >= 0 ? '+' : '') . number_format($allTime->total_units, 2) : '—' }}
            </div>
            <div class="stat-label">All-Time Units</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($allTime->wins ?? 0) }}</div>
            <div class="stat-label">All-Time Wins</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($allTime->losses ?? 0) }}</div>
            <div class="stat-label">All-Time Losses</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </div>
        <div>
            @php
                $allTimeTotal = ($allTime->wins ?? 0) + ($allTime->losses ?? 0);
                $winPct = $allTimeTotal > 0 ? round(($allTime->wins / $allTimeTotal) * 100, 1) : 0;
            @endphp
            <div class="stat-value">{{ $winPct }}%</div>
            <div class="stat-label">All-Time Win %</div>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-header"><h2>Filter Results</h2></div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.performance.index') }}">
            <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
                <div class="form-group" style="min-width:160px;">
                    <label>Sport</label>
                    <select name="sport" class="form-control">
                        <option value="">— All Sports —</option>
                        @foreach($sports as $s)
                            <option value="{{ $s }}" {{ $sport === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="min-width:160px;">
                    <label>Date From</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                </div>
                <div class="form-group" style="min-width:160px;">
                    <label>Date To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                </div>
                <div style="display:flex;gap:8px;padding-bottom:1px;">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('admin.performance.index') }}" class="btn btn-ghost">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Results table --}}
<div class="card">
    <div class="card-header">
        <h2>Performance by Sport</h2>
        @if($sport || $dateFrom || $dateTo)
            <span style="font-size:12px;color:#94a3b8;">
                Filtered
                @if($sport) · {{ $sport }} @endif
                @if($dateFrom) · from {{ $dateFrom }} @endif
                @if($dateTo) · to {{ $dateTo }} @endif
            </span>
        @endif
    </div>
    <div class="card-body" style="padding:0;">
        @if($bySport->isEmpty())
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <h3>No graded picks found</h3>
                <p>Try adjusting your filters, or grade some picks first.</p>
            </div>
        @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Sport</th>
                        <th style="text-align:center;">Picks</th>
                        <th style="text-align:center;">Wins</th>
                        <th style="text-align:center;">Losses</th>
                        <th style="text-align:center;">Pushes</th>
                        <th style="text-align:center;">Win %</th>
                        <th style="text-align:right;">Total Units</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bySport as $row)
                    @php
                        $wl = $row->wins + $row->losses;
                        $pct = $wl > 0 ? round(($row->wins / $wl) * 100, 1) : 0;
                        $unitsPositive = $row->total_units >= 0;
                    @endphp
                    <tr>
                        <td><span class="badge badge-{{ strtolower($row->sport) }}">{{ $row->sport }}</span></td>
                        <td style="text-align:center;font-weight:600;">{{ $row->total }}</td>
                        <td style="text-align:center;color:#16a34a;font-weight:600;">{{ $row->wins }}</td>
                        <td style="text-align:center;color:#dc2626;font-weight:600;">{{ $row->losses }}</td>
                        <td style="text-align:center;color:#64748b;font-weight:600;">{{ $row->pushes }}</td>
                        <td style="text-align:center;">
                            <span style="background:{{ $pct >= 55 ? '#f0fdf4' : ($pct >= 50 ? '#fffbeb' : '#fef2f2') }};color:{{ $pct >= 55 ? '#16a34a' : ($pct >= 50 ? '#d97706' : '#dc2626') }};padding:2px 8px;border-radius:4px;font-size:12px;font-weight:700;">{{ $pct }}%</span>
                        </td>
                        <td style="text-align:right;font-weight:800;font-size:1rem;color:{{ $unitsPositive ? '#16a34a' : '#dc2626' }};">
                            {{ $unitsPositive ? '+' : '' }}{{ number_format($row->total_units, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#f8fafc;border-top:2px solid #e2e8f0;">
                        <td style="font-weight:800;color:#0f172a;">TOTAL</td>
                        <td style="text-align:center;font-weight:800;">{{ $totals['total'] }}</td>
                        <td style="text-align:center;font-weight:800;color:#16a34a;">{{ $totals['wins'] }}</td>
                        <td style="text-align:center;font-weight:800;color:#dc2626;">{{ $totals['losses'] }}</td>
                        <td style="text-align:center;font-weight:800;color:#64748b;">{{ $totals['pushes'] }}</td>
                        <td style="text-align:center;">
                            @php
                                $totalWL = $totals['wins'] + $totals['losses'];
                                $totalPct = $totalWL > 0 ? round(($totals['wins'] / $totalWL) * 100, 1) : 0;
                            @endphp
                            <span style="background:{{ $totalPct >= 55 ? '#f0fdf4' : ($totalPct >= 50 ? '#fffbeb' : '#fef2f2') }};color:{{ $totalPct >= 55 ? '#16a34a' : ($totalPct >= 50 ? '#d97706' : '#dc2626') }};padding:2px 8px;border-radius:4px;font-size:12px;font-weight:700;">{{ $totalPct }}%</span>
                        </td>
                        <td style="text-align:right;font-weight:800;font-size:1.1rem;color:{{ $totals['total_units'] >= 0 ? '#16a34a' : '#dc2626' }};">
                            {{ $totals['total_units'] >= 0 ? '+' : '' }}{{ number_format($totals['total_units'], 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection

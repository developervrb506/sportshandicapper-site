@extends('admin.layouts.admin')

@section('title', 'Dashboard - INSPIN Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($stats['picks']) }}</div>
            <div class="stat-label">Total Picks</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['articles'] }}</div>
            <div class="stat-label">Articles</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['tickets'] }}</div>
            <div class="stat-label">Support Tickets</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['contests'] }}</div>
            <div class="stat-label">Contests</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon {{ ($unitsRow->total_units ?? 0) >= 0 ? 'green' : 'red' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <div>
            <div class="stat-value" style="color:{{ ($unitsRow->total_units ?? 0) >= 0 ? '#16a34a' : '#dc2626' }};">
                {{ $unitsRow && $unitsRow->total_units !== null ? (($unitsRow->total_units >= 0 ? '+' : '') . number_format($unitsRow->total_units, 2)) : '—' }}
            </div>
            <div class="stat-label">All-Time Units</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px;">
    <div class="card">
        <div class="card-header">
            <h2>Quick Actions</h2>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
            <a href="{{ route('admin.picks.index') }}" class="btn btn-primary" style="justify-content:center;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;"><path d="M12 4v16m8-8H4"/></svg>
                Manage Picks ({{ number_format($stats['picks']) }})
            </a>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-success" style="justify-content:center;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;"><path d="M12 4v16m8-8H4"/></svg>
                Manage Articles ({{ $stats['articles'] }})
            </a>
            <a href="{{ route('tickets.index') }}" class="btn btn-ghost" style="justify-content:center;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                Support Tickets ({{ $stats['tickets'] }})
            </a>
            <a href="{{ route('contests.index') }}" class="btn btn-ghost" style="justify-content:center;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                Contests ({{ $stats['contests'] }})
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost" style="justify-content:center;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Manage Users
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>System Info</h2>
        </div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:0;">
                <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #f1f5f9;">
                    <span style="color:#64748b;font-size:14px;">Database</span>
                    <span style="font-weight:600;font-size:14px;">SQLite</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #f1f5f9;">
                    <span style="color:#64748b;font-size:14px;">Framework</span>
                    <span style="font-weight:600;font-size:14px;">Laravel 9</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #f1f5f9;">
                    <span style="color:#64748b;font-size:14px;">PHP Version</span>
                    <span style="font-weight:600;font-size:14px;">{{ phpversion() }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #f1f5f9;">
                    <span style="color:#64748b;font-size:14px;">Environment</span>
                    <span style="font-weight:600;font-size:14px;">{{ config('app.env') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:12px 0;">
                    <span style="color:#64748b;font-size:14px;">Debug Mode</span>
                    <span class="badge {{ config('app.debug') ? 'badge-warning' : 'badge-success' }}">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Recent Activity</h2>
        </div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:16px;">
                <div style="display:flex;align-items:flex-start;gap:12px;">
                    <div style="width:10px;height:10px;border-radius:50%;background:#22c55e;flex-shrink:0;margin-top:5px;"></div>
                    <div>
                        <div style="font-size:14px;font-weight:600;">System Operational</div>
                        <div style="font-size:12px;color:#94a3b8;">All services running normally</div>
                    </div>
                </div>
                <div style="display:flex;align-items:flex-start;gap:12px;">
                    <div style="width:10px;height:10px;border-radius:50%;background:#3b82f6;flex-shrink:0;margin-top:5px;"></div>
                    <div>
                        <div style="font-size:14px;font-weight:600;">Data Imported</div>
                        <div style="font-size:12px;color:#94a3b8;">1,888 picks from legacy system</div>
                    </div>
                </div>
                <div style="display:flex;align-items:flex-start;gap:12px;">
                    <div style="width:10px;height:10px;border-radius:50%;background:#a855f7;flex-shrink:0;margin-top:5px;"></div>
                    <div>
                        <div style="font-size:14px;font-weight:600;">UI Updated</div>
                        <div style="font-size:12px;color:#94a3b8;">Modern admin panel deployed</div>
                    </div>
                </div>
                <div style="display:flex;align-items:flex-start;gap:12px;">
                    <div style="width:10px;height:10px;border-radius:50%;background:#f59e0b;flex-shrink:0;margin-top:5px;"></div>
                    <div>
                        <div style="font-size:14px;font-weight:600;">Auth System</div>
                        <div style="font-size:12px;color:#94a3b8;">Login, register, password reset active</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

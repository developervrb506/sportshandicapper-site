<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - INSPIN')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f1f5f9; color: #0f172a; min-height: 100vh; display: flex; }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px; min-width: 240px; background: #0f172a; min-height: 100vh;
            display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
        }
        .sidebar-logo {
            padding: 20px 20px 16px; border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-logo img { max-width: 140px; height: auto; display: block; }
        .sidebar-logo .logo-sub { color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }

        .sidebar-nav { flex: 1; padding: 12px 0; overflow-y: auto; }
        .nav-section-label { color: #475569; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; padding: 12px 20px 4px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 20px; color: #94a3b8; text-decoration: none;
            font-size: 14px; font-weight: 500; border-radius: 0; transition: all 0.15s;
            position: relative;
        }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
        .nav-item:hover { color: #fff; background: rgba(255,255,255,0.06); }
        .nav-item.active { color: #fff; background: rgba(220,38,38,0.15); }
        .nav-item.active::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
            background: #dc2626; border-radius: 0 2px 2px 0;
        }
        .nav-divider { border: none; border-top: 1px solid rgba(255,255,255,0.06); margin: 8px 0; }

        .sidebar-footer { padding: 12px 20px 16px; border-top: 1px solid rgba(255,255,255,0.08); }
        .sidebar-user { display: flex; align-items: center; gap: 10px; }
        .sidebar-avatar { width: 32px; height: 32px; border-radius: 50%; background: #dc2626; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 13px; flex-shrink: 0; }
        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-name { font-size: 13px; font-weight: 600; color: #e2e8f0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user-role { font-size: 11px; color: #64748b; text-transform: capitalize; }

        /* ── Main ── */
        .main-wrapper { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        .topbar {
            background: #fff; border-bottom: 1px solid #e2e8f0;
            padding: 0 28px; height: 60px; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 18px; font-weight: 700; color: #0f172a; }
        .topbar-actions { display: flex; align-items: center; gap: 12px; }
        .topbar-link { color: #64748b; text-decoration: none; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 5px; }
        .topbar-link:hover { color: #0f172a; }
        .topbar-link svg { width: 16px; height: 16px; }

        .main-content { padding: 28px; flex: 1; }

        /* ── Alerts ── */
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger  { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }
        .error-list { list-style: none; padding: 0; margin: 0 0 16px 0; }
        .error-list li { color: #dc2626; font-size: 13px; margin-bottom: 3px; padding-left: 14px; position: relative; }
        .error-list li::before { content: '•'; position: absolute; left: 0; }

        /* ── Cards ── */
        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .card-header h2 { font-size: 15px; font-weight: 700; color: #0f172a; }
        .card-body { padding: 20px; }

        /* ── Stats grid (dashboard) ── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon svg { width: 24px; height: 24px; }
        .stat-icon.blue   { background: #eff6ff; color: #2563eb; }
        .stat-icon.green  { background: #f0fdf4; color: #16a34a; }
        .stat-icon.purple { background: #faf5ff; color: #9333ea; }
        .stat-icon.amber  { background: #fffbeb; color: #d97706; }
        .stat-icon.red    { background: #fef2f2; color: #dc2626; }
        .stat-value { font-size: 1.75rem; font-weight: 800; color: #0f172a; line-height: 1; }
        .stat-label { font-size: 13px; color: #64748b; margin-top: 4px; font-weight: 500; }

        /* ── Page header ── */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .page-header h1 { font-size: 22px; font-weight: 800; color: #0f172a; }

        /* ── Buttons ── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: all 0.15s; white-space: nowrap; }
        .btn svg { width: 16px; height: 16px; flex-shrink: 0; }
        .btn-primary  { background: #dc2626; color: #fff; }
        .btn-primary:hover  { background: #b91c1c; }
        .btn-success  { background: #16a34a; color: #fff; }
        .btn-success:hover  { background: #15803d; }
        .btn-warning  { background: #d97706; color: #fff; }
        .btn-warning:hover  { background: #b45309; }
        .btn-ghost    { background: #fff; color: #374151; border: 1.5px solid #e2e8f0; }
        .btn-ghost:hover    { background: #f8fafc; border-color: #cbd5e1; }
        .btn-danger   { background: #fef2f2; color: #dc2626; border: 1.5px solid #fecaca; }
        .btn-danger:hover   { background: #fee2e2; }
        .btn-sm { padding: 6px 12px; font-size: 13px; }

        /* ── Search bar ── */
        .search-bar { display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
        .search-bar input, .search-bar select { padding: 9px 14px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 14px; color: #0f172a; background: #fff; }
        .search-bar input:focus, .search-bar select:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.08); }
        .search-bar input { min-width: 240px; flex: 1; }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        thead th { background: #f8fafc; padding: 10px 14px; text-align: left; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
        tbody td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; color: #374151; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #fafafa; }
        .td-actions { display: flex; gap: 6px; align-items: center; }

        /* ── Badges ── */
        .badge { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
        .badge-success { background: #f0fdf4; color: #16a34a; }
        .badge-danger  { background: #fef2f2; color: #dc2626; }
        .badge-warning { background: #fffbeb; color: #d97706; }
        .badge-info    { background: #eff6ff; color: #2563eb; }
        .badge-neutral { background: #f1f5f9; color: #64748b; }
        .badge-purple  { background: #faf5ff; color: #9333ea; }

        /* Sport badges */
        .badge-nfl   { background: #1a3a5c; color: #fff; }
        .badge-nba   { background: #c9243f; color: #fff; }
        .badge-mlb   { background: #003087; color: #fff; }
        .badge-nhl   { background: #000; color: #fff; }
        .badge-ncaaf { background: #2d5a27; color: #fff; }
        .badge-ncaab { background: #7b2d8b; color: #fff; }

        /* ── Forms ── */
        .form-section { margin-bottom: 28px; }
        .form-section-title { font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9; }
        .form-grid { display: grid; gap: 16px; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); }
        .form-grid-2 { display: grid; gap: 16px; grid-template-columns: 1fr 1fr; }
        .form-grid-3 { display: grid; gap: 16px; grid-template-columns: 1fr 1fr 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { font-size: 13px; font-weight: 600; color: #374151; }
        .form-group label .required { color: #dc2626; margin-left: 2px; }
        .form-control {
            padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 8px;
            font-size: 14px; color: #0f172a; background: #fff; width: 100%; transition: all 0.15s;
        }
        .form-control:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.08); }
        .form-control::placeholder { color: #94a3b8; }
        textarea.form-control { resize: vertical; min-height: 90px; }
        select.form-control { cursor: pointer; }
        .form-hint { font-size: 12px; color: #94a3b8; }
        .form-error { font-size: 12px; color: #dc2626; }
        .form-check { display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; color: #374151; }
        .form-check input[type="checkbox"] { width: 16px; height: 16px; accent-color: #dc2626; cursor: pointer; }

        /* Image preview */
        .img-preview { width: 64px; height: 64px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 6px; }

        /* Form actions */
        .form-actions { display: flex; gap: 12px; align-items: center; padding-top: 8px; border-top: 1px solid #f1f5f9; margin-top: 8px; }

        /* ── Pagination ── */
        .pagination { display: flex; gap: 4px; align-items: center; margin-top: 20px; }
        .pagination .page-link { display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 8px; border-radius: 8px; border: 1.5px solid #e2e8f0; background: #fff; color: #374151; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.15s; }
        .pagination .page-link:hover { border-color: #2563eb; color: #2563eb; }
        .pagination .page-item.active .page-link { background: #dc2626; border-color: #dc2626; color: #fff; }
        .pagination .page-item.disabled .page-link { opacity: 0.4; cursor: not-allowed; }

        /* ── Empty state ── */
        .empty-state { text-align: center; padding: 56px 24px; }
        .empty-state svg { width: 48px; height: 48px; color: #cbd5e1; margin: 0 auto 16px; display: block; }
        .empty-state h3 { font-size: 16px; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .empty-state p { font-size: 14px; color: #94a3b8; }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .sidebar { width: 200px; min-width: 200px; }
            .main-wrapper { margin-left: 200px; }
        }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-wrapper { margin-left: 0; }
            .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/inspin-logo.png') }}" alt="INSPIN">
            <div class="logo-sub">Admin Panel</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <hr class="nav-divider">
            <div class="nav-section-label">Content</div>

            <a href="{{ route('admin.picks.index') }}" class="nav-item {{ request()->routeIs('admin.picks.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                Picks
            </a>
            <a href="{{ route('admin.articles.index') }}" class="nav-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Articles
            </a>
            <a href="{{ route('admin.experts.index') }}" class="nav-item {{ request()->routeIs('admin.experts.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Experts
            </a>
            <a href="{{ route('admin.about.edit') }}" class="nav-item {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                About Us
            </a>

            <hr class="nav-divider">
            <div class="nav-section-label">Members</div>

            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Users
            </a>
            <a href="{{ route('admin.whale-packages.index') }}" class="nav-item {{ request()->routeIs('admin.whale-packages.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Packages
            </a>

            <hr class="nav-divider">
            <div class="nav-section-label">Analytics</div>
            <a href="{{ route('admin.performance.index') }}" class="nav-item {{ request()->routeIs('admin.performance.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Performance
            </a>

            <hr class="nav-divider">
            <div class="nav-section-label">Support</div>

            <a href="{{ route('tickets.index') }}" class="nav-item {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                Tickets
            </a>
            <a href="{{ route('contests.index') }}" class="nav-item {{ request()->routeIs('contests.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                Contests
            </a>

            <hr class="nav-divider">
            <a href="{{ route('home') }}" class="nav-item" target="_blank">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Site
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="sidebar-user-role">{{ auth()->user()->role ?? 'admin' }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" id="adminLogoutForm" style="flex-shrink:0;">
                    @csrf
                    <button type="button" onclick="confirmAdminLogout()" style="background:none;border:none;cursor:pointer;padding:4px;color:#475569;" title="Logout">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>

                {{-- Admin logout confirm --}}
                <div id="adminLogoutModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
                    <div style="background:#fff;border-radius:14px;padding:28px;max-width:320px;width:90%;text-align:center;box-shadow:0 20px 50px rgba(0,0,0,.3);">
                        <div style="font-size:2rem;margin-bottom:12px;">🔐</div>
                        <h3 style="font-size:1.05rem;font-weight:700;color:#0f172a;margin-bottom:8px;">Log out of Admin?</h3>
                        <p style="font-size:13px;color:#64748b;margin-bottom:22px;">You'll need your credentials to log back in.</p>
                        <div style="display:flex;gap:10px;justify-content:center;">
                            <button onclick="document.getElementById('adminLogoutModal').style.display='none'"
                                style="padding:9px 22px;background:#f1f5f9;border:none;color:#475569;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
                                Cancel
                            </button>
                            <button onclick="doAdminLogout()"
                                style="padding:9px 22px;background:#dc2626;border:none;color:#fff;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;">
                                Log Out
                            </button>
                        </div>
                    </div>
                </div>
                <script>
                function doAdminLogout() {
                    var token = document.querySelector('meta[name="csrf-token"]') || document.querySelector('input[name="_token"]');
                    var csrfVal = token ? (token.content || token.value) : document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1] || '';
                    fetch('/logout', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfVal, 'Content-Type': 'application/json', 'Accept': 'application/json' }
                    }).then(function() { window.location.href = '/'; }).catch(function() { window.location.href = '/'; });
                }
                function confirmAdminLogout() {
                    var m = document.getElementById('adminLogoutModal');
                    m.style.display = 'flex';
                    m.addEventListener('click', function(e){ if(e.target===this) this.style.display='none'; }, {once:false});
                }
                </script>
            </div>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-actions">
                <a href="{{ route('home') }}" class="topbar-link" target="_blank">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Site
                </a>
            </div>
        </header>

        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <ul class="error-list">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>

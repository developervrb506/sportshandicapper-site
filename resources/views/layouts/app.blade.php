<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; margin: 0; background: #f8fafc; color: #0f172a; line-height: 1.6; }
        .nav { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0 24px; display: flex; gap: 0; align-items: center; flex-wrap: wrap; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .nav a { color: #475569; text-decoration: none; font-weight: 500; padding: 16px 16px; font-size: 14px; transition: background 0.15s, color 0.15s; }
        .nav a:hover { background: #f8fafc; color: #0f172a; }
        .nav a.active { color: #2563eb; border-bottom: 2px solid #2563eb; }
        .container { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
        .card, .admin-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        h1 { margin-top: 0; font-size: 1.5rem; color: #0f172a; }
        table, .admin-table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border-bottom: 1px solid #f1f5f9; padding: 10px 12px; text-align: left; font-size: 14px; }
        th { background: #f8fafc; font-weight: 600; color: #64748b; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; }
        tr:hover { background: #f8fafc; }
        .btn, .admin-btn { display: inline-block; padding: 8px 16px; background: #f1f5f9; color: #475569; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: 500; transition: background 0.15s; }
        .btn:hover, .admin-btn:hover { background: #e2e8f0; }
        .btn-primary, .admin-btn-primary { background: #2563eb; color: #fff; }
        .btn-primary:hover, .admin-btn-primary:hover { background: #1d4ed8; }
        .btn-danger, .admin-btn-danger { background: #dc2626; color: #fff; }
        .btn-danger:hover, .admin-btn-danger:hover { background: #b91c1c; }
        .btn-sm { padding: 4px 10px; font-size: 12px; }
        .form-group, .admin-form-group { margin-bottom: 16px; }
        .form-group label, .admin-form-group label { display: block; font-weight: 500; margin-bottom: 4px; font-size: 14px; color: #374151; }
        .form-group input, .form-group select, .form-group textarea, .admin-form-group input, .admin-form-group select, .admin-form-group textarea { width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; transition: border-color 0.15s; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus, .admin-form-group input:focus, .admin-form-group select:focus, .admin-form-group textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .form-row, .admin-form-row { display: flex; gap: 16px; }
        .form-row .form-group, .admin-form-row .admin-form-group { flex: 1; }
        .form-actions, .admin-form-actions { display: flex; gap: 8px; margin-top: 24px; }
        .alert, .admin-alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-success, .admin-alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger, .admin-alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-open { background: #dbeafe; color: #1e40af; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-resolved { background: #dcfce7; color: #166534; }
        .badge-closed { background: #f1f5f9; color: #475569; }
        .badge-draft { background: #f1f5f9; color: #475569; }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-paused { background: #fef3c7; color: #92400e; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        .badge-completed { background: #dbeafe; color: #1e40af; }
        .badge-free { background: #dbeafe; color: #2563eb; }
        .badge-member { background: #dcfce7; color: #166534; }
        .badge-vip { background: #fef3c7; color: #d97706; }
        .badge-admin { background: #fee2e2; color: #991b1b; }
        .detail-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 16px; margin-bottom: 20px; }
        .detail-item { background: #f8fafc; border-radius: 8px; padding: 12px; }
        .detail-item strong { display: block; font-size: 12px; color: #64748b; text-transform: uppercase; margin-bottom: 4px; }
        .detail-item span { font-size: 15px; color: #0f172a; }
        .detail-section { background: #f8fafc; border-radius: 8px; padding: 16px; margin-top: 16px; }
        .detail-section strong { display: block; font-size: 12px; color: #64748b; text-transform: uppercase; margin-bottom: 8px; }
        .metric { display: inline-block; background: #eff6ff; color: #1d4ed8; border-radius: 8px; padding: 8px 16px; margin-right: 8px; margin-bottom: 8px; font-weight: 700; font-size: 14px; }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('modules.index') }}" class="{{ request()->routeIs('modules.*') ? 'active' : '' }}">Modules</a>
        <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.*') ? 'active' : '' }}">Tickets</a>
        <a href="{{ route('contests.index') }}" class="{{ request()->routeIs('contests.*') ? 'active' : '' }}">Contests</a>
        <a href="{{ route('picks') }}" class="{{ request()->routeIs('picks') ? 'active' : '' }}">Picks</a>
        <a href="{{ route('account.settings') }}" class="{{ request()->routeIs('account.settings') ? 'active' : '' }}">Settings</a>
    </nav>
    <main class="container">
        @yield('content')
    </main>
</body>
</html>

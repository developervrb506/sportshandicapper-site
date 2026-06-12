<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Member Portal - Sportshandicapper')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo01.svg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:    #0A0F1E;
            --gold:  #1E90FF;
            --accent:#1E90FF;
            --card:  #0C1020;
            --inner: #11162A;
            --bdr:   rgba(255,255,255,.07);
            --r:     14px;
        }
        * { box-sizing:border-box; margin:0; padding:0; }
        html,body { height:100%; background:var(--bg); }
        body { font-family:'Inter',sans-serif; color:#fff; line-height:1.5; min-height:100vh; }
        a { text-decoration:none; color:inherit; }
        img { max-width:100%; }

        /* ══════════ TOP NAV ══════════ */
        #topnav {
            position:sticky; top:0; z-index:200;
            display:flex; align-items:center; justify-content:space-between;
            gap:16px; padding:6px 24px; height:68px; overflow:visible;
            background:var(--card);
            border-bottom:1px solid var(--bdr);
        }
        .tn-brand { display:flex; align-items:center; gap:10px; flex-shrink:0; }

        .tn-links { display:flex; align-items:center; gap:4px; flex:1; justify-content:center; flex-wrap:wrap; }
        .tn-link {
            display:flex; align-items:center; gap:8px;
            padding:9px 16px; border-radius:30px;
            font-size:13px; font-weight:600; color:rgba(255,255,255,.55);
            transition:all .15s; white-space:nowrap;
        }
        .tn-link svg { width:16px; height:16px; stroke:currentColor; }
        .tn-link:hover { color:#fff; background:rgba(255,255,255,.05); }
        .tn-link.active { color:#fff; background:var(--accent); }

        .tn-actions { display:flex; align-items:center; gap:10px; flex-shrink:0; }
        .tn-icon-btn {
            width:38px; height:38px; border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            background:rgba(255,255,255,.05); border:1px solid var(--bdr);
            color:rgba(255,255,255,.6); cursor:pointer; position:relative;
        }
        .tn-icon-btn:hover { color:#fff; background:rgba(255,255,255,.09); }
        .tn-icon-btn svg { width:17px; height:17px; stroke:currentColor; }
        .tn-dot { position:absolute; top:7px; right:7px; width:7px; height:7px; border-radius:50%; background:var(--accent); border:2px solid var(--card); }

        .tn-av { width:34px; height:34px; border-radius:50%; background:var(--accent); color:#fff; font-size:14px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .tn-uname { font-size:13px; font-weight:700; color:#fff; line-height:1.2; }
        .tn-upkg  { font-size:10px; font-weight:700; letter-spacing:.06em; color:var(--accent); }

        /* ── Avatar dropdown ── */
        .tn-avdd { position:relative; }
        .tn-avdd-btn { display:flex; align-items:center; gap:6px; background:rgba(255,255,255,.05); border:1px solid var(--bdr); border-radius:30px; padding:5px 10px 5px 5px; cursor:pointer; color:rgba(255,255,255,.5); }
        .tn-avdd-btn:hover { background:rgba(255,255,255,.09); color:#fff; }
        .tn-avdd-menu {
            display:none; position:absolute; top:calc(100% + 10px); right:0; min-width:220px;
            background:var(--card); border:1px solid var(--bdr); border-radius:14px;
            box-shadow:0 12px 40px rgba(0,0,0,.4); overflow:hidden; z-index:300;
        }
        .tn-avdd-menu.open { display:block; }
        .tn-avdd-head { padding:14px 16px; }
        .tn-avdd-divider { height:1px; background:var(--bdr); }
        .tn-avdd-item {
            display:flex; align-items:center; gap:10px; width:100%; text-align:left;
            padding:11px 16px; font-size:13px; font-weight:600; color:rgba(255,255,255,.65);
            background:none; border:none; cursor:pointer; font-family:'Inter',sans-serif;
        }
        .tn-avdd-item svg { width:16px; height:16px; stroke:currentColor; flex-shrink:0; }
        .tn-avdd-item:hover { background:rgba(255,255,255,.05); color:#fff; }
        .tn-avdd-logout { color:#EF4444; }
        .tn-avdd-logout:hover { background:rgba(239,68,68,.08); color:#EF4444; }

        .tn-hamburger { display:none; background:none; border:none; cursor:pointer; color:#fff; }

        /* ══════════ CONTENT ══════════ */
        #sub-content-wrap { max-width:1320px; margin:0 auto; padding:24px; }

        /* ── Cards ── */
        .s-card { background:var(--card); border:1px solid var(--bdr); border-radius:var(--r); overflow:hidden; }
        .s-inner { background:var(--inner); border:1px solid rgba(255,255,255,.06); border-radius:10px; }

        /* ── Labels ── */
        .kpi-label { font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:rgba(255,255,255,.35); margin-bottom:10px; }
        .kpi-val   { font-size:28px; font-weight:800; color:#fff; line-height:1; }
        .kpi-sub   { font-size:13px; color:rgba(255,255,255,.4); margin-top:6px; }
        .gold-bar  { height:2px; background:var(--accent); border-radius:10px; margin:10px 0 6px; }
        .sec-hdr   { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
        .sec-ttl   { font-size:16px; font-weight:700; color:#fff; }
        .sec-lnk   { font-size:11px; font-weight:600; color:var(--accent); }

        /* ── KPI icon chip (top right of KPI cards) ── */
        .kpi-icon { width:34px; height:34px; border-radius:9px; background:rgba(30,144,255,.1); border:1px solid rgba(30,144,255,.2); display:flex; align-items:center; justify-content:center; }
        .kpi-icon svg { width:16px; height:16px; stroke:var(--accent); color:var(--accent); }

        /* ── Badges ── */
        .bw  { background:rgba(34,197,94,.12); border:1px solid rgba(34,197,94,.2); color:#22C55E; }
        .bl  { background:rgba(239,68,68,.12); border:1px solid rgba(239,68,68,.2); color:#EF4444; }
        .bp  { background:rgba(30,144,255,.12); border:1px solid rgba(30,144,255,.2); color:#1E90FF; }
        .bpend { background:rgba(110,110,110,.12); border:1px solid rgba(110,110,110,.2); color:#888; }
        .bact  { background:rgba(34,197,94,.12); border:1px solid rgba(34,197,94,.2); color:#22C55E; }
        .bstart{ background:rgba(92,125,235,.12); border:1px solid rgba(92,125,235,.2); color:#7B97F5; }
        .sbadge { font-size:10px; font-weight:700; padding:3px 9px; border-radius:30px; display:inline-block; }
        .spbadge{ font-size:11px; font-weight:600; padding:3px 8px; border-radius:7px; display:inline-block; }
        .sb-soon { font-size:9px; font-weight:700; padding:2px 7px; border-radius:20px; background:rgba(255,255,255,.07); color:rgba(255,255,255,.3); border:1px solid rgba(255,255,255,.1); margin-left:auto; letter-spacing:.3px; flex-shrink:0; }

        /* ── Mobile ── */
        @media(max-width:1100px){
            .tn-links { order:3; width:100%; justify-content:flex-start; overflow-x:auto; padding-top:10px; border-top:1px solid var(--bdr); margin-top:10px; }
            .tn-uname,.tn-upkg { display:none; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div id="topnav">
    <div class="tn-brand">
        <a href="/subscriber/dashboard" style="display:flex;align-items:center;gap:10px;">
            <img src="{{ asset('images/logo01.svg') }}" alt="Sportshandicapper" style="height:108px;width:auto;object-fit:contain;margin:-20px 0;">
        </a>
    </div>

    @auth
    @php $sub = auth()->user()->activeSubscription()?->load('package'); @endphp
    <nav class="tn-links">
        <a href="/subscriber/dashboard" class="tn-link {{ request()->is('subscriber/dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="7" height="7" rx="1.5"/><rect x="11" y="2" width="7" height="7" rx="1.5"/><rect x="2" y="11" width="7" height="7" rx="1.5"/><rect x="11" y="11" width="7" height="7" rx="1.5"/></svg>
            Overview
        </a>
        <a href="/subscriber/articles" class="tn-link {{ request()->is('subscriber/article*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Articles
        </a>
        <a href="/subscriber/picks" class="tn-link {{ request()->is('subscriber/picks*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            My Picks
        </a>
        <a href="/subscriber/packages" class="tn-link {{ request()->is('subscriber/packages*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
            Packages
        </a>
    </nav>

    <div class="tn-actions">
        <button class="tn-icon-btn" title="Search">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
        <button class="tn-icon-btn" title="Notifications">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            <span class="tn-dot"></span>
        </button>

        {{-- Avatar dropdown --}}
        <div class="tn-avdd" id="avddWrap">
            <button class="tn-avdd-btn" onclick="toggleAvDd()">
                <div class="tn-av">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="tn-avdd-menu" id="avddMenu">
                <div class="tn-avdd-head">
                    <div class="tn-uname">{{ Str::limit(auth()->user()->name,22) }}</div>
                    <div class="tn-upkg">{{ $sub ? '★ '.strtoupper($sub->packageName()) : 'NO PACKAGE' }}</div>
                </div>
                <div class="tn-avdd-divider"></div>
                <a href="/profile" class="tn-avdd-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    My Profile
                </a>
                <a href="/account/settings" class="tn-avdd-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                    Account Settings
                </a>
                <a href="/account/settings" class="tn-avdd-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Billing
                </a>
                <div class="tn-avdd-divider"></div>
                <button class="tn-avdd-item tn-avdd-logout" onclick="confirmLogout()">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </div>
        </div>
    </div>
    @endauth
</div>

<div id="sub-content-wrap">
    @yield('content')
</div>

{{-- Logout modal --}}
<div id="logoutModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(8px);">
    <div style="background:#0C1020;border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:30px;max-width:320px;width:92%;text-align:center;">
        <div style="font-size:2.2rem;margin-bottom:12px;">👋</div>
        <h3 style="font-size:1rem;font-weight:700;color:#fff;margin-bottom:8px;">Log Out?</h3>
        <p style="font-size:13px;color:rgba(255,255,255,.4);margin-bottom:22px;">You'll need to log back in to access your picks.</p>
        <div style="display:flex;gap:8px;justify-content:center;">
            <button onclick="document.getElementById('logoutModal').style.display='none'" style="padding:9px 22px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.7);border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">Stay</button>
            <button onclick="doLogout()" style="padding:9px 22px;background:#ef4444;border:none;color:#fff;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;">Log Out</button>
        </div>
    </div>
</div>

<script>
function toggleAvDd(){ document.getElementById('avddMenu').classList.toggle('open'); }
document.addEventListener('click', function(e){
    var wrap = document.getElementById('avddWrap');
    if (wrap && !wrap.contains(e.target)) document.getElementById('avddMenu').classList.remove('open');
});
function confirmLogout(){ document.getElementById('avddMenu').classList.remove('open'); document.getElementById('logoutModal').style.display='flex'; }
document.getElementById('logoutModal').addEventListener('click',function(e){ if(e.target===this) this.style.display='none'; });
function doLogout(){
    var t=document.querySelector('meta[name="csrf-token"]');
    fetch('/logout',{method:'POST',headers:{'X-CSRF-TOKEN':t?t.content:'','Content-Type':'application/json','Accept':'application/json'}})
    .then(function(){window.location.href='/';}).catch(function(){window.location.href='/';});
}
</script>
@stack('scripts')
</body>
</html>

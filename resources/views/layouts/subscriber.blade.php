<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Member Portal - INSPIN')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/inspin Logo3.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:    #0a0a0a;
            --gold:  #FDB515;
            --side:  #111111;
            --card:  #161616;
            --inner: #1e1e1e;
            --bdr:   rgba(255,255,255,.07);
            --r:     14px;
            --side-w:190px;
        }
        * { box-sizing:border-box; margin:0; padding:0; }
        html,body { height:100%; background:var(--bg); }
        body { font-family:'Inter',sans-serif; color:#fff; line-height:1.5; min-height:100vh; }
        a { text-decoration:none; color:inherit; }
        img { max-width:100%; }

        /* ── Outer wrapper ── */
        #portal-wrap {
            display:flex;
            min-height:100vh;
            padding:12px;
            gap:10px;
        }

        /* ══════════ SIDEBAR ══════════ */
        #sidebar {
            width:var(--side-w);
            flex-shrink:0;
            background:var(--side);
            border:1px solid var(--bdr);
            border-radius:var(--r);
            display:flex;
            flex-direction:column;
            position:sticky;
            top:12px;
            height:calc(100vh - 24px);
            overflow:hidden;
            z-index:200;
        }
        .sb-logo { padding:18px 16px 14px; flex-shrink:0; }
        .sb-logo img { height:32px; width:auto; }
        .sb-divider { height:1px; background:var(--bdr); margin:0 16px; flex-shrink:0; }
        .sb-nav { flex:1; overflow-y:auto; overflow-x:hidden; padding:10px 8px; }
        .sb-nav::-webkit-scrollbar { width:0; }
        .sb-section { font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:rgba(255,255,255,.3); padding:12px 8px 6px; }

        .sb-item {
            display:flex; align-items:center; gap:10px;
            padding:0 8px; height:42px; border-radius:10px;
            cursor:pointer; text-decoration:none; color:rgba(255,255,255,.55);
            font-size:13px; font-weight:600; transition:all .15s;
            margin-bottom:2px; white-space:nowrap;
        }
        .sb-item:hover { color:#fff; background:rgba(255,255,255,.05); }
        .sb-item.active { color:var(--gold); }
        .sb-item.active .sb-icon { background:var(--gold); }
        .sb-item.active .sb-icon svg { color:#000; stroke:#000; }
        .sb-item:hover:not(.active) .sb-icon { background:rgba(255,255,255,.1); }

        .sb-icon {
            width:36px; height:36px; border-radius:9px;
            background:rgba(255,255,255,.07);
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
            transition:background .15s;
        }
        .sb-icon svg { width:16px; height:16px; color:rgba(255,255,255,.5); stroke:rgba(255,255,255,.5); }

        .sb-bottom { flex-shrink:0; padding:10px 8px; border-top:1px solid var(--bdr); }
        .sb-user-row { display:flex; align-items:center; gap:8px; padding:8px; border-radius:10px; background:rgba(255,255,255,.04); }
        .sb-av { width:30px; height:30px; border-radius:8px; background:var(--gold); color:#000; font-size:13px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .sb-uname { font-size:11px; font-weight:600; color:#fff; line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .sb-upkg  { font-size:9px; color:var(--gold); font-weight:600; }

        /* ══════════ MAIN ══════════ */
        #sub-main {
            flex:1; min-width:0;
            background:var(--side);
            border:1px solid var(--bdr);
            border-radius:var(--r);
            display:flex; flex-direction:column;
            overflow:hidden;
        }

        /* Top bar */
        .sub-topbar {
            height:72px; flex-shrink:0;
            border-bottom:1px solid var(--bdr);
            display:flex; align-items:center; justify-content:space-between;
            padding:0 24px;
        }
        .sub-topbar-title { font-size:22px; font-weight:700; color:#fff; }
        .sub-profile-btn {
            display:flex; align-items:center; gap:10px;
            background:rgba(255,255,255,.06); border:1px solid var(--bdr);
            border-radius:10px; padding:8px 14px; cursor:pointer;
        }
        .sub-pav { width:42px; height:42px; border-radius:10px; background:var(--gold); color:#000; font-size:18px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .sub-pname { font-size:14px; font-weight:600; color:#fff; }
        .sub-ppkg  { font-size:12px; font-weight:600; color:var(--gold); }
        .sub-chevron { color:rgba(255,255,255,.3); margin-left:4px; }
        .sub-topbar-hamburger { display:none; background:none; border:none; cursor:pointer; color:#fff; }

        /* Content area */
        .sub-content { flex:1; overflow-y:auto; padding:20px 24px; }
        .sub-content::-webkit-scrollbar { width:4px; }
        .sub-content::-webkit-scrollbar-thumb { background:rgba(255,255,255,.1); border-radius:4px; }

        /* ── Cards ── */
        .s-card { background:var(--card); border:1px solid var(--bdr); border-radius:var(--r); overflow:hidden; }
        .s-inner { background:var(--inner); border:1px solid rgba(255,255,255,.06); border-radius:10px; }

        /* ── Labels ── */
        .kpi-label { font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:rgba(255,255,255,.35); margin-bottom:10px; }
        .kpi-val   { font-size:28px; font-weight:800; color:#fff; line-height:1; }
        .kpi-sub   { font-size:13px; color:rgba(255,255,255,.4); margin-top:6px; }
        .gold-bar  { height:2px; background:var(--gold); border-radius:10px; margin:10px 0 6px; }
        .sec-hdr   { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
        .sec-ttl   { font-size:16px; font-weight:700; color:#fff; }
        .sec-lnk   { font-size:11px; font-weight:600; color:var(--gold); }

        /* ── Badges ── */
        .bw  { background:rgba(0,209,91,.12); border:1px solid rgba(0,209,91,.2); color:#00D15B; }
        .bl  { background:rgba(239,68,68,.12); border:1px solid rgba(239,68,68,.2); color:#EF4444; }
        .bp  { background:rgba(253,181,21,.12); border:1px solid rgba(253,181,21,.2); color:#FDB515; }
        .bpend { background:rgba(110,110,110,.12); border:1px solid rgba(110,110,110,.2); color:#888; }
        .bact  { background:rgba(0,209,91,.12); border:1px solid rgba(0,209,91,.2); color:#00D15B; }
        .bstart{ background:rgba(92,125,235,.12); border:1px solid rgba(92,125,235,.2); color:#7B97F5; }
        .sbadge { font-size:10px; font-weight:700; padding:3px 9px; border-radius:30px; display:inline-block; }
        .spbadge{ font-size:11px; font-weight:600; padding:3px 8px; border-radius:7px; display:inline-block; }
        .sb-soon { font-size:9px; font-weight:700; padding:2px 7px; border-radius:20px; background:rgba(255,255,255,.07); color:rgba(255,255,255,.3); border:1px solid rgba(255,255,255,.1); margin-left:auto; letter-spacing:.3px; flex-shrink:0; }

        /* ── Mobile ── */
        #sbOvl { display:none; position:fixed; inset:0; background:rgba(0,0,0,.7); z-index:199; }
        #sbOvl.on { display:block; }
        @media(max-width:900px){
            #sidebar { position:fixed; top:12px; left:12px; bottom:12px; height:calc(100vh-24px); transform:translateX(-210px); transition:transform .3s; z-index:300; }
            #sidebar.open { transform:translateX(0); }
            #sub-main { border-radius:var(--r); }
            .sub-topbar-hamburger { display:flex; }
            .sub-pname,.sub-ppkg { display:none; }
        }

    </style>
    @stack('styles')
</head>
<body>
<div id="sbOvl" onclick="closeSb()"></div>
<div id="portal-wrap">

    {{-- ════ SIDEBAR ════ --}}
    <aside id="sidebar">
        <div class="sb-logo"><a href="/subscriber/dashboard"><img src="{{ asset('images/inspin-logo.png') }}?v=2" alt="INSPIN"></a></div>
        <div class="sb-divider"></div>

        @auth
        @php $sub = auth()->user()->activeSubscription()?->load('package'); @endphp
        <nav class="sb-nav">
            <div class="sb-section">Menu</div>
            <a href="/subscriber/dashboard" class="sb-item {{ request()->is('subscriber/dashboard') ? 'active' : '' }}">
                <div class="sb-icon"><svg viewBox="0 0 20 20" fill="currentColor"><rect x="1" y="1" width="8" height="8" rx="1.5"/><rect x="11" y="1" width="8" height="8" rx="1.5"/><rect x="1" y="11" width="8" height="8" rx="1.5"/><rect x="11" y="11" width="8" height="8" rx="1.5"/></svg></div>
                Dashboard
            </a>
            <a href="/subscriber/picks" class="sb-item {{ request()->is('subscriber/picks*') ? 'active' : '' }}">
                <div class="sb-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg></div>
                My Picks
            </a>
            <a href="/subscriber/packages" class="sb-item {{ request()->is('subscriber/packages*') ? 'active' : '' }}">
                <div class="sb-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg></div>
                Packages
            </a>
            <div class="sb-section">Content</div>
            <a href="/subscriber/articles" class="sb-item {{ request()->is('subscriber/article*') ? 'active' : '' }}">
                <div class="sb-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
                Articles
            </a>
            <a href="/subscriber/consensus" class="sb-item {{ request()->is('subscriber/consensus*') ? 'active' : '' }}">
                <div class="sb-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
                Consensus
            </a>
            <a href="/subscriber/trends" class="sb-item {{ request()->is('subscriber/trends*') ? 'active' : '' }}">
                <div class="sb-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                Trends
            </a>
            <a href="/subscriber/odds" class="sb-item {{ request()->is('subscriber/odds*') ? 'active' : '' }}">
                <div class="sb-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
                Live Odds
            </a>
            <a href="/subscriber/betting-tools" class="sb-item {{ request()->is('subscriber/betting-tools*') ? 'active' : '' }}">
                <div class="sb-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg></div>
                Betting Tools
            </a>
            <div class="sb-section">Account</div>
            <a href="/profile" class="sb-item {{ request()->is('profile') ? 'active' : '' }}">
                <div class="sb-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
                My Profile
            </a>
            <a href="/account/settings" class="sb-item {{ request()->is('account/settings') ? 'active' : '' }}">
                <div class="sb-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg></div>
                Settings
            </a>
            <button onclick="confirmLogout()" class="sb-item" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;">
                <div class="sb-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div>
                Log Out
            </button>
        </nav>

        {{-- User card --}}
        <div class="sb-bottom">
            <a href="/" style="display:block;font-size:10px;color:rgba(255,255,255,.2);margin-bottom:8px;padding:0 4px;" onmouseover="this.style.color='rgba(255,255,255,.5)'" onmouseout="this.style.color='rgba(255,255,255,.2)'">← Back to INSPIN.com</a>
            <div class="sb-user-row">
                <div class="sb-av">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                <div style="min-width:0;flex:1;">
                    <div class="sb-uname">{{ Str::limit(auth()->user()->name,16) }}</div>
                    <div class="sb-upkg">{{ $sub?$sub->max_stars.'★ Access':'No Package' }}</div>
                </div>
            </div>
        </div>
        @endauth
    </aside>

    {{-- ════ MAIN ════ --}}
    <div id="sub-main">
        <header class="sub-topbar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="sub-topbar-hamburger" onclick="toggleSb()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <span class="sub-topbar-title">@yield('page-title','Portal')</span>
            </div>
        </header>

        <main class="sub-content">@yield('content')</main>
    </div>
</div>

{{-- Logout modal --}}
<div id="logoutModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(8px);">
    <div style="background:#161616;border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:30px;max-width:320px;width:92%;text-align:center;">
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
function toggleSb(){ document.getElementById('sidebar').classList.toggle('open'); document.getElementById('sbOvl').classList.toggle('on'); }
function closeSb() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sbOvl').classList.remove('on'); }
function confirmLogout(){ document.getElementById('logoutModal').style.display='flex'; }
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

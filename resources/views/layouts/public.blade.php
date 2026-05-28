<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sportshandicapper - Sports Betting Analysis & Expert Picks')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/sh-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/sh-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/sh-logo.png') }}">
    <meta name="description" content="@yield('meta', 'Sportshandicapper - Expert sports betting analysis, simulation models, daily picks, and trends for NFL, NBA, MLB, NHL.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* ===== DESIGN TOKENS ===== */
        :root {
            --black:       #060818;
            --black-soft:  #0D1224;
            --black-border:#1E2640;
            --black-hover: #2A3556;
            --gold:        #6366F1;
            --gold-light:  #818CF8;
            --gold-dark:   #4F46E5;
            --gold-glow:   rgba(99,102,241,0.25);
            --white:       #F0F0FF;
            --surface:     #0D1224;
            --surface-2:   #1E2640;
            --text:        #F0F0FF;
            --text-muted:  #9a9ab0;
            --text-dim:    #6e6e8a;
        }

        /* ===== BASE ===== */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { overflow-x: hidden; background: #060818; color-scheme: dark; }
        body { font-family: 'Inter', system-ui, sans-serif; background: transparent; color: #F0F0FF; line-height: 1.6; overflow-x: hidden; max-width: 100vw; -webkit-font-smoothing: antialiased; }
        a { color: var(--text); text-decoration: none; transition: color 0.15s; }
        a:hover { color: var(--gold); }
        img { max-width: 100%; }

        /* ===== HEADER AUTH (right side) ===== */
        .header-auth { display: flex; gap: 18px; align-items: center; flex-shrink: 0; }
        .header-login { color: #F0F0FF; font-size: 13.5px; font-weight: 500; font-family: 'DM Sans', sans-serif; text-decoration: none; transition: color 0.15s; cursor: pointer; background: none; border: none; padding: 0; opacity: 0.75; }
        .header-login:hover { color: #F0F0FF; opacity: 1; }
        .header-signup { display: inline-block; padding: 8px 22px; border: 1px solid rgba(99,102,241,0.5); border-radius: 50px; color: #6366F1; font-size: 13.5px; font-weight: 600; text-decoration: none; transition: background 0.18s, border-color 0.18s; white-space: nowrap; background: rgba(99,102,241,0.08); }
        .header-signup:hover { background: rgba(99,102,241,0.16); border-color: #6366F1; color: #6366F1; }
        .header-user-name { color: #a1a1aa; font-size: 13px; }
        .header-dash-link { color: #d4d4d8; font-size: 13px; font-weight: 600; text-decoration: none; transition: color .15s; }
        .header-dash-link:hover { color: var(--gold); }
        .header-logout-btn { background: none; border: none; color: #71717a; font-size: 13px; font-weight: 600; cursor: pointer; padding: 0; transition: color .15s; }
        .header-logout-btn:hover { color: #ef4444; }

        /* ===== HEADER — sticky glass ===== */
        .header { background: rgba(6,8,24,0.97); border-bottom: 1px solid rgba(99,102,241,.06); position: sticky; top: 0; z-index: 100; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); box-shadow: 0 1px 0 rgba(255,255,255,.04), 0 4px 24px rgba(0,0,0,0.5); }
        .header::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent 0%, var(--gold) 30%, var(--gold-light) 50%, var(--gold) 70%, transparent 100%); }
        .header .wrap { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; }
        .logo { padding: 10px 0; }
        .logo img { height: 48px; width: auto; }

        /* ===== NAV ===== */
        .nav { display: flex; gap: 0; list-style: none; flex-wrap: wrap; transform: none; visibility: visible; align-items: stretch; }
        .nav > li { display: flex; align-items: stretch; }
        .nav a { display: flex; align-items: center; padding: 0 13px; color: #9a9a9a; font-size: 13px; font-weight: 500; font-family: 'DM Sans', sans-serif; text-transform: none; letter-spacing: 0.1px; transition: all 0.18s; border-bottom: 2px solid transparent; position: relative; height: 60px; }
        .nav a:hover { color: #F0F0FF; }
        .nav a.active { color: var(--gold); border-bottom-color: var(--gold); }
        .nav a.active::after, .nav a:hover::after { content: ''; position: absolute; bottom: -1px; left: 50%; transform: translateX(-50%); width: 60%; height: 2px; background: linear-gradient(90deg, transparent, var(--gold), transparent); border-radius: 2px; }
        .nav a.active::after { width: 80%; }

        /* ── Dropdown ── */
        .nav-dropdown-wrap { position: relative; display: flex; align-items: stretch; }
        .nav-dropdown-trigger { cursor: pointer; display: flex !important; align-items: center; gap: 5px; }
        .nav-dropdown-trigger .nav-caret { transition: transform .2s; flex-shrink: 0; opacity: .6; }
        .nav-dropdown-wrap.open .nav-caret { transform: rotate(180deg); opacity: 1; }
        .nav-dropdown-wrap.open > .nav-dropdown-trigger { color: #F0F0FF; }

        .nav-dropdown {
            display: none; position: absolute; top: calc(100% + 4px); left: 50%; transform: translateX(-50%);
            z-index: 500; min-width: 260px;
        }
        .nav-dropdown-wrap.open .nav-dropdown { display: block; animation: ddFadeIn .18s ease; }
        @keyframes ddFadeIn { from{opacity:0;transform:translateX(-50%) translateY(-6px)} to{opacity:1;transform:translateX(-50%) translateY(0)} }

        .nav-dropdown-inner {
            background: #0A0F1E; border: 1px solid rgba(99,102,241,.1);
            border-radius: 14px; padding: 8px; margin-top: 4px;
            box-shadow: 0 16px 48px rgba(0,0,0,.7), 0 0 0 1px rgba(99,102,241,.04);
        }
        .nav-dropdown-item {
            display: flex !important; align-items: center; gap: 12px; padding: 10px 12px !important;
            border-radius: 9px; text-decoration: none; transition: background .15s !important;
            border-bottom: none !important; height: auto !important;
            color: #9a9a9a !important;
        }
        .nav-dropdown-item::after { display: none !important; }
        .nav-dropdown-item:hover { background: rgba(99,102,241,.05) !important; color: #F0F0FF !important; }
        .ndi-icon { font-size: 18px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: rgba(99,102,241,.05); border-radius: 8px; flex-shrink: 0; }
        .ndi-text { flex: 1; display: flex; flex-direction: column; gap: 1px; }
        .ndi-label { font-size: 13px; font-weight: 600; color: #F0F0FF; font-family: 'DM Sans', sans-serif; }
        .ndi-sub { font-size: 11px; color: #6e6e6e; }
        .ndi-badge { font-size: 9px; font-weight: 700; background: rgba(99,102,241,.12); color: #6366F1; border: 1px solid rgba(99,102,241,.25); padding: 2px 7px; border-radius: 10px; white-space: nowrap; flex-shrink: 0; }

        /* ===== CONTAINER ===== */
        .container { max-width: 1280px; margin: 0 auto; padding: 0 20px; }

        /* ===== HERO ===== */
        .hero { background: radial-gradient(ellipse at 50% -20%, #080D1A 0%, var(--black) 55%); padding: 80px 0 72px; text-align: center; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; inset: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f59e0b' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); opacity: 1; }
        .hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent 0%, var(--gold-dark) 20%, var(--gold) 40%, var(--gold-light) 50%, var(--gold) 60%, var(--gold-dark) 80%, transparent 100%); }
        .hero h1 { font-size: 2.75rem; color: var(--white); margin-bottom: 18px; font-weight: 900; letter-spacing: -0.75px; line-height: 1.2; position: relative; }
        .hero h1 span { background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 50%, var(--gold-dark) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero p { color: #a1a1aa; max-width: 640px; margin: 0 auto 36px; font-size: 16px; line-height: 1.75; position: relative; }
        .hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; position: relative; }

        /* ===== BUTTONS ===== */
        .btn { display: inline-block; padding: 13px 30px; border-radius: 9px; font-weight: 700; font-size: 15px; cursor: pointer; border: none; transition: all 0.2s; text-align: center; letter-spacing: 0.1px; }
        .btn-red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #fff; box-shadow: 0 4px 14px rgba(220,38,38,0.3); }
        .btn-red:hover { background: linear-gradient(135deg, #f87171 0%, #ef4444 100%); box-shadow: 0 6px 20px rgba(220,38,38,0.4); transform: translateY(-1px); color: #fff; }
        .btn-yellow { background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%); color: var(--black); box-shadow: 0 4px 14px var(--gold-glow); }
        .btn-yellow:hover { background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%); box-shadow: 0 6px 20px rgba(99,102,241,0.4); transform: translateY(-1px); color: var(--black); }
        .btn-green { background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); color: #fff; }
        .btn-green:hover { background: linear-gradient(135deg, #86efac 0%, #4ade80 100%); transform: translateY(-1px); color: #fff; }
        .btn-blue { background: #2563eb; color: #fff; }
        .btn-blue:hover { background: #1d4ed8; color: #fff; }
        .btn-outline { background: transparent; color: var(--white); border: 1.5px solid rgba(255,255,255,0.2); backdrop-filter: blur(4px); }
        .btn-outline:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.4); color: var(--white); }
        .btn-outline-dark { background: transparent; color: var(--text-muted); border: 1px solid var(--surface-2); border-radius: 8px; }
        .btn-outline-dark:hover { background: var(--surface-2); color: var(--text); }

        /* ===== SECTIONS ===== */
        .section { padding: 60px 0; background: #060818; }
        .section-alt { background: #0A0F1E; }
        .section-title { font-family: 'Space Grotesk', sans-serif; font-size: 1.85rem; color: #F0F0FF; margin-bottom: 8px; font-weight: 500; padding-left: 16px; border-left: 4px solid #6366F1; letter-spacing: -0.2px; }
        .section-sub { color: #6e6e6e; margin-bottom: 36px; font-size: 15px; padding-left: 20px; }

        /* ===== GRID ===== */
        .grid { display: grid; gap: 24px; }
        .grid-2 { grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); }
        .grid-3 { grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); }
        .grid-4 { grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); }

        /* ===== CARDS ===== */
        .card { background: #0D1224; border: 1px solid rgba(99,102,241,.08); border-radius: 12px; overflow: hidden; transition: box-shadow 0.25s, transform 0.2s, border-color 0.25s; }
        .card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.5); transform: translateY(-3px); border-color: rgba(99,102,241,0.3); }
        .card-body { padding: 24px; }
        .card h3 { color: #F0F0FF; margin-bottom: 8px; font-size: 1.05rem; font-weight: 600; font-family: 'Space Grotesk', sans-serif; }
        .card p { color: #9a9a9a; font-size: 14px; }
        .card-meta { display: flex; gap: 12px; font-size: 12px; color: #6e6e6e; margin-top: 12px; }
        .card-meta span { display: flex; align-items: center; gap: 4px; }

        /* ===== BADGES ===== */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
        .badge-nfl { background: #dbeafe; color: #1d4ed8; }
        .badge-nba { background: #fee2e2; color: #dc2626; }
        .badge-mlb { background: #dcfce7; color: #16a34a; }
        .badge-nhl { background: #f3e8ff; color: #9333ea; }
        .badge-ncaa { background: #fef3c7; color: #b45309; }
        .badge-ncaaf { background: #fef3c7; color: #b45309; }
        .badge-ncaab { background: #fef3c7; color: #b45309; }
        .badge-general { background: var(--surface); color: var(--text-muted); }
        .badge-premium { background: #fef3c7; color: #92400e; }
        .badge-free { background: #f0fdf4; color: #16a34a; }
        .badge-consensus { background: #dcfce7; color: #16a34a; }
        .badge-trends { background: #f3e8ff; color: #9333ea; }
        .badge-analysis { background: #fefce8; color: #92400e; }
        .badge-picks { background: #fefce8; color: #92400e; }
        .badge-news { background: var(--surface); color: var(--text-muted); }

        /* ===== TABLES ===== */
        .c-table { width: 100%; border-collapse: collapse; background: #0D1224; border-radius: 12px; overflow: hidden; border: 1px solid rgba(99,102,241,.08); }
        .c-table th { background: #060818; color: #6366F1; padding: 13px 16px; text-align: left; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 1px solid #1E2640; font-weight: 700; }
        .c-table td { padding: 12px 16px; border-bottom: 1px solid #2a2a2a; font-size: 14px; color: #F0F0FF; }
        .c-table tr:last-child td { border-bottom: none; }
        .c-table tr:hover td { background: #262626; }
        .pct-bar { height: 6px; border-radius: 4px; background: #1E2640; overflow: hidden; width: 80px; }
        .pct-fill { height: 100%; border-radius: 4px; }
        .pct-green { background: linear-gradient(90deg, #4ade80, #22c55e); }
        .pct-red { background: linear-gradient(90deg, #f87171, #dc2626); }

        /* ===== PACKAGES (legacy class) ===== */
        .pkg-card { background: var(--white); border: 1.5px solid var(--surface-2); border-radius: 16px; padding: 32px; text-align: center; transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s; }
        .pkg-card:hover { border-color: var(--gold); box-shadow: 0 8px 28px var(--gold-glow); transform: translateY(-2px); }
        .pkg-card.featured { border-color: var(--black); position: relative; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .pkg-card.featured::before { content: 'POPULAR'; position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, var(--black-soft), var(--black)); color: var(--gold); padding: 4px 16px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; }
        .pkg-card h3 { color: var(--text); font-size: 1.25rem; margin-bottom: 4px; }
        .pkg-price { font-size: 2.5rem; font-weight: 900; color: var(--text); margin: 16px 0; }
        .pkg-price sup { font-size: 1rem; color: var(--text-muted); }
        .pkg-duration { color: var(--text-muted); font-size: 14px; margin-bottom: 20px; }
        .pkg-features { list-style: none; text-align: left; margin: 20px 0; }
        .pkg-features li { padding: 8px 0; font-size: 14px; color: var(--text-muted); border-bottom: 1px solid var(--surface); }
        .pkg-features li:last-child { border-bottom: none; }
        .pkg-features li::before { content: '✓'; color: var(--gold); margin-right: 8px; font-weight: 700; }

        /* ===== CTA ===== */
        .cta { background: linear-gradient(135deg, var(--black) 0%, #080D1A 60%, var(--black) 100%); padding: 60px 40px; text-align: center; border-radius: 20px; margin: 32px 0; border: 1px solid var(--black-border); position: relative; overflow: hidden; }
        .cta::before { content: ''; position: absolute; top: -80px; left: 50%; transform: translateX(-50%); width: 400px; height: 200px; background: radial-gradient(ellipse, rgba(99,102,241,0.12) 0%, transparent 70%); pointer-events: none; }
        .cta::after { content: ''; position: absolute; bottom: 0; left: 10%; right: 10%; height: 1px; background: linear-gradient(90deg, transparent, var(--black-border), transparent); }
        .cta h2 { color: var(--white); font-size: 1.85rem; margin-bottom: 14px; font-weight: 900; letter-spacing: -0.3px; position: relative; }
        .cta p { color: #a1a1aa; margin-bottom: 28px; font-size: 16px; position: relative; }
        .cta .btn { background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%); color: var(--black); font-weight: 800; box-shadow: 0 4px 18px var(--gold-glow); position: relative; }
        .cta .btn:hover { background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%); box-shadow: 0 6px 24px rgba(99,102,241,0.45); transform: translateY(-2px); }

        /* ===== FOOTER ===== */
        .footer { background: #060818; padding: 40px 0; margin-top: 0; border-top: 1px solid rgba(99,102,241,.06); position: relative; }
        .footer::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent 0%, var(--gold-dark) 25%, var(--gold) 50%, var(--gold-dark) 75%, transparent 100%); }
        .footer .wrap { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .footer-links { display: flex; gap: 20px; list-style: none; flex-wrap: wrap; }
        .footer-links a { color: #52525b; font-size: 13px; transition: color 0.15s; }
        .footer-links a:hover { color: var(--gold); }
        .footer-copy { color: #3f3f46; font-size: 13px; }
        .social-icons { display: flex; gap: 10px; align-items: center; }
        .social-icons a { display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: var(--black-soft); border: 1px solid var(--black-border); transition: all 0.2s; }
        .social-icons a:hover { background: var(--black-hover); border-color: var(--gold); box-shadow: 0 0 10px var(--gold-glow); }
        .social-icons img { width: 18px; height: 18px; }

        /* ===== PAGE ===== */
        .page { max-width: 900px; margin: 0 auto; padding: 52px 20px; background: #060818; min-height: 60vh; }
        .page h1 { font-family: 'Space Grotesk', sans-serif; color: #F0F0FF; font-size: 2rem; margin-bottom: 24px; font-weight: 500; }
        .page h2 { font-family: 'Space Grotesk', sans-serif; color: #F0F0FF; font-size: 1.4rem; margin: 32px 0 12px; font-weight: 500; }
        .page p { color: #9a9a9a; margin-bottom: 16px; line-height: 1.8; }

        /* ===== ARTICLE DETAIL ===== */
        .article-detail { max-width: 800px; margin: 0 auto; padding: 52px 20px; background: #060818; min-height: 60vh; }
        .article-detail h1 { font-family: 'Space Grotesk', sans-serif; color: #F0F0FF; font-size: 2rem; margin-bottom: 16px; line-height: 1.3; font-weight: 500; }
        .article-detail .meta { display: flex; gap: 16px; font-size: 13px; color: #6e6e6e; margin-bottom: 28px; }
        .article-detail .content { color: #c0c0c0; line-height: 1.85; }
        .article-detail .content p { margin-bottom: 16px; }
        .article-detail .content h2, .article-detail .content h3 { color: #F0F0FF; font-family: 'Space Grotesk', sans-serif; font-weight: 500; margin: 28px 0 14px; }
        .article-detail .content a { color: #6366F1; }
        .article-detail .content strong { color: #F0F0FF; }
        .article-detail .content ul, .article-detail .content ol { padding-left: 20px; margin-bottom: 16px; }
        .article-detail .content li { margin-bottom: 6px; }
        /* ── Article tables (Betting Analysis etc) ── */
        .article-detail .content table { width: 100%; border-collapse: collapse; margin: 24px 0; border-radius: 10px; overflow: hidden; border: 1px solid rgba(99,102,241,.08); }
        .article-detail .content table thead tr { background: #0D1224; }
        .article-detail .content table thead th { padding: 11px 16px; text-align: left; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #6366F1; border-bottom: 1px solid rgba(99,102,241,.1); white-space: nowrap; }
        .article-detail .content table tbody tr { background: #0D1224; transition: background .15s; }
        .article-detail .content table tbody tr:nth-child(even) { background: #0A0F1E; }
        .article-detail .content table tbody tr:hover { background: #141B35; }
        .article-detail .content table tbody td { padding: 10px 16px; font-size: 13.5px; color: #c0c0c0; border-bottom: 1px solid rgba(99,102,241,.05); }
        .article-detail .content table tbody tr:last-child td { border-bottom: none; }
        .article-detail .content table tbody td:first-child { color: #F0F0FF; font-weight: 600; }

        /* ===== PAGINATION ===== */
        .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 32px; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 8px 14px; border-radius: 8px; font-size: 14px; }
        .pagination a { background: #0D1224; border: 1px solid #1E2640; color: #9a9a9a; transition: all 0.15s; }
        .pagination a:hover { background: #2a2a2a; border-color: #6366F1; color: #F0F0FF; }
        .pagination .active { background: #6366F1; color: #060818; border-color: #6366F1; font-weight: 700; }
        .pagination .disabled { opacity: 0.3; pointer-events: none; }

        /* ===== SPORT FILTER ===== */
        .sport-filter { display: flex; gap: 8px; margin-bottom: 28px; flex-wrap: wrap; }
        .sport-filter a { padding: 8px 18px; border-radius: 50px; font-size: 13px; font-weight: 500; font-family: 'DM Sans', sans-serif; background: #0D1224; border: 1px solid #1E2640; color: #9a9a9a; transition: all 0.18s; }
        .sport-filter a:hover { background: #2a2a2a; border-color: #2A3556; color: #F0F0FF; }
        .sport-filter a.active { background: transparent; border-color: #6366F1; color: #6366F1; box-shadow: 0 0 12px rgba(99,102,241,0.15); }

        /* ===== ADMIN (unchanged — admin pages only) ===== */
        .admin-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .admin-card h1 { color: #0f172a; margin-bottom: 20px; font-size: 1.5rem; }
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th { background: #f8fafc; padding: 10px 14px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 700; border-bottom: 2px solid #e2e8f0; }
        .admin-table td { padding: 10px 14px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .admin-table tr:hover { background: #f8fafc; }
        .admin-btn { display: inline-block; padding: 8px 16px; background: #f1f5f9; color: #475569; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 13px; font-weight: 500; }
        .admin-btn:hover { background: #e2e8f0; }
        .admin-btn-primary { background: #2563eb; color: #fff; }
        .admin-btn-primary:hover { background: #1d4ed8; }
        .admin-btn-danger { background: #dc2626; color: #fff; }
        .admin-btn-danger:hover { background: #b91c1c; }
        .admin-form-group { margin-bottom: 16px; }
        .admin-form-group label { display: block; font-weight: 500; margin-bottom: 4px; font-size: 14px; color: #374151; }
        .admin-form-group input, .admin-form-group select, .admin-form-group textarea { width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
        .admin-form-group input:focus, .admin-form-group select:focus, .admin-form-group textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .admin-form-row { display: flex; gap: 16px; }
        .admin-form-row .admin-form-group { flex: 1; }
        .admin-form-actions { display: flex; gap: 8px; margin-top: 24px; }
        .admin-alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .admin-alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .admin-alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .metric { display: inline-block; background: #eff6ff; color: #1d4ed8; border-radius: 8px; padding: 8px 16px; margin-right: 8px; margin-bottom: 8px; font-weight: 700; font-size: 14px; }

        /* ===== HAMBURGER ===== */
        .hamburger { display: none; flex-direction: column; justify-content: center; gap: 5px; cursor: pointer; padding: 8px 6px; background: none; border: 1px solid var(--black-border); border-radius: 8px; z-index: 201; }
        .hamburger span { display: block; width: 22px; height: 2px; background: #a1a1aa; border-radius: 2px; transition: all 0.3s; }
        .hamburger:hover span { background: var(--gold); }
        .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); background: var(--gold); }
        .hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); background: var(--gold); }

        /* Mobile nav overlay — must stay below header (z-index:100) so nav links are clickable */
        .nav-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 99; }
        .nav-overlay.open { display: block; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            /* Header */
            .header .wrap { padding: 0 16px; }
            .logo img { height: 40px; }
            .header-auth { display: none; }

            /* Hamburger on, nav off by default */
            .hamburger { display: flex; }
            .nav {
                position: fixed;
                top: 0; right: 0;
                width: 280px; height: 100vh;
                background: var(--black);
                border-left: 1px solid var(--black-border);
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                z-index: 101;
                transform: translateX(100%);
                transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
                padding-top: 70px;
                box-shadow: -8px 0 40px rgba(0,0,0,0.5);
                overflow-y: auto;
                visibility: hidden;
            }
            .nav.open { transform: translateX(0); visibility: visible; }
            .nav > li { display: block; }
            .nav a { height: auto; padding: 16px 24px; font-size: 13px; border-bottom: 1px solid var(--black-border); margin-bottom: 0; }
            .nav a.active::after, .nav a:hover::after { display: none; }
            .nav-dropdown-wrap { flex-direction: column; }
            .nav-dropdown { position: static; transform: none; display: none !important; min-width: unset; }
            .nav-dropdown-wrap.open .nav-dropdown { display: block !important; animation: none; }
            .nav-dropdown-inner { border-radius: 0; border: none; border-top: 1px solid rgba(99,102,241,.06); background: rgba(255,255,255,.03); box-shadow: none; padding: 4px 0; margin: 0; }
            .nav-dropdown-item { padding: 12px 28px !important; border-radius: 0; }
            .nav-dropdown-trigger { padding: 16px 24px; border-bottom: 1px solid var(--black-border); width: 100%; }

            /* Hero */
            .hero { padding: 44px 0 36px; }
            .hero h1 { font-size: 1.65rem; letter-spacing: -0.3px; }
            .hero p { font-size: 14px; }
            .hero-actions { gap: 10px; }
            .btn { padding: 12px 22px; font-size: 14px; }

            /* Sections */
            .section { padding: 40px 0; }
            .section-title { font-size: 1.45rem; }
            .container { padding: 0 16px; }

            /* Grids */
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }

            /* Admin */
            .admin-form-row { flex-direction: column; }

            /* CTA */
            .cta { padding: 36px 20px; border-radius: 14px; }
            .cta h2 { font-size: 1.45rem; }

            /* Footer */
            .footer .wrap { flex-direction: column; gap: 24px; }
            .footer-links { gap: 12px; }

            /* Modal */
            .modal-box { padding: 24px 20px; width: 95%; }
        }

        @media (max-width: 480px) {
            .hero h1 { font-size: 1.4rem; }
            .hero p { font-size: 13.5px; }
            .section-title { font-size: 1.3rem; }
            .top-bar .auth { gap: 10px; }
            /* Page & article detail */
            .page { padding: 32px 16px; }
            .article-detail { padding: 32px 16px; }
            .article-detail h1 { font-size: 1.5rem; }
            /* Tables horizontal scroll */
            .c-table { display: block; overflow-x: auto; -webkit-overflow-scrolling: touch; }
            /* Sport filter wrap */
            .sport-filter { gap: 6px; }
            .sport-filter a { padding: 6px 12px; font-size: 12px; }
            /* Footer */
            .footer-copy { font-size: 11px; }
        }

        /* ===== GLOBAL AURORA — exact from reference ===== */
        .aurora {
            position: absolute; border-radius: 9999px;
            filter: blur(90px); opacity: 0.55; will-change: transform; pointer-events: none;
        }
        .aurora-1 { width:720px;height:720px;top:-200px;left:-160px;background:radial-gradient(circle,#1E90FF 0%,transparent 60%);animation:aurora-float-1 22s ease-in-out infinite; }
        .aurora-2 { width:640px;height:640px;top:20%;right:-180px;background:radial-gradient(circle,#22D3EE 0%,transparent 60%);animation:aurora-float-2 26s ease-in-out infinite;opacity:0.45; }
        .aurora-3 { width:560px;height:560px;bottom:-180px;left:30%;background:radial-gradient(circle,#A855F7 0%,transparent 60%);animation:aurora-float-3 30s ease-in-out infinite;opacity:0.40; }
        .aurora-4 { width:480px;height:480px;top:55%;left:-120px;background:radial-gradient(circle,#22D3EE 0%,transparent 60%);animation:aurora-float-1 34s ease-in-out infinite reverse;opacity:0.28; }
        @keyframes aurora-float-1 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(80px,60px) scale(1.15)} }
        @keyframes aurora-float-2 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(-100px,80px) scale(1.1)} }
        @keyframes aurora-float-3 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(60px,-80px) scale(1.2)} }
        .conic-shimmer {
            position:absolute;inset:-20%;
            background:conic-gradient(from 0deg at 50% 50%,rgba(14,165,233,0) 0deg,rgba(14,165,233,0.18) 60deg,rgba(168,85,247,0.16) 140deg,rgba(30,144,255,0.18) 220deg,rgba(14,165,233,0) 360deg);
            filter:blur(60px);animation:spin-slow 40s linear infinite;opacity:0.55;
        }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        .scan-beam {
            position:absolute;left:-20%;right:-20%;top:-40%;height:60%;
            background:linear-gradient(180deg,transparent,rgba(14,165,233,0.10),transparent);
            transform:rotate(8deg);filter:blur(20px);animation:scan-move 14s ease-in-out infinite;pointer-events:none;
        }
        @keyframes scan-move {
            0%{transform:translateY(-10%) rotate(8deg);opacity:0}
            30%{opacity:1}
            100%{transform:translateY(180%) rotate(8deg);opacity:0}
        }
        @keyframes grid-pan { from{background-position:0 0,0 0} to{background-position:56px 56px,56px 56px} }

        /* ===== FLOATING PILL NAV ===== */
        .site-header { position: fixed; top: 16px; left: 50%; transform: translateX(-50%); width: 95%; max-width: 1280px; z-index: 150; }
        .pill-nav { display: flex; align-items: center; justify-content: space-between; padding: 10px 16px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.03); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); box-shadow: 0 10px 40px -10px rgba(99,102,241,0.25); }
        .nav-pill-group { display: none; align-items: center; background: rgba(255,255,255,0.05); border-radius: 50px; padding: 4px 8px; border: 1px solid rgba(255,255,255,0.05); gap: 2px; }
        @media (min-width: 1024px) { .nav-pill-group { display: flex; } }
        .nav-pitem { padding: 8px 16px; font-size: 13.5px; font-weight: 500; color: rgba(255,255,255,0.7); border-radius: 50px; transition: all 0.15s; text-decoration: none; display: flex; align-items: center; gap: 6px; white-space: nowrap; }
        .nav-pitem:hover { color: white; background: rgba(255,255,255,0.05); }
        .nav-pitem.active { color: white; background: rgba(255,255,255,0.08); }
        .nav-pitem-badge { font-size: 8px; font-weight: 700; background: #6366F1; color: white; border-radius: 4px; padding: 2px 5px; letter-spacing: 0.05em; text-transform: uppercase; }
        .nav-pitem-pulse { width: 7px; height: 7px; border-radius: 50%; background: #22c55e; animation: livePulse 1.4s infinite; display: inline-block; flex-shrink: 0; }
        .nav-pdivider { width: 1px; height: 16px; background: rgba(255,255,255,0.1); margin: 0 4px; flex-shrink: 0; }
        .nav-pdrop { position: relative; }
        .nav-pdrop-btn { display: flex; align-items: center; gap: 6px; padding: 8px 16px; font-size: 13.5px; font-weight: 500; color: rgba(255,255,255,0.7); border-radius: 50px; transition: all 0.15s; background: none; border: none; cursor: pointer; font-family: 'Inter', sans-serif; }
        .nav-pdrop-btn:hover { color: #a5b4fc; background: rgba(99,102,241,0.1); }
        .nav-pdrop-btn .caret { transition: transform 0.2s; }
        .nav-pdrop:hover .nav-pdrop-btn .caret { transform: rotate(180deg); }
        .nav-pdrop-menu { display: none; position: absolute; right: 0; top: calc(100% + 12px); width: 260px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); background: rgba(10,10,20,0.96); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); padding: 8px; box-shadow: 0 20px 50px rgba(0,0,0,0.6); z-index: 10; }
        .nav-pdrop:hover .nav-pdrop-menu { display: block; animation: ddFadeIn .15s ease; }
        .nav-pdrop-item { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 10px 12px; border-radius: 10px; cursor: default; transition: background 0.12s; }
        .nav-pdrop-item:hover { background: rgba(255,255,255,0.05); }
        .nav-pdrop-label { font-size: 13.5px; font-weight: 600; color: white; margin-bottom: 1px; }
        .nav-pdrop-sub { font-size: 11px; color: #94A3B8; }
        .nav-pdrop-soon { font-size: 9px; font-weight: 700; background: rgba(99,102,241,0.15); color: #818CF8; border-radius: 20px; padding: 2px 8px; letter-spacing: 0.1em; text-transform: uppercase; white-space: nowrap; flex-shrink: 0; }
        .nav-join { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; font-size: 13.5px; font-weight: 600; color: white; border-radius: 9999px; background: #1E90FF; box-shadow: 0 8px 24px -12px rgba(30,144,255,0.5); transition: transform 0.2s ease, background 0.2s ease; text-decoration: none; border: none; cursor: pointer; font-family: 'Inter', sans-serif; }
        .nav-join:hover { transform: translateY(-1px); background: #1873cc; color: white; }
        .nav-login-btn { font-size: 13.5px; font-weight: 500; color: rgba(255,255,255,0.8); transition: color 0.15s; text-decoration: none; cursor: pointer; background: none; border: none; padding: 0; font-family: 'Inter', sans-serif; }
        .nav-login-btn:hover { color: white; }
        .nav-ham { display: flex; flex-direction: column; gap: 5px; cursor: pointer; padding: 8px 6px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; }
        @media (min-width: 1024px) { .nav-ham { display: none; } }
        .nav-ham span { display: block; width: 20px; height: 2px; background: rgba(255,255,255,0.7); border-radius: 2px; transition: all 0.3s; }
        .nav-ham.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .nav-ham.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .nav-ham.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }
        .nav-drawer { position: fixed; top: 0; right: 0; width: 280px; height: 100vh; background: rgba(7,9,26,0.98); border-left: 1px solid rgba(255,255,255,0.08); flex-direction: column; z-index: 201; transform: translateX(100%); transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); padding-top: 80px; display: flex; backdrop-filter: blur(20px); overflow-y: auto; }
        .nav-drawer.open { transform: translateX(0); }
        .nav-drawer a, .nav-drawer button { padding: 16px 24px; color: rgba(255,255,255,0.7); font-size: 14px; font-weight: 500; border-bottom: 1px solid rgba(255,255,255,0.06); text-decoration: none; display: block; background: none; border-right: none; border-top: none; border-left: none; text-align: left; width: 100%; cursor: pointer; transition: color 0.15s; font-family: 'DM Sans', sans-serif; }
        .nav-drawer a:hover, .nav-drawer button:hover { color: white; }
        /* ===== SITE DESIGN UTILITIES — exact from reference ===== */
        .site-content { padding-top: 5.5rem; position: relative; z-index: 1; }
        /* Buttons — fully pill-shaped */
        .btn-primary {
            display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;
            padding:0.75rem 1.5rem;border-radius:9999px;
            background:#1E90FF;
            color:white;font-weight:600;font-size:0.95rem;
            box-shadow:0 8px 24px -12px rgba(30,144,255,0.5);
            transition:transform 0.2s ease,background 0.2s ease;
            text-decoration:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;
        }
        .btn-primary:hover { transform:translateY(-1px);background:#1873cc;color:white; }
        .btn-secondary {
            display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;
            padding:0.75rem 1.5rem;border-radius:9999px;
            background:transparent;border:1px solid rgba(255,255,255,0.15);
            color:white;font-weight:600;font-size:0.95rem;
            transition:all 0.2s ease;text-decoration:none;cursor:pointer;font-family:'Inter',sans-serif;
        }
        .btn-secondary:hover { background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.3);color:white; }
        /* Cards */
        .glass {
            background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.1);
            border-radius:20px;backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
        }
        .card-glass {
            background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);
            border-radius:20px;backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
            transition:border-color 0.25s,box-shadow 0.3s;
        }
        .card-premium {
            background:#0C1020;
            border:1px solid rgba(255,255,255,0.08);border-radius:1rem;
            box-shadow:0 20px 50px -20px rgba(0,0,0,0.7);
            transition:transform 0.3s ease,border-color 0.3s ease;
        }
        .card-premium:hover { transform:translateY(-3px);border-color:rgba(255,255,255,0.18); }
        /* Text utilities */
        .gradient-text { color:#ffffff; }
        .gradient-text-vivid { color:#22D3EE; }
        .glow-text { text-shadow:0 0 40px rgba(14,165,233,0.45); }
        .eyebrow { font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;color:#94A3B8; }
        .container-x { max-width:1200px;margin-inline:auto;padding-inline:1.5rem; }
        .divider-glow { height:1px;background:rgba(255,255,255,0.1); }
        /* ===== CHAT WIDGET MOBILE ===== */
        @media (max-width: 520px) {
            #chatPanel {
                right: 0; left: 0; bottom: 0;
                width: 100%; max-height: 75vh;
                border-radius: 20px 20px 0 0;
                border-left: none; border-right: none; border-bottom: none;
            }
            #chatBtn { bottom: 16px; right: 16px; width: 50px; height: 50px; }
        }
    </style>
    @stack('styles')
    <style>
        /* ===== MODAL ===== */
        .modal-overlay { position: fixed; inset: 0; background: rgba(3,5,15,0.85); z-index: 1000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); overflow-y: auto; padding: 24px 16px; }
        .modal-overlay.active { display: flex; }
        @keyframes modalIn { from { opacity: 0; transform: scale(0.95) translateY(16px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .modal-tab-content { display: none; }
        .modal-tab-content.active { display: block; }
        .modal-input {
            width: 100%;
            height: 48px;
            padding: 0 44px 0 42px;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            background: rgba(255,255,255,0.04);
            color: #F0F0FF;
            box-sizing: border-box;
        }
        .modal-input::placeholder { color: #64748B; }
        .modal-input:focus { outline: none; border-color: rgba(34,211,238,0.5); background: rgba(255,255,255,0.06); box-shadow: 0 0 0 4px rgba(34,211,238,0.1); }
        .modal-btn {
            width: 100%;
            padding: 13px;
            background: #1E90FF;
            color: white;
            border: none;
            border-radius: 9999px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            box-shadow: 0 8px 24px -8px rgba(30,144,255,0.5);
            display: flex; align-items: center; justify-content: center;
        }
        .modal-btn:hover { transform: translateY(-1px); background: #1873cc; }
        .modal-remember { display: flex; align-items: center; gap: 8px; }
        .modal-remember input[type=checkbox] { width: 16px; height: 16px; accent-color: #1E90FF; cursor: pointer; flex-shrink: 0; }
        .modal-remember label { font-size: 13px; color: #94A3B8; cursor: pointer; user-select: none; }
        .modal-divider { display: flex; align-items: center; gap: 10px; margin: 16px 0; }
        .modal-divider span { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.15em; color: #64748B; white-space: nowrap; }
        .modal-divider::before, .modal-divider::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.08); }
        .modal-error { color: #ef4444; font-size: 13px; margin-top: 4px; display: none; }
        @media (max-width: 700px) {
            .modal-overlay > div { grid-template-columns: 1fr !important; }
            .modal-overlay > div > div:first-child { display: none !important; }
        }
    </style>
</head>
<body>
    {{-- Flash notifications --}}
    @if(session('info'))
    <div id="flash-info" style="position:fixed;top:20px;left:50%;transform:translateX(-50%);z-index:9999;background:#0A0F1E;border:1px solid rgba(99,102,241,.3);border-radius:50px;padding:12px 24px;display:flex;align-items:center;gap:10px;box-shadow:0 8px 32px rgba(0,0,0,.5);">
        <span style="font-size:16px;">📧</span>
        <span style="font-size:13px;font-weight:600;color:#fff;white-space:nowrap;">{{ session('info') }}</span>
    </div>
    <script>setTimeout(function(){var t=document.getElementById('flash-info');if(t){t.style.transition='opacity .4s';t.style.opacity='0';setTimeout(function(){t.remove()},400);}},5000);</script>
    @endif
    @if(session('error'))
    <div id="flash-error" style="position:fixed;top:20px;left:50%;transform:translateX(-50%);z-index:9999;background:#0A0F1E;border:1px solid rgba(239,68,68,.3);border-radius:50px;padding:12px 24px;display:flex;align-items:center;gap:10px;box-shadow:0 8px 32px rgba(0,0,0,.5);">
        <span style="font-size:16px;">⚠️</span>
        <span style="font-size:13px;font-weight:600;color:#f87171;white-space:nowrap;">{{ session('error') }}</span>
    </div>
    <script>setTimeout(function(){var t=document.getElementById('flash-error');if(t){t.style.transition='opacity .4s';t.style.opacity='0';setTimeout(function(){t.remove()},400);}},5000);</script>
    @endif
    {{-- ═══ GLOBAL AURORA BACKGROUND ═══ --}}
    <div id="aurora-bg" style="position:fixed;inset:0;z-index:0;overflow:hidden;pointer-events:none;background:#060818;">
        {{-- Blob 1: top-left blue --}}
        <div style="position:absolute;top:-20%;left:-10%;width:60vw;height:60vw;border-radius:9999px;background:#1E90FF;filter:blur(160px);opacity:0.12;"></div>
        {{-- Blob 2: bottom-right cyan --}}
        <div style="position:absolute;bottom:-20%;right:-10%;width:55vw;height:55vw;border-radius:9999px;background:#0EA5E9;filter:blur(160px);opacity:0.10;"></div>
        {{-- Noise overlay --}}
        <div class="noise-overlay"></div>
        {{-- Vignette --}}
        <div class="vignette"></div>
        {{-- Particles --}}
        <canvas id="particleCanvas" style="position:absolute;inset:0;width:100%;height:100%;opacity:0.5;"></canvas>
    </div>

    <div class="nav-overlay" id="navOverlay" onclick="closeNav()"></div>

    {{-- Floating pill nav --}}
    <header class="site-header">
        <nav class="pill-nav">
            {{-- Logo --}}
            <a href="{{ route('home') }}" style="text-decoration:none;flex-shrink:0;display:flex;align-items:center;">
                <img src="{{ asset('images/Sports-Handicappers.png') }}" alt="Sportshandicapper" style="height:110px;width:auto;object-fit:contain;margin:-32px 0;">
            </a>

            {{-- Pill-grouped nav links --}}
            <div class="nav-pill-group">
                <a href="{{ route('articles') }}" class="nav-pitem {{ request()->routeIs('article*') || request()->routeIs('articles') ? 'active' : '' }}" style="position:relative;">
                    Exclusive Articles
                    <span class="nav-pitem-badge">New</span>
                </a>
                <a href="{{ route('picks') }}" class="nav-pitem {{ request()->routeIs('picks') ? 'active' : '' }}">
                    <span class="nav-pitem-pulse"></span>Picks
                </a>
                <a href="{{ route('join') }}" class="nav-pitem {{ request()->routeIs('join') ? 'active' : '' }}">
                    Packages
                </a>
                <div class="nav-pdivider"></div>
                <div class="nav-pdrop">
                    <button class="nav-pdrop-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        Data &amp; Tools
                        <svg class="caret" width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <div class="nav-pdrop-menu">
                        @foreach([['Betting Tools','Calculators &amp; trackers'],['Live Odds','Real-time odds comparison'],['Consensus','Public betting splits'],['Trends','Hot streaks &amp; patterns']] as $item)
                        <div class="nav-pdrop-item">
                            <div><p class="nav-pdrop-label">{{ $item[0] }}</p><p class="nav-pdrop-sub">{!! $item[1] !!}</p></div>
                            <span class="nav-pdrop-soon">Soon</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('about') }}" class="nav-pitem {{ request()->routeIs('about') ? 'active' : '' }}">
                    About Us
                </a>
            </div>

            {{-- Actions --}}
            <div style="display:flex;align-items:center;gap:16px;flex-shrink:0;">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="nav-login-btn">{{ Auth::user()->name }}</a>
                    @else
                        <a href="/subscriber/dashboard" class="nav-login-btn">{{ Auth::user()->name }}</a>
                    @endif
                    <button type="button" onclick="doLogout()" class="nav-login-btn" style="color:#6e6e8a;">Logout</button>
                @else
                    <button onclick="openModal()" class="nav-login-btn" style="display:none;" id="desktopLogin">Log In</button>
                    <button onclick="openModal()" class="nav-login-btn" id="desktopLoginShow">Log In</button>
                    <a onclick="openModal('join');return false;" href="#" class="nav-join">
                        Join Now
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                @endauth
                <button class="nav-ham" id="hamburger" onclick="toggleNav()">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </nav>
    </header>

    {{-- Mobile slide-out drawer --}}
    <div class="nav-drawer" id="mainNav">
        <a href="{{ route('articles') }}">Exclusive Articles</a>
        <a href="{{ route('picks') }}">Picks</a>
        <a href="{{ route('join') }}">Packages</a>
        <a href="{{ route('tools') }}">Betting Tools</a>
        <a href="{{ route('odds') }}">Live Odds</a>
        <a href="{{ route('consensus') }}">Consensus</a>
        <a href="{{ route('trends') }}">Trends</a>
        <a href="{{ route('about') }}">About Us</a>
        @auth
            <a href="{{ Auth::user()->isAdmin() ? route('dashboard') : '/subscriber/dashboard' }}">My Account</a>
            <button type="button" onclick="doLogout()">Logout</button>
        @else
            <button onclick="openModal();closeNav()">Log In</button>
            <button onclick="openModal('join');closeNav()">Join Now</button>
        @endauth
    </div>

    <div class="site-content">
        @yield('content')
    </div>

    <footer style="background:#060818;border-top:1px solid rgba(255,255,255,0.05);padding:48px 0 0;position:relative;z-index:1;">
        <div class="container-x">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;padding-bottom:32px;" class="footer-grid-resp">
                {{-- Brand column --}}
                <div>
                    <div style="margin-bottom:16px;">
                        <img src="{{ asset('images/Sports-Handicappers.png') }}" alt="Sportshandicapper" style="height:80px;width:auto;object-fit:contain;">
                    </div>
                    <p style="color:#64748B;font-size:13px;line-height:1.7;max-width:280px;">Simulation-powered sports picks with a verified 3-year track record. Built by bettors, powered by data.</p>
                </div>
                {{-- Links column --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
                    <div>
                        <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.15em;color:#64748B;margin-bottom:12px;">Product</p>
                        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px;">
                            <li><a href="{{ route('articles') }}" style="font-size:13px;color:#94A3B8;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#94A3B8'">Exclusive Articles</a></li>
                            <li><a href="{{ route('picks') }}" style="font-size:13px;color:#94A3B8;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#94A3B8'">Picks</a></li>
                            <li><a href="{{ route('join') }}" style="font-size:13px;color:#94A3B8;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#94A3B8'">Packages</a></li>
                            <li><a href="{{ route('about') }}" style="font-size:13px;color:#94A3B8;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#94A3B8'">About Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.15em;color:#64748B;margin-bottom:12px;">Legal</p>
                        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px;">
                            <li><a href="{{ route('privacy') }}" style="font-size:13px;color:#94A3B8;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#94A3B8'">Privacy Policy</a></li>
                            <li><a href="{{ route('terms') }}" style="font-size:13px;color:#94A3B8;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#94A3B8'">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="divider-glow"></div>
            <div style="padding:20px 0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <p style="font-size:12px;color:#334155;">&copy; {{ date('Y') }} Sportshandicapper.com &mdash; All Rights Reserved.</p>
                <p style="font-size:11px;color:#1E293B;max-width:480px;text-align:right;">For news and entertainment purposes only. 21+ · If you or someone you know has a gambling problem, call 1-800-GAMBLER.</p>
            </div>
        </div>
    </footer>
    <style>
    @media (max-width: 600px) {
        .footer-grid-resp { grid-template-columns: 1fr !important; }
    }
    </style>

    <!-- Auth Modal — two-column design -->
    <div id="authModal" class="modal-overlay" onclick="closeModal()">
        <div onclick="event.stopPropagation()" style="position:relative;width:100%;max-width:900px;display:grid;grid-template-columns:1.05fr 1fr;border-radius:24px;overflow:hidden;border:1px solid rgba(255,255,255,0.1);background:rgba(10,12,28,0.92);box-shadow:0 40px 120px -20px rgba(30,144,255,0.35);animation:modalIn 0.25s cubic-bezier(0.22,1,0.36,1);">
            <!-- Top cyan strip -->
            <div style="position:absolute;top:0;left:0;right:0;height:2px;background:rgba(34,211,238,0.5);z-index:1;"></div>

            <!-- LEFT: Brand panel -->
            <div style="position:relative;display:flex;flex-direction:column;justify-content:space-between;padding:40px;background:#0A0F22;overflow:hidden;">
                <div style="position:absolute;top:-20%;left:-15%;width:380px;height:380px;border-radius:9999px;background:#1E90FF;filter:blur(110px);opacity:0.5;pointer-events:none;"></div>
                <div style="position:absolute;bottom:-20%;right:-10%;width:340px;height:340px;border-radius:9999px;background:#A855F7;filter:blur(110px);opacity:0.4;pointer-events:none;"></div>
                <div style="position:absolute;inset:0;opacity:0.04;background-image:radial-gradient(circle at 1px 1px,white 1px,transparent 0);background-size:24px 24px;"></div>

                <div style="position:relative;">
                    <div style="margin-bottom:4px;">
                        <img src="{{ asset('images/Sports-Handicappers.png') }}" alt="Sportshandicapper" style="height:56px;width:auto;object-fit:contain;">
                    </div>
                    <div style="margin-top:32px;">
                        <div style="display:inline-flex;align-items:center;gap:8px;padding:5px 12px;border-radius:9999px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.15em;color:#CBD5E1;margin-bottom:20px;">
                            <span style="position:relative;display:inline-flex;width:6px;height:6px;border-radius:9999px;background:#22c55e;"></span>
                            Verified Picks · Live
                        </div>
                        <h2 style="font-size:clamp(1.5rem,2.5vw,2rem);font-weight:800;line-height:1.2;color:white;margin:0 0 16px;">Sharper picks.<br><span style="color:#22D3EE;">Smarter bankroll.</span></h2>
                        <p style="color:#94A3B8;font-size:13px;line-height:1.7;max-width:280px;margin:0;">Join thousands of bettors winning with timestamped, graded picks from verified handicappers — across every major league.</p>
                    </div>
                </div>

                <div style="position:relative;display:flex;flex-direction:column;gap:10px;margin-top:32px;">
                    @foreach([['📈','+184u YTD verified profit'],['🛡️','100% timestamped &amp; graded'],['🏆','Top 1% capper leaderboard']] as $feat)
                    <div style="display:flex;align-items:center;gap:12px;border-radius:12px;border:1px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.03);padding:10px 14px;">
                        <div style="width:32px;height:32px;border-radius:8px;background:#1E90FF;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;">{{ $feat[0] }}</div>
                        <span style="font-size:13px;color:#CBD5E1;">{!! $feat[1] !!}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT: Form panel -->
            <div style="position:relative;padding:28px 32px 32px;overflow-y:auto;max-height:90vh;">
                <button onclick="closeModal()" style="position:absolute;top:16px;right:16px;width:32px;height:32px;border-radius:9999px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);cursor:pointer;display:flex;align-items:center;justify-content:center;color:#94A3B8;font-size:16px;line-height:1;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">&times;</button>

                <div style="margin-bottom:20px;">
                    <div class="eyebrow" style="color:#6366F1;display:flex;align-items:center;gap:6px;margin-bottom:6px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1l3 6 6.5 1-4.7 4.6 1.1 6.4L12 16l-5.9 3 1.1-6.4L2.5 8 9 7z"/></svg>
                        <span id="modalEyebrow">Welcome back</span>
                    </div>
                    <h3 id="modalTitle" style="font-size:1.6rem;font-weight:800;color:white;margin:0 0 6px;">Sign in to your account</h3>
                    <p id="modalSubtitle" style="font-size:13px;color:#64748B;margin:0;">Access today's picks and your tracked bankroll.</p>
                </div>

                <!-- Sliding tab switcher -->
                <div style="position:relative;display:grid;grid-template-columns:1fr 1fr;padding:4px;border-radius:9999px;border:1px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.03);margin-bottom:24px;">
                    <span id="tabSlider" style="position:absolute;top:4px;bottom:4px;width:calc(50% - 4px);border-radius:9999px;background:#1E90FF;box-shadow:0 8px 24px -8px rgba(30,144,255,0.7);transition:transform 0.25s ease;transform:translateX(4px);"></span>
                    <button id="tabLoginBtn" onclick="switchTab('login')" style="position:relative;z-index:1;padding:10px;background:none;border:none;font-size:13.5px;font-weight:600;cursor:pointer;border-radius:9999px;color:white;font-family:'Inter',sans-serif;transition:color .2s;">Log In</button>
                    <button id="tabRegisterBtn" onclick="switchTab('register')" style="position:relative;z-index:1;padding:10px;background:none;border:none;font-size:13.5px;font-weight:600;cursor:pointer;border-radius:9999px;color:#94A3B8;font-family:'Inter',sans-serif;transition:color .2s;">Join Now</button>
                </div>

                <!-- Login Form -->
                <div id="loginTab" class="modal-tab-content active">
                    <form id="loginForm" style="display:flex;flex-direction:column;gap:14px;">
                        <div style="position:relative;">
                            <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#64748B;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </div>
                            <input type="email" class="modal-input" placeholder="Email address" name="email" required autocomplete="email" style="padding-left:42px;">
                        </div>
                        <div style="position:relative;">
                            <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#64748B;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            </div>
                            <input type="password" id="loginPassword" class="modal-input" placeholder="Password" name="password" required autocomplete="current-password" style="padding-left:42px;padding-right:44px;margin-bottom:0;">
                            <button type="button" onclick="togglePw('loginPassword',this)" tabindex="-1" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#64748B;line-height:1;padding:0;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div class="modal-remember">
                                <input type="checkbox" id="rememberMe" name="remember">
                                <label for="rememberMe">Remember me</label>
                            </div>
                            <a href="{{ route('password.request') }}" style="font-size:12.5px;color:#22D3EE;text-decoration:none;" onmouseover="this.style.color='#7DD3FC'" onmouseout="this.style.color='#22D3EE'">Forgot password?</a>
                        </div>
                        <button type="submit" class="modal-btn" style="margin-top:0;">Log In</button>
                        <div id="loginError" class="modal-error"></div>
                        <p style="text-align:center;font-size:13px;color:#64748B;margin:0;">Don't have an account? <a href="#" onclick="switchTab('register');return false;" style="color:#22D3EE;font-weight:600;text-decoration:none;">Join Now</a></p>
                    </form>
                </div>

                <!-- Register Form -->
                <div id="registerTab" class="modal-tab-content">
                    {{-- Step 1: Disclaimer --}}
                    <div id="registerDisclaimer">
                        <div style="border-radius:12px;border:1px solid rgba(251,191,36,0.2);background:rgba(251,191,36,0.04);padding:14px 16px;margin-bottom:16px;">
                            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.15em;color:#FCD34D;margin-bottom:6px;">This is not a gambling site</div>
                            <p style="font-size:12px;color:#94A3B8;line-height:1.6;margin:0 0 12px;">Information is for entertainment purposes only. Past performance is not a guarantee of future results.</p>
                            <div style="display:flex;flex-direction:column;gap:8px;">
                                <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;">
                                    <input type="checkbox" id="agreeTerms" style="width:16px;height:16px;accent-color:#1E90FF;flex-shrink:0;margin-top:2px;">
                                    <span style="font-size:12px;color:#94A3B8;line-height:1.5;">I agree to the <a href="{{ route('terms') }}" target="_blank" style="color:#22D3EE;text-decoration:none;">Terms of Service</a></span>
                                </label>
                                <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;">
                                    <input type="checkbox" id="agreePrivacy" style="width:16px;height:16px;accent-color:#1E90FF;flex-shrink:0;margin-top:2px;">
                                    <span style="font-size:12px;color:#94A3B8;line-height:1.5;">I agree to the <a href="{{ route('privacy') }}" target="_blank" style="color:#22D3EE;text-decoration:none;">Privacy Policy</a></span>
                                </label>
                            </div>
                        </div>
                        <div id="checkboxError" style="color:#ef4444;font-size:12px;margin-bottom:10px;display:none;">Please agree to both the Terms of Service and Privacy Policy to continue.</div>
                        <button type="button" onclick="checkAndContinue()" class="modal-btn">I Understand — Continue</button>
                        <div class="modal-divider" style="margin-top:16px;"><span>or</span></div>
                        <p style="text-align:center;font-size:13px;color:#64748B;margin:0;">Already have an account? <a href="#" onclick="switchTab('login');return false;" style="color:#22D3EE;font-weight:600;text-decoration:none;">Log In</a></p>
                    </div>
                    {{-- Step 2: Registration fields --}}
                    <div id="registerFormFields" style="display:none;">
                        <form id="registerForm" style="display:flex;flex-direction:column;gap:12px;">
                            <div style="position:relative;">
                                <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#64748B;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                                <input type="text" class="modal-input" placeholder="Full name" name="name" required autocomplete="name" style="margin-bottom:0;padding-left:42px;">
                            </div>
                            <div style="position:relative;">
                                <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#64748B;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                                <input type="email" class="modal-input" placeholder="Email address" name="email" required autocomplete="email" style="margin-bottom:0;padding-left:42px;">
                            </div>
                            <div style="position:relative;">
                                <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#64748B;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></div>
                                <input type="password" id="regPassword" class="modal-input" placeholder="Password" name="password" required autocomplete="new-password" style="margin-bottom:0;padding-left:42px;padding-right:44px;">
                                <button type="button" onclick="togglePw('regPassword',this)" tabindex="-1" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#64748B;line-height:1;padding:0;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                            </div>
                            <div style="position:relative;">
                                <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#64748B;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></div>
                                <input type="password" id="regPasswordConfirm" class="modal-input" placeholder="Confirm password" name="password_confirmation" required autocomplete="new-password" style="margin-bottom:0;padding-left:42px;padding-right:44px;">
                                <button type="button" onclick="togglePw('regPasswordConfirm',this)" tabindex="-1" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#64748B;line-height:1;padding:0;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                            </div>
                            <button type="submit" class="modal-btn">Create Account</button>
                            <div id="registerError" class="modal-error"></div>
                            <p style="text-align:center;font-size:13px;color:#64748B;margin:0;">Already have an account? <a href="#" onclick="switchTab('login');return false;" style="color:#22D3EE;font-weight:600;text-decoration:none;">Log In</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data & Tools dropdown
        function toggleDropdown(e) {
            e.preventDefault();
            var wrap = e.currentTarget.closest('.nav-dropdown-wrap');
            var isOpen = wrap.classList.contains('open');
            // Close all other dropdowns
            document.querySelectorAll('.nav-dropdown-wrap.open').forEach(function(el) { el.classList.remove('open'); });
            if (!isOpen) wrap.classList.add('open');
        }
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.nav-dropdown-wrap')) {
                document.querySelectorAll('.nav-dropdown-wrap.open').forEach(function(el) { el.classList.remove('open'); });
            }
        });

        function resendVerification(email) {
            var btn = document.getElementById('resendVerifyBtn');
            if (btn) { btn.disabled = true; btn.textContent = 'Sending...'; }
            fetch('/email/verification-notification', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ email: email })
            })
            .then(function(r){ return r.json(); })
            .then(function(){
                if (btn) { btn.textContent = '✓ Email Resent — Check Your Inbox'; btn.style.background = 'rgba(0,209,91,.1)'; btn.style.borderColor = 'rgba(0,209,91,.3)'; btn.style.color = '#00D15B'; }
            })
            .catch(function(){
                if (btn) { btn.disabled = false; btn.textContent = '↺ Resend Verification Email'; }
            });
        }

        // Logout using fresh CSRF token from meta tag (avoids 419 errors)
        function doLogout() {
            var token = document.querySelector('meta[name="csrf-token"]');
            if (!token) { document.location = '/'; return; }
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token.content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(function() {
                window.location.href = '/';
            }).catch(function() {
                window.location.href = '/';
            });
        }

        // Nav toggle
        function toggleNav() {
            var nav = document.getElementById('mainNav');
            var btn = document.getElementById('hamburger');
            var overlay = document.getElementById('navOverlay');
            var isOpen = nav.classList.contains('open');
            if (isOpen) {
                nav.classList.remove('open');
                btn.classList.remove('open');
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            } else {
                nav.classList.add('open');
                btn.classList.add('open');
                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
        }
        function closeNav() {
            document.getElementById('mainNav').classList.remove('open');
            document.getElementById('hamburger').classList.remove('open');
            document.getElementById('navOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        // Close nav on resize back to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) closeNav();
        });

        // Modal functions
        function openModal(tab) {
            document.getElementById('authModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            switchTab(tab === 'join' ? 'register' : 'login');
        }
        
        function closeModal() {
            document.getElementById('authModal').classList.remove('active');
            document.body.style.overflow = '';
        }
        
        function togglePw(id, btn) {
            var el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
            btn.style.opacity = el.type === 'text' ? '1' : '0.5';
        }

        function showRegisterForm() {
            document.getElementById('registerDisclaimer').style.display = 'none';
            document.getElementById('registerFormFields').style.display = 'block';
        }

        function checkAndContinue() {
            var terms = document.getElementById('agreeTerms');
            var privacy = document.getElementById('agreePrivacy');
            var err = document.getElementById('checkboxError');
            if (!terms.checked || !privacy.checked) {
                err.style.display = 'block';
                return;
            }
            err.style.display = 'none';
            showRegisterForm();
        }

        function switchTab(tab) {
            document.querySelectorAll('.modal-tab-content').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.modal-error').forEach(e => e.style.display = 'none');
            // Reset register disclaimer on tab switch
            var disc = document.getElementById('registerDisclaimer');
            var fields = document.getElementById('registerFormFields');
            if (disc) disc.style.display = 'block';
            if (fields) fields.style.display = 'none';
            var t = document.getElementById('agreeTerms'); if (t) t.checked = false;
            var p = document.getElementById('agreePrivacy'); if (p) p.checked = false;
            var e = document.getElementById('checkboxError'); if (e) e.style.display = 'none';

            var slider = document.getElementById('tabSlider');
            var loginBtn = document.getElementById('tabLoginBtn');
            var registerBtn = document.getElementById('tabRegisterBtn');

            if (tab === 'login') {
                document.getElementById('loginTab').classList.add('active');
                if (slider) slider.style.transform = 'translateX(4px)';
                if (loginBtn) loginBtn.style.color = 'white';
                if (registerBtn) registerBtn.style.color = '#94A3B8';
                var eyebrow = document.getElementById('modalEyebrow');
                if (eyebrow) eyebrow.textContent = 'Welcome back';
                var title = document.getElementById('modalTitle');
                if (title) title.textContent = 'Sign in to your account';
                var sub = document.getElementById('modalSubtitle');
                if (sub) sub.textContent = 'Access today\'s picks and your tracked bankroll.';
            } else {
                document.getElementById('registerTab').classList.add('active');
                if (slider) slider.style.transform = 'translateX(calc(100% + 4px))';
                if (loginBtn) loginBtn.style.color = '#94A3B8';
                if (registerBtn) registerBtn.style.color = 'white';
                var eyebrow = document.getElementById('modalEyebrow');
                if (eyebrow) eyebrow.textContent = 'Join the edge';
                var title = document.getElementById('modalTitle');
                if (title) title.textContent = 'Create your account';
                var sub = document.getElementById('modalSubtitle');
                if (sub) sub.textContent = 'Start with a free trial — cancel anytime.';
            }
        }
        
        // Modal only closes via the X button — clicking outside does nothing
        
        // Handle login form
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            if (document.getElementById('rememberMe').checked) {
                formData.set('remember', '1');
            }
            const errorDiv = document.getElementById('loginError');
            
            fetch('/login', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect || '{{ route('dashboard') }}';
                } else if (data.verified === false) {
                    // Show email verification required message inside modal
                    document.querySelector('#loginTab .modal-body, #loginTab form')?.closest('form')?.parentElement
                    errorDiv.innerHTML = '📧 <strong>Email not verified.</strong> We just resent the link — check your inbox and spam folder, then try again.';
                    errorDiv.style.display = 'block';
                } else {
                    errorDiv.textContent = data.message || 'Login failed. Please check your credentials.';
                    errorDiv.style.display = 'block';
                }
            })
            .catch(error => {
                errorDiv.textContent = 'An error occurred. Please try again.';
                errorDiv.style.display = 'block';
            });
        });

        // Handle register form
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const errorDiv = document.getElementById('registerError');
            
            fetch('/register', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Store registered email for resend
                    var regEmail = formData.get('email');
                    document.getElementById('registerFormFields').innerHTML =
                        '<div style="text-align:center;padding:10px 0;">' +
                        '<div style="font-size:3rem;margin-bottom:14px;">📧</div>' +
                        '<h3 style="color:#fff;font-size:1.15rem;font-weight:700;margin-bottom:8px;">Check Your Email</h3>' +
                        '<p style="color:rgba(255,255,255,.5);font-size:13px;line-height:1.7;margin-bottom:6px;">' +
                        'We sent a verification link to<br><strong style="color:#6366F1;">' + regEmail + '</strong>' +
                        '</p>' +
                        '<p style="color:rgba(255,255,255,.4);font-size:12px;margin-bottom:18px;">Click the link in that email to activate your account and start your <strong style="color:#fff;">7-day free trial</strong>.</p>' +
                        '<div style="background:rgba(99,102,241,.06);border:1px solid rgba(99,102,241,.15);border-radius:10px;padding:14px;margin-bottom:16px;font-size:12px;color:rgba(255,255,255,.4);text-align:left;">' +
                        '<strong style="color:#6366F1;display:block;margin-bottom:4px;">📬 Didn\'t receive it?</strong>' +
                        'Check your <strong style="color:#fff;">spam or junk folder</strong> first. If it\'s not there, click the button below to resend.' +
                        '</div>' +
                        '<button id="resendVerifyBtn" onclick="resendVerification(\'' + regEmail + '\')" ' +
                        'style="width:100%;padding:12px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.15);color:#fff;border-radius:50px;font-size:13px;font-weight:600;cursor:pointer;font-family:\'Inter\',sans-serif;margin-bottom:10px;">'+
                        '↺ &nbsp;Resend Verification Email' +
                        '</button>' +
                        '<p style="font-size:11px;color:rgba(255,255,255,.2);">Already verified? <a href="/" onclick="openModal();switchTab(\'login\');return false;" style="color:rgba(255,255,255,.4);">Log in here →</a></p>' +
                        '</div>';
                    document.getElementById('registerDisclaimer').style.display = 'none';
                } else {
                    errorDiv.textContent = data.message || 'Registration failed. Please try again.';
                    errorDiv.style.display = 'block';
                }
            })
            .catch(error => {
                errorDiv.textContent = 'An error occurred. Please try again.';
                errorDiv.style.display = 'block';
            });
        });
        
    </script>
    @stack('scripts')

    {{-- ═══ CONTACT US FLOATING BUTTON ═══ --}}
    <style>
        #contactBtn {
            position:fixed; bottom:88px; right:24px; z-index:8990;
            width:50px; height:50px; border-radius:50%;
            background:#1E2640; border:1.5px solid rgba(99,102,241,.35);
            cursor:pointer; display:flex; align-items:center; justify-content:center;
            box-shadow:0 4px 16px rgba(0,0,0,.5), 0 0 0 1px rgba(99,102,241,.08);
            transition:border-color .2s, box-shadow .2s, background .2s;
        }
        #contactBtn:hover { background:#2A3556; border-color:rgba(99,102,241,.6); box-shadow:0 4px 20px rgba(99,102,241,.2); }
        #contactMenu {
            position:fixed; bottom:148px; right:24px; z-index:8989;
            display:flex; flex-direction:column; gap:10px; align-items:flex-end;
            pointer-events:none; opacity:0;
            transform:translateY(10px);
            transition:opacity .22s, transform .22s;
        }
        #contactMenu.open { opacity:1; transform:translateY(0); pointer-events:all; }
        .contact-item {
            display:flex; align-items:center; gap:10px; cursor:pointer;
        }
        .contact-label {
            background:#0A0F1E; border:1px solid rgba(99,102,241,.1);
            color:#F0F0FF; font-size:12px; font-weight:600;
            padding:6px 12px; border-radius:8px; white-space:nowrap;
            box-shadow:0 2px 10px rgba(0,0,0,.3);
        }
        .contact-icon {
            width:44px; height:44px; border-radius:50%; flex-shrink:0;
            display:flex; align-items:center; justify-content:center;
            font-size:18px; box-shadow:0 2px 10px rgba(0,0,0,.3);
            text-decoration:none; transition:transform .15s;
        }
        .contact-icon:hover { transform:scale(1.1); }
    </style>

    {{-- Contact Menu Items --}}
    <div id="contactMenu">
        <div class="contact-item">
            <span class="contact-label">Call Us</span>
            <a href="tel:#" class="contact-icon" style="background:#1E2640;border:1px solid rgba(99,102,241,.12);" title="Call">
                📞
            </a>
        </div>
        <div class="contact-item">
            <span class="contact-label">Send Email</span>
            <a href="mailto:#" class="contact-icon" style="background:#EA4335;" title="Email">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4Z" fill="white" fill-opacity="0.2" stroke="white" stroke-width="1.5"/>
                    <path d="M22 6L12 13L2 6" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        <div class="contact-item">
            <span class="contact-label">Telegram</span>
            <a href="https://t.me/#" target="_blank" rel="noopener" class="contact-icon" style="background:#229ED9;" title="Telegram">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="white"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.248-2.012 9.475c-.148.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.462c.537-.194 1.006.131.875.747z"/></svg>
            </a>
        </div>
        <div class="contact-item">
            <span class="contact-label">WhatsApp</span>
            <a href="https://wa.me/#" target="_blank" rel="noopener" class="contact-icon" style="background:#25D366;" title="WhatsApp">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
        </div>
    </div>

    {{-- Contact Toggle Button --}}
    <button id="contactBtn" onclick="toggleContact()" title="Contact Us">
        <svg width="20" height="20" fill="none" stroke="#F0F0FF" stroke-width="2" viewBox="0 0 24 24" id="contactIcon"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.22 1.18 2 2 0 012.22 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.56-.56a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/></svg>
    </button>

    <script>
    var contactOpen = false;
    function toggleContact() {
        contactOpen = !contactOpen;
        document.getElementById('contactMenu').classList.toggle('open', contactOpen);
        var icon = document.getElementById('contactIcon');
        icon.style.stroke = contactOpen ? '#6366F1' : '#F0F0FF';
    }
    // Close contact menu if chat opens
    var origToggleChat = typeof toggleChat === 'function' ? toggleChat : null;
    </script>

    {{-- ═══ INSPIN AI CHAT WIDGET ═══ --}}
    <style>
        #chatBtn {
            position:fixed; bottom:24px; right:24px; z-index:9000;
            width:54px; height:54px; border-radius:50%;
            background:linear-gradient(135deg,#818CF8,#6366F1);
            border:none; cursor:pointer;
            box-shadow:0 4px 20px rgba(99,102,241,.5), 0 0 0 0 rgba(99,102,241,.4);
            display:flex; align-items:center; justify-content:center;
            transition:transform .2s, box-shadow .2s;
            animation:chatPulse 2.5s infinite;
        }
        #chatBtn:hover { transform:scale(1.08); box-shadow:0 6px 28px rgba(99,102,241,.7); animation:none; }
        @keyframes chatPulse {
            0%,100% { box-shadow:0 4px 20px rgba(99,102,241,.5),0 0 0 0 rgba(99,102,241,.35); }
            50%      { box-shadow:0 4px 20px rgba(99,102,241,.5),0 0 0 10px rgba(99,102,241,0); }
        }
        #chatBadge {
            position:absolute; top:-4px; right:-4px;
            width:18px; height:18px; border-radius:50%;
            background:#ef4444; color:#fff; font-size:10px; font-weight:700;
            display:flex; align-items:center; justify-content:center;
            border:2px solid #060818;
        }
        #chatPanel {
            position:fixed; bottom:88px; right:24px; z-index:8999;
            width:340px; max-height:520px;
            background:#0D1224; border:1px solid rgba(99,102,241,.3);
            border-radius:16px; overflow:hidden;
            box-shadow:0 20px 60px rgba(0,0,0,.7), 0 0 40px rgba(99,102,241,.06);
            display:none; flex-direction:column;
            animation:chatSlideIn .22s cubic-bezier(.34,1.56,.64,1);
        }
        #chatPanel.open { display:flex; }
        @keyframes chatSlideIn { from{opacity:0;transform:translateY(16px) scale(.96)} to{opacity:1;transform:none} }
        #chatHeader {
            background:linear-gradient(135deg,#0D1224,#141B35);
            border-bottom:1px solid rgba(99,102,241,.2);
            padding:14px 16px; display:flex; align-items:center; gap:10px; flex-shrink:0;
        }
        #chatAvatar {
            width:36px; height:36px; border-radius:50%;
            background:#000; overflow:hidden;
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        #chatMessages {
            flex:1; overflow-y:auto; padding:16px; display:flex; flex-direction:column; gap:10px;
            scroll-behavior:smooth;
        }
        #chatMessages::-webkit-scrollbar { width:4px; }
        #chatMessages::-webkit-scrollbar-track { background:transparent; }
        #chatMessages::-webkit-scrollbar-thumb { background:#1E2640; border-radius:4px; }
        .chat-msg { display:flex; gap:8px; align-items:flex-end; }
        .chat-msg.user { flex-direction:row-reverse; }
        .chat-bubble {
            max-width:80%; min-width:60px; padding:10px 14px; border-radius:14px;
            font-size:13px; line-height:1.55; overflow-wrap:break-word; word-break:normal;
            white-space:pre-wrap;
        }
        .chat-bubble.bot {
            background:#141B35; color:#b0b0c8; border:1px solid rgba(99,102,241,.12);
            border-bottom-left-radius:4px;
        }
        .chat-bubble.user {
            background:linear-gradient(135deg,#818CF8,#6366F1);
            color:#060818; font-weight:600; border-bottom-right-radius:4px;
        }
        .chat-time { font-size:10px; color:#4a4a4a; margin-top:2px; text-align:center; }
        #chatTyping { display:none; align-items:center; gap:6px; padding:0 4px; }
        #chatTyping span { width:6px; height:6px; border-radius:50%; background:#818CF8; opacity:.4; animation:typingDot 1.2s infinite; }
        #chatTyping span:nth-child(2) { animation-delay:.2s; }
        #chatTyping span:nth-child(3) { animation-delay:.4s; }
        @keyframes typingDot { 0%,80%,100%{opacity:.4;transform:scale(1)} 40%{opacity:1;transform:scale(1.2)} }
        #chatInputArea {
            border-top:1px solid rgba(99,102,241,.08);
            padding:12px; display:flex; gap:8px; align-items:center; flex-shrink:0;
            background:#060818;
        }
        #chatInput {
            flex:1; background:#0D1224; border:1px solid rgba(99,102,241,.1);
            border-radius:50px; padding:9px 16px; color:#F0F0FF; font-size:13px;
            font-family:'DM Sans',sans-serif; outline:none; transition:border-color .2s;
        }
        #chatInput::placeholder { color:#4a4a4a; }
        #chatInput:focus { border-color:rgba(99,102,241,.6); }
        #chatSend {
            width:36px; height:36px; border-radius:50%; border:none; cursor:pointer;
            background:linear-gradient(135deg,#818CF8,#6366F1); display:flex;
            align-items:center; justify-content:center; flex-shrink:0;
            transition:transform .15s, opacity .15s;
        }
        #chatSend:hover { transform:scale(1.08); }
        #chatSend:disabled { opacity:.4; cursor:default; transform:none; }
    </style>

    {{-- Chat Button --}}
    <button id="chatBtn" onclick="toggleChat()" aria-label="Open AI Support Chat">
        <span id="chatBadge">1</span>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#060818" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
        </svg>
    </button>

    {{-- Chat Panel --}}
    <div id="chatPanel">
        <div id="chatHeader">
            <div id="chatAvatar">
                <img src="{{ asset('images/chat-bot.png') }}" alt="INSPIN Assistant" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
            </div>
            <div style="flex:1;">
                <div style="font-size:13.5px;font-weight:700;color:#F0F0FF;font-family:'Space Grotesk',sans-serif;">SH Assistant</div>
                <div style="font-size:10px;color:#00D15B;display:flex;align-items:center;gap:4px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#00D15B;display:inline-block;"></span> Online · Replies instantly
                </div>
            </div>
            <button onclick="toggleChat()" style="background:rgba(99,102,241,.06);border:none;cursor:pointer;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#6e6e6e;font-size:16px;transition:background .15s;" onmouseover="this.style.background='rgba(99,102,241,.12)'" onmouseout="this.style.background='rgba(99,102,241,.06)'">&times;</button>
        </div>

        <div id="chatMessages">
            <div class="chat-msg">
                <img src="{{ asset('images/chat-bot.png') }}" alt="" style="width:28px;height:28px;border-radius:50%;object-fit:cover;flex-shrink:0;background:#000;">
                <div>
                    <div class="chat-bubble bot">👋 Hi! I'm the Sportshandicapper Assistant. I can help you with picks, packages, how the site works, or anything else. What can I help you with?</div>
                    <div class="chat-time">Just now</div>
                </div>
            </div>
            <div id="chatTyping" class="chat-msg">
                <img src="{{ asset('images/chat-bot.png') }}" style="width:28px;height:28px;border-radius:50%;object-fit:cover;flex-shrink:0;background:#000;">
                <div class="chat-bubble bot" style="padding:12px 16px;">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>

        <div id="chatInputArea">
            <input id="chatInput" type="text" placeholder="Ask me anything about Sportshandicapper…" maxlength="400" onkeydown="if(event.key==='Enter')sendChat()">
            <button id="chatSend" onclick="sendChat()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#060818" stroke-width="2.5" stroke-linecap="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            </button>
        </div>
    </div>

    <script>
    var chatOpen = false;
    var chatHistory = [];
    var botAvatarHtml = '<img src="{{ asset("images/chat-bot.png") }}" style="width:28px;height:28px;border-radius:50%;object-fit:cover;flex-shrink:0;background:#000;">';

    function toggleChat() {
        chatOpen = !chatOpen;
        document.getElementById('chatPanel').classList.toggle('open', chatOpen);
        document.getElementById('chatBadge').style.display = chatOpen ? 'none' : 'flex';
        sessionStorage.setItem('chatOpen', chatOpen ? '1' : '0');
        if (chatOpen) { scrollChat(); document.getElementById('chatInput').focus(); }
    }

    // Save chat to sessionStorage
    function saveChat() {
        sessionStorage.setItem('chatHistory', JSON.stringify(chatHistory));
    }

    // Restore chat from sessionStorage on page load
    function restoreChat() {
        try {
            var saved = JSON.parse(sessionStorage.getItem('chatHistory') || '[]');
            if (saved.length > 0) {
                // Clear the default welcome message first
                var msgs = document.getElementById('chatMessages');
                var typing = document.getElementById('chatTyping');
                // Remove all children except typing indicator
                while (msgs.firstChild && msgs.firstChild !== typing) {
                    msgs.removeChild(msgs.firstChild);
                }
                saved.forEach(function(m) {
                    appendMsg(m.role === 'user' ? 'user' : 'bot', m.content, m.time);
                    if (m.role === 'user') {
                        chatHistory.push({role:'user', content:m.content});
                    } else {
                        chatHistory.push({role:'assistant', content:m.content});
                    }
                });
            }
        } catch(e) {}

        // Restore open state
        if (sessionStorage.getItem('chatOpen') === '1') {
            chatOpen = true;
            document.getElementById('chatPanel').classList.add('open');
            document.getElementById('chatBadge').style.display = 'none';
            scrollChat();
        }
    }

    document.addEventListener('DOMContentLoaded', restoreChat);

    function sendChat() {
        var input = document.getElementById('chatInput');
        var msg = input.value.trim();
        if (!msg) return;

        input.value = '';
        document.getElementById('chatSend').disabled = true;

        var now = new Date();
        var msgTime = now.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
        appendMsg('user', msg);
        chatHistory.push({role:'user', content:msg});
        // Save to sessionStorage with timestamp for restore
        var stored = JSON.parse(sessionStorage.getItem('chatHistory') || '[]');
        stored.push({role:'user', content:msg, time:msgTime});
        sessionStorage.setItem('chatHistory', JSON.stringify(stored));

        // Show typing indicator
        var typing = document.getElementById('chatTyping');
        typing.style.display = 'flex';
        scrollChat();

        fetch('{{ route("chat") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: msg, history: chatHistory.slice(-8) })
        })
        .then(r => r.json())
        .then(data => {
            typing.style.display = 'none';
            var reply = data.reply || 'Sorry, I had trouble with that. Please try again!';
            var repTime = new Date().toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
            appendMsg('bot', reply);
            chatHistory.push({role:'assistant', content:reply});
            var stored2 = JSON.parse(sessionStorage.getItem('chatHistory') || '[]');
            stored2.push({role:'assistant', content:reply, time:repTime});
            sessionStorage.setItem('chatHistory', JSON.stringify(stored2));
        })
        .catch(() => {
            typing.style.display = 'none';
            appendMsg('bot', 'Having a brief connection issue. Please try again in a moment!');
        })
        .finally(() => {
            document.getElementById('chatSend').disabled = false;
            document.getElementById('chatInput').focus();
        });
    }

    function appendMsg(role, text, savedTime) {
        var msgs = document.getElementById('chatMessages');
        var typing = document.getElementById('chatTyping');

        var div = document.createElement('div');
        div.className = 'chat-msg ' + (role === 'user' ? 'user' : '');

        var now = new Date();
        var time = savedTime || now.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});

        if (role === 'bot') {
            div.innerHTML = botAvatarHtml + '<div><div class="chat-bubble bot">' + escHtml(text) + '</div><div class="chat-time">' + time + '</div></div>';
        } else {
            div.innerHTML = '<div><div class="chat-bubble user">' + escHtml(text) + '</div><div class="chat-time" style="text-align:right;">' + time + '</div></div>';
        }

        msgs.insertBefore(div, typing);
        scrollChat();
    }

    function scrollChat() {
        var msgs = document.getElementById('chatMessages');
        msgs.scrollTop = msgs.scrollHeight;
    }

    function escHtml(t) {
        return t.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
    }
    </script>

    {{-- ═══ CANVAS PARTICLE SYSTEM ═══ --}}
    <script>
    (function(){
        var canvas = document.getElementById('particleCanvas');
        if(!canvas) return;
        var ctx = canvas.getContext('2d');
        var W, H, particles = [];
        var DIST_SQ = 14000;
        var MAX = 110;

        function rand(a,b){ return a + Math.random()*(b-a); }

        function resize(){
            var dpr = Math.min(window.devicePixelRatio||1, 2);
            W = window.innerWidth; H = window.innerHeight;
            canvas.width = W * dpr; canvas.height = H * dpr;
            ctx.setTransform(dpr,0,0,dpr,0,0);
            init();
        }

        function init(){
            var count = Math.min(Math.floor((W*H)/8000), MAX);
            particles = [];
            for(var i=0;i<count;i++){
                particles.push({
                    x:rand(0,W), y:rand(0,H),
                    vx:rand(-0.25,0.25), vy:rand(-0.25,0.25),
                    r:rand(1.5,2.5),
                    hue:rand(220,280),
                    alpha:rand(0.4,0.8)
                });
            }
        }

        function draw(){
            ctx.clearRect(0,0,W,H);
            var p, q, dx, dy, dSq, a;

            for(var i=0;i<particles.length;i++){
                for(var j=i+1;j<particles.length;j++){
                    p=particles[i]; q=particles[j];
                    dx=p.x-q.x; dy=p.y-q.y;
                    dSq=dx*dx+dy*dy;
                    if(dSq<DIST_SQ){
                        a=(1-dSq/DIST_SQ)*0.35;
                        ctx.beginPath();
                        ctx.moveTo(p.x,p.y); ctx.lineTo(q.x,q.y);
                        ctx.strokeStyle='hsla('+((p.hue+q.hue)/2)+',75%,70%,'+a+')';
                        ctx.lineWidth=0.5; ctx.stroke();
                    }
                }
            }

            for(var i=0;i<particles.length;i++){
                p=particles[i];
                var g=ctx.createRadialGradient(p.x,p.y,0,p.x,p.y,p.r*3);
                g.addColorStop(0,'hsla('+p.hue+',80%,72%,'+p.alpha+')');
                g.addColorStop(1,'hsla('+p.hue+',80%,72%,0)');
                ctx.beginPath(); ctx.arc(p.x,p.y,p.r*3,0,Math.PI*2);
                ctx.fillStyle=g; ctx.fill();
                p.x+=p.vx; p.y+=p.vy;
                if(p.x<0||p.x>W) p.vx*=-1;
                if(p.y<0||p.y>H) p.vy*=-1;
            }
            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', resize);
        resize();
        draw();
    })();
    </script>
</body>
</html>

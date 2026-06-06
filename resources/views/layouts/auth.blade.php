<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sportshandicapper')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,400;0,600;0,700;0,800;0,900;1,700&family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }
        html { background:#03050F; color-scheme:dark; -webkit-font-smoothing:antialiased; }
        body {
            font-family:'Inter', system-ui, sans-serif;
            background:#03050F;
            color:#e2e8f0;
            min-height:100vh;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            padding:24px 16px;
            position:relative;
            overflow-x:hidden;
        }

        /* Subtle background glow */
        body::before {
            content:'';
            position:fixed;
            top:-20%;left:50%;
            transform:translateX(-50%);
            width:800px;height:500px;
            border-radius:50%;
            background:radial-gradient(ellipse,rgba(30,144,255,0.08) 0%,transparent 70%);
            pointer-events:none;
            z-index:0;
        }

        /* Close button */
        .auth-close {
            position:absolute;top:16px;right:16px;
            width:32px;height:32px;border-radius:8px;
            display:flex;align-items:center;justify-content:center;
            background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);
            color:rgba(255,255,255,0.4);text-decoration:none;
            transition:all .15s;z-index:10;
        }
        .auth-close:hover { background:rgba(255,255,255,0.1);color:white; }

        /* Card */
        .auth-card {
            position:relative;
            z-index:1;
            width:100%;max-width:448px;
            background:#0C1020;
            border:1px solid rgba(255,255,255,0.08);
            border-radius:16px;
            overflow:hidden;
            box-shadow:0 20px 50px -20px rgba(0,0,0,0.7);
        }
        .auth-card-top-line {
            position:absolute;top:0;left:0;right:0;height:1px;
            background:rgba(30,144,255,0.5);
        }
        .auth-card-inner { padding:28px; }

        /* Logo */
        .auth-logo { height:28px;width:auto;display:block;margin-bottom:28px; }

        /* Eyebrow */
        .auth-eyebrow {
            font-size:10px;font-weight:700;text-transform:uppercase;
            letter-spacing:0.25em;color:#1E90FF;margin-bottom:8px;
            font-family:'Inter',sans-serif;
        }

        /* Heading */
        .auth-heading {
            font-family:'Exo 2',sans-serif;
            font-size:1.6rem;font-weight:900;color:white;
            letter-spacing:-0.02em;line-height:1.1;margin-bottom:8px;
            text-transform:none;
        }
        .auth-subtext { font-size:13px;color:#64748B;line-height:1.6;margin-bottom:24px; }

        /* Tab switcher */
        .auth-tabs {
            display:grid;grid-template-columns:1fr 1fr;
            padding:4px;border-radius:10px;
            border:1px solid rgba(255,255,255,0.08);
            background:rgba(0,0,0,0.4);
            margin-bottom:20px;gap:0;
        }
        .auth-tab {
            padding:10px 0;text-align:center;font-size:11px;font-weight:700;
            text-transform:uppercase;letter-spacing:0.14em;border-radius:7px;
            border:none;cursor:pointer;transition:all .15s;
            font-family:'Inter',sans-serif;text-decoration:none;display:block;
        }
        .auth-tab.active { background:#1E90FF;color:white; }
        .auth-tab.inactive { background:transparent;color:#64748B; }
        .auth-tab.inactive:hover { color:white; }

        /* Fields */
        .field-wrap { margin-bottom:14px; }
        .field-label {
            display:block;font-size:10px;font-weight:700;
            text-transform:uppercase;letter-spacing:0.18em;
            color:#475569;margin-bottom:6px;font-family:'Inter',sans-serif;
        }
        .field-inner { position:relative; }
        .field-input {
            width:100%;height:44px;border-radius:8px;
            background:rgba(0,0,0,0.3);border:1px solid rgba(255,255,255,0.1);
            padding:0 14px;padding-right:44px;
            font-size:14px;color:white;font-family:'Inter',sans-serif;
            transition:border-color .15s,background .15s;
            outline:none;
        }
        .field-input:focus { border-color:rgba(30,144,255,0.6);background:rgba(0,0,0,0.4); }
        .field-input::placeholder { color:#475569; }
        .field-trailing {
            position:absolute;right:0;top:0;bottom:0;
            width:44px;display:flex;align-items:center;justify-content:center;
        }
        .pw-toggle {
            background:none;border:none;cursor:pointer;
            color:#475569;padding:0;display:flex;align-items:center;
            transition:color .15s;
        }
        .pw-toggle:hover { color:white; }

        /* Row options (remember me / forgot) */
        .field-options {
            display:flex;align-items:center;justify-content:space-between;
            margin-top:2px;margin-bottom:14px;font-size:12px;
        }
        .field-options a { color:#22D3EE;font-weight:600;text-decoration:none;transition:color .15s; }
        .field-options a:hover { color:white; }

        /* Custom checkbox */
        .check-label { display:flex;align-items:flex-start;gap:8px;cursor:pointer;font-size:12px;color:#64748B;line-height:1.5; }
        .check-box {
            flex-shrink:0;width:16px;height:16px;border-radius:4px;margin-top:1px;
            border:1px solid rgba(255,255,255,0.2);background:rgba(0,0,0,0.3);
            display:flex;align-items:center;justify-content:center;transition:all .15s;
            cursor:pointer;
        }
        .check-box.checked { background:#1E90FF;border-color:#1E90FF; }
        input[type="checkbox"] { display:none; }

        /* Submit */
        .auth-submit {
            display:flex;align-items:center;justify-content:center;gap:8px;
            width:100%;padding:12px 20px;border-radius:9999px;
            background:#1E90FF;color:white;border:none;cursor:pointer;
            font-size:14px;font-weight:700;font-family:'Exo 2',sans-serif;
            text-transform:uppercase;letter-spacing:0.06em;
            box-shadow:0 8px 24px -12px rgba(30,144,255,0.5);
            transition:background .15s,transform .15s;margin-top:8px;
        }
        .auth-submit:hover { background:#1873cc;transform:translateY(-1px); }
        .auth-submit:hover { background:#1873cc; }
        .auth-submit:disabled { opacity:0.45;cursor:not-allowed; }

        /* OR divider */
        .auth-or {
            display:flex;align-items:center;gap:12px;
            margin:16px 0;font-size:10px;color:#475569;
            text-transform:uppercase;letter-spacing:0.25em;font-weight:700;
        }
        .auth-or::before,.auth-or::after {
            content:'';flex:1;height:1px;
            background:rgba(255,255,255,0.08);
        }

        /* Social buttons */
        .social-grid { display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:20px; }
        .social-btn {
            height:40px;border-radius:8px;border:1px solid rgba(255,255,255,0.1);
            background:rgba(255,255,255,0.02);color:#cbd5e1;
            font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;
            display:flex;align-items:center;justify-content:center;gap:8px;
            cursor:pointer;transition:all .15s;font-family:'Inter',sans-serif;
        }
        .social-btn:hover { background:rgba(255,255,255,0.06);border-color:rgba(255,255,255,0.2); }

        /* Bottom link */
        .auth-switch { text-align:center;font-size:12px;color:#64748B;padding-top:8px; }
        .auth-switch a,.auth-switch button {
            color:#22D3EE;font-weight:700;text-decoration:none;
            background:none;border:none;cursor:pointer;padding:0;font-size:12px;
            transition:color .15s;
        }
        .auth-switch a:hover,.auth-switch button:hover { color:white; }

        /* Errors */
        .auth-error {
            border-radius:8px;background:rgba(239,68,68,0.08);
            border:1px solid rgba(239,68,68,0.2);color:#f87171;
            font-size:13px;padding:10px 14px;margin-bottom:14px;
        }
        .auth-error-list { list-style:none; }
        .auth-error-list li+li { margin-top:4px; }

        @media(max-width:480px){
            .auth-card-inner { padding:24px 20px 28px; }
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-card-top-line"></div>
        <a href="{{ route('home') }}" class="auth-close" aria-label="Close">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </a>
        <div class="auth-card-inner">
            @yield('content')
        </div>
    </div>
</body>
</html>

@extends('layouts.public')
@section('title', $article->title . ' — Sportshandicapper')

@push('styles')
<style>
/* ── Hero ── */
.art-hero-section {
    width:100%;
    background:linear-gradient(180deg,#08101f 0%,#060c18 100%);
}
.art-hero-inner {
    max-width:960px;
    margin:0 auto;
    padding:40px 24px 36px;
}
.art-breadcrumb {
    display:flex;align-items:center;gap:6px;
    font-size:11px;color:#475569;margin-bottom:20px;
    text-transform:uppercase;letter-spacing:.5px;font-weight:600;
}
.art-breadcrumb a { color:#475569;text-decoration:none; }
.art-breadcrumb a:hover { color:#94A3B8; }
.art-breadcrumb-sep { color:#2d3748; }
.art-tag-row {
    display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:18px;
}
.art-tag {
    display:inline-flex;align-items:center;
    padding:3px 11px;border-radius:5px;
    font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;
}
.art-pill {
    display:inline-flex;align-items:center;
    padding:4px 12px;border-radius:20px;
    font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;
}
.art-hero-title {
    font-size:clamp(1.5rem,2.8vw,2.15rem);
    font-weight:700;
    color:#f1f5f9;
    line-height:1.25;
    letter-spacing:-0.015em;
    margin:0 0 20px;
    max-width:820px;
}
.art-hero-meta {
    display:flex;align-items:center;gap:0;flex-wrap:wrap;
    font-size:13px;color:#475569;
    border-top:1px solid rgba(255,255,255,.06);
    padding-top:18px;
    margin-top:4px;
}
.art-hero-meta-author {
    display:flex;align-items:center;gap:9px;margin-right:24px;
}
.art-author-avatar {
    width:32px;height:32px;border-radius:50%;
    background:rgba(30,144,255,.15);border:1px solid rgba(30,144,255,.25);
    display:flex;align-items:center;justify-content:center;
    font-size:11px;font-weight:700;color:#60a5fa;flex-shrink:0;
}
.art-hero-meta-author strong { color:#94A3B8;font-weight:600;font-size:13px; }
.art-meta-sep { width:1px;height:14px;background:rgba(255,255,255,.1);margin:0 20px;flex-shrink:0; }
.art-meta-item { display:flex;align-items:center;gap:6px;color:#475569;font-size:13px; }
.art-meta-item svg { opacity:.5; }
/* ── Featured image ── */
.art-feat-img {
    width:100%;
    aspect-ratio:16/7;
    object-fit:cover;
    display:block;
    border-radius:12px 12px 0 0;
}

/* ── Body wrapper ── */
.art-outer {
    max-width:1160px;
    margin:0 auto;
    padding:0 20px 80px;
}
.art-excerpt-bar {
    background:rgba(30,144,255,.04);
    border-left:3px solid rgba(30,144,255,.5);
    border-radius:0 6px 6px 0;
    padding:16px 22px;
    margin-bottom:28px;
}
.art-excerpt-bar p {
    font-size:1rem;color:#94A3B8;line-height:1.8;
    font-style:italic;margin:0;
}
.art-columns {
    display:flex;gap:36px;align-items:flex-start;
    margin-top:36px;
}
.art-main { flex:1;min-width:0; }
.art-sidebar { width:310px;flex-shrink:0; }
.art-sidebar-sticky { position:sticky;top:88px; }

/* ── Article content card ── */
.art-card {
    background:#0C1120;
    border:1px solid rgba(255,255,255,.07);
    border-radius:16px;
    padding:36px 40px;
}

/* ── Body typography ── */
.art-body {
    font-size:16.5px;
    line-height:1.9;
    color:#CBD5E1;
    font-family:'Inter',system-ui,sans-serif;
}
.art-body > *:first-child { margin-top:0; }
.art-body h2 {
    font-size:1.2rem;font-weight:800;color:#f1f5f9;
    margin:36px 0 14px;letter-spacing:-.01em;
    padding-bottom:10px;
    border-bottom:1px solid rgba(30,144,255,.2);
}
.art-body h3 {
    font-size:1rem;font-weight:700;color:#e2e8f0;
    margin:26px 0 10px;text-transform:uppercase;letter-spacing:.04em;font-size:.85rem;
    color:#60a5fa;
}
.art-body p { margin-bottom:18px; }
.art-body p:last-child { margin-bottom:0; }
.art-body ul,.art-body ol { margin-bottom:18px;padding-left:0;list-style:none; }
.art-body ul li {
    padding:5px 0 5px 20px;
    position:relative;color:#CBD5E1;border-bottom:1px solid rgba(255,255,255,.04);
}
.art-body ul li::before { content:'›';position:absolute;left:0;color:#1E90FF;font-size:1.1em;font-weight:700; }
.art-body ol { counter-reset:ol-cnt; }
.art-body ol li {
    counter-increment:ol-cnt;
    padding:5px 0 5px 28px;position:relative;color:#CBD5E1;
    border-bottom:1px solid rgba(255,255,255,.04);
}
.art-body ol li::before {
    content:counter(ol-cnt);position:absolute;left:0;
    color:#1E90FF;font-size:11px;font-weight:700;
    background:rgba(30,144,255,.12);border-radius:50%;
    width:18px;height:18px;display:flex;align-items:center;justify-content:center;top:7px;
}
.art-body a { color:#60a5fa;text-decoration:underline;text-underline-offset:3px; }
.art-body strong { color:#f1f5f9;font-weight:700; }
.art-body em { color:#94A3B8; }
.art-body blockquote {
    border-left:3px solid rgba(30,144,255,.5);
    padding:14px 20px;margin:24px 0;
    background:rgba(30,144,255,.04);
    border-radius:0 10px 10px 0;
    color:#94A3B8;font-style:italic;font-size:1.02rem;
}
/* Tables */
.art-body table { width:100%;border-collapse:collapse;margin:20px 0 28px;font-size:13.5px; }
.art-body thead tr { background:rgba(30,144,255,.1); }
.art-body th {
    color:#60a5fa;padding:9px 14px;text-align:left;
    font-size:10px;text-transform:uppercase;letter-spacing:.6px;font-weight:700;
    border-bottom:1px solid rgba(30,144,255,.25);white-space:nowrap;
}
.art-body td {
    padding:9px 14px;border-bottom:1px solid rgba(255,255,255,.05);color:#CBD5E1;
    vertical-align:middle;
}
.art-body tr:hover td { background:rgba(255,255,255,.02); }
.art-body tr:nth-child(even) td { background:rgba(255,255,255,.015); }
/* Highlight / callout divs inside content */
.art-body .callout,.art-body .highlight-box {
    background:rgba(30,144,255,.06);
    border:1px solid rgba(30,144,255,.18);
    border-radius:10px;padding:16px 20px;margin:20px 0;
}

/* ── Sidebar panels ── */
.sb-panel {
    background:#0C1120;
    border:1px solid rgba(255,255,255,.07);
    border-radius:14px;overflow:hidden;
    margin-bottom:14px;
}
.sb-panel:last-child { margin-bottom:0; }
.sb-panel-hdr {
    padding:13px 16px;
    border-bottom:1px solid rgba(255,255,255,.07);
    background:rgba(30,144,255,.04);
}
.sb-panel-hdr-title { font-size:11px;color:#1E90FF;text-transform:uppercase;letter-spacing:.7px;font-weight:700; }
.sb-section { border-bottom:1px solid rgba(255,255,255,.05); }
.sb-section:last-child { border-bottom:none; }
.sb-section-body { padding:13px 15px; }
.sb-label { font-size:10px;color:#1E90FF;text-transform:uppercase;letter-spacing:.6px;font-weight:700;margin-bottom:7px; }

/* ── Premium gate ── */
.premium-gate {
    background:#0C1120;border:1px solid rgba(30,144,255,.18);
    border-radius:14px;padding:44px 36px;text-align:center;
}

/* ── Related ── */
.related-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:16px; }
.related-card {
    background:#0C1120;border:1px solid rgba(255,255,255,.07);
    border-radius:10px;text-decoration:none;display:block;overflow:hidden;
    transition:border-color .2s,transform .2s;
}
.related-card:hover { border-color:rgba(30,144,255,.4);transform:translateY(-3px); }

/* ── Pick card ── */
.pick-card {
    margin-top:36px;padding:24px;
    background:#080f1e;border:1px solid rgba(30,144,255,.2);
    border-radius:14px;
}

@media(max-width:980px){
    .art-columns { flex-direction:column; }
    .art-sidebar { width:100%; }
    .art-sidebar-sticky { position:static; }
    .art-card { padding:24px 22px; }
    .related-grid { grid-template-columns:1fr 1fr; }
}
@media(max-width:600px){
    .art-hero-title { font-size:1.35rem; }
    .art-hero-inner { padding:28px 16px 24px; }
    .art-hero-meta { gap:0; }
    .art-meta-sep { margin:0 12px; }
    .art-card { padding:20px 16px; }
    .art-outer { padding:0 12px 60px; }
    .related-grid { grid-template-columns:1fr; }
}
</style>
@endpush

@section('content')
@php
$hasSups = $article->supplements->count() > 0;
$sp = strtolower($article->sport ?? '');
$sportMeta = [
    'nfl'   => ['bg'=>'rgba(29,78,216,.2)',   'color'=>'#93c5fd','grad'=>'linear-gradient(135deg,#0d1a37,#1e3a8a)'],
    'mlb'   => ['bg'=>'rgba(22,163,74,.2)',    'color'=>'#4ade80','grad'=>'linear-gradient(135deg,#0a2212,#166534)'],
    'nba'   => ['bg'=>'rgba(220,38,38,.2)',    'color'=>'#f87171','grad'=>'linear-gradient(135deg,#2d0a0a,#7f1d1d)'],
    'nhl'   => ['bg'=>'rgba(30,144,255,.2)',   'color'=>'#60a5fa','grad'=>'linear-gradient(135deg,#071830,#0d3a6b)'],
    'ncaaf' => ['bg'=>'rgba(245,158,11,.2)',   'color'=>'#fcd34d','grad'=>'linear-gradient(135deg,#1a1205,#78350f)'],
    'ncaab' => ['bg'=>'rgba(168,85,247,.2)',   'color'=>'#c084fc','grad'=>'linear-gradient(135deg,#1a0d2e,#581c87)'],
];
$sm = $sportMeta[$sp] ?? ['bg'=>'rgba(30,144,255,.15)','color'=>'#60a5fa','grad'=>'linear-gradient(135deg,#071830,#0d2a5a)'];

$readTime = max(1, (int) ceil(str_word_count(strip_tags($article->content ?? '')) / 220));
@endphp

{{-- ── HERO ── --}}
<div class="art-hero-section">
    <div class="art-hero-inner">

        {{-- Breadcrumb --}}
        <div class="art-breadcrumb">
            <a href="{{ route('articles') }}">Articles</a>
            <span class="art-breadcrumb-sep">›</span>
            <span style="color:#60a5fa;">{{ $article->sport }}</span>
        </div>

        {{-- Tags --}}
        <div class="art-tag-row">
            <span class="art-tag" style="background:{{ $sm['bg'] }};color:{{ $sm['color'] }};border:1px solid {{ $sm['color'] }}44;">{{ $article->sport }}</span>
            @if($article->category)
            <span class="art-tag" style="background:rgba(255,255,255,.05);color:#64748B;border:1px solid rgba(255,255,255,.08);">{{ $article->category }}</span>
            @endif
            @if($article->is_premium)
            <span class="art-tag" style="background:rgba(30,144,255,.12);color:#60a5fa;border:1px solid rgba(30,144,255,.25);">PREMIUM</span>
            @endif
        </div>

        {{-- Title --}}
        <h1 class="art-hero-title">{{ $article->title }}</h1>

        {{-- Meta row --}}
        <div class="art-hero-meta">
            @php
                $authorName = $article->expert_name ?: ($article->author ?: 'Editorial');
                $initials = implode('', array_map(fn($w) => strtoupper($w[0]), array_slice(explode(' ', $authorName), 0, 2)));
            @endphp
            <div class="art-hero-meta-author">
                <div class="art-author-avatar">{{ $initials }}</div>
                <strong>{{ $authorName }}</strong>
            </div>
            @if($article->published_at)
            <div class="art-meta-sep"></div>
            <div class="art-meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $article->published_at->format('M d, Y') }}
            </div>
            @endif
            <div class="art-meta-sep"></div>
            <div class="art-meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $readTime }} min read
            </div>
        </div>

    </div>
</div>

{{-- ── BODY ── --}}
<div class="art-outer">

    @if($article->excerpt)
    <div class="art-excerpt-bar">
        <p>{{ $article->excerpt }}</p>
    </div>
    @endif

    <div class="art-columns">

        {{-- ── MAIN CONTENT ── --}}
        <main class="art-main">

            {{-- Premium gate --}}
            @if($article->is_premium && (!auth()->check() || auth()->user()->role === 'free'))
            <div class="premium-gate">
                <div style="width:54px;height:54px;border-radius:50%;background:rgba(30,144,255,.1);border:1px solid rgba(30,144,255,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                </div>
                <h3 style="color:#f1f5f9;font-size:1.15rem;font-weight:700;margin:0 0 8px;">Premium Content</h3>
                <p style="color:#64748B;margin:0 0 26px;font-size:14px;line-height:1.6;">This article is available to active subscribers only.</p>
                <a href="{{ route('join') }}" class="btn-primary" style="display:inline-block;padding:13px 36px;text-decoration:none;border-radius:50px;font-size:15px;">View Membership Plans</a>
                @guest
                <p style="color:#475569;margin:18px 0 0;font-size:13px;">Already a member? <button onclick="openModal()" style="background:none;border:none;color:#1E90FF;cursor:pointer;font-size:13px;font-weight:600;">Sign in here</button></p>
                @endguest
            </div>

            @else

            {{-- Article body card --}}
            <div class="art-card" style="padding:0;overflow:hidden;">
                @if($article->featured_image)
                <img src="@inspinAsset($article->featured_image)" alt="{{ $article->title }}" class="art-feat-img" onerror="this.style.display='none'">
                @endif
                <div class="art-body content" style="padding:36px 40px;">
                    {!! $article->content !!}
                </div>
            </div>

            {{-- Linked pick --}}
            @php $linkedPick = $article->relatedPicks?->where('is_active', true)->first(); @endphp
            @if($linkedPick)
            <div class="pick-card">
                <div class="sb-label" style="margin-bottom:14px;">Today's Pick for This Game</div>
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px;margin-bottom:12px;">
                    <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                        @php
                            $tRaw = $linkedPick->game_time ? (string)$linkedPick->game_time : '00:00:00';
                            $tStr = strlen($tRaw) === 5 ? $tRaw.':00' : substr($tRaw, 0, 8);
                            $gStart = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $linkedPick->game_date->format('Y-m-d').' '.$tStr, 'America/New_York');
                            $pNow = \Carbon\Carbon::now('America/New_York');
                            $pStatus = $linkedPick->result !== 'pending' ? 'Graded' : ($pNow->gte($gStart) ? 'Started' : 'Active');
                            $psc = ['Started'=>['rgba(239,68,68,.12)','#ef4444'],'Active'=>['rgba(34,197,94,.12)','#22c55e'],'Graded'=>['rgba(100,100,100,.1)','#64748B']][$pStatus] ?? ['rgba(100,100,100,.1)','#64748B'];
                        @endphp
                        <span class="art-pill" style="background:{{ $sm['bg'] }};color:{{ $sm['color'] }};">{{ $linkedPick->sport }}</span>
                        <span style="background:{{ $psc[0] }};color:{{ $psc[1] }};border:1px solid {{ $psc[1] }}44;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">{{ $pStatus }}</span>
                    </div>
                    @if($linkedPick->stars)
                    <div style="color:#fbbf24;font-size:13px;font-weight:700;">
                        @if($linkedPick->stars === 10)★10 WHALE@else{{ str_repeat('★', $linkedPick->stars) }}@endif
                    </div>
                    @endif
                </div>
                <div style="font-size:1.05rem;font-weight:700;color:#f1f5f9;margin-bottom:5px;">
                    {{ $linkedPick->team1_name }} <span style="color:#334155;font-size:12px;margin:0 6px;">vs</span> {{ $linkedPick->team2_name }}
                </div>
                <div style="color:#64748B;font-size:13px;margin-bottom:18px;">
                    {{ $linkedPick->game_date?->format('M d, Y') }}{{ $linkedPick->game_time ? ' at '.\Carbon\Carbon::parse($linkedPick->game_time)->format('g:i A').' ET' : '' }}@if($linkedPick->venue) <span style="color:#1e293b;">·</span> {{ $linkedPick->venue }}@endif
                </div>
                @auth
                <div style="background:rgba(30,144,255,.07);border:1px solid rgba(30,144,255,.18);border-radius:10px;padding:14px 18px;">
                    <div class="sb-label" style="margin-bottom:4px;">The Pick</div>
                    <div style="font-size:1rem;font-weight:600;color:#f1f5f9;">{{ $linkedPick->pick }}</div>
                </div>
                @else
                <button onclick="openModal('join')" class="btn-primary" style="display:block;width:100%;padding:14px;border:none;cursor:pointer;font-size:15px;border-radius:50px;font-weight:700;">
                    View Pick — Join or Sign In
                </button>
                @endauth
            </div>
            @endif

            @endif {{-- end premium gate --}}

            {{-- Related articles --}}
            @if($related->count() > 0)
            <div style="margin-top:48px;">
                <div style="font-size:10px;color:#1E90FF;text-transform:uppercase;letter-spacing:.7px;font-weight:700;margin-bottom:16px;">More in {{ $article->sport }}</div>
                <div class="related-grid">
                    @foreach($related as $r)
                    @php
                        $rs = strtolower($r->sport ?? '');
                        $rsm = $sportMeta[$rs] ?? ['bg'=>'rgba(30,144,255,.1)','color'=>'#60a5fa','grad'=>'linear-gradient(135deg,#071830,#0d2a5a)'];
                    @endphp
                    <a href="{{ route('article.show', $r) }}" class="related-card">
                        <div style="position:relative;aspect-ratio:16/9;background:{{ $rsm['grad'] }};overflow:hidden;">
                            @if($r->featured_image)
                            <img src="@inspinAsset($r->featured_image)" alt="{{ $r->title }}" style="width:100%;height:100%;object-fit:cover;display:block;" onerror="this.style.display='none'">
                            @endif
                            <span class="art-pill" style="position:absolute;top:8px;left:8px;background:{{ $rsm['bg'] }};color:{{ $rsm['color'] }};border:1px solid {{ $rsm['color'] }}33;">{{ $r->sport }}</span>
                        </div>
                        <div style="padding:12px 14px;">
                            <h3 style="font-size:13px;color:#e2e8f0;line-height:1.45;font-weight:600;margin:0;">{{ Str::limit($r->title, 65) }}</h3>
                            @if($r->published_at)
                            <div style="font-size:11px;color:#475569;margin-top:6px;">{{ $r->published_at->format('M d, Y') }}</div>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </main>

        {{-- ── SIDEBAR ── --}}
        @if($hasSups)
        <aside class="art-sidebar">
            <div class="art-sidebar-sticky">

                @foreach($article->supplements as $sup)

                    @php $isAiSup = ($sup->type === 'ai_generated' && $sup->ai_content); @endphp
                    @if($isAiSup)
                    @php $ai = json_decode($sup->ai_content, true); $aiIdx = $loop->index; @endphp

                    {{-- Audio player (from AI supplement audio field if present) --}}

                    @if(!empty($ai['executive_summary']))
                    <div class="sb-panel">
                        <div class="sb-panel-hdr"><div class="sb-panel-hdr-title">Executive Summary</div></div>
                        <div class="sb-section-body" style="padding:15px 16px;">
                            <p style="font-size:13.5px;color:#94A3B8;line-height:1.7;margin:0;">{{ $ai['executive_summary'] }}</p>
                        </div>
                    </div>
                    @endif

                    @if(!empty($ai['tweet']))
                    <div class="sb-panel">
                        <div class="sb-panel-hdr" style="background:rgba(30,144,255,.06);">
                            <div class="sb-panel-hdr-title" style="color:#60a5fa;">Quick Take</div>
                        </div>
                        <div style="padding:14px 16px;">
                            <p style="font-size:13px;color:#CBD5E1;line-height:1.6;margin:0;font-style:italic;">"{{ $ai['tweet'] }}"</p>
                        </div>
                    </div>
                    @endif

                    @if(!empty($ai['insights']))
                    <div class="sb-panel">
                        <div class="sb-panel-hdr"><div class="sb-panel-hdr-title">Key Insights</div></div>
                        <div style="padding:13px 15px;">
                            @foreach($ai['insights'] as $ins)
                            <div style="display:flex;gap:9px;margin-bottom:8px;font-size:13px;color:#94A3B8;line-height:1.55;">
                                <span style="color:#1E90FF;flex-shrink:0;font-size:14px;margin-top:-1px;">›</span><span>{{ $ins }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($ai['debate']))
                    <div class="sb-panel">
                        <div class="sb-panel-hdr"><div class="sb-panel-hdr-title">Sharp vs Public</div></div>
                        <div style="padding:13px 15px;display:flex;flex-direction:column;gap:8px;">
                            <div style="background:rgba(34,197,94,.05);border-left:3px solid #22c55e;padding:9px 12px;border-radius:0 7px 7px 0;">
                                <div style="font-size:9px;color:#22c55e;font-weight:700;margin-bottom:4px;letter-spacing:.4px;text-transform:uppercase;">Sharp Money</div>
                                <div style="font-size:12.5px;color:#94A3B8;line-height:1.55;">{{ $ai['debate']['sharp'] ?? '' }}</div>
                            </div>
                            <div style="background:rgba(30,144,255,.05);border-left:3px solid #1E90FF;padding:9px 12px;border-radius:0 7px 7px 0;">
                                <div style="font-size:9px;color:#1E90FF;font-weight:700;margin-bottom:4px;letter-spacing:.4px;text-transform:uppercase;">Public Bettors</div>
                                <div style="font-size:12.5px;color:#94A3B8;line-height:1.55;">{{ $ai['debate']['public'] ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(!empty($ai['stats']))
                    <div class="sb-panel">
                        <div class="sb-panel-hdr"><div class="sb-panel-hdr-title">Quick Stats</div></div>
                        <div style="padding:13px 15px;">
                            @foreach($ai['stats'] as $stat)
                            <div style="display:flex;gap:9px;margin-bottom:7px;font-size:13px;color:#94A3B8;line-height:1.5;">
                                <span style="color:#60a5fa;flex-shrink:0;">›</span><span>{{ $stat }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($ai['flashcards']))
                    <div class="sb-panel">
                        <div class="sb-panel-hdr">
                            <div class="sb-panel-hdr-title">Flashcards <span style="color:#334155;font-weight:400;font-size:9px;text-transform:none;letter-spacing:0;margin-left:4px;">tap to reveal</span></div>
                        </div>
                        <div style="padding:12px 14px;">
                            @foreach($ai['flashcards'] as $fi => $card)
                            @php $cid = 'fc-'.$aiIdx.'-'.$fi; @endphp
                            <div style="border:1px solid rgba(255,255,255,.06);border-radius:8px;margin-bottom:8px;overflow:hidden;background:rgba(255,255,255,.02);">
                                <button onclick="toggleFlashcard('{{ $cid }}')"
                                    style="width:100%;text-align:left;background:none;border:none;padding:10px 14px;cursor:pointer;display:flex;align-items:flex-start;justify-content:space-between;gap:8px;">
                                    <span style="font-size:12.5px;color:#CBD5E1;font-weight:600;line-height:1.4;">{{ $card['q'] ?? '' }}</span>
                                    <span id="{{ $cid }}-icon" style="color:#1E90FF;font-size:18px;flex-shrink:0;line-height:1;transition:transform .2s;">+</span>
                                </button>
                                <div id="{{ $cid }}" style="display:none;padding:0 14px 12px;font-size:12.5px;color:#64748B;line-height:1.65;border-top:1px solid rgba(255,255,255,.05);">
                                    <div style="padding-top:10px;">{{ $card['a'] ?? '' }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @endif
                    @if(!$isAiSup)
                    @php
                        $embedIsUrl = $sup->embed_code && (str_starts_with(trim($sup->embed_code), 'http://') || str_starts_with(trim($sup->embed_code), 'https://'));
                        $linkUrl = $embedIsUrl ? trim($sup->embed_code) : $sup->external_url;
                        $isVideo = $sup->type === 'video';
                        $isAudio = $sup->type === 'audio';
                        $typeColors = ['video'=>['#a855f7','rgba(168,85,247,.08)'],'audio'=>['#22c55e','rgba(34,197,94,.07)'],'infographic'=>['#1E90FF','rgba(30,144,255,.08)'],'debate'=>['#f59e0b','rgba(245,158,11,.08)']];
                        $tc = $typeColors[$sup->type] ?? ['#64748B','rgba(255,255,255,.04)'];
                        if ($isAudio && $sup->image_path):
                    @endphp
                    <div class="sb-panel" style="background:linear-gradient(160deg,rgba(34,197,94,.07) 0%,transparent 70%);">
                        <div style="padding:16px 18px 16px;">
                            <div style="display:flex;align-items:center;gap:11px;margin-bottom:14px;">
                                <div style="width:42px;height:42px;border-radius:50%;background:rgba(34,197,94,.12);border:1.5px solid rgba(34,197,94,.35);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/></svg>
                                </div>
                                <div>
                                    <div style="font-size:13px;font-weight:700;color:#f1f5f9;">Listen to Analysis</div>
                                    <div style="font-size:10px;color:#22c55e;margin-top:2px;font-weight:500;">AI Audio Summary</div>
                                </div>
                            </div>
                            <audio controls style="width:100%;height:36px;border-radius:50px;outline:none;accent-color:#1E90FF;">
                                <source src="@inspinAsset($sup->image_path)" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                    @php elseif ($sup->image_path): @endphp
                    <div class="sb-panel">
                        <div style="padding:11px 15px 9px;display:flex;align-items:center;gap:8px;border-bottom:1px solid rgba(255,255,255,.05);">
                            <div style="width:28px;height:28px;border-radius:6px;background:{{ $tc[1] }};display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">{{ $sup->type_icon }}</div>
                            <div>
                                <div style="font-size:9px;color:{{ $tc[0] }};text-transform:uppercase;letter-spacing:.6px;font-weight:700;">{{ ucfirst($sup->type) }}</div>
                                @if($sup->title)<div style="font-size:12px;font-weight:600;color:#f1f5f9;line-height:1.3;">{{ $sup->title }}</div>@endif
                            </div>
                        </div>
                        <img src="@inspinAsset($sup->image_path)" alt="{{ $sup->title }}" style="width:100%;display:block;">
                    </div>
                    @php elseif ($sup->embed_code && !$embedIsUrl && preg_match('/<iframe\s[^>]*src=["\']https?:\/\/[^"\']+["\'][^>]*>/i', $sup->embed_code)): @endphp
                    <div class="sb-panel">
                        <div style="padding:10px 15px 8px;display:flex;align-items:center;gap:8px;border-bottom:1px solid rgba(255,255,255,.05);">
                            <div style="width:28px;height:28px;border-radius:6px;background:{{ $tc[1] }};display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">{{ $sup->type_icon }}</div>
                            @if($sup->title)<div style="font-size:12px;font-weight:600;color:#f1f5f9;">{{ $sup->title }}</div>@endif
                        </div>
                        <div>{!! $sup->embed_code !!}</div>
                    </div>
                    @php elseif ($linkUrl): @endphp
                    <div class="sb-panel">
                        <div style="padding:15px;">
                            <div style="display:flex;align-items:center;gap:9px;margin-bottom:13px;">
                                <div style="width:32px;height:32px;border-radius:8px;background:{{ $tc[1] }};border:1px solid {{ $tc[0] }}33;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @if($isVideo)<svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $tc[0] }}"><path d="M8 5v14l11-7z"/></svg>
                                    @elseif($isAudio)<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $tc[0] }}" stroke-width="2"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                                    @else<span style="font-size:13px;">{{ $sup->type_icon }}</span>@endif
                                </div>
                                <div>
                                    <div style="font-size:9px;color:{{ $tc[0] }};text-transform:uppercase;letter-spacing:.7px;font-weight:700;">{{ ucfirst($sup->type) }}</div>
                                    @if($sup->title)<div style="font-size:13px;font-weight:600;color:#f1f5f9;line-height:1.3;">{{ $sup->title }}</div>@endif
                                </div>
                            </div>
                            <a href="{{ $linkUrl }}" target="_blank" rel="noopener"
                               style="display:flex;align-items:center;justify-content:center;gap:8px;background:{{ $tc[0] }};color:#060818;font-size:13px;font-weight:700;text-decoration:none;padding:11px 16px;border-radius:9px;width:100%;transition:opacity .18s;"
                               onmouseover="this.style.opacity='.82'" onmouseout="this.style.opacity='1'">
                                @if($isVideo)
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="#060818"><path d="M8 5v14l11-7z"/></svg> Watch Now
                                @elseif($isAudio)
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#060818" stroke-width="2.5"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/></svg> Listen Now
                                @else
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#060818" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg> View Content
                                @endif
                            </a>
                        </div>
                    </div>
                    @php endif; @endphp
                    @endif

                @endforeach

            </div>
        </aside>
        @endif

    </div>
</div>

@push('scripts')
<script>
function toggleFlashcard(id) {
    var el  = document.getElementById(id);
    var ico = document.getElementById(id + '-icon');
    var open = el.style.display !== 'none';
    el.style.display  = open ? 'none' : 'block';
    ico.textContent   = open ? '+' : '×';
    ico.style.transform = open ? '' : 'rotate(45deg)';
}
</script>
@endpush
@endsection

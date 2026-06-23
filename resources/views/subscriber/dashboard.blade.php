@extends('layouts.subscriber')
@section('title', 'My Dashboard - Sportshandicapper')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* KPI row */
.kpi-row { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:14px; }
@media(max-width:1100px){ .kpi-row{grid-template-columns:repeat(2,1fr);} }
@media(max-width:560px)  { .kpi-row{grid-template-columns:1fr 1fr;} }

/* Mid + bottom rows */
.mid-row    { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px; }
.bot-row    { display:grid; grid-template-columns:1.6fr 1fr; gap:12px; }
@media(max-width:1000px){ .mid-row,.bot-row{grid-template-columns:1fr;} }

/* Card inner utility */
.dk { background:var(--inner); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:20px 22px; }

/* Section header */
.sh { display:flex; align-items:center; justify-content:space-between; padding-bottom:14px; margin-bottom:14px; border-bottom:1px solid rgba(255,255,255,.06); }
.sh-t { font-size:15px; font-weight:700; color:#fff; letter-spacing:-.01em; }
.sh-l { font-size:12px; font-weight:600; color:var(--accent); display:inline-flex; align-items:center; gap:4px; }
.sh-l svg { width:13px; height:13px; stroke:currentColor; }

.stat-num { font-variant-numeric:tabular-nums; letter-spacing:-.02em; }
.welcome-h1 { font-size:clamp(24px,3vw,32px); font-weight:800; color:#fff; letter-spacing:-.02em; }

/* Pick row */
.pick-row { display:flex; align-items:center; gap:12px; padding:11px 0; border-bottom:1px solid rgba(255,255,255,.05); }
.pick-row:last-child { border-bottom:none; padding-bottom:0; }
.pick-row:first-child { padding-top:0; }

/* Expert avatar */
.ex-av { width:38px; height:38px; border-radius:9px; background:var(--accent); color:#fff; font-size:16px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; }

/* Sport badge colors */
.sp-mlb  { background:rgba(34,197,94,.12);  border:1px solid rgba(34,197,94,.2);  color:#22C55E; }
.sp-nfl  { background:rgba(59,130,246,.12); border:1px solid rgba(59,130,246,.2); color:#3B82F6; }
.sp-nba  { background:rgba(239,68,68,.12);  border:1px solid rgba(239,68,68,.2);  color:#EF4444; }
.sp-nhl  { background:rgba(168,85,247,.12); border:1px solid rgba(168,85,247,.2); color:#A855F7; }
.sp-def  { background:rgba(253,181,21,.12); border:1px solid rgba(253,181,21,.2); color:#FDB515; }

/* Article row */
.art-row { display:flex; align-items:flex-start; gap:12px; padding:11px 0; border-bottom:1px solid rgba(255,255,255,.05); }
.art-row:last-child { border-bottom:none; }
.art-thumb { width:68px; height:56px; border-radius:9px; object-fit:cover; flex-shrink:0; background:var(--inner); display:flex; align-items:center; justify-content:center; font-size:1.4rem; }
</style>
@endpush

@section('content')
@php
    $total = $wins + $losses + $pushes;
    $wr    = $total > 0 ? round(($wins / $total) * 100, 1) : 0;
    $u     = $sub ? (float)$sub->units_total : 0;

    $sportEmojis = ['MLB'=>'⚾','NFL'=>'🏈','NBA'=>'🏀','NHL'=>'🏒','NCAAF'=>'🏈','NCAAB'=>'🏀'];
    $sportBadgeClass = ['MLB'=>'sp-mlb','NFL'=>'sp-nfl','NBA'=>'sp-nba','NHL'=>'sp-nhl','NCAAF'=>'sp-def','NCAAB'=>'sp-def'];
    $sportColors = [
        'MLB'  =>['rgba(34,197,94,.12)', 'rgba(34,197,94,.2)', '#22C55E'],
        'NFL'  =>['rgba(59,130,246,.12)','rgba(59,130,246,.2)','#3B82F6'],
        'NBA'  =>['rgba(239,68,68,.12)', 'rgba(239,68,68,.2)', '#EF4444'],
        'NHL'  =>['rgba(168,85,247,.12)','rgba(168,85,247,.2)','#A855F7'],
        'NCAAF'=>['rgba(249,115,22,.12)','rgba(249,115,22,.2)','#F97316'],
        'NCAAB'=>['rgba(245,158,11,.12)','rgba(245,158,11,.2)','#F59E0B'],
    ];
    $userInitial = strtoupper(substr(auth()->user()->name, 0, 1));
@endphp

{{-- Email verified success banner --}}
@if(session('verified'))
<div style="background:rgba(0,209,91,.08);border:1px solid rgba(0,209,91,.25);border-radius:12px;padding:16px 20px;margin-bottom:16px;display:flex;align-items:center;gap:14px;">
    <div style="width:42px;height:42px;background:rgba(0,209,91,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">✓</div>
    <div>
        <div style="font-size:15px;font-weight:700;color:#00D15B;margin-bottom:2px;">Email Verified — Welcome to Sportshandicapper!</div>
        <div style="font-size:13px;color:rgba(255,255,255,.4);">Your account is now active. Browse your picks, check the latest articles, and explore your dashboard below.</div>
    </div>
</div>
@endif

@if(!$sub)
{{-- No subscription --}}
<div class="dk" style="text-align:center;padding:56px;margin-top:4px;">
    <div style="font-size:3rem;margin-bottom:16px;">📦</div>
    <h2 style="font-size:1.2rem;font-weight:700;color:#fff;margin-bottom:8px;">No Active Package</h2>
    <p style="color:rgba(255,255,255,.4);margin-bottom:24px;">Subscribe to start accessing expert picks.</p>
    <a href="/subscriber/packages" style="display:inline-block;padding:11px 30px;background:var(--accent);color:#fff;border-radius:50px;font-weight:700;text-decoration:none;">View Packages →</a>
</div>
@else

{{-- ─── Greeting ─── --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:20px;">
    <div>
        <div class="welcome-h1">Welcome back, {{ explode(' ',$user->name)[0] }}.</div>
        <div style="font-size:14.5px;color:rgba(255,255,255,.4);margin-top:5px;">Here is a snapshot of your handicapping desk today.</div>
    </div>
    <a href="/subscriber/picks" class="btn-primary" style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;background:var(--accent);color:#fff;border-radius:50px;font-weight:700;font-size:13px;white-space:nowrap;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l2.4 7.2H22l-6 4.4 2.3 7.1-6.3-4.3-6.3 4.3 2.3-7.1-6-4.4h7.6z"/></svg>
        Today's Live Board
    </a>
</div>

{{-- ─── KPI row ─── --}}
<div class="kpi-row">

    {{-- My Package --}}
    <div class="dk">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div class="kpi-label">My Package</div>
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M8 21h8M12 17v4M7 4h10l-1 7a4 4 0 01-8 0L7 4z"/><path d="M5 4H3a2 2 0 002 2 4 4 0 003 2M19 4h2a2 2 0 01-2 2 4 4 0 01-3 2"/></svg></div>
        </div>
        <div style="font-size:22px;font-weight:800;color:#fff;margin-bottom:8px;line-height:1.1;">{{ $sub->packageName() }}</div>
        <div style="font-size:12px;color:var(--accent);font-weight:700;margin-bottom:8px;">
            {{ str_repeat('★', min($sub->max_stars,5)) }}{{ $sub->max_stars>5?'+':'' }} Access
        </div>
        <div style="height:4px;background:rgba(255,255,255,.08);border-radius:10px;overflow:hidden;margin-bottom:8px;">
            <div style="height:100%;width:60%;background:var(--accent);border-radius:10px;"></div>
        </div>
        <div style="font-size:11px;color:rgba(255,255,255,.35);">
            @if(isset($sub->status_note) && $sub->status_note==='extended')
                <span style="color:#6366f1;">⟳ Extended</span>
            @elseif($sub->isExpired())
                <span style="color:#ef4444;">Expired</span>
            @else
                Expires {{ $sub->expires_at->format('M d, Y') }}
            @endif
        </div>
    </div>

    {{-- Total Units --}}
    <div class="dk">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div class="kpi-label">Total Units</div>
            <div class="kpi-icon" style="{{ $u>=0 ? '' : 'background:rgba(239,68,68,.1);border-color:rgba(239,68,68,.2);' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" style="{{ $u>=0 ? 'stroke:#22C55E;color:#22C55E;' : 'stroke:#EF4444;color:#EF4444;' }}">
                    @if($u>=0)
                        <polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/>
                    @else
                        <polyline points="3 7 9 13 13 9 21 17"/><polyline points="14 17 21 17 21 10"/>
                    @endif
                </svg>
            </div>
        </div>
        <div style="font-size:32px;font-weight:800;line-height:1;font-variant-numeric:tabular-nums;letter-spacing:-.02em;color:{{ $u>=0?'#22C55E':'#EF4444' }};margin-bottom:8px;">{{ $u>=0?'+':'' }}{{ number_format($u,2) }}</div>
        <div style="height:4px;background:rgba(255,255,255,.08);border-radius:10px;overflow:hidden;margin-bottom:8px;">
            <div style="height:100%;width:{{ min(abs($u)*8,100) }}%;background:{{ $u>=0?'#22C55E':'#EF4444' }};border-radius:10px;"></div>
        </div>
        <div style="font-size:12px;color:rgba(255,255,255,.35);">{{ $u>=0?'Profitable since sign up':'Currently at a deficit' }}</div>
    </div>

    {{-- Win Rate --}}
    <div class="dk">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div class="kpi-label">Win Rate</div>
            <div class="kpi-icon" style="{{ $wr>=55 ? 'background:rgba(34,197,94,.1);border-color:rgba(34,197,94,.2);' : 'background:rgba(239,68,68,.1);border-color:rgba(239,68,68,.2);' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" style="{{ $wr>=55 ? 'stroke:#22C55E;color:#22C55E;' : 'stroke:#EF4444;color:#EF4444;' }}">
                    @if($wr>=55)
                        <polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/>
                    @else
                        <polyline points="3 7 9 13 13 9 21 17"/><polyline points="14 17 21 17 21 10"/>
                    @endif
                </svg>
            </div>
        </div>
        <div style="font-size:32px;font-weight:800;line-height:1;font-variant-numeric:tabular-nums;letter-spacing:-.02em;color:{{ $wr>=55?'#22C55E':($wr>=45&&$total>0?'#1E90FF':($total>0?'#EF4444':'rgba(255,255,255,.3)')) }};margin-bottom:8px;">{{ $wr }}%</div>
        <div style="height:4px;background:rgba(255,255,255,.08);border-radius:10px;overflow:hidden;margin-bottom:8px;">
            <div style="height:100%;width:{{ max($wr,4) }}%;background:{{ $wr>=55?'#22C55E':($wr>=45&&$total>0?'#1E90FF':'#EF4444') }};border-radius:10px;"></div>
        </div>
        <div style="font-size:12px;color:rgba(255,255,255,.35);">{{ $wins }}W · {{ $losses }}L{{ $pushes ? ' · '.$pushes.'P' : '' }} · {{ $total }} graded</div>
    </div>

    {{-- Active Picks --}}
    <div class="dk">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div class="kpi-label">Active Picks</div>
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="2 12 6 12 9 4 14 20 17 12 22 12"/></svg></div>
        </div>
        <div style="font-size:32px;font-weight:800;line-height:1;font-variant-numeric:tabular-nums;letter-spacing:-.02em;color:#fff;margin-bottom:8px;">{{ $activePicks->count() }}</div>
        <div style="height:4px;background:rgba(255,255,255,.08);border-radius:10px;overflow:hidden;margin-bottom:8px;">
            <div style="height:100%;width:{{ $picksSinceStart>0 ? min(($activePicks->count()/$picksSinceStart)*100,100) : 0 }}%;background:var(--accent);border-radius:10px;"></div>
        </div>
        <div style="font-size:12px;color:rgba(255,255,255,.35);">{{ $picksSinceStart }} total picks{{ $activePicks->count()>0 ? ' · ' : '' }}@if($activePicks->count()>0)<a href="/subscriber/picks" style="font-weight:700;color:var(--accent);">View Picks →</a>@endif</div>
    </div>
</div>

{{-- ─── Mid row: Active picks  +  By Sport ─── --}}
<div class="mid-row">

    {{-- Active Picks --}}
    <div class="dk">
        <div class="sh">
            <span class="sh-t">Active Picks</span>
            <a href="/subscriber/picks" class="sh-l">View All <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg></a>
        </div>
        @if($activePicks->count()>0)
            @foreach($activePicks as $pick)
            @php
                $tRaw = $pick->game_time ? (string)$pick->game_time : '00:00:00';
                $tStr = strlen($tRaw)===5 ? $tRaw.':00' : substr($tRaw,0,8);
                $gS   = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pick->game_date->format('Y-m-d').' '.$tStr, 'America/New_York');
                $pNow = \Carbon\Carbon::now('America/New_York');
                $pStatus = $pNow->gte($gS) ? 'Started' : 'Active';
            @endphp
            <div class="pick-row">
                <div class="ex-av">{{ $userInitial }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:700;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $pick->team1_name }} vs {{ $pick->team2_name }}
                    </div>
                    <div style="font-size:11px;color:rgba(255,255,255,.35);margin-top:2px;">
                        {{ $pick->game_date->format('M d') }}{{ $pick->game_time ? ' · '.\Carbon\Carbon::parse($pick->game_time)->format('g:i A').' ET' : '' }}
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                    <span style="font-size:13px;color:var(--accent);">{{ str_repeat('★',(int)min($pick->stars,5)) }}</span>
                    <span class="sbadge {{ $pStatus==='Started'?'bstart':'bact' }}">{{ $pStatus }}</span>
                </div>
            </div>
            @endforeach
        @else
            <div style="text-align:center;padding:48px 0;color:rgba(255,255,255,.3);">
                <div style="width:56px;height:56px;border-radius:50%;background:rgba(30,144,255,.1);border:1px solid rgba(30,144,255,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                    <svg width="22" height="22" fill="none" stroke="#1E90FF" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <p style="font-size:15px;font-weight:700;color:#fff;margin-bottom:6px;">No picks on the board</p>
                <p style="font-size:13px;color:rgba(255,255,255,.35);max-width:260px;margin:0 auto;">When our analysts release a play, it will show up here in real time.</p>
            </div>
        @endif
    </div>

    {{-- By Sport --}}
    <div class="dk">
        <div class="sh">
            <span class="sh-t">By Sport</span>
            <a href="/subscriber/trends" class="sh-l">Full Trends <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg></a>
        </div>
        @if(count($sportRecord)>0)
            @foreach($sportRecord as $sport=>$rec)
            @php
                $st    = $rec['wins'] + $rec['losses'] + $rec['pushes'];
                $stWr  = $st > 0 ? round(($rec['wins']/$st)*100) : 0;
                $uVal  = $rec['units'] ?? 0;
            @endphp
            <div style="margin-bottom:18px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:7px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:16px;">{{ $sportEmojis[$sport]??'🏅' }}</span>
                        <span style="font-size:14px;font-weight:700;color:#fff;">{{ $sport }}</span>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:14px;font-weight:700;color:{{ $uVal>0?'#22C55E':($uVal<0?'#EF4444':'#fff') }};">{{ $uVal>=0?'+':'' }}{{ number_format($uVal,1) }}u</div>
                        <div style="font-size:10px;color:rgba(255,255,255,.3);">{{ $rec['wins'] }}-{{ $rec['losses'] }}</div>
                    </div>
                </div>
                <div style="height:4px;background:rgba(255,255,255,.08);border-radius:10px;overflow:hidden;">
                    <div style="width:{{ $st>0 ? max(6,$stWr) : 4 }}%;height:100%;background:{{ $uVal>0?'#22C55E':($uVal<0?'#EF4444':'rgba(255,255,255,.15)') }};border-radius:10px;"></div>
                </div>
            </div>
            @endforeach
        @else
            <div style="text-align:center;padding:32px 0;color:rgba(255,255,255,.3);">
                <div style="font-size:2rem;margin-bottom:8px;">📈</div>
                <p style="font-size:12px;">Stats appear once picks are graded</p>
            </div>
        @endif
    </div>
</div>

{{-- ─── Bottom row: Pick History  +  Latest Articles ─── --}}
<div class="bot-row">

    {{-- Pick History --}}
    <div class="dk">
        <div class="sh">
            <span class="sh-t">Pick History</span>
            <a href="/subscriber/picks?tab=results" class="sh-l">See All <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg></a>
        </div>
        @if($recentPicks->count()>0)
            @foreach($recentPicks as $pick)
            @php
                $isGraded = in_array($pick->result, ['win','loss','push']);
                $badgeMap = ['win'=>'bw','loss'=>'bl','push'=>'bp'];
                $bClass   = $isGraded ? ($badgeMap[$pick->result]??'bpend') : 'bpend';
                $bText    = $isGraded ? strtoupper($pick->result) : 'PENDING';
                $sc3      = $sportColors[$pick->sport] ?? ['rgba(253,181,21,.12)','rgba(253,181,21,.2)','#FDB515'];
                $spClass  = $sportBadgeClass[strtoupper($pick->sport??'')] ?? 'sp-def';
            @endphp
            <div class="pick-row">
                <span class="spbadge {{ $spClass }}" style="font-size:10px;min-width:38px;text-align:center;">{{ $pick->sport }}</span>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:700;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $pick->team1_name }} vs {{ $pick->team2_name }}
                    </div>
                    <div style="font-size:10px;color:rgba(255,255,255,.3);margin-top:2px;">
                        {{ $pick->game_date->format('M d') }} · {{ str_repeat('★',(int)min($pick->stars,5)) }}
                    </div>
                </div>
                <div style="text-align:right;flex-shrink:0;">
                    <span class="sbadge {{ $bClass }}">{{ $bText }}</span>
                    @if($pick->units_result !== null)
                    <div style="font-size:11px;font-weight:700;margin-top:3px;color:{{ $pick->units_result>=0?'#00D15B':'#EF4444' }};">{{ $pick->units_result>=0?'+':'' }}{{ $pick->units_result }}u</div>
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <div style="text-align:center;padding:32px 0;color:rgba(255,255,255,.3);">
                <div style="font-size:2rem;margin-bottom:8px;">🏅</div>
                <p style="font-size:12px;">No picks yet since your sign-up date</p>
            </div>
        @endif
    </div>

    {{-- Latest Articles --}}
    <div class="dk">
        <div class="sh">
            <span class="sh-t">Latest Articles</span>
            <a href="/subscriber/articles" class="sh-l">All Articles <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg></a>
        </div>
        @if($latestArticles->count()>0)
            @foreach($latestArticles as $art)
            @php
                $asc     = $sportColors[$art->sport??''] ?? ['rgba(253,181,21,.12)','rgba(253,181,21,.2)','#FDB515'];
                $aspClass = $sportBadgeClass[strtoupper($art->sport??'')] ?? 'sp-def';
            @endphp
            <a href="/subscriber/articles/{{ $art->slug }}" class="art-row" style="text-decoration:none;" onmouseover="this.style.opacity='.75'" onmouseout="this.style.opacity='1'">
                @if($art->featured_image)
                    <img src="@inspinAsset($art->featured_image)" class="art-thumb" alt="">
                @else
                    <div class="art-thumb">🏅</div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:5px;flex-wrap:wrap;">
                        <span class="spbadge {{ $aspClass }}" style="font-size:9px;">{{ $art->sport }}</span>
                        <span style="font-size:10px;color:rgba(255,255,255,.3);">{{ $art->published_at?->format('M d') }}</span>
                    </div>
                    <div style="font-size:12px;font-weight:700;color:#fff;line-height:1.4;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">{{ $art->title }}</div>
                </div>
            </a>
            @endforeach
        @else
            <div style="text-align:center;padding:32px 0;color:rgba(255,255,255,.3);">
                <p style="font-size:12px;">No articles yet</p>
            </div>
        @endif
    </div>
</div>

{{-- Upgrade CTA --}}
@if($sub->max_stars < 10)
<div style="margin-top:12px;background:rgba(253,181,21,.04);border:1px solid rgba(253,181,21,.1);border-radius:12px;padding:14px 18px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
    <div>
        <div style="font-size:13px;font-weight:700;color:#fff;margin-bottom:2px;">🚀 Unlock More Picks</div>
        <div style="font-size:12px;color:rgba(255,255,255,.4);">Your package includes up to <strong style="color:var(--accent);">{{ $sub->max_stars }}★</strong> picks. Upgrade for higher-confidence plays.</div>
    </div>
    <a href="/subscriber/packages" style="padding:9px 22px;background:var(--accent);color:#fff;border-radius:50px;font-weight:700;text-decoration:none;font-size:12px;white-space:nowrap;">Upgrade Package</a>
</div>
@endif

@endif
@endsection

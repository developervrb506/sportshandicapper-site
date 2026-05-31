@extends('layouts.public')
@section('title', 'Sportshandicapper | Verified Picks & Sharp Analytics')
@section('meta', 'Timestamped expert picks, verified records, and institutional sports analytics across MLB, NBA, NFL, NHL, CFB and CBB.')

@push('styles')
<style>
/* ── Utility grids ── */
.g3 { display:grid;grid-template-columns:repeat(3,1fr);gap:24px; }
.g4 { display:grid;grid-template-columns:repeat(4,1fr);gap:24px; }
@media(max-width:1024px){ .g3{grid-template-columns:repeat(2,1fr)} .g4{grid-template-columns:repeat(2,1fr)} }
@media(max-width:640px){ .g3,.g4{grid-template-columns:1fr} }

/* ── Section heading ── */
.section-h2 { font-size:clamp(2rem,4vw,3rem);font-weight:900;color:white;letter-spacing:-0.03em;line-height:1.0; }

/* ── Eyebrow ── */
.eyebrow { font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;color:#94A3B8; }

/* ── Confidence bar ── */
.conf-bar { height:4px;background:rgba(255,255,255,0.06);border-radius:9999px;overflow:hidden; }
.conf-fill { height:100%;background:#1E90FF;border-radius:9999px; }
.conf-fill-green { background:#22c55e; }

/* ── Package cards ── */
.pkg-card { border-radius:16px;border:1px solid rgba(255,255,255,0.08);background:#0C1020;padding:28px;position:relative;display:flex;flex-direction:column;transition:border-color .25s,transform .25s; }
.pkg-card:hover { border-color:rgba(30,144,255,0.35);transform:translateY(-2px); }
.pkg-card.highlight { border-color:rgba(30,144,255,0.5);box-shadow:0 0 0 1px rgba(30,144,255,0.2),0 20px 60px -20px rgba(30,144,255,0.3); }
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════ --}}
{{--  TICKER                                        --}}
{{-- ══════════════════════════════════════════════ --}}
@php
$staticTicks = [
    ['MLB','NYY -1.5 vs BOS','WIN','#22c55e'],
    ['NBA','BOS/MIA Over 218.5','WIN','#22c55e'],
    ['NHL','EDM ML vs LAK','WIN','#22c55e'],
    ['NFL','KC -3 vs LAC','PEND','#fbbf24'],
    ['CFB','Georgia -7.5','WIN','#22c55e'],
    ['MLB','LAD/SD Under 8','LOSS','#f87171'],
    ['CBB','Duke -4 vs UNC','WIN','#22c55e'],
    ['NBA','DEN ML vs PHX','WIN','#22c55e'],
];
if($expertPicks->count() > 0) {
    $tickItems = $expertPicks->map(function($p) {
        $res = strtoupper($p->result ?? 'PEND');
        if($res === 'PENDING') $res = 'PEND';
        $color = $res === 'WIN' ? '#22c55e' : ($res === 'LOSS' ? '#f87171' : '#fbbf24');
        $text = trim(($p->team1_name ?? '') . ' vs ' . ($p->team2_name ?? ''));
        return [$p->sport ?? 'SPT', $text, $res, $color];
    })->toArray();
    $tickItems = array_merge($tickItems, $tickItems);
} else {
    $tickItems = array_merge($staticTicks, $staticTicks);
}
@endphp
<div style="border-bottom:1px solid rgba(255,255,255,0.08);background:rgba(0,0,0,0.4);overflow:hidden;">
    <div style="display:flex;gap:40px;padding:10px 0;white-space:nowrap;animation:ticker 45s linear infinite;">
        @foreach($tickItems as $t)
        <div style="display:inline-flex;align-items:center;gap:10px;font-size:11px;font-family:monospace;text-transform:uppercase;letter-spacing:0.08em;flex-shrink:0;">
            <span style="padding:2px 6px;border-radius:4px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#cbd5e1;font-size:9px;font-weight:700;">{{ $t[0] }}</span>
            <span style="color:#e2e8f0;">{{ $t[1] }}</span>
            <span style="font-weight:700;color:{{ $t[3] }};">{{ $t[2] }}</span>
            <span style="color:#334155;">•</span>
        </div>
        @endforeach
    </div>
</div>

{{-- ══════════════════════════════════════════════ --}}
{{--  HERO                                          --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="container-x" style="padding:64px 0 80px;">
    <div style="display:grid;grid-template-columns:1.15fr 1fr;gap:48px;align-items:center;" class="hero-grid">
        <div class="reveal">
            {{-- Live badge — real if picks exist, neutral if not --}}
            @if($expertPicks->count() > 0)
            <div style="display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border-radius:8px;border:1px solid rgba(34,197,94,0.3);background:rgba(34,197,94,0.05);margin-bottom:24px;">
                <span style="position:relative;display:inline-flex;width:6px;height:6px;border-radius:9999px;background:#22c55e;" class="ping-soft"></span>
                <span style="font-size:10px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#86efac;">Live Slate &middot; {{ $expertPicks->count() }} picks released today</span>
            </div>
            @else
            <div style="display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border-radius:8px;border:1px solid rgba(30,144,255,0.3);background:rgba(30,144,255,0.05);margin-bottom:24px;">
                <span style="font-size:10px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#7DD3FC;">Expert Picks &middot; 6 Sports Covered</span>
            </div>
            @endif

            <h1 style="font-size:clamp(2.75rem,5vw,4.5rem);font-weight:900;line-height:0.95;letter-spacing:-0.03em;color:white;margin:0 0 24px;">
                Sharper picks.<br>
                <span style="color:#1E90FF;">Verified</span> records.
            </h1>

            <p style="font-size:clamp(15px,1.4vw,18px);color:#94A3B8;line-height:1.75;max-width:520px;margin:0 0 32px;">
                We don't sell hype. Every pick is timestamped before line move, posted with reasoning, and graded after the final whistle. Coverage spans MLB, NBA, NFL, NHL, CFB and CBB.
            </p>

            <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:40px;">
                <a href="{{ route('join') }}" class="btn-primary">
                    View Membership
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('picks') }}" class="btn-secondary">See Today's Picks</a>
            </div>

            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:24px;">
                <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#64748B;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    3rd-party verified
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#64748B;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22D3EE" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Posted pre-market move
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#64748B;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="2" stroke-linecap="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Graded transparently
                </div>
            </div>
        </div>

        {{-- Scoreboard card --}}
        @php
        $hasLivePicks = $expertPicks->count() > 0;
        $scoreboardPicks = $hasLivePicks ? $expertPicks->take(3) : null;
        $staticBoard = [
            ['MLB','NYY','BOS','NYY -1.5',92,'+6.4%'],
            ['NBA','BOS','MIA','Over 218.5',88,'+4.1%'],
            ['NHL','EDM','LAK','EDM ML',81,'+3.2%'],
        ];
        @endphp
        <div class="reveal" style="transition-delay:0.15s;">
            <div class="card-premium" style="overflow:hidden;">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(0,0,0,0.3);">
                    <div style="display:flex;align-items:center;gap:8px;">
                        @if($hasLivePicks)
                        <div style="width:8px;height:8px;border-radius:50%;background:#22c55e;"></div>
                        <span style="font-size:10px;font-weight:700;letter-spacing:0.2em;text-transform:uppercase;color:#cbd5e1;">Tonight's Card</span>
                        @else
                        <div style="width:8px;height:8px;border-radius:50%;background:#1E90FF;"></div>
                        <span style="font-size:10px;font-weight:700;letter-spacing:0.2em;text-transform:uppercase;color:#cbd5e1;">Expert Board Preview</span>
                        @endif
                    </div>
                    @if($hasLivePicks)
                    <span style="font-size:10px;font-family:monospace;color:#64748B;">{{ now()->format('M d') }} &middot; {{ now()->format('g:i A') }} ET</span>
                    @else
                    <span style="font-size:10px;font-family:monospace;color:#64748B;">SAMPLE DATA</span>
                    @endif
                </div>
                <div>
                    @if($hasLivePicks)
                        @foreach($scoreboardPicks as $pick)
                        <div style="padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.04);transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <span style="padding:2px 6px;border-radius:4px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);font-size:9px;font-weight:700;letter-spacing:0.1em;color:#94A3B8;">{{ $pick->sport }}</span>
                                    <span style="font-weight:700;color:white;font-size:13px;">{{ $pick->team1_name }} <span style="color:#475569;">vs</span> {{ $pick->team2_name }}</span>
                                </div>
                                @if($pick->team1_percent)
                                <span style="font-size:10px;font-family:monospace;color:#22c55e;font-weight:700;">+{{ round(($pick->team1_percent - 50) * 0.2, 1) }}% EV</span>
                                @endif
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                <div style="display:flex;align-items:center;gap:8px;font-size:13px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                    <span style="font-weight:600;color:#94A3B8;font-size:11px;">Members only</span>
                                </div>
                                @if($pick->team1_percent)
                                <div style="display:flex;align-items:center;gap:8px;min-width:120px;">
                                    <div class="conf-bar" style="flex:1;"><div class="conf-fill" style="width:{{ $pick->team1_percent }}%;"></div></div>
                                    <span style="font-size:10px;font-family:monospace;color:#94A3B8;width:28px;text-align:right;">{{ $pick->team1_percent }}%</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        @foreach($staticBoard as $g)
                        <div style="padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.04);transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <span style="padding:2px 6px;border-radius:4px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);font-size:9px;font-weight:700;letter-spacing:0.1em;color:#94A3B8;">{{ $g[0] }}</span>
                                    <span style="font-weight:700;color:white;font-size:13px;">{{ $g[1] }} <span style="color:#475569;">vs</span> {{ $g[2] }}</span>
                                </div>
                                <span style="font-size:10px;font-family:monospace;color:#22c55e;font-weight:700;">{{ $g[5] }} EV</span>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                <div style="display:flex;align-items:center;gap:8px;font-size:13px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                    <span style="font-weight:600;color:#94A3B8;font-size:11px;">Members only</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:8px;min-width:120px;">
                                    <div class="conf-bar" style="flex:1;"><div class="conf-fill" style="width:{{ $g[4] }}%;"></div></div>
                                    <span style="font-size:10px;font-family:monospace;color:#94A3B8;width:28px;text-align:right;">{{ $g[4] }}%</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                <div style="padding:12px 20px;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-size:10px;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;">
                        {{ $hasLivePicks ? $expertPicks->count().' picks today' : 'Subscribe to unlock picks' }}
                    </span>
                    <a href="{{ route('picks') }}" style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#22D3EE;text-decoration:none;display:flex;align-items:center;gap:4px;">View board <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg></a>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
@media(max-width:900px){ .hero-grid{grid-template-columns:1fr!important} .hero-grid>div:last-child{display:none} }
</style>

{{-- ══════════════════════════════════════════════ --}}
{{--  RECORD STRIP                                  --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="border-top:1px solid rgba(255,255,255,0.06);border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(0,0,0,0.3);">
    <div class="container-x" style="padding:32px 0;">
        <div style="display:grid;grid-template-columns:repeat(4,1fr);divide-x:1px solid rgba(255,255,255,0.05);" class="record-grid">
            @foreach([['30-Day Hit','67.4','%','67.4'],['YTD Units','+184','u','184'],['Win Streak','7','W','7'],['ROI','12.8','%','12.8']] as $i=>$r)
            <div class="reveal" style="text-align:center;padding:0 16px;border-right:{{ $i<3 ? '1px solid rgba(255,255,255,0.06)' : 'none' }};">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;color:#64748B;margin-bottom:8px;">{{ $r[0] }}</div>
                <div class="counter-num" style="font-size:clamp(2rem,3.5vw,3rem);font-weight:900;color:white;font-family:monospace;line-height:1;" data-target="{{ $r[3] }}" data-prefix="{{ str_starts_with($r[1],'+') ? '+' : '' }}" data-suffix="{{ $r[2] }}">{{ $r[1] }}{{ $r[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<style>
@media(max-width:640px){ .record-grid{grid-template-columns:repeat(2,1fr)!important} }
</style>

{{-- ══════════════════════════════════════════════ --}}
{{--  EXCLUSIVE ARTICLES                            --}}
{{-- ══════════════════════════════════════════════ --}}
@php
$staticArticles = [
    ['a1','NHL','Game Preview','Colorado Avalanche vs Las Vegas Knights — Playoff edge analysis','MacKinnon meets Marner in a playoff clash that could define the series. Who holds the edge in Game 3?','Mike Davis','May 24, 2026','6 min',true],
    ['a2','NBA','Game Preview','Oklahoma City Thunder vs San Antonio Spurs — Where the smart money sits','OKC leads 2-1 but San Antonio fights back at home. Game 4 is a must-watch and the line has moved.','David Wilson','May 24, 2026','5 min',false],
    ['a3','NFL','Best Bets','DC Defenders vs Orlando Storm — Full breakdown and best bets','The Defenders invade Orlando on May 22nd. Can the Storm\'s offense hold the fort? Full breakdown inside.','Dave Johnson','May 22, 2026','7 min',false],
    ['a4','MLB','Trends','Phillies vs Rockies — Why the road dogs keep cashing at Coors','A look at three trends quietly moving the needle on NL West totals this month.','M. Rinner','May 21, 2026','4 min',false],
    ['a5','NBA','Consensus','Where the public is wrong on tonight\'s NBA slate','Three games where the consensus and sharp money are heading in opposite directions.','Mike Davis','May 20, 2026','5 min',false],
    ['a6','NHL','Series Outlook','Eastern Conference Final — Goalie matchup is the whole story','Save percentage, high-danger chances, and what the model says about the series price.','D. Wilson','May 19, 2026','6 min',false],
];
$usingRealArticles = $articles->count() > 0;
$featuredArticle = $usingRealArticles ? $articles->first() : null;
$restArticles = $usingRealArticles ? $articles->slice(1) : null;
$staticFeatured = collect($staticArticles)->firstWhere(7, true);
$staticRest = collect($staticArticles)->where(7, false)->values();
@endphp

<section class="container-x" style="padding:80px 0 60px;">
    {{-- Header --}}
    <div class="reveal" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:20px;padding-bottom:40px;border-bottom:1px solid rgba(255,255,255,0.06);margin-bottom:40px;">
        <div>
            <div style="display:inline-flex;align-items:center;gap:8px;padding:5px 12px;border-radius:6px;border:1px solid rgba(30,144,255,0.3);background:rgba(30,144,255,0.05);margin-bottom:20px;">
                <span style="width:6px;height:6px;border-radius:50%;background:#1E90FF;flex-shrink:0;"></span>
                <span style="font-size:10px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#1E90FF;">Editorial &middot; Updated daily</span>
            </div>
            <h2 class="section-h2" style="margin-bottom:16px;">Articles &amp; <span style="color:#1E90FF;">Analysis.</span></h2>
            <p style="color:#94A3B8;font-size:14px;line-height:1.7;max-width:520px;margin:0;">Expert betting articles, consensus reads, and trends. Written before the lines move, archived after the final whistle.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:32px;">
            @foreach([['07','This week'],['4','Leagues'],['3','Writers']] as $s)
            <div style="text-align:center;">
                <div style="font-size:2rem;font-weight:900;color:white;font-family:monospace;line-height:1;">{{ $s[0] }}</div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;color:#64748B;margin-top:4px;">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- League filter --}}
    <div class="reveal" style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;margin-bottom:40px;">
        <div style="display:flex;flex-wrap:wrap;gap:6px;" id="artLeagueFilters">
            @foreach(['ALL','NFL','NBA','MLB','NHL'] as $l)
            <button onclick="filterArticles('{{ $l }}')" data-league="{{ $l }}" class="art-filter-btn {{ $l==='ALL'?'art-active':'' }}" style="padding:6px 12px;border-radius:6px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;border:1px solid {{ $l==='ALL'?'#1E90FF':'rgba(255,255,255,0.1)' }};background:{{ $l==='ALL'?'#1E90FF':'rgba(255,255,255,0.04)' }};color:{{ $l==='ALL'?'white':'#94A3B8' }};cursor:pointer;transition:all .15s;font-family:Rajdhani,sans-serif;">{{ $l }}</button>
            @endforeach
        </div>
        <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#64748B;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>
            <span id="artCount">{{ $usingRealArticles ? $articles->count() : count($staticArticles) }} articles</span>
        </div>
    </div>

    {{-- Featured Article --}}
    @if($usingRealArticles && $featuredArticle)
    <a href="{{ route('article.show', $featuredArticle) }}" class="reveal art-item" data-league="{{ $featuredArticle->sport }}" style="display:grid;grid-template-columns:1fr 1.1fr;gap:48px;align-items:center;padding-bottom:48px;border-bottom:1px solid rgba(255,255,255,0.06);margin-bottom:48px;text-decoration:none;cursor:pointer;group:true;" class="art-featured-row">
        <div>
            <div style="display:flex;align-items:center;gap:10px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;margin-bottom:16px;">
                <span style="color:#1E90FF;">{{ $featuredArticle->sport }}</span>
                <span style="height:1px;width:20px;background:rgba(255,255,255,0.1);"></span>
                <span style="color:#64748B;">Featured</span>
            </div>
            <h3 style="font-size:clamp(1.4rem,2.5vw,2rem);font-weight:900;line-height:1.1;color:white;margin-bottom:16px;letter-spacing:-0.02em;transition:color .2s;" onmouseover="this.style.color='#1E90FF'" onmouseout="this.style.color='white'">{{ $featuredArticle->title }}</h3>
            <p style="color:#94A3B8;font-size:14px;line-height:1.7;margin-bottom:24px;">{{ Str::limit(strip_tags($featuredArticle->excerpt ?? ''), 160) }}</p>
            <div style="display:flex;align-items:center;gap:16px;font-size:11px;color:#64748B;margin-bottom:24px;">
                <span style="font-weight:600;color:#cbd5e1;">{{ $featuredArticle->author }}</span>
                <span>·</span>
                <span style="font-family:monospace;">{{ $featuredArticle->published_at?->format('M d, Y') }}</span>
            </div>
            <div style="display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#1E90FF;">
                Read article
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </div>
        </div>
        <div style="position:relative;aspect-ratio:16/10;border-radius:12px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);background:linear-gradient(135deg,#0A0C1C,#0d1024,rgba(30,144,255,0.1));">
            @if($featuredArticle->featured_image)
            <img src="{{ asset('storage/'.$featuredArticle->featured_image) }}" alt="{{ $featuredArticle->title }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.75;">
            @endif
            <div style="position:absolute;bottom:16px;left:16px;right:16px;display:flex;align-items:flex-end;justify-content:space-between;">
                <span style="font-size:4rem;font-weight:900;color:rgba(255,255,255,0.05);font-family:monospace;line-height:1;">{{ strtoupper(substr($featuredArticle->sport ?? 'SPT',0,3)) }}</span>
                <span style="padding:4px 10px;border-radius:4px;border:1px solid rgba(30,144,255,0.4);background:rgba(30,144,255,0.1);font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#1E90FF;">Featured</span>
            </div>
        </div>
    </a>
    @else
    {{-- Static featured article --}}
    @php $sf = $staticFeatured; @endphp
    <div class="reveal art-item" data-league="{{ $sf[1] }}" style="display:grid;grid-template-columns:1fr 1.1fr;gap:48px;align-items:center;padding-bottom:48px;border-bottom:1px solid rgba(255,255,255,0.06);margin-bottom:48px;cursor:pointer;" onclick="window.location='{{ route('articles') }}'">
        <div>
            <div style="display:flex;align-items:center;gap:10px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;margin-bottom:16px;">
                <span style="color:#1E90FF;">{{ $sf[1] }}</span>
                <span style="height:1px;width:20px;background:rgba(255,255,255,0.1);"></span>
                <span style="color:#64748B;">{{ $sf[2] }}</span>
            </div>
            <h3 style="font-size:clamp(1.4rem,2.5vw,2rem);font-weight:900;line-height:1.1;color:white;margin-bottom:16px;letter-spacing:-0.02em;transition:color .2s;" onmouseover="this.style.color='#1E90FF'" onmouseout="this.style.color='white'">{{ $sf[3] }}</h3>
            <p style="color:#94A3B8;font-size:14px;line-height:1.7;margin-bottom:24px;">{{ $sf[4] }}</p>
            <div style="display:flex;align-items:center;gap:16px;font-size:11px;color:#64748B;margin-bottom:24px;">
                <span style="font-weight:600;color:#cbd5e1;">{{ $sf[5] }}</span>
                <span>·</span>
                <span style="font-family:monospace;">{{ $sf[6] }}</span>
                <span>·</span>
                <span style="display:flex;align-items:center;gap:4px;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $sf[7] }}
                </span>
            </div>
            <div style="display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#1E90FF;">
                Read article <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </div>
        </div>
        <div style="position:relative;aspect-ratio:16/10;border-radius:12px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);background:linear-gradient(135deg,#0A0C1C,#0d1024,rgba(30,144,255,0.08));">
            <div style="position:absolute;inset:0;opacity:0.04;background-image:repeating-linear-gradient(90deg,rgba(255,255,255,1) 0 1px,transparent 1px 80px);"></div>
            <div style="position:absolute;bottom:16px;left:16px;right:16px;display:flex;align-items:flex-end;justify-content:space-between;">
                <span style="font-size:4rem;font-weight:900;color:rgba(255,255,255,0.05);font-family:monospace;line-height:1;">{{ $sf[1] }}</span>
                <span style="padding:4px 10px;border-radius:4px;border:1px solid rgba(30,144,255,0.4);background:rgba(30,144,255,0.1);font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#1E90FF;">Featured</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Articles Grid --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:40px 40px;" id="articlesGrid" class="articles-grid">
        @if($usingRealArticles)
            @foreach($restArticles as $i=>$art)
            <article class="reveal art-item" data-league="{{ $art->sport }}" style="display:flex;flex-direction:column;cursor:pointer;transition-delay:{{ $i*0.06 }}s;" onclick="window.location='{{ route('article.show', $art) }}'">
                <div style="display:flex;align-items:center;gap:10px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;margin-bottom:12px;">
                    <span style="color:#1E90FF;">{{ $art->sport }}</span>
                    <span style="height:1px;width:16px;background:rgba(255,255,255,0.1);"></span>
                    <span style="color:#64748B;">Analysis</span>
                </div>
                <h3 style="font-size:15px;font-weight:700;line-height:1.4;color:white;margin-bottom:10px;transition:color .2s;flex:1;" onmouseover="this.style.color='#1E90FF'" onmouseout="this.style.color='white'">{{ $art->title }}</h3>
                <p style="font-size:13px;color:#64748B;line-height:1.6;margin-bottom:16px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{{ Str::limit(strip_tags($art->excerpt ?? ''), 100) }}</p>
                <div style="padding-top:14px;border-top:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:space-between;font-size:11px;color:#64748B;">
                    <span style="font-weight:600;color:#94A3B8;">{{ $art->author }}</span>
                    <span style="font-family:monospace;">{{ $art->published_at?->format('M d') }}</span>
                </div>
            </article>
            @endforeach
        @else
            @foreach($staticRest->take(5) as $i=>$art)
            <article class="reveal art-item" data-league="{{ $art[1] }}" style="display:flex;flex-direction:column;cursor:pointer;transition-delay:{{ $i*0.06 }}s;" onclick="window.location='{{ route('articles') }}'">
                <div style="display:flex;align-items:center;gap:10px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;margin-bottom:12px;">
                    <span style="color:#1E90FF;">{{ $art[1] }}</span>
                    <span style="height:1px;width:16px;background:rgba(255,255,255,0.1);"></span>
                    <span style="color:#64748B;">{{ $art[2] }}</span>
                </div>
                <h3 style="font-size:15px;font-weight:700;line-height:1.4;color:white;margin-bottom:10px;transition:color .2s;flex:1;" onmouseover="this.style.color='#1E90FF'" onmouseout="this.style.color='white'">{{ $art[3] }}</h3>
                <p style="font-size:13px;color:#64748B;line-height:1.6;margin-bottom:16px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{{ $art[4] }}</p>
                <div style="padding-top:14px;border-top:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:space-between;font-size:11px;color:#64748B;">
                    <span style="font-weight:600;color:#94A3B8;">{{ $art[5] }}</span>
                    <span style="display:flex;align-items:center;gap:4px;font-family:monospace;">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $art[7] }}
                    </span>
                </div>
            </article>
            @endforeach
        @endif
    </div>

    {{-- No results --}}
    <div id="artNoResults" style="display:none;padding:64px 0;text-align:center;color:#64748B;font-size:13px;">No articles in this league yet.</div>

    {{-- CTA --}}
    <div class="reveal" style="margin-top:48px;padding-top:40px;border-top:1px solid rgba(255,255,255,0.06);display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:20px;">
        <div>
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;color:#64748B;margin-bottom:8px;">Members</div>
            <p style="font-size:17px;font-weight:700;color:white;margin:0;">Get every article the moment it's published.</p>
        </div>
        <a href="{{ route('join') }}" class="btn-primary">
            Become a Member
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>
</section>
<style>
@media(max-width:900px){ .art-item[style*="grid-template-columns:1fr 1.1fr"]{grid-template-columns:1fr!important} }
@media(max-width:768px){ #articlesGrid{grid-template-columns:repeat(2,1fr)!important} }
@media(max-width:480px){ #articlesGrid{grid-template-columns:1fr!important} }
</style>

{{-- ══════════════════════════════════════════════ --}}
{{--  TODAY'S BOARD                                 --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="container-x" style="padding:80px 0;">
    <div class="reveal" style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:32px;">
        <div>
            <p class="eyebrow" style="color:#1E90FF;margin-bottom:8px;">{{ $expertPicks->count() > 0 ? 'Live Board' : 'Expert Board' }}</p>
            <h2 class="section-h2">Today's Picks.</h2>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:6px;" id="leagueFilters">
            @foreach(['ALL','MLB','NBA','NFL','NHL','CFB','CBB'] as $l)
            <button onclick="filterLeague('{{ $l }}')" data-league="{{ $l }}" class="league-btn {{ $l==='ALL'?'active':'' }}" style="padding:6px 12px;border-radius:6px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;border:1px solid {{ $l==='ALL' ? '#1E90FF' : 'rgba(255,255,255,0.1)' }};background:{{ $l==='ALL' ? '#1E90FF' : 'rgba(255,255,255,0.04)' }};color:{{ $l==='ALL' ? 'white' : '#94A3B8' }};cursor:pointer;transition:all .15s;font-family:Inter,sans-serif;">{{ $l }}</button>
            @endforeach
        </div>
    </div>

    <div class="card-premium reveal" style="overflow:hidden;">
        {{-- Header row --}}
        <div style="display:grid;grid-template-columns:70px 1fr 160px 80px 110px 100px;gap:12px;padding:12px 20px;border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(0,0,0,0.4);font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748B;" class="board-header">
            <div>League</div><div>Matchup</div><div>Pick</div><div style="text-align:center;">Units</div><div style="text-align:right;">Confidence</div><div style="text-align:right;">Expert</div>
        </div>
        {{-- Rows --}}
        @php
        $staticBoardRows = [
            ['MLB','Yankees vs Red Sox','7:05 PM','Sample',92,3,'M. Rinner'],
            ['NBA','Celtics vs Heat','8:00 PM','Sample',88,2,'M. Davis'],
            ['NHL','Oilers vs Kings','10:00 PM','Sample',81,2,'K. Pratt'],
        ];
        $usingRealPicks = $expertPicks->count() > 0;
        @endphp

        @if($usingRealPicks)
            @foreach($expertPicks->take(4) as $i=>$pick)
            <div class="board-row reveal" data-league="{{ $pick->sport }}" style="display:grid;grid-template-columns:70px 1fr 160px 80px 110px 100px;gap:12px;padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.04);align-items:center;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                <div><span style="padding:2px 7px;border-radius:4px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);font-size:9px;font-weight:700;letter-spacing:0.1em;color:#cbd5e1;">{{ $pick->sport }}</span></div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:white;">{{ $pick->team1_name }} vs {{ $pick->team2_name }}</div>
                    <div style="font-size:10px;color:#64748B;font-family:monospace;margin-top:2px;">
                        {{ $pick->game_date?->format('M d') }}{{ $pick->game_time ? ' · '.date('g:i A', strtotime($pick->game_time)) : '' }}
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:#94A3B8;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    <span style="font-size:11px;">Members only</span>
                </div>
                <div style="text-align:center;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:6px;background:rgba(30,144,255,0.12);border:1px solid rgba(30,144,255,0.25);color:#1E90FF;font-weight:900;font-size:11px;font-family:monospace;">{{ $pick->stars ?? '?' }}u</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:flex-end;gap:8px;">
                    @if($pick->team1_percent)
                    <div class="conf-bar" style="width:60px;"><div style="height:4px;border-radius:9999px;background:#22c55e;width:{{ $pick->team1_percent }}%;"></div></div>
                    <span style="font-size:11px;font-family:monospace;font-weight:700;color:#86efac;">{{ $pick->team1_percent }}%</span>
                    @else
                    <span style="font-size:11px;color:#64748B;">–</span>
                    @endif
                </div>
                <div style="text-align:right;font-size:12px;font-weight:600;color:#94A3B8;">{{ $pick->analyst ?? '–' }}</div>
            </div>
            @endforeach
        @else
            @foreach($staticBoardRows as $i=>$row)
            <div class="board-row reveal" data-league="{{ $row[0] }}" style="display:grid;grid-template-columns:70px 1fr 160px 80px 110px 100px;gap:12px;padding:16px 20px;border-bottom:{{ $i<count($staticBoardRows)-1?'1px solid rgba(255,255,255,0.04)':'none' }};align-items:center;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                <div><span style="padding:2px 7px;border-radius:4px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);font-size:9px;font-weight:700;letter-spacing:0.1em;color:#cbd5e1;">{{ $row[0] }}</span></div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:white;">{{ $row[1] }}</div>
                    <div style="font-size:10px;color:#64748B;font-family:monospace;margin-top:2px;">{{ $row[2] }}</div>
                </div>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#94A3B8;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    <span style="font-size:11px;">Members only</span>
                </div>
                <div style="text-align:center;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:6px;background:rgba(30,144,255,0.12);border:1px solid rgba(30,144,255,0.25);color:#1E90FF;font-weight:900;font-size:11px;font-family:monospace;">{{ $row[5] }}u</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:flex-end;gap:8px;">
                    <div class="conf-bar" style="width:60px;"><div style="height:4px;border-radius:9999px;background:#22c55e;width:{{ $row[4] }}%;"></div></div>
                    <span style="font-size:11px;font-family:monospace;font-weight:700;color:#86efac;">{{ $row[4] }}%</span>
                </div>
                <div style="text-align:right;font-size:12px;font-weight:600;color:#94A3B8;">{{ $row[6] }}</div>
            </div>
            @endforeach
        @endif

        <div style="padding:12px 20px;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:12px;color:#64748B;">
                {{ $usingRealPicks ? 'More picks behind paywall' : 'Subscribe to see real picks' }}
            </span>
            <a href="{{ route('picks') }}" style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#22D3EE;text-decoration:none;display:flex;align-items:center;gap:4px;">Unlock board <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg></a>
        </div>
    </div>
</section>
<style>
@media(max-width:900px){ .board-header{display:none!important} .board-row{grid-template-columns:60px 1fr 80px 80px!important} .board-row>div:nth-child(3),.board-row>div:nth-child(6){display:none!important} }
</style>

{{-- ══════════════════════════════════════════════ --}}
{{--  CAPPERS LEADERBOARD                           --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="container-x" style="padding:0 0 80px;">
    <div class="reveal" style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:12px;">
        <div>
            <p class="eyebrow" style="color:#22D3EE;margin-bottom:8px;">Verified Experts</p>
            <h2 class="section-h2">Cappers Leaderboard.</h2>
        </div>
        <a href="{{ route('picks') }}" style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#22D3EE;text-decoration:none;display:flex;align-items:center;gap:4px;">All experts <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg></a>
    </div>
    <div class="g3">
        @foreach([['Michael Rinner','MLB Specialist','128-74','184.3','18.2','MR'],['Mike Davis','NBA / CBB','94-58','142.7','14.6','MD'],['Kyle Pratt','NHL / NFL','76-49','98.4','11.9','KP']] as $i=>$e)
        <div class="card-premium reveal" style="padding:24px;transition-delay:{{ $i*0.1 }}s;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:44px;height:44px;border-radius:50%;background:#1E90FF;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:900;color:white;border:2px solid rgba(255,255,255,0.15);flex-shrink:0;">{{ $e[5] }}</div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:white;">{{ $e[0] }}</div>
                        <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.12em;color:#64748B;font-weight:700;margin-top:1px;">{{ $e[1] }}</div>
                    </div>
                </div>
                <span style="padding:3px 8px;border-radius:4px;background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.25);color:#86efac;font-size:9px;font-weight:900;letter-spacing:0.1em;">#{{ $i+1 }}</span>
            </div>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;border-top:1px solid rgba(255,255,255,0.05);padding-top:16px;">
                <div><div style="font-size:9px;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;font-weight:700;margin-bottom:4px;">W-L</div><div style="font-size:14px;font-weight:700;color:white;font-family:monospace;">{{ $e[2] }}</div></div>
                <div><div style="font-size:9px;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;font-weight:700;margin-bottom:4px;">Units</div><div style="font-size:14px;font-weight:700;color:#22c55e;font-family:monospace;">+{{ $e[3] }}</div></div>
                <div><div style="font-size:9px;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;font-weight:700;margin-bottom:4px;">ROI</div><div style="font-size:14px;font-weight:700;color:#22D3EE;font-family:monospace;">{{ $e[4] }}%</div></div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{--  MEMBERSHIP PACKAGES                           --}}
{{-- ══════════════════════════════════════════════ --}}
@php
$pkgData = [
    [
        'rank'     => '00',
        'name'     => 'Free Trial',
        'price'    => 'FREE',
        'period'   => '7 DAYS',
        'tag'      => 'START FREE',
        'featured' => false,
        'features' => ['1 Week Access','1 star Picks','24/7 Support','No card required'],
        'cta'      => 'Start Free Trial',
        'icon'     => 'gift',
    ],
    [
        'rank'     => '03',
        'name'     => 'Standard',
        'price'    => '$99.99',
        'period'   => '/ MONTH',
        'tag'      => 'MOST POPULAR',
        'featured' => true,
        'features' => ['1 Month Access','1, 2, 3, 4 star Picks','Live alerts and Discord','Whale plays preview'],
        'cta'      => 'Get Standard',
        'icon'     => 'trophy',
    ],
    [
        'rank'     => '07',
        'name'     => 'Whale',
        'price'    => '$999.99',
        'period'   => '/ YEAR',
        'tag'      => 'ULTIMATE ACCESS',
        'featured' => false,
        'features' => ['1 Year Access','Every star tier unlocked','10 star Whale picks','1:1 strategy call'],
        'cta'      => 'Become a Whale',
        'icon'     => 'crown',
    ],
];
$icons = [
    'gift'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>',
    'trophy' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polyline points="14 2 14 6 20 6 20 9 17 9"/><polyline points="10 2 10 6 4 6 4 9 7 9"/><path d="M7 9a5 5 0 0010 0"/><line x1="12" y1="14" x2="12" y2="22"/><line x1="8" y1="22" x2="16" y2="22"/></svg>',
    'crown'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20h20M5 20l-2-9 5 4 4-8 4 8 5-4-2 9"/></svg>',
];
@endphp
<section class="container-x" style="padding:0 0 80px;" id="packages">
    <div class="reveal" style="text-align:center;margin-bottom:48px;max-width:640px;margin-left:auto;margin-right:auto;">
        <p class="eyebrow" style="color:#1E90FF;margin-bottom:12px;">Membership</p>
        <h2 class="section-h2" style="margin-bottom:12px;">Built for serious <span style="color:#1E90FF;">bettors</span>.</h2>
        <p style="color:#64748B;font-size:14px;margin:0;">Three ways in. Try it free, run the season, or own the year.</p>
    </div>

    <div class="g3 reveal" style="max-width:960px;margin:0 auto;align-items:stretch;">
        @foreach($pkgData as $i=>$p)
        <div style="position:relative;border-radius:8px;border:1px solid {{ $p['featured'] ? 'rgba(30,144,255,0.5)' : 'rgba(255,255,255,0.1)' }};background:rgba(0,0,0,0.3);overflow:hidden;display:flex;flex-direction:column;transition:border-color .2s;{{ $p['featured'] ? 'transform:scale(1.03);box-shadow:0 0 40px -12px rgba(30,144,255,0.4);' : '' }}" onmouseover="{{ !$p['featured'] ? 'this.style.borderColor=\"rgba(255,255,255,0.2)\"' : '' }}" onmouseout="{{ !$p['featured'] ? 'this.style.borderColor=\"rgba(255,255,255,0.1)\"' : '' }}">

            {{-- Top bar --}}
            @if($p['featured'])
            <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 20px;background:#1E90FF;">
                <span style="font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:0.1em;color:white;">★ {{ $p['tag'] }}</span>
                <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.8);">Picked by 73%</span>
            </div>
            @else
            <div style="height:1px;background:rgba(30,144,255,0.3);"></div>
            @endif

            <div style="padding:28px;flex:1;display:flex;flex-direction:column;">
                {{-- Icon + Rank --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <div style="width:40px;height:40px;border-radius:6px;display:flex;align-items:center;justify-content:center;background:{{ $p['featured'] ? 'rgba(30,144,255,0.15)' : 'rgba(255,255,255,0.04)' }};border:1px solid {{ $p['featured'] ? 'rgba(30,144,255,0.4)' : 'rgba(255,255,255,0.08)' }};color:{{ $p['featured'] ? '#1E90FF' : '#94A3B8' }};">{!! $icons[$p['icon']] !!}</div>
                    <div style="font-size:1.75rem;font-weight:900;font-family:monospace;color:rgba(255,255,255,0.08);line-height:1;">{{ $p['rank'] }}</div>
                </div>

                {{-- Tag + Name --}}
                <div style="margin-bottom:16px;">
                    @if(!$p['featured'])
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.14em;color:#1E90FF;margin-bottom:4px;">{{ $p['tag'] }}</div>
                    @endif
                    <h3 style="font-size:1.25rem;font-weight:900;color:white;margin:0;">{{ $p['name'] }}</h3>
                </div>

                {{-- Price --}}
                <div style="display:flex;align-items:baseline;gap:6px;margin-bottom:20px;">
                    <span style="font-size:2.25rem;font-weight:900;font-family:monospace;line-height:1;color:{{ $p['price']==='FREE' ? '#1E90FF' : 'white' }};">{{ $p['price'] }}</span>
                    <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;">{{ $p['period'] }}</span>
                </div>

                {{-- Divider --}}
                <div style="height:1px;background:rgba(255,255,255,0.05);margin-bottom:20px;"></div>

                {{-- Features --}}
                <ul style="list-style:none;padding:0;margin:0 0 24px;flex:1;display:flex;flex-direction:column;gap:10px;">
                    @foreach($p['features'] as $feat)
                    <li style="display:flex;align-items:center;gap:8px;font-size:13px;color:#e2e8f0;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;"><polyline points="20 6 9 17 4 12" stroke="{{ $p['featured'] ? '#1E90FF' : 'rgba(30,144,255,0.6)' }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>

                {{-- CTA --}}
                <a href="{{ route('join') }}" class="{{ $p['featured'] ? 'btn-primary' : 'btn-secondary' }}" style="width:100%;justify-content:center;{{ !$p['featured'] ? 'border-color:rgba(255,255,255,0.15);color:#94A3B8;' : '' }}">
                    {{ $p['cta'] }}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="reveal" style="margin-top:40px;display:flex;flex-direction:column;align-items:center;gap:8px;">
        <a href="{{ route('join') }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:6px;border:1px solid rgba(30,144,255,0.4);background:rgba(30,144,255,0.05);font-size:13px;font-weight:700;color:white;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='rgba(30,144,255,0.15)';this.style.borderColor='#1E90FF'" onmouseout="this.style.background='rgba(30,144,255,0.05)';this.style.borderColor='rgba(30,144,255,0.4)'">
            Compare all 8 plans
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.15em;color:#475569;">5 more tiers on the full board</div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{--  FINAL CTA                                     --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="container-x" style="padding:0 0 96px;">
    <div class="reveal" style="position:relative;">
        {{-- Subtle lane lines --}}
        <div style="position:absolute;left:0;right:0;top:50%;height:1px;background:rgba(255,255,255,0.04);pointer-events:none;"></div>
        <div style="position:absolute;left:0;right:0;top:calc(50% + 24px);height:1px;background:rgba(255,255,255,0.03);pointer-events:none;"></div>
        <div style="position:absolute;left:0;right:0;top:calc(50% - 48px);height:1px;background:rgba(255,255,255,0.03);pointer-events:none;"></div>

        <div style="display:grid;grid-template-columns:1.5fr 1fr;gap:64px;align-items:center;" class="cta-grid">
            <div>
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
                    <span style="height:1px;width:40px;background:#1E90FF;display:inline-block;"></span>
                    <span style="font-size:10px;font-weight:900;letter-spacing:0.28em;text-transform:uppercase;color:#1E90FF;">Join the edge</span>
                </div>
                <h2 style="font-size:clamp(2.5rem,5vw,4.5rem);font-weight:900;color:white;line-height:0.95;letter-spacing:-0.03em;margin-bottom:32px;">
                    Stop guessing.<br>
                    <span style="position:relative;display:inline-block;">
                        <span style="color:#1E90FF;">Start grading.</span>
                        <span style="position:absolute;bottom:-12px;left:0;right:0;height:1px;background:rgba(30,144,255,0.2);"></span>
                        <span style="position:absolute;bottom:-12px;left:0;height:1px;background:#1E90FF;display:inline-block;" class="sprint-line"></span>
                        <span style="position:absolute;bottom:-16px;left:0;width:8px;height:8px;border-radius:50%;background:#1E90FF;box-shadow:0 0 12px rgba(30,144,255,0.9);" class="sprint-dot"></span>
                    </span>
                </h2>
                <p style="font-size:clamp(14px,1.3vw,17px);color:#94A3B8;max-width:480px;line-height:1.75;margin-bottom:36px;">
                    Verified picks across every major sport, posted before the line moves. No hype, just receipts.
                </p>
                <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:36px;">
                    <a href="{{ route('join') }}" class="btn-primary">
                        Become a Member
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('picks') }}" class="btn-secondary">Browse free picks</a>
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:24px;">
                    <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#64748B;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        3-yr verified record
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#64748B;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Cancel anytime
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#64748B;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22D3EE" stroke-width="2" stroke-linecap="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        6 sports covered
                    </div>
                </div>
            </div>

            <div style="padding-left:32px;border-left:1px solid rgba(255,255,255,0.06);">
                <div style="display:flex;flex-direction:column;gap:28px;">
                    @foreach([['67.4','%','30-day hit rate','#22c55e'],['+184','u','YTD profit','#1E90FF'],['12.8','%','Return on investment','#fbbf24']] as $s)
                    <div style="display:flex;align-items:baseline;justify-content:space-between;gap:16px;">
                        <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.22em;font-weight:700;color:#64748B;">{{ $s[2] }}</div>
                        <div style="font-size:clamp(2rem,3.5vw,3rem);font-weight:900;font-family:monospace;line-height:1;color:{{ $s[3] }};">{{ $s[0] }}<span style="font-size:1rem;color:#64748B;margin-left:2px;">{{ $s[1] }}</span></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<style>
@media(max-width:900px){ .cta-grid{grid-template-columns:1fr!important} .cta-grid>div:last-child{border-left:none!important;padding-left:0!important;border-top:1px solid rgba(255,255,255,0.06);padding-top:32px;} }
</style>

@endsection

@push('scripts')
<script>
// ── Scroll Reveal ──
(function(){
    var els = document.querySelectorAll('.reveal');
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){ e.target.classList.add('is-visible'); obs.unobserve(e.target); }
        });
    },{threshold:0.1});
    els.forEach(function(el){ obs.observe(el); });
})();

// ── Counter Animation ──
(function(){
    var nums = document.querySelectorAll('.counter-num');
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(!e.isIntersecting) return;
            var el = e.target;
            var target = parseFloat(el.dataset.target);
            var prefix = el.dataset.prefix || '';
            var suffix = el.dataset.suffix || '';
            var decimals = target % 1 !== 0 ? 1 : 0;
            var start = 0, duration = 1800, startTime = null;
            function step(ts){
                if(!startTime) startTime = ts;
                var prog = Math.min((ts - startTime)/duration, 1);
                var ease = 1 - Math.pow(1-prog, 3);
                var cur = (start + (target - start) * ease).toFixed(decimals);
                el.textContent = prefix + cur + suffix;
                if(prog < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
            obs.unobserve(el);
        });
    },{threshold:0.5});
    nums.forEach(function(el){ obs.observe(el); });
})();

// ── Article League Filter ──
function filterArticles(league){
    document.querySelectorAll('.art-filter-btn').forEach(function(btn){
        var active = btn.dataset.league === league;
        btn.style.background = active ? '#1E90FF' : 'rgba(255,255,255,0.04)';
        btn.style.borderColor = active ? '#1E90FF' : 'rgba(255,255,255,0.1)';
        btn.style.color = active ? 'white' : '#94A3B8';
    });
    var items = document.querySelectorAll('.art-item');
    var visible = 0;
    items.forEach(function(item){
        var show = league === 'ALL' || item.dataset.league === league;
        item.style.display = show ? '' : 'none';
        if(show) visible++;
    });
    var noRes = document.getElementById('artNoResults');
    if(noRes) noRes.style.display = visible === 0 ? 'block' : 'none';
    var cnt = document.getElementById('artCount');
    if(cnt) cnt.textContent = visible + ' articles';
}

// ── League Filter ──
function filterLeague(league){
    document.querySelectorAll('.league-btn').forEach(function(btn){
        var active = btn.dataset.league === league;
        btn.style.background = active ? '#1E90FF' : 'rgba(255,255,255,0.04)';
        btn.style.borderColor = active ? '#1E90FF' : 'rgba(255,255,255,0.1)';
        btn.style.color = active ? 'white' : '#94A3B8';
    });
    document.querySelectorAll('.board-row').forEach(function(row){
        row.style.display = (league === 'ALL' || row.dataset.league === league) ? '' : 'none';
    });
}
</script>
@endpush

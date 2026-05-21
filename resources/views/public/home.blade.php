@extends('layouts.public')
@section('title', 'INSPIN - Sports Betting Analysis & Picks')

@push('styles')
<style>
body { background: #171818; }

/* ── Responsive grids ── */
.home-articles-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
@media(max-width:900px){ .home-articles-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:560px){ .home-articles-grid { grid-template-columns: 1fr; } }

.home-picks-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 20px; }
@media(max-width:740px){ .home-picks-grid { grid-template-columns: 1fr; } }

.home-pkg-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
@media(max-width:900px){ .home-pkg-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:560px){ .home-pkg-grid { grid-template-columns: 1fr; } }

/* ── Article card ── */
.home-art-card {
    background: #212121;
    border: 1px solid rgba(255,252,238,0.07);
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    transition: border-color .2s, transform .2s, box-shadow .2s;
    color: inherit;
}
.home-art-card:hover { border-color: rgba(253,181,21,0.35); transform: translateY(-3px); box-shadow: 0 16px 48px rgba(0,0,0,.6); }
.home-art-card img { width:100%; height:185px; object-fit:cover; display:block; }

/* ── Pick card ── */
.home-pick-card {
    background: #212121;
    border: 1px solid rgba(255,252,238,0.12);
    border-radius: 12px;
    padding: 20px 22px 18px;
    display: flex;
    flex-direction: column;
    gap: 0;
    transition: border-color .2s, box-shadow .2s;
}
.home-pick-card:hover { border-color: rgba(253,181,21,0.45); box-shadow: 0 8px 32px rgba(0,0,0,.5); }

/* ── Package card ── */
.home-pkg-card {
    background: #212121;
    border: 1px solid rgba(255,252,238,0.07);
    border-radius: 12px;
    padding: 26px 22px 22px;
    position: relative;
    display: flex;
    flex-direction: column;
    transition: border-color .2s, box-shadow .2s;
}
.home-pkg-card:hover { border-color: rgba(253,181,21,0.35); box-shadow: 0 8px 32px rgba(0,0,0,.4); }

/* ── Nav arrow buttons ── */
.arr-btn {
    width: 34px; height: 34px; border-radius: 50%;
    border: 1.5px solid #FDB515; background: transparent;
    color: #FDB515; font-size: 18px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .18s, color .18s; flex-shrink: 0;
    line-height: 1;
}
.arr-btn:hover { background: #FDB515; color: #171818; }

/* ── Live dot pulse ── */
@keyframes livePulse { 0%,100%{opacity:1} 50%{opacity:.3} }
.live-dot { display:inline-block; width:8px; height:8px; border-radius:50%; background:#ef4444; animation:livePulse 1.4s infinite; flex-shrink:0; }

/* ── Team avatar ── */
.t-avatar {
    width:28px; height:28px; border-radius:50%;
    background:#2d2d2d; color:#6e6e6e;
    display:flex; align-items:center; justify-content:center;
    font-size:8px; font-weight:800; letter-spacing:.3px;
    flex-shrink:0; text-transform:uppercase;
}

/* ── Hero heading responsive ── */
@media(max-width:900px){ .hero-h1 { font-size:2.8rem !important; } }
@media(max-width:640px){ .hero-h1 { font-size:2rem !important; } }
@media(max-width:400px){ .hero-h1 { font-size:1.5rem !important; } }

/* ── Mobile section padding ── */
@media(max-width:768px){
    .home-picks-grid { grid-template-columns:1fr !important; }
    .home-pkg-grid { grid-template-columns:1fr !important; }
    .home-articles-grid { grid-template-columns:1fr !important; }
}
@media(max-width:480px){
    .home-pick-card { padding:16px; }
    .home-pkg-card { padding:20px 16px; }
    .arr-btn { width:30px; height:30px; font-size:16px; }
}
</style>
@endpush

@section('content')

{{-- ════════════════════════════════════════════ --}}
{{--  HERO                                         --}}
{{-- ════════════════════════════════════════════ --}}
<section style="background:#171818;padding:110px 0 100px;text-align:center;position:relative;overflow:hidden;min-height:520px;display:flex;align-items:center;">
    {{-- Crosshatch grid lines --}}
    <div style="position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,252,238,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,252,238,.03) 1px,transparent 1px);background-size:68px 68px;"></div>
    {{-- Centre vignette --}}
    <div style="position:absolute;inset:0;pointer-events:none;background:radial-gradient(ellipse 80% 65% at 50% 48%,rgba(23,24,24,.85) 0%,transparent 100%);"></div>
    {{-- Bottom gold divider --}}
    <div style="position:absolute;bottom:0;left:0;right:0;height:1.5px;background:linear-gradient(90deg,transparent 5%,#c47f10 30%,#FDB515 50%,#c47f10 70%,transparent 95%);"></div>
    {{-- Amber corner dots --}}
    <div style="position:absolute;bottom:76px;left:56px;width:8px;height:8px;border-radius:50%;background:#FDB515;opacity:.65;box-shadow:0 0 8px rgba(253,181,21,.5);"></div>
    <div style="position:absolute;bottom:76px;right:56px;width:8px;height:8px;border-radius:50%;background:#FDB515;opacity:.65;box-shadow:0 0 8px rgba(253,181,21,.5);"></div>

    <div class="container" style="position:relative;width:100%;">
        {{-- Headline with Figma gradient: edges fade into #171818, center is #FFFCEE --}}
        <h1 class="hero-h1" style="font-family:'Clash Display',sans-serif;font-size:61px;font-weight:500;line-height:1.18;letter-spacing:-.5px;margin-bottom:24px;max-width:920px;margin-left:auto;margin-right:auto;background:linear-gradient(90deg,#171818 -15.33%,#FFFCEE 48.07%,#171818 113.68%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            INSPIN Simulation/Handicapper Model – Up +150 Units over 3 Years
        </h1>
        <p style="color:#FDB515;font-size:13.5px;font-weight:500;margin-bottom:16px;letter-spacing:.1px;opacity:.9;">
            ($100 bettor won $15,000 / $500 bettor won $75,000 / $1,000 bettor won $150,000)
        </p>
        <p style="color:#7a7a8a;font-size:15px;font-weight:400;margin-bottom:22px;">
            Want to crush the books without the guesswork?
        </p>
        <p style="margin-bottom:34px;">
            <a href="{{ route('join') }}" style="color:#5a5a6a;font-size:13px;text-decoration:underline;text-underline-offset:3px;transition:color .15s;" onmouseover="this.style.color='#9a9aaa'" onmouseout="this.style.color='#5a5a6a'">See More</a>
        </p>
        <a href="{{ route('join') }}"
           style="display:inline-block;padding:13px 46px;border:1px solid #FDB515;border-radius:50px;color:#FDB515;font-family:'DM Sans',sans-serif;font-weight:600;font-size:15px;letter-spacing:.2px;text-decoration:none;background:#171818;transition:box-shadow .2s;box-shadow:0 0 21.7px rgba(253,181,21,.39);"
           onmouseover="this.style.boxShadow='0 0 32px rgba(253,181,21,.6)'"
           onmouseout="this.style.boxShadow='0 0 21.7px rgba(253,181,21,.39)'"
        >Join Now</a>
    </div>
</section>

{{-- ════════════════════════════════════════════ --}}
{{--  EXCLUSIVE ARTICLES                           --}}
{{-- ════════════════════════════════════════════ --}}
@if($articles->count() > 0)
<section style="background:#171818;padding:80px 0;">
    <div class="container">
        {{-- Section header --}}
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:32px;flex-wrap:wrap;">
            <div>
                <h2 style="font-family:'Clash Display',sans-serif;font-size:1.7rem;font-weight:500;color:#FFFCEE;letter-spacing:-.2px;margin-bottom:5px;">Exclusive Articles and Analysis</h2>
                <p style="color:#6e6e6e;font-size:13.5px;margin:0;">Expert insights to sharpen your edge</p>
            </div>
            <div style="display:flex;gap:8px;padding-top:6px;">
                <button class="arr-btn" onclick="scrollArts(-1)" aria-label="Previous">&#8249;</button>
                <button class="arr-btn" onclick="scrollArts(1)"  aria-label="Next">&#8250;</button>
            </div>
        </div>

        <div id="artsTrack" class="home-articles-grid">
            @foreach($articles as $art)
            <a href="{{ route('article.show', $art) }}" class="home-art-card">
                @if($art->featured_image)
                    <img src="{{ asset('storage/'.$art->featured_image) }}" alt="{{ $art->title }}">
                @else
                    <div style="width:100%;height:185px;background:#2d2d2d;display:flex;align-items:center;justify-content:center;color:#4a4a4a;font-size:2.5rem;">🏅</div>
                @endif

                <div style="padding:16px 18px 20px;display:flex;flex-direction:column;flex:1;">
                    {{-- Badge row --}}
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;flex-wrap:wrap;">
                        @php
                            $sp = strtolower($art->sport ?? '');
                            $bc = $sp==='mlb'?'rgba(22,163,74,.15)':($sp==='nba'?'rgba(220,38,38,.15)':($sp==='nfl'?'rgba(29,78,216,.15)':'rgba(253,181,21,.12)'));
                            $tc = $sp==='mlb'?'#4ade80':($sp==='nba'?'#f87171':($sp==='nfl'?'#93c5fd':'#FDB515'));
                        @endphp
                        <span style="background:{{ $bc }};color:{{ $tc }};padding:3px 10px;border-radius:5px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">{{ $art->sport }}</span>
                        <span style="background:rgba(36,251,238,0.12);border:1px solid rgba(36,251,238,0.3);color:#24FBEE;padding:2px 8px;border-radius:5px;font-size:10px;font-weight:600;letter-spacing:.3px;">{{ $art->category }}</span>
                    </div>
                    {{-- Title --}}
                    <h3 style="font-family:'Clash Display',sans-serif;font-size:14px;font-weight:500;color:#FFFCEE;line-height:1.4;margin-bottom:8px;">{{ Str::limit($art->title, 80) }}</h3>
                    {{-- Excerpt --}}
                    <p style="font-size:13px;color:#6e6e6e;line-height:1.55;flex:1;margin-bottom:14px;">{{ Str::limit(strip_tags($art->excerpt ?? ''), 110) }}</p>
                    {{-- Meta --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,252,238,.06);padding-top:11px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:26px;height:26px;border-radius:50%;background:#2d2d2d;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;color:#9a9a9a;flex-shrink:0;text-transform:uppercase;">{{ substr($art->author ?? 'A',0,1) }}</div>
                            <span style="font-size:12px;color:#9a9a9a;">{{ $art->author }}</span>
                        </div>
                        <span style="display:flex;align-items:center;gap:4px;color:#4a4a4a;font-size:12px;flex-shrink:0;">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $art->published_at?->format('M d, Y') ?? '' }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════ --}}
{{--  ACTIVE PICKS                                --}}
{{-- ════════════════════════════════════════════ --}}
@if($expertPicks->count() > 0)
<section style="background:#171818;padding:80px 0;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;pointer-events:none;background-image:radial-gradient(circle,rgba(253,181,21,.035) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="container" style="position:relative;">
        {{-- Header --}}
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:28px;flex-wrap:wrap;">
            <div>
                <h2 style="font-family:'Clash Display',sans-serif;font-size:1.7rem;font-weight:500;color:#FFFCEE;letter-spacing:-.2px;margin-bottom:5px;">Active Picks</h2>
                <p style="color:#6e6e6e;font-size:13.5px;margin:0;">Current picks — login to see full details</p>
            </div>
            <a href="{{ route('picks') }}" style="display:inline-flex;align-items:center;padding:9px 22px;border:1px solid #FDB515;border-radius:50px;color:#FDB515;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap;transition:background .18s;align-self:flex-start;margin-top:4px;" onmouseover="this.style.background='rgba(253,181,21,.1)'" onmouseout="this.style.background='transparent'">View All Picks</a>
        </div>

        {{-- 2×2 grid --}}
        <div class="home-picks-grid">
            @foreach($expertPicks as $pick)
            @php
                $rawTime   = $pick->game_time ? (string)$pick->game_time : '00:00:00';
                $timeStr   = strlen($rawTime) === 5 ? $rawTime.':00' : substr($rawTime, 0, 8);
                $gameStart = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pick->game_date->format('Y-m-d').' '.$timeStr, 'America/New_York');
                $now       = \Carbon\Carbon::now('America/New_York');
                $status    = $pick->result !== 'pending' ? 'Graded' : ($now->gte($gameStart) ? 'Started' : 'Active');
                $sportEmojis = ['MLB'=>'⚾','NFL'=>'🏈','NBA'=>'🏀','NHL'=>'🏒','NCAAF'=>'🏈','NCAAB'=>'🏀','MMA'=>'🥊','GOLF'=>'⛳'];
                $sEmoji = $sportEmojis[$pick->sport] ?? '🏅';
                $t1init = strtoupper(substr($pick->team1_name ?? 'TM',0,3));
                $t2init = strtoupper(substr($pick->team2_name ?? 'TM',0,3));
                $conf   = $pick->team1_percent;
                $statusStyles = ['Started'=>'background:rgba(239,68,68,.15);border:1px solid #ef4444;color:#ef4444;','Active'=>'background:rgba(0,209,91,.15);border:1px solid #00D15B;color:#00D15B;','Graded'=>'background:rgba(100,100,100,.12);border:1px solid #4a4a4a;color:#9a9a9a;'];
            @endphp
            <div class="home-pick-card">
                {{-- Row 1: sport icon circle + name | stars --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:38px;height:38px;border-radius:50%;background:#2a2a2a;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;border:1px solid rgba(255,252,238,.08);">{{ $sEmoji }}</div>
                        <span style="color:#FFFCEE;font-size:14px;font-weight:600;letter-spacing:.1px;">{{ $pick->sport }}</span>
                    </div>
                    <div style="font-size:15px;letter-spacing:1px;">
                        @if($pick->stars === 10)
                            <span style="color:#FDB515;font-size:10px;font-weight:800;letter-spacing:.2px;">★10 WHALE</span>
                        @else
                            <span style="color:#FDB515;">{{ str_repeat('★', (int)$pick->stars) }}</span><span style="color:#3a3a3a;">{{ str_repeat('★', max(0,5-(int)$pick->stars)) }}</span>
                        @endif
                    </div>
                </div>

                {{-- Row 2: status pill + time --}}
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;flex-wrap:wrap;">
                    @if($status==='Started')<span class="live-dot"></span>@endif
                    <span style="{{ $statusStyles[$status] ?? '' }}font-size:13px;font-weight:800;padding:3px 10px;border-radius:20px;">{{ $status }}</span>
                    <span style="color:#6e6e6e;font-size:12px;">
                        {{ $pick->game_date?->format('M d') }}{{ $pick->game_time ? ' @ '.\Carbon\Carbon::parse($pick->game_time)->format('g:i A').' ET' : '' }}
                    </span>
                </div>

                {{-- Row 3: Teams combined + confidence --}}
                <div style="margin-bottom:16px;">
                    <div style="display:flex;align-items:center;gap:7px;margin-bottom:10px;flex-wrap:wrap;">
                        <div style="width:28px;height:28px;border-radius:50%;background:#2a2a2a;flex-shrink:0;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,252,238,.08);overflow:hidden;">
                            @if($pick->team1_logo)
                                <img src="{{ asset('storage/'.$pick->team1_logo) }}" style="width:22px;height:22px;object-fit:contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                                <span style="display:none;font-size:8px;font-weight:800;color:#9a9a9a;">{{ $t1init }}</span>
                            @else
                                <span style="font-size:8px;font-weight:800;color:#9a9a9a;">{{ $t1init }}</span>
                            @endif
                        </div>
                        <span style="color:#FFFCEE;font-size:13px;font-weight:600;">{{ $pick->team1_name }}</span>
                        <span style="color:#4a4a4a;font-size:11px;">vs</span>
                        <div style="width:28px;height:28px;border-radius:50%;background:#2a2a2a;flex-shrink:0;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,252,238,.08);overflow:hidden;">
                            @if($pick->team2_logo)
                                <img src="{{ asset('storage/'.$pick->team2_logo) }}" style="width:22px;height:22px;object-fit:contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                                <span style="display:none;font-size:8px;font-weight:800;color:#9a9a9a;">{{ $t2init }}</span>
                            @else
                                <span style="font-size:8px;font-weight:800;color:#9a9a9a;">{{ $t2init }}</span>
                            @endif
                        </div>
                        <span style="color:#FFFCEE;font-size:13px;font-weight:600;">{{ $pick->team2_name }}</span>
                    </div>
                    @if($conf)
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:7px;">
                        <span style="{{ $statusStyles[$status] ?? '' }}font-size:11px;font-weight:800;padding:2px 8px;border-radius:20px;">{{ $status }} Pick</span>
                        <span style="font-size:13px;font-weight:700;color:#FDB515;">{{ $conf }}% Confidence</span>
                    </div>
                    <div style="height:4px;background:#2a2a2a;border-radius:4px;overflow:hidden;">
                        <div style="width:{{ $conf }}%;height:100%;background:#FDB515;border-radius:4px;"></div>
                    </div>
                    @endif
                </div>

                {{-- View Pick --}}
                @auth
                    <a href="{{ route('picks') }}" style="display:block;text-align:center;padding:11px;border:1px solid #3a3a3a;border-radius:9px;color:#9a9a9a;font-weight:600;font-size:13px;text-decoration:none;transition:border-color .15s,color .15s;" onmouseover="this.style.borderColor='#FDB515';this.style.color='#FDB515'" onmouseout="this.style.borderColor='#3a3a3a';this.style.color='#9a9a9a'">View Pick</a>
                @else
                    <button onclick="openModal('join')" style="width:100%;padding:11px;border:1px solid #3a3a3a;border-radius:9px;color:#9a9a9a;font-weight:600;font-size:13px;background:transparent;cursor:pointer;transition:border-color .15s,color .15s;" onmouseover="this.style.borderColor='#FDB515';this.style.color='#FDB515'" onmouseout="this.style.borderColor='#3a3a3a';this.style.color='#9a9a9a'">View Pick</button>
                @endauth
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════ --}}
{{--  MEMBERSHIP PACKAGES                         --}}
{{-- ════════════════════════════════════════════ --}}
@php
    $featuredSlugs    = ['free-trial','1-week','2-weeks','monthly','quarterly','semi-annual'];
    $featuredPackages = $packages
        ->filter(fn($p) => in_array($p->slug, $featuredSlugs))
        ->sortBy(fn($p)  => array_search($p->slug, $featuredSlugs));
@endphp
<section style="background:#171818;padding:80px 0;">
    <div class="container">
        <div style="margin-bottom:36px;">
            <h2 style="font-family:'Clash Display',sans-serif;font-size:1.7rem;font-weight:500;color:#FFFCEE;letter-spacing:-.2px;margin-bottom:6px;">Membership Packages</h2>
            <p style="color:#6e6e6e;font-size:13.5px;margin:0;">Start free. Upgrade anytime. Cancel anytime.</p>
        </div>

        <div class="home-pkg-grid">
            @foreach($featuredPackages as $pkg)
            @php
                $isFree    = $pkg->slug === 'free-trial';
                $isMonthly = $pkg->slug === 'monthly';
            @endphp
            <div class="home-pkg-card">
                {{-- Badge --}}
                @if($isFree)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:#22c55e;color:#fff;padding:4px 18px;border-radius:20px;font-size:10px;font-weight:700;letter-spacing:.6px;white-space:nowrap;box-shadow:0 2px 8px rgba(34,197,94,.4);">Starts Free</div>
                @elseif($isMonthly)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:#FDB515;color:#171818;padding:4px 18px;border-radius:20px;font-size:10px;font-weight:700;letter-spacing:.6px;white-space:nowrap;box-shadow:0 2px 8px rgba(253,181,21,.4);">Starts Free</div>
                @endif

                <div style="margin-top:{{ ($isFree||$isMonthly)?'12px':'0' }}">
                    <p style="font-size:11.5px;color:#6e6e6e;margin-bottom:4px;letter-spacing:.3px;">{{ $pkg->duration }} Access</p>
                    <p style="font-family:'Clash Display',sans-serif;font-size:1rem;font-weight:500;color:#FFFCEE;margin-bottom:18px;letter-spacing:-.1px;">{{ $pkg->name }}</p>
                </div>

                {{-- Price --}}
                <div style="margin-bottom:20px;">
                    @if($isFree)
                        <div style="font-family:'Clash Display',sans-serif;font-size:2.8rem;font-weight:600;color:#FFFCEE;line-height:1;letter-spacing:-1px;">FREE</div>
                        <div style="font-size:12px;color:#4ade80;margin-top:6px;">No credit card needed</div>
                    @else
                        <div style="font-family:'Clash Display',sans-serif;font-size:2.4rem;font-weight:600;color:#FFFCEE;line-height:1;letter-spacing:-1px;">
                            <sup style="font-size:.9rem;color:#6e6e6e;vertical-align:top;margin-top:9px;font-weight:500;">$</sup>{{ number_format($pkg->price,2) }}
                        </div>
                    @endif
                </div>

                {{-- Features --}}
                <ul style="list-style:none;padding:0;margin:0 0 22px;flex:1;">
                    @foreach(array_slice($pkg->features ?? [],0,5) as $feat)
                    <li style="display:flex;align-items:center;gap:9px;padding:7px 0;font-size:13px;color:#9a9a9a;border-bottom:1px solid rgba(255,252,238,.06);">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="flex-shrink:0;"><circle cx="8" cy="8" r="8" fill="rgba(74,222,128,.12)"/><polyline points="5,8.5 7,10.5 11,6" stroke="#4ade80" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>

                {{-- CTA --}}
                <a href="{{ route('join') }}"
                   style="display:block;text-align:center;padding:11px;border-radius:50px;font-weight:600;font-size:14px;text-decoration:none;letter-spacing:.1px;transition:background .18s;border:1px solid {{ $isFree?'#22c55e':'#2dd4bf' }};color:{{ $isFree?'#22c55e':'#2dd4bf' }};background:transparent;"
                   onmouseover="this.style.background='{{ $isFree?'rgba(34,197,94,.1)':'rgba(45,212,191,.1)' }}'"
                   onmouseout="this.style.background='transparent'">
                    {{ $isFree ? 'Start Free Trial' : 'Get Started' }}
                </a>
            </div>
            @endforeach
        </div>

        <p style="text-align:center;margin-top:24px;">
            <a href="{{ route('join') }}" style="color:#4a4a4a;font-size:13px;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#FDB515'" onmouseout="this.style.color='#4a4a4a'">View all packages &amp; pricing →</a>
        </p>
    </div>
</section>

@push('scripts')
<script>
function scrollArts(d) {
    var t = document.getElementById('artsTrack');
    if (t) t.scrollBy({ left: d * 360, behavior: 'smooth' });
}
</script>
@endpush

@endsection

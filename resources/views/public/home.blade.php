@extends('layouts.public')
@section('title', 'Sportshandicapper — Simulation Model Up +150 Units Over 3 Years')
@section('meta', 'Exclusive articles, daily picks, and membership access to a proven sports simulation handicapper model. Crush the books without the guesswork.')

@push('styles')
<style>
/* ── Pulse animation ── */
@keyframes livePulse { 0%,100%{opacity:1} 50%{opacity:.3} }
.pulse-dot { display:inline-block;width:8px;height:8px;border-radius:50%;background:rgba(14,165,233,0.8); }
.pulse-dot-ping { position:absolute;inset:0;border-radius:50%;background:rgba(14,165,233,0.75);animation:ping 1.2s cubic-bezier(0,0,0.2,1) infinite; }
@keyframes ping { 75%,100%{transform:scale(2);opacity:0} }
.pulse-green { background:#22c55e; }
.pulse-green-ping { position:absolute;inset:0;border-radius:50%;background:#22c55e;animation:ping 1.2s cubic-bezier(0,0,0.2,1) infinite; }
.live-dot { display:inline-flex;width:6px;height:6px;border-radius:50%;background:#22c55e;animation:livePulse 1.4s infinite; }

/* ── Grid background (hero) ── */
.hero-grid-lines {
    background-image: linear-gradient(to right,rgba(255,255,255,0.04) 1px,transparent 1px),linear-gradient(to bottom,rgba(255,255,255,0.04) 1px,transparent 1px);
    background-size:56px 56px;
}

/* ── Section heading ── */
.section-h2 { font-size:clamp(1.75rem,3vw,2.25rem);font-weight:800;color:white;letter-spacing:-0.03em;line-height:1.1; }

/* ── Eyebrow pill ── */
.eyebrow-pill { display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:9999px;background:rgba(14,165,233,0.1);border:1px solid rgba(14,165,233,0.3);color:#7DD3FC;font-size:10px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase; }

/* ── Round CTA link ── */
.round-link { display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:9999px;border:1px solid rgba(14,165,233,0.4);color:#7DD3FC;font-size:13px;font-weight:600;text-decoration:none;transition:all .2s; }
.round-link:hover { background:rgba(14,165,233,0.1);border-color:rgba(14,165,233,0.7);color:#BAE6FD; }

/* ── Confidence bar ── */
.conf-bar { height:8px;background:rgba(255,255,255,0.06);border-radius:9999px;overflow:hidden; }
.conf-fill { height:100%;background:linear-gradient(90deg,#1E90FF,#22D3EE);border-radius:9999px; }
.conf-fill-violet { background:linear-gradient(90deg,#0EA5E9,#22D3EE); }
.conf-fill-full { background:linear-gradient(90deg,#1E90FF,#22D3EE,#A855F7);box-shadow:0 0 10px rgba(30,144,255,0.4); }

/* ── Grids ── */
.g12 { display:grid;grid-template-columns:repeat(12,1fr);gap:24px;align-items:start; }
.g12-center { align-items:center; }
.c7 { grid-column:span 7; }
.c5 { grid-column:span 5; }
.g3 { display:grid;grid-template-columns:repeat(3,1fr);gap:24px; }
.g4 { display:grid;grid-template-columns:repeat(4,1fr);gap:24px; }
.g2 { display:grid;grid-template-columns:repeat(2,1fr);gap:32px;align-items:center; }
.g-stats { display:grid;grid-template-columns:repeat(4,1fr);gap:32px; }

@media(max-width:1024px){
    .g12,.g12-center { grid-template-columns:1fr; }
    .c7,.c5 { grid-column:span 1; }
    .g3 { grid-template-columns:repeat(2,1fr); }
    .g4 { grid-template-columns:repeat(2,1fr); }
    .g2 { grid-template-columns:1fr; }
    .g-stats { grid-template-columns:repeat(2,1fr);gap:24px; }
}
@media(max-width:640px){
    .g3,.g4 { grid-template-columns:1fr; }
    .g-stats { grid-template-columns:repeat(2,1fr);gap:16px; }
}

/* ── Article cards ── */
.art-featured { border-radius:16px;overflow:hidden;border:1px solid rgba(255,255,255,0.1);background:#0C1020;transition:border-color .25s,transform .25s;display:flex;flex-direction:column;min-height:460px;text-decoration:none;color:inherit; }
.art-featured:hover { border-color:rgba(30,144,255,0.4);transform:translateY(-2px); }
.art-secondary { display:flex;gap:16px;border-radius:16px;border:1px solid rgba(255,255,255,0.08);background:#0C1020;padding:16px;transition:all .2s;text-decoration:none;color:inherit; }
.art-secondary:hover { border-color:rgba(30,144,255,0.3);transform:translateY(-1px); }

/* ── Pick cards ── */
.pick-feat { border-radius:16px;border:1px solid rgba(30,144,255,0.25);background:#0C1020;padding:32px 36px;position:relative;overflow:hidden;display:flex;flex-direction:column; }
.pick-secondary { border-radius:16px;border:1px solid rgba(255,255,255,0.08);background:#0C1020;padding:20px;transition:all .2s;display:flex;flex-direction:column; }
.pick-secondary:hover { border-color:rgba(30,144,255,0.3);transform:translateY(-1px); }
.pick-mini { border-radius:12px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);padding:16px; }

/* ── Stats bar ── */
.stats-section { border-top:1px solid rgba(255,255,255,0.06);border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(255,255,255,0.015); }
.stat-num { font-size:clamp(1.75rem,3vw,2.5rem);font-weight:900;letter-spacing:-0.04em;color:#22D3EE;line-height:1; }

/* ── Package cards ── */
.pkg-card { border-radius:16px;border:1px solid rgba(255,255,255,0.1);background:#0C1020;padding:28px 24px;position:relative;display:flex;flex-direction:column;transition:border-color .25s,box-shadow .3s; }
.pkg-card:hover { border-color:rgba(30,144,255,0.4);box-shadow:0 20px 60px -20px rgba(30,144,255,0.2); }
.pkg-card.highlight { border-color:rgba(30,144,255,0.5);background:#0C1020;box-shadow:0 0 0 1px rgba(30,144,255,0.3),0 20px 60px -20px rgba(30,144,255,0.35); }

/* ── Tool cards ── */
.tool-card { border-radius:16px;padding:24px;position:relative;background:linear-gradient(180deg,rgba(13,18,36,0.9),rgba(10,12,28,0.9));border:1px solid rgba(14,165,233,0.12);box-shadow:0 1px 0 rgba(255,255,255,0.04) inset,0 20px 40px -20px rgba(0,0,0,0.6);transition:transform .3s ease,box-shadow .3s ease,border-color .3s ease; }
.tool-card:hover { transform:translateY(-3px);border-color:rgba(14,165,233,0.35);box-shadow:0 0 0 1px rgba(168,85,247,0.4),0 20px 60px -20px rgba(168,85,247,0.45); }
.tool-icon { width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(14,165,233,0.12);border:1px solid rgba(14,165,233,0.25);font-size:20px; }
.tool-soon { position:absolute;top:16px;right:16px;font-size:9px;font-weight:700;background:rgba(14,165,233,0.15);color:#7DD3FC;border-radius:9999px;padding:3px 10px;letter-spacing:0.12em;text-transform:uppercase; }

/* ── About stat cards ── */
.about-stat { border-radius:14px;border:1px solid rgba(255,255,255,0.05);background:rgba(255,255,255,0.02);padding:20px; }
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════ --}}
{{--  HERO                                          --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="padding:80px 0 96px;position:relative;overflow:hidden;">
    <div class="container-x">
        <div class="g12 g12-center">

            {{-- LEFT --}}
            <div class="c7" style="display:flex;flex-direction:column;gap:28px;">
                {{-- Live badge --}}
                <div>
                    <div style="display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border-radius:9999px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:rgba(14,165,233,0.9);">
                        <span style="position:relative;display:inline-flex;width:8px;height:8px;">
                            <span class="pulse-dot-ping"></span>
                            <span class="pulse-dot"></span>
                        </span>
                        Live Edge Detection Active
                    </div>
                </div>

                {{-- Headline --}}
                <h1 style="font-size:clamp(2.5rem,5vw,4.25rem);font-weight:800;line-height:1.05;letter-spacing:-0.03em;color:white;margin:0;">
                    Betting <span class="gradient-text-vivid">Intelligence</span> At Scale.
                </h1>

                {{-- Subtext --}}
                <p style="font-size:clamp(15px,1.5vw,18px);color:#94A3B8;line-height:1.75;max-width:540px;margin:0;">
                    Institutional-grade sports analytics, predictive modeling, and live pick feeds built for professional handicappers. Don't play the house — use their data against them.
                </p>

                {{-- CTAs --}}
                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:16px;">
                    <a href="{{ route('join') }}" class="btn-primary">
                        Get Started Today
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('picks') }}" class="btn-secondary">
                        Explore Models
                    </a>
                </div>
            </div>

            {{-- RIGHT: ROI Simulator --}}
            <div class="c5">
                <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:2.5rem;padding:32px 36px;position:relative;overflow:hidden;box-shadow:0 32px 80px rgba(0,0,0,0.4),0 0 0 1px rgba(14,165,233,0.05);">
                    <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(30,144,255,0.1),transparent 50%,rgba(168,85,247,0.1));opacity:0.7;pointer-events:none;border-radius:inherit;"></div>
                    <div style="position:relative;z-index:1;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;">
                            <h3 style="font-family:'Space Grotesk',sans-serif;font-size:18px;font-weight:700;color:white;letter-spacing:-0.01em;margin:0;">ROI Simulator</h3>
                            <span style="font-size:9px;font-weight:700;padding:5px 10px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:6px;color:#94A3B8;letter-spacing:0.12em;text-transform:uppercase;">Pro Model v4.2</span>
                        </div>

                        <div style="display:flex;flex-direction:column;gap:20px;margin-bottom:28px;">
                            <div>
                                <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                                    <span style="font-size:14px;color:#94A3B8;font-weight:500;">Monthly Units Staked</span>
                                    <span style="font-size:14px;color:white;font-weight:700;">450 Units</span>
                                </div>
                                <div class="conf-bar"><div class="conf-fill" style="width:65%;"></div></div>
                            </div>
                            <div>
                                <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                                    <span style="font-size:14px;color:#94A3B8;font-weight:500;">Projected Win Rate</span>
                                    <span style="font-size:14px;color:#22D3EE;font-weight:700;">58.4%</span>
                                </div>
                                <div class="conf-bar"><div class="conf-fill conf-fill-violet" style="width:78%;"></div></div>
                            </div>
                        </div>

                        <div style="padding-top:24px;border-top:1px solid rgba(255,255,255,0.06);text-align:center;margin-bottom:20px;">
                            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;color:#64748B;margin-bottom:8px;">Potential Monthly Profit</div>
                            <div style="font-family:'Space Grotesk',sans-serif;font-size:clamp(2.25rem,4vw,3.25rem);font-weight:800;color:white;letter-spacing:-0.04em;line-height:1;">$12,480.00</div>
                            <div style="font-size:11px;font-weight:700;color:#818CF8;letter-spacing:0.15em;margin-top:8px;text-transform:uppercase;">+24.2% ROI Per Slip</div>
                        </div>

                        <a href="{{ route('join') }}" style="display:block;text-align:center;padding:13px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:14px;font-size:11px;font-weight:700;color:white;text-decoration:none;letter-spacing:0.12em;text-transform:uppercase;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,0.09)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                            Apply Strategy
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{--  EXCLUSIVE ARTICLES                            --}}
{{-- ══════════════════════════════════════════════ --}}
@php
$sampleArticles = [
    ['tag'=>'MLB','title'=>'GAME PREVIEW: Texas Rangers vs. Colorado Rockies analysis, best bets','author'=>'Michael Rinner','date'=>'May 19, 2026','bg'=>'#7f1d1d','initial'=>'M'],
    ['tag'=>'NBA','title'=>'Cavaliers vs Knicks: Eastern Conference clash with playoff implications','author'=>'Mike Davis','date'=>'May 18, 2026','bg'=>'#1e1b4b','initial'=>'M'],
    ['tag'=>'MLB','title'=>'Blue Jays vs Yankees: AL East rivalry sets up sharp value spots','author'=>'Michael Rinner','date'=>'May 17, 2026','bg'=>'#172554','initial'=>'M'],
];
$displayArticles = $articles->count() > 0 ? null : $sampleArticles;
@endphp
<section style="padding:80px 0;">
    <div class="container-x">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:40px;flex-wrap:wrap;">
            <div style="display:flex;flex-direction:column;gap:8px;">
                <h2 class="section-h2">Exclusive Articles and Analysis</h2>
                <p style="color:#64748B;font-size:14px;margin:0;">Expert insights to sharpen your edge</p>
            </div>
            <a href="{{ route('articles') }}" class="round-link">All Articles <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
        </div>

        @if($articles->count() > 0)
        @php $featured = $articles->first(); $rest = $articles->slice(1,2); @endphp
        <div class="g12">
            <div class="c7">
                <a href="{{ route('article.show', $featured) }}" class="art-featured">
                    <div style="position:relative;height:280px;background:#1e3a5f;overflow:hidden;flex-shrink:0;">
                        @if($featured->featured_image)
                            <img src="{{ asset('storage/'.$featured->featured_image) }}" alt="{{ $featured->title }}" style="width:100%;height:100%;object-fit:cover;opacity:0.7;">
                        @endif
                        <div style="position:absolute;inset:0;background:linear-gradient(to top,#0C1020 0%,rgba(12,16,32,0.3) 60%,transparent 100%);"></div>
                        <div style="position:absolute;top:16px;left:16px;display:flex;gap:8px;">
                            <span style="font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:white;background:#1E90FF;padding:5px 12px;border-radius:6px;">★ Featured</span>
                            <span style="font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:white;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);padding:5px 10px;border-radius:6px;">{{ $featured->sport }}</span>
                        </div>
                    </div>
                    <div style="padding:28px;flex:1;display:flex;flex-direction:column;">
                        <span style="font-size:10px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:#38BDF8;margin-bottom:10px;display:block;">{{ $featured->sport }} · {{ $featured->published_at?->format('M d, Y') ?? '' }}</span>
                        <h3 style="font-size:clamp(1rem,2vw,1.4rem);font-weight:800;color:white;line-height:1.3;margin-bottom:14px;flex:1;">{{ $featured->title }}</h3>
                        <p style="color:#64748B;font-size:14px;line-height:1.65;margin-bottom:20px;">{{ Str::limit(strip_tags($featured->excerpt ?? ''), 120) }}</p>
                        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:16px;border-top:1px solid rgba(255,255,255,0.06);">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;border-radius:50%;background:#1E90FF;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:white;">{{ substr($featured->author ?? 'A',0,1) }}</div>
                                <div><div style="font-size:13px;font-weight:600;color:white;">{{ $featured->author }}</div><div style="font-size:11px;color:#64748B;">Analyst</div></div>
                            </div>
                            <span style="color:#38BDF8;font-size:12px;font-weight:700;">Read Story →</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="c5" style="display:flex;flex-direction:column;gap:16px;">
                @foreach($rest as $art)
                <a href="{{ route('article.show', $art) }}" class="art-secondary">
                    <div style="width:130px;flex-shrink:0;border-radius:10px;background:#1e3a5f;position:relative;overflow:hidden;min-height:100px;">
                        @if($art->featured_image)<img src="{{ asset('storage/'.$art->featured_image) }}" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.7;">@endif
                        <div style="position:absolute;bottom:6px;left:6px;"><span style="font-size:8px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:white;background:rgba(0,0,0,0.6);padding:3px 7px;border-radius:4px;">{{ $art->sport }}</span></div>
                    </div>
                    <div style="flex:1;min-width:0;display:flex;flex-direction:column;padding:2px 0;">
                        <span style="font-size:9px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:#38BDF8;margin-bottom:8px;">{{ $art->sport }}</span>
                        <h3 style="font-size:14px;font-weight:700;color:white;line-height:1.4;flex:1;">{{ Str::limit($art->title, 75) }}</h3>
                        <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#64748B;margin-top:8px;">
                            <span style="font-weight:600;color:#94A3B8;">{{ $art->author }}</span>
                            <span>·</span><span>{{ $art->published_at?->format('M d, Y') ?? '' }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
                @if($rest->count() < 2)
                @php $sample = $sampleArticles[1]; @endphp
                <div class="art-secondary" style="cursor:default;">
                    <div style="width:130px;flex-shrink:0;border-radius:10px;background:{{ $sample['bg'] }};min-height:100px;display:flex;align-items:center;justify-content:center;position:relative;">
                        <span style="position:absolute;bottom:6px;left:6px;font-size:8px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:white;background:rgba(0,0,0,0.6);padding:3px 7px;border-radius:4px;">{{ $sample['tag'] }}</span>
                    </div>
                    <div style="flex:1;min-width:0;display:flex;flex-direction:column;padding:2px 0;">
                        <span style="font-size:9px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:#38BDF8;margin-bottom:8px;">{{ $sample['tag'] }}</span>
                        <h3 style="font-size:14px;font-weight:700;color:white;line-height:1.4;flex:1;">{{ $sample['title'] }}</h3>
                        <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#64748B;margin-top:8px;">
                            <span style="font-weight:600;color:#94A3B8;">{{ $sample['author'] }}</span>
                            <span>·</span><span>{{ $sample['date'] }}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        {{-- Static sample articles --}}
        @php $fa = $sampleArticles[0]; @endphp
        <div class="g12">
            <div class="c7">
                <div class="art-featured">
                    <div style="position:relative;height:280px;background:{{ $fa['bg'] }};overflow:hidden;flex-shrink:0;">
                        <div style="position:absolute;inset:0;background:linear-gradient(to top,#0C1020 0%,rgba(12,16,32,0.2) 60%,transparent 100%);"></div>
                        <div style="position:absolute;top:16px;left:16px;display:flex;gap:8px;">
                            <span style="font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:white;background:#1E90FF;padding:5px 12px;border-radius:6px;">★ Featured</span>
                            <span style="font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:white;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);padding:5px 10px;border-radius:6px;">{{ $fa['tag'] }}</span>
                        </div>
                    </div>
                    <div style="padding:28px;flex:1;display:flex;flex-direction:column;">
                        <span style="font-size:10px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:#38BDF8;margin-bottom:10px;display:block;">{{ $fa['tag'] }} · {{ $fa['date'] }}</span>
                        <h3 style="font-size:clamp(1rem,2vw,1.4rem);font-weight:800;color:white;line-height:1.3;margin-bottom:14px;flex:1;">{{ $fa['title'] }}</h3>
                        <p style="color:#64748B;font-size:14px;line-height:1.65;margin-bottom:20px;">Expert analysis covering the top betting angles, line movement, and simulation model output for tonight's matchup.</p>
                        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:16px;border-top:1px solid rgba(255,255,255,0.06);">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;border-radius:50%;background:#e11d48;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:white;">M</div>
                                <div><div style="font-size:13px;font-weight:600;color:white;">{{ $fa['author'] }}</div><div style="font-size:11px;color:#64748B;">Analyst</div></div>
                            </div>
                            <a href="{{ route('articles') }}" style="color:#38BDF8;font-size:12px;font-weight:700;text-decoration:none;">Read Story →</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="c5" style="display:flex;flex-direction:column;gap:16px;">
                @foreach(array_slice($sampleArticles,1,2) as $sa)
                <div class="art-secondary" style="cursor:default;">
                    <div style="width:130px;flex-shrink:0;border-radius:10px;background:{{ $sa['bg'] }};min-height:100px;display:flex;align-items:center;justify-content:center;position:relative;">
                        <span style="position:absolute;bottom:6px;left:6px;font-size:8px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:white;background:rgba(0,0,0,0.6);padding:3px 7px;border-radius:4px;">{{ $sa['tag'] }}</span>
                    </div>
                    <div style="flex:1;min-width:0;display:flex;flex-direction:column;padding:2px 0;">
                        <span style="font-size:9px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:#38BDF8;margin-bottom:8px;">{{ $sa['tag'] }}</span>
                        <h3 style="font-size:14px;font-weight:700;color:white;line-height:1.4;flex:1;">{{ $sa['title'] }}</h3>
                        <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#64748B;margin-top:8px;">
                            <span style="font-weight:600;color:#94A3B8;">{{ $sa['author'] }}</span>
                            <span>·</span><span>{{ $sa['date'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{--  ACTIVE PICKS                                  --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="padding:80px 0;">
    <div class="container-x">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:40px;flex-wrap:wrap;">
            <div style="display:flex;flex-direction:column;gap:8px;">
                <div style="display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#86efac;margin-bottom:4px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block;animation:livePulse 1.4s infinite;"></span>Live
                </div>
                <h2 class="section-h2">Active Picks</h2>
                <p style="color:#64748B;font-size:14px;margin:0;">Current picks — <a href="{{ route('join') }}" style="color:#38BDF8;text-decoration:none;" onmouseover="this.style.color='#7DD3FC'" onmouseout="this.style.color='#38BDF8'">login to see full details</a></p>
            </div>
            <a href="{{ route('picks') }}" class="round-link">View All Picks →</a>
        </div>

        @if($expertPicks->count() > 0)
        @php
            $fp = $expertPicks->first();
            $rp = $expertPicks->slice(1,3);
            $getStatus = function($pick){
                $t = $pick->game_time?(string)$pick->game_time:'00:00:00';
                $ts = strlen($t)===5?$t.':00':substr($t,0,8);
                $gs = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$pick->game_date->format('Y-m-d').' '.$ts,'America/New_York');
                $now = \Carbon\Carbon::now('America/New_York');
                return $pick->result!=='pending'?'Graded':($now->gte($gs)?'Started':'Active');
            };
            $fpStatus = $getStatus($fp);
        @endphp
        <div class="g12">
            <div class="c7" style="height:100%;">
                <div class="pick-feat" style="height:100%;">
                    <div style="position:absolute;top:-80px;right:-60px;width:320px;height:320px;border-radius:50%;background:rgba(30,144,255,0.15);filter:blur(80px);pointer-events:none;"></div>
                    <div style="position:relative;z-index:1;display:flex;flex-direction:column;height:100%;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span style="font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:white;background:#1E90FF;padding:5px 12px;border-radius:6px;">★ Spotlight</span>
                                @if($fpStatus==='Started'||$fpStatus==='Active')
                                <span style="display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:9999px;border:1px solid rgba(34,197,94,0.4);color:#86efac;font-size:11px;font-weight:700;"><span class="live-dot"></span>Live · Started</span>
                                @endif
                            </div>
                            @if($fp->stars===10)<span style="color:#22D3EE;font-size:11px;font-weight:800;letter-spacing:0.1em;">★10 WHALE</span>@else<span style="color:#818CF8;font-size:14px;letter-spacing:2px;">{{ str_repeat('★',(int)$fp->stars) }}</span>@endif
                        </div>
                        <div style="margin-bottom:20px;">
                            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.15em;color:#38BDF8;margin-bottom:8px;">{{ $fp->sport }} · {{ $fp->game_date?->format('M d') }}{{ $fp->game_time?' @ '.\Carbon\Carbon::parse($fp->game_time)->format('g:i A').' ET':'' }}</div>
                            <div style="display:flex;align-items:baseline;gap:12px;flex-wrap:wrap;">
                                <span style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:800;color:white;letter-spacing:-0.03em;">{{ $fp->team1_name }}</span>
                                <span style="font-size:11px;color:#475569;text-transform:uppercase;letter-spacing:0.1em;">vs</span>
                                <span style="font-size:clamp(1.1rem,2vw,1.6rem);font-weight:700;color:#94A3B8;letter-spacing:-0.02em;">{{ $fp->team2_name }}</span>
                            </div>
                        </div>
                        @if($fp->team1_percent)
                        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:20px;">
                            <div class="pick-mini"><div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;margin-bottom:6px;">Confidence</div><div style="font-size:1.5rem;font-weight:800;color:white;">{{ $fp->team1_percent }}%</div></div>
                            <div class="pick-mini"><div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;margin-bottom:6px;">Edge</div><div style="font-size:1.5rem;font-weight:800;color:#86efac;">+EV</div></div>
                            <div class="pick-mini"><div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;margin-bottom:6px;">Stars</div><div style="font-size:15px;color:#818CF8;margin-top:4px;">{{ $fp->stars===10?'★10':str_repeat('★',(int)$fp->stars) }}</div></div>
                        </div>
                        <div style="margin-bottom:20px;"><div class="conf-bar"><div class="conf-fill conf-fill-full" style="width:{{ $fp->team1_percent }}%;"></div></div></div>
                        @endif
                        <div style="display:flex;gap:12px;margin-top:auto;">
                            @auth<a href="{{ route('picks') }}" class="btn-primary" style="flex:1;">View Pick Details →</a>
                            @else<a onclick="openModal('join');return false;" href="#" class="btn-primary" style="flex:1;">Unlock Whale Pick →</a>@endauth
                            <button class="btn-secondary" style="padding:14px 20px;">Details</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="c5" style="display:flex;flex-direction:column;gap:14px;">
                @foreach($rp as $pick)
                @php $pConf = $pick->team1_percent; @endphp
                <div class="pick-secondary">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:30px;height:30px;border-radius:8px;background:#1E90FF;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;color:white;">{{ strtoupper(substr($pick->sport,0,3)) }}</div>
                            <span style="display:inline-flex;align-items:center;gap:5px;color:#86efac;font-size:11px;font-weight:700;"><span class="live-dot" style="width:5px;height:5px;"></span>Live</span>
                        </div>
                        @if($pick->stars===10)<span style="color:#22D3EE;font-size:9px;font-weight:800;letter-spacing:0.1em;">★10 WHALE</span>@else<span style="color:#818CF8;font-size:12px;letter-spacing:1px;">{{ str_repeat('★',(int)$pick->stars) }}</span>@endif
                    </div>
                    <div style="display:flex;align-items:baseline;gap:8px;margin-bottom:6px;flex-wrap:wrap;">
                        <span style="font-size:14px;font-weight:700;color:white;">{{ $pick->team1_name }}</span>
                        <span style="font-size:10px;color:#475569;text-transform:uppercase;">vs</span>
                        <span style="font-size:13px;font-weight:600;color:#94A3B8;">{{ $pick->team2_name }}</span>
                    </div>
                    <div style="font-size:11px;color:#64748B;margin-bottom:10px;">{{ $pick->game_date?->format('M d') }}{{ $pick->game_time?' @ '.\Carbon\Carbon::parse($pick->game_time)->format('g:i A').' ET':'' }}</div>
                    @if($pConf)<div style="margin-top:auto;"><div style="display:flex;justify-content:space-between;margin-bottom:5px;"><span style="font-size:9px;font-weight:700;text-transform:uppercase;color:#64748B;">Confidence</span><span style="font-size:12px;font-weight:800;color:white;">{{ $pConf }}%</span></div><div class="conf-bar" style="height:5px;"><div class="conf-fill conf-fill-full" style="width:{{ $pConf }}%;"></div></div></div>@endif
                </div>
                @endforeach
                @if($rp->count()<3)
                <div class="pick-secondary" style="opacity:0.35;justify-content:center;align-items:center;min-height:72px;"><p style="color:#64748B;font-size:13px;text-align:center;">More picks loading...</p></div>
                @endif
            </div>
        </div>
        @else
        {{-- Static sample picks --}}
        <div class="g12">
            <div class="c7" style="height:100%;">
                <div class="pick-feat" style="height:100%;">
                    <div style="position:absolute;top:-80px;right:-60px;width:300px;height:300px;border-radius:50%;background:rgba(30,144,255,0.15);filter:blur(80px);pointer-events:none;"></div>
                    <div style="position:relative;z-index:1;display:flex;flex-direction:column;height:100%;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span style="font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:white;background:#1E90FF;padding:5px 12px;border-radius:6px;">★ Spotlight</span>
                                <span style="display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:9999px;border:1px solid rgba(34,197,94,0.4);color:#86efac;font-size:11px;font-weight:700;"><span class="live-dot"></span>Live · Started</span>
                            </div>
                            <span style="color:#22D3EE;font-size:11px;font-weight:800;letter-spacing:0.1em;">★10 WHALE</span>
                        </div>
                        <div style="margin-bottom:20px;">
                            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.15em;color:#38BDF8;margin-bottom:8px;">MLB · May 25 @ 6:05 PM ET</div>
                            <div style="display:flex;align-items:baseline;gap:12px;flex-wrap:wrap;">
                                <span style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:800;color:white;letter-spacing:-0.03em;">Texas Rangers</span>
                                <span style="font-size:11px;color:#475569;text-transform:uppercase;letter-spacing:0.1em;">vs</span>
                                <span style="font-size:clamp(1.1rem,2vw,1.6rem);font-weight:700;color:#94A3B8;letter-spacing:-0.02em;">Colorado Rockies</span>
                            </div>
                            <div style="font-size:12px;color:#64748B;margin-top:4px;">Coors Field, Denver, CO</div>
                        </div>
                        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:20px;">
                            <div class="pick-mini"><div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;margin-bottom:6px;">Confidence</div><div style="font-size:1.5rem;font-weight:800;color:white;">94%</div></div>
                            <div class="pick-mini"><div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;margin-bottom:6px;">Edge</div><div style="font-size:1.5rem;font-weight:800;color:#86efac;">+8.2%</div></div>
                            <div class="pick-mini"><div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;margin-bottom:6px;">Stars</div><div style="font-size:15px;color:#818CF8;margin-top:4px;">★10</div></div>
                        </div>
                        <div style="margin-bottom:20px;"><div class="conf-bar"><div class="conf-fill conf-fill-full" style="width:94%;"></div></div></div>
                        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:14px 16px;display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                            <div><div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748B;margin-bottom:4px;">Pick</div><div style="font-size:15px;font-weight:800;color:white;">Rangers ML -118</div></div>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </div>
                        <div style="display:flex;gap:12px;margin-top:auto;">
                            <a onclick="openModal('join');return false;" href="#" class="btn-primary" style="flex:1;">Unlock Whale Pick →</a>
                            <button class="btn-secondary" style="padding:14px 20px;">Details</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="c5" style="display:flex;flex-direction:column;gap:14px;">
                @foreach([['Blue Jays','Yankees','MLB',93,'★10 WHALE','#22D3EE','May 25 @ 7:05 PM ET'],['Cavaliers','Knicks','NBA',76,'★★★★★','#818CF8','May 25 @ 7:30 PM ET'],['Braves','Marlins','MLB',78,'★★★★★','#818CF8','May 25 @ 6:40 PM ET']] as $sp)
                <div class="pick-secondary">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:30px;height:30px;border-radius:8px;background:#1E90FF;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;color:white;">{{ strtoupper(substr($sp[2],0,3)) }}</div>
                            <span style="display:inline-flex;align-items:center;gap:5px;color:#86efac;font-size:11px;font-weight:700;"><span class="live-dot" style="width:5px;height:5px;"></span>Live</span>
                        </div>
                        <span style="color:{{ $sp[5] }};font-size:9px;font-weight:800;letter-spacing:0.1em;">{{ $sp[4] }}</span>
                    </div>
                    <div style="display:flex;align-items:baseline;gap:8px;margin-bottom:6px;">
                        <span style="font-size:14px;font-weight:700;color:white;">{{ $sp[0] }}</span>
                        <span style="font-size:10px;color:#475569;text-transform:uppercase;">vs</span>
                        <span style="font-size:13px;font-weight:600;color:#94A3B8;">{{ $sp[1] }}</span>
                    </div>
                    <div style="font-size:11px;color:#64748B;margin-bottom:10px;">{{ $sp[6] }}</div>
                    <div style="margin-top:auto;"><div style="display:flex;justify-content:space-between;margin-bottom:5px;"><span style="font-size:9px;font-weight:700;text-transform:uppercase;color:#64748B;">Confidence</span><span style="font-size:12px;font-weight:800;color:white;">{{ $sp[3] }}%</span></div><div class="conf-bar" style="height:5px;"><div class="conf-fill conf-fill-full" style="width:{{ $sp[3] }}%;"></div></div></div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{--  TRUST STATS                                   --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="stats-section" style="padding:48px 0;">
    <div class="container-x">
        <div class="g-stats">
            @foreach([['1,248+','Total Units Won'],['3 yrs','Verified Track Record'],['6','Sports Covered'],['62.4%','Win Rate']] as $s)
            <div style="text-align:center;">
                <div class="stat-num">{{ $s[0] }}</div>
                <div class="eyebrow" style="margin-top:8px;">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{--  MEMBERSHIP PACKAGES                           --}}
{{-- ══════════════════════════════════════════════ --}}
@php
$pkgMeta = [
    'free-trial' => ['tag'=>'Try it out','period'=>'trial','features'=>['3 sports','5 picks/day','Basic analytics','Email support'],'cta'=>'Start Free'],
    '1-week'     => ['tag'=>'Quick test','period'=>'/ week','features'=>['All sports','Full pick feed','Confidence ratings','Email + chat'],'cta'=>'Choose plan'],
    '2-weeks'    => ['tag'=>'Sharper edge','period'=>'/ 2 weeks','features'=>['All sports','Whale picks','Live odds','Priority chat'],'cta'=>'Choose plan'],
    'monthly'    => ['tag'=>'Most Popular','period'=>'/ month','features'=>['Everything in 2 Wks','ROI simulator','Trend reports','Pro Discord'],'cta'=>'Choose plan'],
    'quarterly'  => ['tag'=>'Save 33%','period'=>'/ quarter','features'=>['Everything in 1 Mo','Locked-line tracking','1:1 strategy call','Beta access'],'cta'=>'Choose plan'],
    'semi-annual'=> ['tag'=>'Best value','period'=>'/ 6 months','features'=>['Everything in 3 Mo','Bankroll planning','Private model alerts','Concierge support'],'cta'=>'Choose plan'],
];
$featuredSlugs = ['free-trial','1-week','2-weeks','monthly','quarterly','semi-annual'];
$featuredPackages = $packages->filter(fn($p)=>in_array($p->slug,$featuredSlugs))->sortBy(fn($p)=>array_search($p->slug,$featuredSlugs));
@endphp
<section style="padding:80px 0;">
    <div class="container-x">
        <div style="text-align:center;margin-bottom:52px;">
            <p class="eyebrow" style="margin-bottom:12px;display:inline-block;">Pricing</p>
            <h2 class="section-h2" style="margin-bottom:10px;">Membership Packages</h2>
            <p style="color:#64748B;font-size:15px;margin:0;">Start free. Upgrade anytime. Cancel anytime.</p>
        </div>

        <div class="g3">
            @foreach($featuredPackages as $pkg)
            @php
                $isFree = $pkg->slug==='free-trial';
                $isMo   = $pkg->slug==='monthly';
                $meta   = $pkgMeta[$pkg->slug] ?? ['tag'=>'','period'=>'','features'=>[],'cta'=>'Choose plan'];
            @endphp
            <div class="pkg-card {{ $isMo?'highlight':'' }}" style="{{ $isMo?'padding-top:40px;':'' }}">
                @if($isMo)
                <div style="position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:#1E90FF;color:white;padding:5px 20px;border-radius:9999px;font-size:10px;font-weight:700;letter-spacing:.08em;white-space:nowrap;text-transform:uppercase;">MOST POPULAR</div>
                @endif

                <div style="margin-bottom:6px;">
                    <p style="font-size:9px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:#1E90FF;margin:0 0 6px;">{{ strtoupper($meta['tag']) }}</p>
                    <h3 style="font-size:18px;font-weight:700;color:white;margin:0;">{{ $pkg->name }} Access</h3>
                </div>

                <div style="margin:16px 0 20px;display:flex;align-items:baseline;gap:4px;">
                    @if($isFree)
                        <span style="font-size:2.5rem;font-weight:800;color:white;letter-spacing:-0.04em;line-height:1;">FREE</span>
                        <span style="font-size:13px;color:#64748B;">trial</span>
                    @else
                        <span style="font-size:2.4rem;font-weight:800;color:white;letter-spacing:-0.04em;line-height:1;">${{ number_format($pkg->price,2) }}</span>
                        <span style="font-size:13px;color:#64748B;">{{ $meta['period'] }}</span>
                    @endif
                </div>

                <ul style="list-style:none;padding:0;margin:0 0 24px;flex:1;">
                    @foreach($meta['features'] as $feat)
                    <li style="display:flex;align-items:center;gap:9px;padding:7px 0;font-size:13px;color:#94A3B8;border-bottom:1px solid rgba(255,255,255,0.05);">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" style="flex-shrink:0;"><circle cx="7.5" cy="7.5" r="7.5" fill="rgba(34,197,94,0.12)"/><polyline points="4.5,8 6.5,10 10.5,5.5" stroke="#4ade80" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('join') }}" class="{{ $isMo?'btn-primary':'btn-secondary' }}" style="width:100%;justify-content:center;{{ $isMo?'':'border-color:rgba(255,255,255,0.12);color:#94A3B8;' }}">
                    {{ $meta['cta'] }}
                </a>
            </div>
            @endforeach
        </div>

        <p style="text-align:center;margin-top:32px;">
            <a href="{{ route('join') }}" style="font-size:13px;color:#38BDF8;text-decoration:none;" onmouseover="this.style.color='#7DD3FC'" onmouseout="this.style.color='#38BDF8'">View all packages &amp; pricing →</a>
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{--  DATA & TOOLS                                  --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="padding:80px 0;">
    <div class="container-x">
        <div style="max-width:640px;margin-bottom:48px;">
            <p class="eyebrow" style="margin-bottom:12px;">Data &amp; tools</p>
            <h2 class="section-h2">Everything you need to beat the books.</h2>
        </div>
        <div class="g4">
            @foreach([['🔬','Simulation Model','Monte-Carlo backed projections across every game on the slate.'],['⚡','Live Odds','Real-time line comparison across major sportsbooks.'],['📊','Consensus Data','Track where the public — and the sharps — are betting.'],['📈','Hot Trends','Streaks, splits, and situational angles updated daily.']] as $t)
            <div class="tool-card">
                <span class="tool-soon">Soon</span>
                <div class="tool-icon">{{ $t[0] }}</div>
                <h3 style="font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;color:white;margin:16px 0 6px;letter-spacing:-0.01em;">{{ $t[1] }}</h3>
                <p style="font-size:13px;color:#64748B;line-height:1.65;margin:0;">{{ $t[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{--  ABOUT                                         --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="padding:80px 0;">
    <div class="container-x">
        <div class="g2">
            <div>
                <p class="eyebrow" style="margin-bottom:12px;">About us</p>
                <h2 class="section-h2" style="margin-bottom:20px;">Built by bettors.<br>Powered by simulation.</h2>
                <p style="color:#94A3B8;font-size:15px;line-height:1.75;margin-bottom:16px;">We built our simulation handicapper model to remove emotion from betting. Every pick is the output of millions of game iterations modeled against live market lines — so the only thing left to do is follow the edge.</p>
                <p style="color:#94A3B8;font-size:15px;line-height:1.75;margin-bottom:32px;">Three years of verified results, transparent unit accounting, and a team of analysts who actually bet the plays we publish.</p>
                <div style="display:flex;gap:16px;flex-wrap:wrap;">
                    <a href="{{ route('join') }}" class="btn-primary">Join Now</a>
                    <a href="{{ route('picks') }}" class="btn-secondary">See Today's Picks</a>
                </div>
            </div>
            <div class="card-premium" style="padding:32px;position:relative;overflow:hidden;">
                <div style="position:absolute;inset:0;z-index:0;opacity:0.4;background:radial-gradient(closest-side,rgba(14,165,233,0.35),transparent 70%);"></div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;position:relative;z-index:1;">
                    @foreach([['62.4%','Win rate'],['+1,248u','Total profit'],['3 yrs','Verified'],['6','Sports']] as $s)
                    <div class="about-stat">
                        <div class="gradient-text-vivid" style="font-size:1.75rem;font-weight:900;letter-spacing:-0.03em;">{{ $s[0] }}</div>
                        <div class="eyebrow" style="margin-top:4px;">{{ $s[1] }}</div>
                    </div>
                    @endforeach
                </div>
                <div style="margin-top:24px;display:flex;align-items:flex-start;gap:8px;font-size:11px;color:#334155;position:relative;z-index:1;line-height:1.5;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    Information is for news and entertainment purposes only. Past performance is not a guarantee of future results.
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

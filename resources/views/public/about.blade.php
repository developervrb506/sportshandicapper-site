@extends('layouts.public')
@section('title', 'About | Sportshandicapper')
@section('meta', 'We don\'t sell hype. We sell receipts. Verified picks across NFL, NBA, MLB, NHL, CFB, CBB, PGA and XFL.')

@push('styles')
<style>
.about-pillar { border-radius:8px;border:1px solid rgba(255,255,255,0.08);background:rgba(0,0,0,0.3);padding:28px;transition:border-color .2s; }
.about-pillar:hover { border-color:rgba(30,144,255,0.35); }
.about-expert { border-radius:8px;border:1px solid rgba(255,255,255,0.08);background:rgba(0,0,0,0.3);padding:24px;text-align:center;transition:border-color .2s; }
.about-expert:hover { border-color:rgba(30,144,255,0.35); }
.timeline-item { position:relative;padding-left:28px; }
.timeline-item::before { content:'';position:absolute;left:0;top:7px;width:8px;height:8px;border-radius:50%;background:#1E90FF;box-shadow:0 0 8px rgba(30,144,255,0.5); }
.timeline-item::after { content:'';position:absolute;left:3.5px;top:15px;bottom:-24px;width:1px;background:rgba(255,255,255,0.06); }
.timeline-item:last-child::after { display:none; }
</style>
@endpush

@section('content')

@php
$staticExperts = [
    ['name'=>'Mike Davis',        'specialty'=>'MLB Specialist',   'initials'=>'MD', 'bio'=>'15+ years analyzing baseball markets. Focuses on starting pitcher matchups, bullpen usage, and park-factor adjusted totals.'],
    ['name'=>'David Wilson',      'specialty'=>'NHL Analyst',      'initials'=>'DW', 'bio'=>'Former professional hockey player turned full-time handicapper. Specializes in goaltender matchups and puck-line value.'],
    ['name'=>'Michael Rinnier',   'specialty'=>'NBA / CBB',        'initials'=>'MR', 'bio'=>'Quantitative model builder. Runs nightly simulations using adjusted offensive and defensive ratings across all 30 NBA teams.'],
    ['name'=>'Dave Johnson',      'specialty'=>'NFL / CFB',        'initials'=>'DJ', 'bio'=>'Sharp football specialist with a decade of verified ATS records. Focuses on line movement and situational spots.'],
];
$useRealExperts = isset($experts) && $experts->count() > 0;
@endphp

{{-- ── Hero ── --}}
<div style="border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(0,0,0,0.3);">
    <div class="container-x" style="padding:64px 0 56px;">
        <div class="reveal" style="max-width:760px;">
            <p class="eyebrow" style="color:#1E90FF;margin-bottom:16px;">About Us</p>
            <h1 style="font-size:clamp(2.5rem,5vw,4.5rem);font-weight:900;line-height:0.95;letter-spacing:-0.03em;color:white;margin:0 0 24px;">
                We don't sell hype.<br>
                <span style="color:#1E90FF;">We sell receipts.</span>
            </h1>
            <p style="font-size:clamp(15px,1.4vw,18px);color:#64748B;line-height:1.75;max-width:600px;margin:0 0 32px;">Every pick is timestamped before line move, posted with reasoning, and graded after the final whistle. Coverage spans NFL, NBA, MLB, NHL, CFB, CBB, PGA and XFL.</p>
            <div style="display:flex;flex-wrap:wrap;gap:8px;">
                @foreach(['NFL','NBA','MLB','NHL','CFB','CBB','PGA','XFL'] as $lg)
                <span style="padding:4px 12px;border-radius:4px;background:rgba(30,144,255,0.08);border:1px solid rgba(30,144,255,0.2);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#7DD3FC;">{{ $lg }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ── Performance Metrics ── --}}
<section style="border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(0,0,0,0.2);">
    <div class="container-x" style="padding:40px 0;">
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0;" class="about-stats-grid">
            @foreach([['+150u','Over 3 years','Units won'],['$15K+','On $100 bets','Profit potential'],['10,000+','Per game','Simulations run'],['24/7','Always on','Live support']] as $i=>$s)
            <div class="reveal" style="text-align:center;padding:32px 16px;border-right:{{ $i<3?'1px solid rgba(255,255,255,0.06)':'none' }};">
                <div class="counter-num" style="font-size:clamp(2rem,3.5vw,3rem);font-weight:900;font-family:'JetBrains Mono',monospace;color:white;line-height:1;margin-bottom:6px;" data-target="{{ preg_replace('/[^0-9.]/','',$s[0]) }}" data-prefix="{{ str_starts_with($s[0],'+') ? '+' : (str_starts_with($s[0],'$') ? '$' : '') }}" data-suffix="{{ str_ends_with($s[0],'u') ? 'u' : (str_ends_with($s[0],'+') ? '+' : '') }}">{{ $s[0] }}</div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;color:#1E90FF;margin-bottom:4px;">{{ $s[1] }}</div>
                <div style="font-size:11px;color:#475569;font-weight:600;">{{ $s[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Core Pillars ── --}}
<section class="container-x" style="padding:80px 0;">
    <div class="reveal" style="margin-bottom:48px;">
        <p class="eyebrow" style="color:#22D3EE;margin-bottom:10px;">How We Work</p>
        <h2 class="section-h2">Three pillars.</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;" class="pillars-grid">
        @foreach([
            ['01','Simulation Engine','Monte Carlo analysis',  'We run 10,000+ simulations per game using adjusted offensive/defensive ratings, pace, travel schedules, and real-time line updates. No guesswork.',  '#1E90FF'],
            ['02','Sharp Analytics', 'Money flow & CLV',       'We track ticket counts, handle percentages, and closing line value across 12 sportsbooks. When sharp money and our model agree, we act.',             '#22D3EE'],
            ['03','Verified Records','Timestamped picks',      'Every pick is locked and timestamped before kickoff. Results are graded by a third-party service and published in full — win, loss, or push.',         '#4ade80'],
        ] as $i=>$p)
        <div class="about-pillar reveal" style="transition-delay:{{ $i*80 }}ms;">
            <div style="font-size:clamp(2rem,3vw,2.5rem);font-weight:900;font-family:'JetBrains Mono',monospace;color:rgba(255,255,255,0.06);line-height:1;margin-bottom:20px;">{{ $p[0] }}</div>
            <div style="width:40px;height:40px;border-radius:6px;background:rgba(30,144,255,0.1);border:1px solid rgba(30,144,255,0.25);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                @if($i===0)
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $p[4] }}" stroke-width="1.75" stroke-linecap="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                @elseif($i===1)
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $p[4] }}" stroke-width="1.75" stroke-linecap="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                @else
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $p[4] }}" stroke-width="1.75" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                @endif
            </div>
            <p class="eyebrow" style="color:{{ $p[4] }};margin-bottom:8px;">{{ $p[2] }}</p>
            <h3 style="font-size:1.15rem;font-weight:900;color:white;margin:0 0 12px;">{{ $p[1] }}</h3>
            <p style="font-size:13px;color:#64748B;line-height:1.7;margin:0;">{{ $p[3] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ── Team ── --}}
<section class="container-x" style="padding:0 0 80px;">
    <div class="reveal" style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:40px;flex-wrap:wrap;gap:16px;">
        <div>
            <p class="eyebrow" style="color:#1E90FF;margin-bottom:10px;">The Team</p>
            <h2 class="section-h2">Expert handicappers.</h2>
        </div>
        <p style="font-size:13px;color:#475569;max-width:360px;">Decades of combined experience. Every pick owned end-to-end — data, model, post, grade.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;" class="experts-grid">
        @if($useRealExperts)
            @foreach($experts as $i=>$expert)
            <div class="about-expert reveal" style="transition-delay:{{ $i*60 }}ms;">
                @if($expert->avatar)
                <img src="{{ asset('storage/uploads/experts/'.$expert->avatar) }}" alt="{{ $expert->name }}" style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:2px solid rgba(30,144,255,0.3);margin:0 auto 16px;display:block;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div style="display:none;width:72px;height:72px;border-radius:50%;background:#1E90FF;align-items:center;justify-content:center;color:white;font-weight:900;font-size:24px;margin:0 auto 16px;">{{ strtoupper(substr($expert->name,0,1)) }}</div>
                @else
                <div style="width:72px;height:72px;border-radius:50%;background:#1E90FF;display:flex;align-items:center;justify-content:center;color:white;font-weight:900;font-size:24px;margin:0 auto 16px;">{{ strtoupper(substr($expert->name,0,1)) }}</div>
                @endif
                <div style="font-size:15px;font-weight:900;color:white;margin-bottom:4px;">{{ $expert->name }}</div>
                @if($expert->specialty)
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.14em;color:#1E90FF;margin-bottom:12px;">{{ $expert->specialty }}</div>
                @endif
                @if($expert->bio)
                <p style="font-size:12px;color:#64748B;line-height:1.65;">{{ Str::limit($expert->bio, 120) }}</p>
                @endif
            </div>
            @endforeach
        @else
            @foreach($staticExperts as $i=>$e)
            <div class="about-expert reveal" style="transition-delay:{{ $i*60 }}ms;">
                <div style="width:72px;height:72px;border-radius:50%;background:#1E90FF;display:flex;align-items:center;justify-content:center;color:white;font-weight:900;font-size:22px;margin:0 auto 16px;">{{ $e['initials'] }}</div>
                <div style="font-size:15px;font-weight:900;color:white;margin-bottom:4px;">{{ $e['name'] }}</div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.14em;color:#1E90FF;margin-bottom:12px;">{{ $e['specialty'] }}</div>
                <p style="font-size:12px;color:#64748B;line-height:1.65;">{{ $e['bio'] }}</p>
            </div>
            @endforeach
        @endif
    </div>
</section>

{{-- ── Timeline ── --}}
<section class="container-x" style="padding:0 0 80px;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start;" class="timeline-grid">
        <div class="reveal">
            <p class="eyebrow" style="color:#1E90FF;margin-bottom:10px;">Our History</p>
            <h2 class="section-h2" style="margin-bottom:40px;">Built over years.</h2>
            <div style="display:flex;flex-direction:column;gap:24px;">
                @foreach([['2019','Founded','Sportshandicapper launched with a focus on MLB and NFL, backed by a proprietary Monte Carlo simulation engine.'],['2020','Model proven','First full season produced +47 units across 4 sports. The model outperformed closing lines on 61% of plays.'],['2022','Multi-sport expansion','Coverage expanded to NHL, CBB, CFB and PGA. Added verified third-party grading to all published picks.'],['2024','Institutional level','10,000+ simulations per game. Over +150 units verified across 3 years. Whale tier and Discord launched.'],] as $t)
                <div class="timeline-item">
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;color:#1E90FF;margin-bottom:4px;">{{ $t[0] }}</div>
                    <div style="font-size:15px;font-weight:900;color:white;margin-bottom:6px;">{{ $t[1] }}</div>
                    <p style="font-size:13px;color:#64748B;line-height:1.65;margin:0;">{{ $t[2] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Guarantee ── --}}
        <div class="reveal" style="transition-delay:0.1s;">
            <p class="eyebrow" style="color:#22D3EE;margin-bottom:10px;">Our Promise</p>
            <h2 class="section-h2" style="margin-bottom:24px;">Profit guarantee.</h2>
            <p style="font-size:15px;color:#64748B;line-height:1.75;margin-bottom:32px;">If you purchase a package and do not show a net profit at the end of your cycle, your package automatically renews — on us — until you are.</p>
            <div style="padding:24px;border-radius:8px;border:1px solid rgba(30,144,255,0.3);background:rgba(30,144,255,0.05);">
                <div style="display:flex;align-items:flex-start;gap:14px;">
                    <div style="width:40px;height:40px;border-radius:6px;background:rgba(30,144,255,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="2" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:900;color:white;margin-bottom:6px;">Zero-risk commitment</div>
                        <p style="font-size:13px;color:#64748B;line-height:1.65;margin:0;">We put our money where our model is. No profit by end of your billing cycle? Renews free until you win.</p>
                    </div>
                </div>
            </div>
            <div style="margin-top:32px;">
                <a href="{{ route('join') }}" class="btn-primary">
                    Start Free Trial
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
@media(max-width:900px){
    .about-stats-grid { grid-template-columns:repeat(2,1fr)!important; }
    .about-stats-grid>div:nth-child(2) { border-right:none!important; }
    .about-stats-grid>div:nth-child(3) { border-top:1px solid rgba(255,255,255,0.06); }
    .pillars-grid { grid-template-columns:1fr!important; }
    .experts-grid { grid-template-columns:repeat(2,1fr)!important; }
    .timeline-grid { grid-template-columns:1fr!important; }
}
@media(max-width:560px){
    .about-stats-grid { grid-template-columns:repeat(2,1fr)!important; }
    .experts-grid { grid-template-columns:repeat(2,1fr)!important; }
}
</style>

@endsection

@push('scripts')
<script>
(function(){
    var els = document.querySelectorAll('.reveal');
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){ e.target.classList.add('is-visible'); obs.unobserve(e.target); }
        });
    },{threshold:0.08});
    els.forEach(function(el){ obs.observe(el); });
})();

(function(){
    var nums = document.querySelectorAll('.counter-num');
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(!e.isIntersecting) return;
            var el = e.target, target = parseFloat(el.dataset.target)||0;
            var prefix = el.dataset.prefix||'', suffix = el.dataset.suffix||'';
            var decimals = target%1!==0?1:0, start=0, dur=1600, t0=null;
            function step(ts){ if(!t0)t0=ts; var p=Math.min((ts-t0)/dur,1), ease=1-Math.pow(1-p,3); el.textContent=prefix+(start+(target-start)*ease).toFixed(decimals)+suffix; if(p<1)requestAnimationFrame(step); }
            requestAnimationFrame(step);
            obs.unobserve(el);
        });
    },{threshold:0.5});
    nums.forEach(function(el){ obs.observe(el); });
})();
</script>
@endpush

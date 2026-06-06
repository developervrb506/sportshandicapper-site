@extends('layouts.public')
@section('title', 'Packages | Sportshandicapper')
@section('meta', 'Pick your edge. Free trial, weekly, monthly, and whale tier season packages with transparent unit tracking.')

@push('styles')
<style>
/* ── Tier card ── */
.tier-card {
    position:relative;
    height:100%;
    border-radius:16px;
    border:1px solid rgba(255,255,255,0.08);
    background:#0C1020;
    padding:24px;
    transition:border-color .2s;
    overflow:hidden;
}
.tier-card:hover { border-color:rgba(30,144,255,0.3); }
.tier-card.accent {
    border-color:rgba(30,144,255,0.5);
    box-shadow:0 0 60px -20px rgba(30,144,255,0.3);
}
.tier-card.accent::before {
    content:'';
    position:absolute;
    inset-inline:0;
    top:0;
    height:1px;
    background:linear-gradient(to right,transparent,#1E90FF,transparent);
}
.tier-card-hover-glow {
    position:absolute;
    top:-96px;right:-96px;
    width:192px;height:192px;
    border-radius:50%;
    background:rgba(30,144,255,0);
    filter:blur(48px);
    transition:background .3s;
    pointer-events:none;
}
.tier-card:hover .tier-card-hover-glow { background:rgba(30,144,255,0.08); }

.tier-rank {
    font-size:12px;font-weight:700;
    font-family:'Exo 2',sans-serif;
}
.tier-name {
    margin-top:8px;font-size:1.5rem;font-weight:900;color:white;
    font-family:'Exo 2',sans-serif;
}
.tier-access {
    margin-top:4px;font-size:10px;text-transform:uppercase;
    letter-spacing:0.2em;color:#475569;font-weight:600;
}
.tier-price {
    margin-top:24px;font-size:2.5rem;font-weight:900;color:white;
    font-family:'Exo 2',sans-serif;line-height:1;
}
.tier-bonus {
    margin-top:6px;font-size:11px;font-weight:600;
    text-transform:uppercase;letter-spacing:0.15em;color:#1E90FF;
}
.tier-stars { margin-top:20px;display:flex;align-items:center;gap:4px; }
.tier-star { width:14px;height:14px; }
.tier-divider { margin-top:20px;height:1px;background:rgba(255,255,255,0.06); }
.tier-features { margin-top:20px;display:flex;flex-direction:column;gap:10px; }
.tier-feature {
    display:flex;align-items:center;gap:10px;
    font-size:14px;color:#94a3b8;
}
.tier-feature-icon {
    width:20px;height:20px;border-radius:6px;
    background:rgba(30,144,255,0.1);border:1px solid rgba(30,144,255,0.25);
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.tier-cta {
    margin-top:28px;width:100%;height:44px;border-radius:8px;
    font-size:14px;font-weight:700;
    display:inline-flex;align-items:center;justify-content:center;gap:8px;
    transition:all .2s;cursor:pointer;border:none;text-decoration:none;
    font-family:'Exo 2',sans-serif;text-transform:uppercase;letter-spacing:0.05em;
}
.tier-cta.accent-btn {
    background:#1E90FF;
    color:white;
}
.tier-cta.accent-btn:hover { background:#1873cc; }
.tier-cta.plain-btn {
    background:transparent;
    border:1px solid rgba(255,255,255,0.12);
    color:#94a3b8;
}
.tier-cta.plain-btn:hover { border-color:rgba(30,144,255,0.4);color:white;background:rgba(30,144,255,0.06); }

.pkg-badge {
    padding:3px 8px;font-size:9px;font-weight:700;
    text-transform:uppercase;letter-spacing:0.12em;border-radius:4px;
    background:rgba(30,144,255,0.15);color:#93c5fd;
    border:1px solid rgba(30,144,255,0.3);white-space:nowrap;
}

/* ── Tier grid ── */
.tier-grid {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:16px;
    margin-top:48px;
}
@media(max-width:900px){ .tier-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:600px){ .tier-grid { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div class="container-x" style="padding-top:64px;padding-bottom:80px;">

    {{-- ── Header ── --}}
    <div style="text-align:center;max-width:680px;margin:0 auto;" class="reveal">
        <p class="eyebrow" style="color:#1E90FF;margin-bottom:16px;">Membership</p>
        <h1 style="font-size:clamp(2.6rem,6vw,4rem);font-weight:900;color:white;line-height:1;font-family:'Exo 2',sans-serif;letter-spacing:-0.02em;margin:0 0 20px;">
            Pick your <span style="color:#1E90FF;">edge.</span>
        </h1>
        <p style="color:#64748B;line-height:1.75;font-size:15px;margin:0;">
            Eight transparent tiers. Verified records, full pick history and unit tracking across every plan.
        </p>
    </div>

    {{-- ── Free Trial Banner ── --}}
    <div class="reveal" style="margin-top:40px;position:relative;overflow:hidden;border-radius:12px;border:1px solid rgba(30,144,255,0.3);background:#0C1020;">
        <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(to right,transparent,#1E90FF,transparent);"></div>
        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:20px;padding:20px 24px;">
            <div style="display:flex;align-items:center;gap:16px;flex:1;min-width:0;">
                <div style="width:48px;height:48px;border-radius:10px;background:rgba(30,144,255,0.1);border:1px solid rgba(30,144,255,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12v10H4V12M22 7H2v5h20V7zM12 22V7M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
                </div>
                <div style="min-width:0;">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.25em;color:#1E90FF;font-weight:700;">Free Trial · No card required</div>
                    <div style="margin-top:4px;font-size:1.05rem;font-weight:700;color:white;">1 Week Access with 1 star picks included</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:20px;flex-shrink:0;">
                <div style="text-align:right;">
                    <div style="font-size:2rem;font-weight:900;color:white;line-height:1;font-family:'Exo 2',sans-serif;">FREE</div>
                    <div style="margin-top:4px;font-size:10px;text-transform:uppercase;letter-spacing:0.2em;color:#475569;font-weight:600;">7 days</div>
                </div>
                <a href="{{ route('register') }}" class="btn-primary" style="white-space:nowrap;">
                    Start Trial
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- ── Tier Grid ── --}}
    @php
    $tiers = [
        ['rank'=>'01','name'=>'Sprint',  'access'=>'1 Week Access',  'price'=>'$24.99',  'stars'=>2,  'bonus'=>'Get 2 star picks',                     'included'=>['1 Week Access','24/7 Support','Expert Analysis','1, 2 star Picks'],                 'badge'=>null],
        ['rank'=>'02','name'=>'Doubles', 'access'=>'2 Week Access',  'price'=>'$49.99',  'stars'=>3,  'bonus'=>'Get 3 star picks plus extra week',     'included'=>['2 Week Access','24/7 Support','Expert Analysis','1, 2, 3 star Picks'],              'badge'=>null],
        ['rank'=>'03','name'=>'Starter', 'access'=>'1 Month Access', 'price'=>'$99.99',  'stars'=>4,  'bonus'=>'Get 4 star picks plus extra 2 weeks',  'included'=>['1 Month Access','24/7 Support','Expert Analysis','1, 2, 3, 4 star Picks'],         'badge'=>'popular'],
        ['rank'=>'04','name'=>'Stretch', 'access'=>'2 Month Access', 'price'=>'$149.99', 'stars'=>5,  'bonus'=>'Get 5 star picks plus extra month',    'included'=>['2 Month Access','24/7 Support','Expert Analysis','1, 2, 3, 4, 5 star Picks'],     'badge'=>null],
        ['rank'=>'05','name'=>'Quarter', 'access'=>'3 Month Access', 'price'=>'$199.99', 'stars'=>5,  'bonus'=>'Get extra month',                      'included'=>['3 Month Access','24/7 Support','Expert Analysis','1, 2, 3, 4, 5 star Picks'],     'badge'=>null],
        ['rank'=>'06','name'=>'Season',  'access'=>'6 Month Access', 'price'=>'$299.99', 'stars'=>10, 'bonus'=>'Get 10 star picks plus extra 3 months','included'=>['6 Month Access','24/7 Support','Expert Analysis','1 to 10 star Picks'],           'badge'=>'best'],
    ];
    @endphp

    <div class="tier-grid">
        @foreach($tiers as $i => $t)
        @php $accent = in_array($t['badge'], ['popular','best']); @endphp
        <div class="tier-card {{ $accent ? 'accent' : '' }} reveal" style="transition-delay:{{ $i*50 }}ms;">
            <div class="tier-card-hover-glow"></div>

            <div style="position:relative;display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:4px;">
                <div>
                    <div class="tier-rank" style="color:{{ $accent ? '#1E90FF' : '#334155' }};">{{ $t['rank'] }}</div>
                    <div class="tier-name">{{ $t['name'] }}</div>
                    <div class="tier-access">{{ $t['access'] }}</div>
                </div>
                @if($t['badge'])
                <span class="pkg-badge">{{ $t['badge'] === 'popular' ? 'Most Popular' : 'Best Value' }}</span>
                @endif
            </div>

            <div style="position:relative;">
                <div class="tier-price">{{ $t['price'] }}</div>
                <div class="tier-bonus">{{ $t['bonus'] }}</div>

                <div class="tier-stars">
                    @for($s = 0; $s < min($t['stars'], 5); $s++)
                    <svg class="tier-star" viewBox="0 0 24 24" fill="{{ $accent ? '#1E90FF' : 'rgba(255,255,255,0.2)' }}" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endfor
                    @if($t['stars'] > 5)
                    <span style="margin-left:4px;font-size:11px;font-weight:700;color:#1E90FF;font-family:'JetBrains Mono',monospace;">{{ $t['stars'] }}★</span>
                    @endif
                </div>

                <div class="tier-divider"></div>

                <ul class="tier-features">
                    @foreach($t['included'] as $feature)
                    <li class="tier-feature">
                        <div class="tier-feature-icon">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="tier-cta {{ $accent ? 'accent-btn' : 'plain-btn' }}">
                    Select {{ $t['name'] }}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Whale ── --}}
    <div class="reveal" style="margin-top:16px;position:relative;overflow:hidden;border-radius:12px;border:1px solid rgba(30,144,255,0.3);background:#0C1020;padding:32px 40px;">
        <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(to right,transparent,#1E90FF,transparent);"></div>
        <div style="position:absolute;top:-80px;right:-40px;width:280px;height:280px;border-radius:50%;background:rgba(30,144,255,0.06);filter:blur(80px);pointer-events:none;"></div>

        <div style="position:relative;display:grid;grid-template-columns:auto 1fr auto;gap:32px;align-items:center;" class="whale-grid">
            <div style="display:flex;align-items:center;gap:16px;">
                <div style="font-size:3rem;font-weight:900;color:rgba(30,144,255,0.2);line-height:1;font-family:'Exo 2',sans-serif;">07</div>
                <div style="width:56px;height:56px;border-radius:12px;background:rgba(30,144,255,0.1);border:1px solid rgba(30,144,255,0.3);display:flex;align-items:center;justify-content:center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7z"/></svg>
                </div>
            </div>

            <div style="min-width:0;">
                <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.25em;color:#1E90FF;font-weight:700;margin-bottom:8px;">Whale Package · Ultimate Access</div>
                <h3 style="font-size:clamp(1.2rem,2.2vw,1.6rem);font-weight:900;color:white;line-height:1.2;font-family:'Exo 2',sans-serif;margin:0 0 16px;">
                    1 Year Access with every star tier unlocked.
                </h3>
                <div style="display:flex;flex-wrap:wrap;gap:8px 20px;">
                    @foreach(['10 star Picks + 6 extra months','24/7 Support','Expert Analysis','Whale Analysis'] as $wf)
                    <span style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#94a3b8;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $wf }}
                    </span>
                    @endforeach
                </div>
            </div>

            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:12px;min-width:160px;">
                <div style="text-align:right;">
                    <div style="font-size:clamp(1.8rem,2.5vw,2.25rem);font-weight:900;color:white;line-height:1;font-family:'Exo 2',sans-serif;">$999.99</div>
                    <div style="margin-top:4px;font-size:10px;text-transform:uppercase;letter-spacing:0.2em;color:#475569;font-weight:600;">1 Year</div>
                </div>
                <a href="{{ route('register') }}" class="btn-primary" style="white-space:nowrap;">
                    Become a Whale
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    <p style="margin-top:40px;text-align:center;font-size:12px;color:#334155;">
        Already have an account?
        <a href="{{ route('login') }}" style="color:#1E90FF;font-weight:600;text-decoration:none;margin-left:4px;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#1E90FF'">Login here</a>
    </p>

</div>

<style>
@media(max-width:900px){
    .whale-grid { grid-template-columns:1fr !important; }
    .whale-grid > div:last-child { align-items:flex-start !important; }
}
</style>

@endsection

@push('scripts')
<script>
(function(){
    var els = document.querySelectorAll('.reveal');
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('is-visible'); obs.unobserve(e.target); } });
    },{threshold:0.06});
    els.forEach(function(el){ obs.observe(el); });
})();
</script>
@endpush

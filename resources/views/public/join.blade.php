@extends('layouts.public')
@section('title', 'Join INSPIN - Membership Packages')

@push('styles')
<style>
    .pkg-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
    @media(max-width:900px){ .pkg-grid { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:560px){ .pkg-grid { grid-template-columns: 1fr; } }
    .feat-row { display:flex; align-items:center; gap:9px; padding:7px 0; font-size:13px; border-bottom:1px solid rgba(255,252,238,.06); }
    .feat-row:last-child { border-bottom:none; }
    .feat-check { width:16px; height:16px; flex-shrink:0; }
    .feat-x { width:16px; height:16px; flex-shrink:0; color:#4a4a4a; }
    /* Mobile fixes */
    @media(max-width:768px){
        .whale-inner,.free-inner { flex-direction:column !important; text-align:center !important; gap:16px !important; }
        .whale-price-block,.free-price-block { width:100% !important; text-align:center !important; }
    }
    @media(max-width:560px){
        .join-banner { padding:24px 20px !important; }
        .join-hero { padding:40px 0 36px !important; }
        .join-hero h1 { font-size:1.6rem !important; }
        .pkg-price-text { font-size:1.7rem !important; }
        .whale-price-num { font-size:2rem !important; }
        .free-price-num { font-size:2.2rem !important; }
    }
</style>
@endpush

@section('content')

{{-- Hero --}}
<section class="join-hero" style="background:#171818;padding:70px 0 60px;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,252,238,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,252,238,.03) 1px,transparent 1px);background-size:68px 68px;"></div>
    <div style="position:absolute;bottom:0;left:0;right:0;height:1.5px;background:linear-gradient(90deg,transparent 5%,#c47f10 30%,#FDB515 50%,#c47f10 70%,transparent 95%);"></div>
    <div class="container" style="position:relative;">
        <h1 class="join-hero-h1" style="font-family:'Clash Display',sans-serif;color:#FFFCEE;font-size:2.2rem;font-weight:500;margin-bottom:12px;letter-spacing:-.2px;">Membership Packages</h1>
        <p style="color:#6e6e6e;max-width:560px;margin:0 auto 10px;font-size:15px;">Start free. Upgrade anytime. Cancel anytime.</p>
        <p style="color:#9a9a9a;max-width:620px;margin:0 auto;font-size:14px;">Our simulation model is up <strong style="color:#FDB515;">+150 units</strong> over 3 years — a $100 bettor netted $15,000+ profit.</p>
    </div>
</section>

<div class="section">
    <div class="container">

        {{-- ═══ FREE TRIAL — Full-width green banner (like Whale) ═══ --}}
        <div onclick="openModal('join')" class="join-banner" style="cursor:pointer;background:#212121;border-radius:16px;padding:36px 40px;position:relative;overflow:hidden;border:1px solid rgba(34,197,94,.25);box-shadow:0 0 40px rgba(34,197,94,.06);margin-bottom:32px;">
            {{-- Green glow top bar --}}
            <div style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,transparent 0%,#22c55e 30%,#4ade80 50%,#22c55e 70%,transparent 100%);"></div>
            <div style="position:absolute;top:0;right:0;width:300px;height:100%;background:radial-gradient(ellipse at 80% 50%,rgba(34,197,94,.08) 0%,transparent 65%);pointer-events:none;"></div>

            <div class="free-inner" style="display:flex;align-items:center;justify-content:space-between;gap:24px;position:relative;z-index:1;flex-wrap:wrap;">
                {{-- Left: icon + details --}}
                <div style="display:flex;align-items:center;gap:20px;">
                    <div style="font-size:3rem;line-height:1;filter:drop-shadow(0 4px 12px rgba(34,197,94,.3));">🎁</div>
                    <div>
                        <div style="color:#22c55e;font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:6px;">Starts Free — No Credit Card Needed</div>
                        <div style="font-family:'Clash Display',sans-serif;color:#FFFCEE;font-size:1.5rem;font-weight:500;margin-bottom:10px;">Free Trial · 1 Week Access</div>
                        <div style="display:flex;gap:20px;flex-wrap:wrap;">
                            @foreach(['24/7 Support','Expert Analysis','1★ Picks Included'] as $f)
                            <span style="color:#6e6e6e;font-size:13px;display:flex;align-items:center;gap:5px;">
                                <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="rgba(34,197,94,.15)"/><polyline points="5,8.5 7,10.5 11,6" stroke="#22c55e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                                {{ $f }}
                            </span>
                            @endforeach
                            <span style="color:#4a4a4a;font-size:13px;display:flex;align-items:center;gap:5px;">
                                <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="rgba(74,74,74,.2)"/><line x1="5" y1="5" x2="11" y2="11" stroke="#4a4a4a" stroke-width="1.5" stroke-linecap="round"/><line x1="11" y1="5" x2="5" y2="11" stroke="#4a4a4a" stroke-width="1.5" stroke-linecap="round"/></svg>
                                2, 3, 4, 5, 10★ Picks
                            </span>
                        </div>
                    </div>
                </div>
                {{-- Right: price + CTA --}}
                <div class="free-price-block" style="text-align:center;flex-shrink:0;">
                    <div style="font-family:'Clash Display',sans-serif;font-size:3rem;font-weight:600;line-height:1;letter-spacing:-1px;color:#22c55e;">FREE</div>
                    <div style="color:#4a4a4a;font-size:12px;margin-bottom:18px;margin-top:4px;">1 Week Access · No card required</div>
                    <div style="background:#22c55e;color:#171818;padding:12px 28px;border-radius:50px;font-weight:700;font-size:14px;display:inline-block;box-shadow:0 0 20px rgba(34,197,94,.35);">Start Free Trial →</div>
                </div>
            </div>
        </div>

        {{-- ═══ 6 PACKAGES — 3×2 grid ═══ --}}
        @php
        $packages6 = [
            [
                'price'   => '$24.99',
                'tagline' => 'Get 2★ Picks',
                'access'  => '1 Week Access',
                'badge'   => null,
                'include' => ['1 Week Access','24/7 Support','Expert Analysis','1, 2★ Picks'],
                'exclude' => ['3, 4, 5, 10★ Picks'],
                'color'   => '#FDB515',
            ],
            [
                'price'   => '$49.99',
                'tagline' => 'Get 3★ Picks + extra week',
                'access'  => '2 Week Access',
                'badge'   => null,
                'include' => ['2 Week Access','24/7 Support','Expert Analysis','1, 2, 3★ Picks'],
                'exclude' => ['4, 5, 10★ Picks'],
                'color'   => '#FDB515',
            ],
            [
                'price'   => '$99.99',
                'tagline' => 'Get 4★ Picks + extra 2 weeks',
                'access'  => '1 Month Access',
                'badge'   => 'Most Popular',
                'badge_color' => '#FDB515',
                'badge_text'  => '#171818',
                'include' => ['1 Month Access','24/7 Support','Expert Analysis','1, 2, 3, 4★ Picks'],
                'exclude' => ['5, 10★ Picks'],
                'color'   => '#FDB515',
            ],
            [
                'price'   => '$149.99',
                'tagline' => 'Get 5★ Picks + extra month',
                'access'  => '2 Month Access',
                'badge'   => null,
                'include' => ['2 Month Access','24/7 Support','Expert Analysis','1, 2, 3, 4, 5★ Picks'],
                'exclude' => ['10★ Picks'],
                'color'   => '#FDB515',
            ],
            [
                'price'   => '$199.99',
                'tagline' => 'Get extra month',
                'access'  => '3 Month Access',
                'badge'   => null,
                'include' => ['3 Month Access','24/7 Support','Expert Analysis','1, 2, 3, 4, 5★ Picks'],
                'exclude' => ['10★ Picks'],
                'color'   => '#FDB515',
            ],
            [
                'price'   => '$299.99',
                'tagline' => 'Get 10★ Picks + extra 3 months',
                'access'  => '6 Month Access',
                'badge'   => 'Best Value',
                'badge_color' => '#2dd4bf',
                'badge_text'  => '#171818',
                'include' => ['6 Month Access','24/7 Support','Expert Analysis','1, 2, 3, 4, 5, 10★ Picks'],
                'exclude' => ['Whale Analysis'],
                'color'   => '#2dd4bf',
            ],
        ];
        @endphp

        <div class="pkg-grid" style="margin-bottom:32px;">
            @foreach($packages6 as $pkg)
            <div style="background:#212121;border:1px solid rgba(255,252,238,.08);border-radius:12px;padding:28px 22px 22px;text-align:center;position:relative;display:flex;flex-direction:column;transition:border-color .2s,box-shadow .2s;"
                 onmouseover="this.style.borderColor='rgba(253,181,21,.35)';this.style.boxShadow='0 8px 32px rgba(0,0,0,.4)'"
                 onmouseout="this.style.borderColor='rgba(255,252,238,.08)';this.style.boxShadow='none'">

                @if(!empty($pkg['badge']))
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:{{ $pkg['badge_color'] }};color:{{ $pkg['badge_text'] }};padding:4px 18px;border-radius:20px;font-size:10px;font-weight:700;letter-spacing:.6px;white-space:nowrap;">{{ $pkg['badge'] }}</div>
                @endif

                <div style="margin-top:{{ !empty($pkg['badge'])?'12px':'0' }};margin-bottom:6px;">
                    <div style="font-family:'Clash Display',sans-serif;font-size:2.2rem;font-weight:600;color:#FFFCEE;line-height:1;letter-spacing:-1px;margin-bottom:4px;">{{ $pkg['price'] }}</div>
                    <div style="font-size:11.5px;color:#6e6e6e;margin-bottom:6px;">{{ $pkg['access'] }}</div>
                    <div style="font-size:12px;color:{{ $pkg['color'] }};font-weight:600;margin-bottom:18px;">{{ $pkg['tagline'] }}</div>
                </div>

                <ul style="list-style:none;padding:0;margin:0 0 20px;flex:1;text-align:left;">
                    @foreach($pkg['include'] as $feat)
                    <li class="feat-row">
                        <svg class="feat-check" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="rgba(74,222,128,.12)"/><polyline points="5,8.5 7,10.5 11,6" stroke="#4ade80" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                        <span style="color:#9a9a9a;">{{ $feat }}</span>
                    </li>
                    @endforeach
                    @foreach($pkg['exclude'] as $feat)
                    <li class="feat-row">
                        <svg class="feat-x" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="rgba(74,74,74,.15)"/><line x1="5.5" y1="5.5" x2="10.5" y2="10.5" stroke="#4a4a4a" stroke-width="1.5" stroke-linecap="round"/><line x1="10.5" y1="5.5" x2="5.5" y2="10.5" stroke="#4a4a4a" stroke-width="1.5" stroke-linecap="round"/></svg>
                        <span style="color:#4a4a4a;text-decoration:line-through;">{{ $feat }}</span>
                    </li>
                    @endforeach
                </ul>

                <button onclick="openModal('join')"
                    style="display:block;width:100%;text-align:center;padding:12px;border-radius:50px;font-weight:600;font-size:14px;cursor:pointer;transition:background .18s;border:1px solid {{ $pkg['color'] }};color:{{ $pkg['color'] }};background:transparent;"
                    onmouseover="this.style.background='rgba(253,181,21,.1)'"
                    onmouseout="this.style.background='transparent'">
                    Get Started
                </button>
            </div>
            @endforeach
        </div>

        {{-- ═══ WHALE PACKAGE — full-width banner ═══ --}}
        <div onclick="openModal('join')" class="join-banner" style="cursor:pointer;background:#212121;border-radius:16px;padding:36px 40px;position:relative;overflow:hidden;border:1px solid rgba(253,181,21,.2);box-shadow:0 0 40px rgba(253,181,21,.06);margin-bottom:24px;">
            <div style="position:absolute;top:0;right:0;width:300px;height:100%;background:radial-gradient(ellipse at 80% 50%,rgba(253,181,21,.08) 0%,transparent 65%);pointer-events:none;"></div>
            <div class="whale-inner" style="display:flex;align-items:center;justify-content:space-between;gap:24px;position:relative;z-index:1;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:20px;">
                    <div style="font-size:3rem;line-height:1;filter:drop-shadow(0 4px 12px rgba(253,181,21,.3));">🐋</div>
                    <div>
                        <div style="color:#FDB515;font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:6px;">Whale Package — Ultimate Access</div>
                        <div style="font-family:'Clash Display',sans-serif;color:#FFFCEE;font-size:1.5rem;font-weight:500;margin-bottom:6px;">1 Year Access · Get 10★ Picks + extra 6 months</div>
                        <div style="display:flex;gap:16px;flex-wrap:wrap;">
                            @foreach(['24/7 Support','Expert Analysis','1–7★ Picks Included'] as $f)
                            <span style="color:#6e6e6e;font-size:13px;display:flex;align-items:center;gap:5px;">
                                <span style="color:#FDB515;font-size:10px;">★</span>{{ $f }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="whale-price-block" style="text-align:center;flex-shrink:0;">
                    <div style="background:linear-gradient(135deg,#fdd060 0%,#FDB515 50%,#e09c0d 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-family:'Clash Display',sans-serif;font-size:2.8rem;font-weight:600;line-height:1;letter-spacing:-1px;">$999.99</div>
                    <div style="color:#4a4a4a;font-size:12px;margin-bottom:18px;margin-top:4px;">1 Year Access</div>
                    <div style="background:#FDB515;color:#171818;padding:12px 28px;border-radius:50px;font-weight:700;font-size:14px;display:inline-block;box-shadow:0 0 20px rgba(253,181,21,.35);">Become a Whale →</div>
                </div>
            </div>
        </div>

        <p style="text-align:center;color:#6e6e6e;margin-top:20px;font-size:14px;">
            Already have an account? <button onclick="openModal()" style="background:none;border:none;color:#FDB515;font-weight:600;cursor:pointer;font-size:14px;">Login here</button>
        </p>
    </div>
</div>
@endsection

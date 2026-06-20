@extends('layouts.subscriber')
@section('title', 'Upgrade Package | Sportshandicapper')
@section('page-title', 'Membership Packages')

@push('styles')
<style>
.pkg-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:1000px){ .pkg-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:560px) { .pkg-grid { grid-template-columns:1fr; } }
.feat-li { display:flex; align-items:center; gap:8px; padding:6px 0; font-size:12.5px; border-bottom:1px solid rgba(255,252,238,.05); }
.feat-li:last-child { border-bottom:none; }
</style>
@endpush

@section('content')

{{-- Expired / no subscription notice --}}
@if(session('expired'))
<div style="background:rgba(239,68,68,.07);border:1px solid rgba(239,68,68,.25);border-radius:12px;padding:18px 22px;margin-bottom:20px;display:flex;align-items:flex-start;gap:14px;">
    <div style="font-size:1.6rem;flex-shrink:0;">🔒</div>
    <div>
        <div style="font-size:15px;font-weight:700;color:#fff;margin-bottom:4px;">Your Access Has Expired</div>
        <div style="font-size:13px;color:rgba(255,255,255,.5);line-height:1.6;">
            Your free trial or subscription has ended. Choose a package below to continue viewing expert picks, consensus data, and analysis.
        </div>
    </div>
</div>
@endif

{{-- Current plan notice --}}
@if($currentSub)
<div style="background:rgba(253,181,21,.06);border:1px solid rgba(253,181,21,.15);border-radius:10px;padding:14px 18px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
    <svg width="18" height="18" fill="none" stroke="#FDB515" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div>
        <span style="font-size:13px;font-weight:600;color:#FFFCEE;">Current plan: </span>
        <span style="font-size:13px;color:#FDB515;font-weight:700;">{{ $currentSub->packageName() }}</span>
        <span style="font-size:13px;color:#9a9a9a;"> · {{ $currentSub->max_stars }}★ access</span>
        @if(!$currentSub->isExpired())
        <span style="font-size:13px;color:#6e6e6e;"> · Expires {{ $currentSub->expires_at->format('M d, Y') }}</span>
        @endif
    </div>
</div>
@endif

<p style="font-size:13px;color:#6e6e6e;margin-bottom:22px;">Choose a package to upgrade your access. Contact support after purchasing to activate your new tier.</p>

{{-- Package grid --}}
@php
$featuredSlugs = ['free-trial','1-week','2-weeks','monthly','quarterly','semi-annual'];
$packageDetails = [
    'free-trial'  => ['stars'=>1, 'excludes'=>'2, 3, 4, 5, 10★ Picks'],
    '1-week'      => ['stars'=>2, 'excludes'=>'3, 4, 5, 10★ Picks'],
    '2-weeks'     => ['stars'=>3, 'excludes'=>'4, 5, 10★ Picks'],
    'monthly'     => ['stars'=>4, 'excludes'=>'5, 10★ Picks'],
    'quarterly'   => ['stars'=>5, 'excludes'=>'10★ Picks'],
    'semi-annual' => ['stars'=>5, 'excludes'=>'10★ Picks'],
];
@endphp

<div class="pkg-grid">
    @foreach($featuredPackages as $pkg)
    @php
        $isFree    = $pkg->slug === 'free-trial';
        $isMonthly = $pkg->slug === 'monthly';
        $isBest    = $pkg->slug === 'semi-annual';
        $hasBadge  = $isFree || $isMonthly || $isBest;
        $isCurrent = $currentSub && $currentSub->package && $currentSub->package->slug === $pkg->slug;
        $details   = $packageDetails[$pkg->slug] ?? ['stars'=>1,'excludes'=>''];
    @endphp
    <div style="background:#141414;border:1px solid {{ $isCurrent ? 'rgba(253,181,21,.4)' : 'rgba(255,252,238,.07)' }};border-radius:12px;padding:22px 18px;position:relative;display:flex;flex-direction:column;transition:border-color .2s,box-shadow .2s;"
         onmouseover="this.style.borderColor='rgba(253,181,21,.3)';this.style.boxShadow='0 4px 20px rgba(0,0,0,.4)'"
         onmouseout="this.style.borderColor='{{ $isCurrent ? 'rgba(253,181,21,.4)' : 'rgba(255,252,238,.07)' }}';this.style.boxShadow='none'">

        {{-- Badge --}}
        @if($isCurrent)
        <div style="position:absolute;top:-11px;left:50%;transform:translateX(-50%);background:#FDB515;color:#171818;padding:3px 14px;border-radius:20px;font-size:9px;font-weight:800;letter-spacing:.5px;white-space:nowrap;">CURRENT PLAN</div>
        @elseif($isFree)
        <div style="position:absolute;top:-11px;left:50%;transform:translateX(-50%);background:#22c55e;color:#fff;padding:3px 14px;border-radius:20px;font-size:9px;font-weight:800;letter-spacing:.5px;white-space:nowrap;">STARTS FREE</div>
        @elseif($isMonthly)
        <div style="position:absolute;top:-11px;left:50%;transform:translateX(-50%);background:#FDB515;color:#171818;padding:3px 14px;border-radius:20px;font-size:9px;font-weight:800;letter-spacing:.5px;white-space:nowrap;">MOST POPULAR</div>
        @elseif($isBest)
        <div style="position:absolute;top:-11px;left:50%;transform:translateX(-50%);background:#2dd4bf;color:#171818;padding:3px 14px;border-radius:20px;font-size:9px;font-weight:800;letter-spacing:.5px;white-space:nowrap;">BEST VALUE</div>
        @endif

        <div style="margin-top:{{ $hasBadge || $isCurrent ? '10px' : '0' }};margin-bottom:16px;">
            <div style="font-size:10px;color:#6e6e6e;margin-bottom:3px;letter-spacing:.3px;">{{ $pkg->duration }} Access</div>
            <div style="font-family:'Clash Display',sans-serif;font-size:.95rem;font-weight:500;color:#FFFCEE;margin-bottom:14px;">{{ $pkg->name }}</div>

            @if($isFree)
            <div style="font-family:'Clash Display',sans-serif;font-size:2rem;font-weight:600;color:#FFFCEE;line-height:1;">FREE</div>
            <div style="font-size:11px;color:#4ade80;margin-top:4px;">No credit card needed</div>
            @else
            <div style="font-family:'Clash Display',sans-serif;font-size:2rem;font-weight:600;color:#FFFCEE;line-height:1;">
                <sup style="font-size:.9rem;color:#6e6e6e;vertical-align:top;margin-top:6px;">$</sup>{{ number_format($pkg->price,2) }}
            </div>
            @endif
        </div>

        {{-- Stars included --}}
        <div style="background:rgba(253,181,21,.05);border:1px solid rgba(253,181,21,.12);border-radius:8px;padding:8px 12px;margin-bottom:14px;text-align:center;">
            <div style="font-size:9px;color:#6e6e6e;text-transform:uppercase;letter-spacing:.4px;margin-bottom:3px;">Picks Access</div>
            <div style="font-size:13px;color:#FDB515;font-weight:700;">1★ – {{ $details['stars'] === 10 ? '10★' : $details['stars'].'★' }} Picks</div>
        </div>

        {{-- Features --}}
        <ul style="list-style:none;padding:0;margin:0 0 18px;flex:1;">
            @foreach(array_slice($pkg->features ?? [], 0, 4) as $feat)
            <li class="feat-li">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" style="flex-shrink:0;"><circle cx="8" cy="8" r="8" fill="rgba(74,222,128,.1)"/><polyline points="5,8.5 7,10.5 11,6" stroke="#4ade80" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                <span style="color:#9a9a9a;">{{ $feat }}</span>
            </li>
            @endforeach
            @if($details['excludes'])
            <li class="feat-li" style="opacity:.5;">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" style="flex-shrink:0;"><circle cx="8" cy="8" r="8" fill="rgba(100,100,100,.15)"/><line x1="5.5" y1="5.5" x2="10.5" y2="10.5" stroke="#6e6e6e" stroke-width="1.5" stroke-linecap="round"/><line x1="10.5" y1="5.5" x2="5.5" y2="10.5" stroke="#6e6e6e" stroke-width="1.5" stroke-linecap="round"/></svg>
                <span style="color:#4a4a4a;text-decoration:line-through;font-size:11.5px;">{{ $details['excludes'] }}</span>
            </li>
            @endif
        </ul>

        @if($isCurrent)
        <div style="display:block;text-align:center;padding:10px;border-radius:8px;font-size:13px;font-weight:600;background:rgba(253,181,21,.08);border:1px solid rgba(253,181,21,.2);color:#FDB515;cursor:default;">
            ✓ Active Plan
        </div>
        @else
        <button onclick="showUpgradeModal('{{ $pkg->name }}', '{{ $isFree ? 'free' : 'paid' }}')"
           style="display:block;width:100%;text-align:center;padding:10px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;border:1px solid {{ $isFree?'#22c55e':'#FDB515' }};color:{{ $isFree?'#22c55e':'#FDB515' }};background:transparent;transition:background .18s;"
           onmouseover="this.style.background='{{ $isFree?'rgba(34,197,94,.1)':'rgba(253,181,21,.1)' }}'"
           onmouseout="this.style.background='transparent'">
            {{ $isFree ? 'Start Free Trial' : 'Get Started' }} →
        </button>
        @endif
    </div>
    @endforeach
</div>

{{-- Whale Package --}}
@if($whaleRegular || $whalePackages->count() > 0)
@php $whale = $whaleRegular ?? $whalePackages->first(); @endphp
<div style="background:#141414;border:1px solid rgba(253,181,21,.2);border-radius:14px;padding:28px 32px;position:relative;overflow:hidden;box-shadow:0 0 30px rgba(253,181,21,.04);">
    <div style="position:absolute;top:0;right:0;width:250px;height:100%;background:radial-gradient(ellipse at 80% 50%,rgba(253,181,21,.06) 0%,transparent 65%);pointer-events:none;"></div>
    <div style="display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;position:relative;">
        <div style="display:flex;align-items:center;gap:16px;">
            <div style="font-size:2.5rem;filter:drop-shadow(0 2px 8px rgba(253,181,21,.3));">🐋</div>
            <div>
                <div style="font-size:9px;color:#FDB515;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Ultimate Access</div>
                <div style="font-family:'Clash Display',sans-serif;font-size:1.3rem;font-weight:500;color:#FFFCEE;margin-bottom:6px;">{{ $whale->name ?? $whale->title ?? 'Whale Package' }}</div>
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    @foreach(['All star picks (1★–10★)','1 Year Access','24/7 Support'] as $f)
                    <span style="font-size:12px;color:#6e6e6e;display:flex;align-items:center;gap:4px;"><span style="color:#FDB515;font-size:9px;">★</span>{{ $f }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div style="text-align:center;flex-shrink:0;">
            <div style="font-family:'Clash Display',sans-serif;font-size:2rem;font-weight:600;background:linear-gradient(135deg,#fdd060,#FDB515,#e09c0d);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;">${{ number_format($whale->price,2) }}</div>
            <div style="font-size:11px;color:#4a4a4a;margin:4px 0 14px;">1 Year Access</div>
            <button onclick="showUpgradeModal('Whale Package', 'paid')" style="display:inline-block;padding:10px 24px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;font-size:13px;cursor:pointer;border:none;box-shadow:0 0 16px rgba(253,181,21,.3);">Become a Whale →</button>
        </div>
    </div>
</div>
@endif

<p style="text-align:center;color:#6e6e6e;font-size:12px;margin-top:16px;">
    Ready to upgrade? Click any package and follow the instructions.
</p>

{{-- Upgrade Modal --}}
<div id="upgradeModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.8);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(8px);">
    <div style="background:#1a1a1a;border:1px solid rgba(253,181,21,.2);border-radius:16px;padding:32px;max-width:400px;width:92%;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.7);">
        <div style="font-size:2.5rem;margin-bottom:14px;">⭐</div>
        <h3 style="font-family:'Clash Display',sans-serif;font-size:1.2rem;font-weight:500;color:#FFFCEE;margin-bottom:6px;" id="upgradeModalTitle">Upgrade to Package</h3>
        <p style="font-size:13px;color:#6e6e6e;margin-bottom:20px;line-height:1.65;">
            To purchase or upgrade your package, please contact our support team. We'll activate your new tier immediately after payment is confirmed.
        </p>

        <div style="background:rgba(253,181,21,.06);border:1px solid rgba(253,181,21,.15);border-radius:10px;padding:16px;margin-bottom:20px;text-align:left;">
            <div style="font-size:10px;color:#FDB515;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-bottom:10px;">How to upgrade</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#9a9a9a;">
                    <span style="width:22px;height:22px;border-radius:50%;background:#FDB515;color:#171818;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;flex-shrink:0;">1</span>
                    Submit a support ticket with your desired package
                </div>
                <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#9a9a9a;">
                    <span style="width:22px;height:22px;border-radius:50%;background:#FDB515;color:#171818;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;flex-shrink:0;">2</span>
                    Complete payment via our secure checkout
                </div>
                <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#9a9a9a;">
                    <span style="width:22px;height:22px;border-radius:50%;background:#FDB515;color:#171818;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;flex-shrink:0;">3</span>
                    Your access is upgraded immediately
                </div>
            </div>
        </div>

        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="document.getElementById('upgradeModal').style.display='none'"
                style="padding:10px 22px;background:#212121;border:1px solid rgba(255,252,238,.1);color:#9a9a9a;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:all .15s;"
                onmouseover="this.style.borderColor='rgba(255,252,238,.25)';this.style.color='#FFFCEE'"
                onmouseout="this.style.borderColor='rgba(255,252,238,.1)';this.style.color='#9a9a9a'">
                Cancel
            </button>
            <a href="/profile" onclick="document.getElementById('upgradeModal').style.display='none'"
                style="padding:10px 22px;background:#FDB515;color:#171818;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Contact Support
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showUpgradeModal(pkgName, type) {
    document.getElementById('upgradeModalTitle').textContent = 'Upgrade to ' + pkgName;
    var m = document.getElementById('upgradeModal');
    m.style.display = 'flex';
}
document.getElementById('upgradeModal').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@endpush
@endsection

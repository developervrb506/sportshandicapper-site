@extends('layouts.subscriber')
@section('title', 'Upgrade Package | Sportshandicapper')
@section('page-title', 'Membership Packages')

@push('styles')
<style>
.pkg-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:1000px){ .pkg-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:560px) { .pkg-grid { grid-template-columns:1fr; } }

.tier-card {
    position:relative; height:100%; border-radius:14px;
    border:1px solid var(--bdr); background:var(--inner);
    padding:22px; transition:border-color .2s; overflow:hidden;
    display:flex; flex-direction:column;
}
.tier-card:hover { border-color:rgba(30,144,255,0.3); }
.tier-card.accent { border-color:rgba(30,144,255,0.5); box-shadow:0 0 50px -20px rgba(30,144,255,0.3); }
.tier-card.current { border-color:rgba(34,197,94,0.5); }
.tier-card.accent::before, .tier-card.current::before {
    content:''; position:absolute; inset-inline:0; top:0; height:1px;
    background:linear-gradient(to right,transparent,var(--accent),transparent);
}
.tier-card.current::before { background:linear-gradient(to right,transparent,#22C55E,transparent); }

.tier-badge {
    padding:3px 10px; font-size:9px; font-weight:800; text-transform:uppercase;
    letter-spacing:0.5px; border-radius:20px; white-space:nowrap;
}
.tier-rank { font-size:10px; font-weight:700; color:#334155; letter-spacing:.5px; }
.tier-card.accent .tier-rank { color:var(--accent); }
.tier-access { margin-top:3px; font-size:10px; text-transform:uppercase; letter-spacing:.3px; color:#475569; font-weight:600; }
.tier-name { margin-top:6px; font-size:1.05rem; font-weight:700; color:#fff; }
.tier-price { margin-top:18px; font-size:2rem; font-weight:800; color:#fff; line-height:1; }
.tier-price sup { font-size:.85rem; color:#475569; vertical-align:top; margin-top:5px; }
.tier-stars-box {
    background:rgba(30,144,255,0.06); border:1px solid rgba(30,144,255,0.15);
    border-radius:8px; padding:8px 12px; margin:14px 0; text-align:center;
}
.tier-stars-label { font-size:9px; color:#475569; text-transform:uppercase; letter-spacing:.4px; margin-bottom:3px; }
.tier-stars-val { font-size:13px; color:var(--accent); font-weight:700; }
.tier-divider { margin:16px 0; height:1px; background:var(--bdr); }
.tier-feature-li { display:flex; align-items:center; gap:8px; padding:6px 0; font-size:12.5px; color:#94A3B8; border-bottom:1px solid rgba(255,255,255,0.04); }
.tier-feature-li:last-child { border-bottom:none; }
.tier-feature-icon {
    width:18px; height:18px; border-radius:5px; background:rgba(30,144,255,0.1);
    border:1px solid rgba(30,144,255,0.25); display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.tier-cta {
    margin-top:auto; display:block; width:100%; text-align:center; padding:11px;
    border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; border:none;
    text-decoration:none; transition:background .18s;
}
.tier-cta.accent-btn { background:var(--accent); color:#fff; }
.tier-cta.accent-btn:hover { background:#1873cc; }
.tier-cta.plain-btn { background:transparent; border:1px solid rgba(255,255,255,0.12); color:#94A3B8; }
.tier-cta.plain-btn:hover { border-color:rgba(30,144,255,0.4); color:#fff; background:rgba(30,144,255,0.06); }
.tier-cta.current-cta { background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.25); color:#22C55E; cursor:default; }
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
<div style="background:rgba(30,144,255,.06);border:1px solid rgba(30,144,255,.18);border-radius:10px;padding:14px 18px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
    <svg width="18" height="18" fill="none" stroke="var(--accent)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div>
        <span style="font-size:13px;font-weight:600;color:#fff;">Current plan: </span>
        <span style="font-size:13px;color:var(--accent);font-weight:700;">{{ $currentSub->packageName() }}</span>
        <span style="font-size:13px;color:#475569;"> · {{ $currentSub->max_stars }}★ access</span>
        @if(!$currentSub->isExpired())
        <span style="font-size:13px;color:#334155;"> · Expires {{ $currentSub->expires_at->format('M d, Y') }}</span>
        @endif
    </div>
</div>
@endif

<p style="font-size:13px;color:#475569;margin-bottom:22px;">Choose a package to upgrade your access. Contact support after purchasing to activate your new tier.</p>

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
    @foreach($featuredPackages as $i => $pkg)
    @php
        $isFree    = $pkg->slug === 'free-trial';
        $isMonthly = $pkg->slug === 'monthly';
        $isBest    = $pkg->slug === 'semi-annual';
        $isCurrent = $currentSub && $currentSub->package && $currentSub->package->slug === $pkg->slug;
        $accent    = ($isMonthly || $isBest) && !$isCurrent;
        $details   = $packageDetails[$pkg->slug] ?? ['stars'=>1,'excludes'=>''];
    @endphp
    <div class="tier-card {{ $isCurrent ? 'current' : ($accent ? 'accent' : '') }}">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;">
            <div>
                <div class="tier-rank">{{ sprintf('%02d', $i + 1) }}</div>
                <div class="tier-name">{{ $pkg->name }}</div>
                <div class="tier-access">{{ $pkg->duration }} Access</div>
            </div>
            @if($isCurrent)
            <span class="tier-badge" style="background:rgba(34,197,94,.15);color:#22C55E;">Current</span>
            @elseif($isFree)
            <span class="tier-badge" style="background:rgba(34,197,94,.15);color:#22C55E;">Free</span>
            @elseif($isMonthly)
            <span class="tier-badge" style="background:rgba(30,144,255,.15);color:var(--accent);">Popular</span>
            @elseif($isBest)
            <span class="tier-badge" style="background:rgba(34,211,238,.15);color:#22D3EE;">Best Value</span>
            @endif
        </div>

        @if($isFree)
        <div class="tier-price">FREE</div>
        <div style="font-size:11px;color:#22C55E;margin-top:4px;">No credit card needed</div>
        @else
        <div class="tier-price"><sup>$</sup>{{ number_format($pkg->price,2) }}</div>
        @endif

        <div class="tier-stars-box">
            <div class="tier-stars-label">Picks Access</div>
            <div class="tier-stars-val">1★ – {{ $details['stars'] }}★ Picks</div>
        </div>

        <div class="tier-divider"></div>

        <ul style="list-style:none;padding:0;margin:0 0 18px;">
            @foreach(array_slice($pkg->features ?? [], 0, 4) as $feat)
            <li class="tier-feature-li">
                <div class="tier-feature-icon">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                {{ $feat }}
            </li>
            @endforeach
            @if($details['excludes'])
            <li class="tier-feature-li" style="opacity:.45;">
                <div class="tier-feature-icon" style="background:rgba(100,100,100,.1);border-color:rgba(100,100,100,.2);">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </div>
                <span style="text-decoration:line-through;">{{ $details['excludes'] }}</span>
            </li>
            @endif
        </ul>

        @if($isCurrent)
        <div class="tier-cta current-cta">✓ Active Plan</div>
        @else
        <button onclick="showUpgradeModal('{{ $pkg->name }}')" class="tier-cta {{ $accent ? 'accent-btn' : 'plain-btn' }}">
            {{ $isFree ? 'Start Free Trial' : 'Get Started' }} →
        </button>
        @endif
    </div>
    @endforeach
</div>

{{-- Whale Package --}}
@if($whaleRegular || $whalePackages->count() > 0)
@php $whale = $whaleRegular ?? $whalePackages->first(); @endphp
<div style="background:var(--inner);border:1px solid rgba(30,144,255,.25);border-radius:14px;padding:28px 32px;position:relative;overflow:hidden;">
    <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(to right,transparent,var(--accent),transparent);"></div>
    <div style="position:absolute;top:-80px;right:-40px;width:240px;height:240px;border-radius:50%;background:rgba(30,144,255,.06);filter:blur(70px);pointer-events:none;"></div>
    <div style="display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;position:relative;">
        <div style="display:flex;align-items:center;gap:16px;">
            <div style="width:56px;height:56px;border-radius:12px;background:rgba(30,144,255,.1);border:1px solid rgba(30,144,255,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7z"/></svg>
            </div>
            <div>
                <div style="font-size:9px;color:var(--accent);font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Ultimate Access</div>
                <div style="font-size:1.2rem;font-weight:700;color:#fff;margin-bottom:6px;">{{ $whale->name ?? $whale->title ?? 'Whale Package' }}</div>
                <div style="display:flex;gap:14px;flex-wrap:wrap;">
                    @foreach(['All star picks (1★–10★)','1 Year Access','24/7 Support'] as $f)
                    <span style="font-size:12px;color:#94A3B8;display:flex;align-items:center;gap:5px;">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $f }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
        <div style="text-align:center;flex-shrink:0;">
            <div style="font-size:2rem;font-weight:800;color:#fff;line-height:1;">${{ number_format($whale->price,2) }}</div>
            <div style="font-size:11px;color:#475569;margin:4px 0 14px;">1 Year Access</div>
            <button onclick="showUpgradeModal('Whale Package')" style="display:inline-block;padding:10px 24px;background:var(--accent);color:#fff;border-radius:50px;font-weight:700;font-size:13px;cursor:pointer;border:none;">Become a Whale →</button>
        </div>
    </div>
</div>
@endif

<p style="text-align:center;color:#475569;font-size:12px;margin-top:16px;">
    Ready to upgrade? Click any package and follow the instructions.
</p>

{{-- Upgrade Modal --}}
<div id="upgradeModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.8);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(8px);">
    <div style="background:var(--card);border:1px solid rgba(30,144,255,.2);border-radius:16px;padding:32px;max-width:400px;width:92%;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.7);">
        <div style="width:56px;height:56px;border-radius:50%;background:rgba(30,144,255,.1);border:1px solid rgba(30,144,255,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <h3 style="font-size:1.2rem;font-weight:700;color:#fff;margin-bottom:6px;" id="upgradeModalTitle">Upgrade to Package</h3>
        <p style="font-size:13px;color:#475569;margin-bottom:20px;line-height:1.65;">
            To purchase or upgrade your package, please contact our support team. We'll activate your new tier immediately after payment is confirmed.
        </p>

        <div style="background:rgba(30,144,255,.06);border:1px solid rgba(30,144,255,.15);border-radius:10px;padding:16px;margin-bottom:20px;text-align:left;">
            <div style="font-size:10px;color:var(--accent);font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-bottom:10px;">How to upgrade</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @foreach(['Submit a support ticket with your desired package','Complete payment via our secure checkout','Your access is upgraded immediately'] as $i => $step)
                <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#94A3B8;">
                    <span style="width:22px;height:22px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;flex-shrink:0;">{{ $i + 1 }}</span>
                    {{ $step }}
                </div>
                @endforeach
            </div>
        </div>

        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="document.getElementById('upgradeModal').style.display='none'"
                style="padding:10px 22px;background:var(--inner);border:1px solid var(--bdr);color:#94A3B8;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:all .15s;"
                onmouseover="this.style.borderColor='rgba(255,255,255,.25)';this.style.color='#fff'"
                onmouseout="this.style.borderColor='var(--bdr)';this.style.color='#94A3B8'">
                Cancel
            </button>
            <a href="/profile" onclick="document.getElementById('upgradeModal').style.display='none'"
                style="padding:10px 22px;background:var(--accent);color:#fff;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Contact Support
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showUpgradeModal(pkgName) {
    document.getElementById('upgradeModalTitle').textContent = 'Upgrade to ' + pkgName;
    document.getElementById('upgradeModal').style.display = 'flex';
}
document.getElementById('upgradeModal').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@endpush
@endsection

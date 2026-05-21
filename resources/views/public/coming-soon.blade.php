@extends('layouts.public')
@section('title', ($pageTitle ?? 'Coming Soon') . ' - INSPIN')

@section('content')
<div style="background:#171818;min-height:72vh;display:flex;align-items:center;justify-content:center;padding:60px 20px;">
    <div style="text-align:center;max-width:540px;">

        {{-- Icon --}}
        <div style="width:80px;height:80px;border-radius:50%;background:rgba(253,181,21,.08);border:2px solid rgba(253,181,21,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:2.4rem;">
            {{ $pageIcon ?? '🚀' }}
        </div>

        {{-- Coming Soon badge --}}
        <div style="display:inline-block;background:rgba(253,181,21,.1);border:1px solid rgba(253,181,21,.25);color:#FDB515;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;padding:5px 18px;border-radius:20px;margin-bottom:22px;">
            Coming Soon
        </div>

        {{-- Title --}}
        <h1 style="font-family:'Clash Display',sans-serif;font-size:2.2rem;font-weight:500;color:#FFFCEE;margin-bottom:14px;line-height:1.25;">
            {{ $pageTitle ?? 'This Feature' }}
        </h1>

        {{-- Description --}}
        <p style="font-size:15px;color:#6e6e6e;line-height:1.75;margin-bottom:36px;">
            {{ $pageDesc ?? "We're putting the finishing touches on this feature. Check back soon — it'll be worth the wait." }}
        </p>

        {{-- Divider --}}
        <div style="height:1px;background:linear-gradient(90deg,transparent,rgba(253,181,21,.15),transparent);margin-bottom:36px;"></div>

        {{-- Links to active pages --}}
        <p style="font-size:12px;color:#4a4a4a;text-transform:uppercase;letter-spacing:.5px;font-weight:700;margin-bottom:14px;">Available Now</p>
        <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('picks') }}"
               style="padding:10px 22px;background:rgba(253,181,21,.08);border:1px solid rgba(253,181,21,.2);color:#FDB515;border-radius:50px;font-size:13px;font-weight:600;text-decoration:none;transition:background .18s;"
               onmouseover="this.style.background='rgba(253,181,21,.16)'" onmouseout="this.style.background='rgba(253,181,21,.08)'">
               Expert Picks
            </a>
            <a href="{{ route('articles') }}"
               style="padding:10px 22px;background:rgba(255,252,238,.04);border:1px solid rgba(255,252,238,.08);color:#9a9a9a;border-radius:50px;font-size:13px;font-weight:600;text-decoration:none;transition:background .18s;"
               onmouseover="this.style.background='rgba(255,252,238,.08)'" onmouseout="this.style.background='rgba(255,252,238,.04)'">
               Articles
            </a>
            <a href="{{ route('join') }}"
               style="padding:10px 22px;background:rgba(255,252,238,.04);border:1px solid rgba(255,252,238,.08);color:#9a9a9a;border-radius:50px;font-size:13px;font-weight:600;text-decoration:none;transition:background .18s;"
               onmouseover="this.style.background='rgba(255,252,238,.08)'" onmouseout="this.style.background='rgba(255,252,238,.04)'">
               Packages
            </a>
        </div>

    </div>
</div>
@endsection

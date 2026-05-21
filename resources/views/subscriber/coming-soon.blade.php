@extends('layouts.subscriber')
@section('title', ($pageTitle ?? 'Coming Soon') . ' - INSPIN')
@section('page-title', $pageTitle ?? 'Coming Soon')

@section('content')
<div style="display:flex;align-items:center;justify-content:center;min-height:60vh;">
    <div style="text-align:center;max-width:460px;">

        {{-- Icon --}}
        <div style="width:80px;height:80px;background:rgba(253,181,21,.08);border:1px solid rgba(253,181,21,.2);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:2.2rem;margin:0 auto 24px;">
            {{ $pageIcon ?? '🚀' }}
        </div>

        {{-- Badge --}}
        <div style="display:inline-block;background:rgba(253,181,21,.1);border:1px solid rgba(253,181,21,.25);color:#FDB515;font-size:10px;font-weight:700;padding:4px 14px;border-radius:20px;letter-spacing:.5px;margin-bottom:16px;">
            COMING SOON
        </div>

        {{-- Title --}}
        <h1 style="font-size:1.6rem;font-weight:800;color:#fff;margin-bottom:10px;">
            {{ $pageTitle ?? 'Coming Soon' }}
        </h1>

        {{-- Description --}}
        <p style="font-size:14px;color:rgba(255,255,255,.45);line-height:1.75;margin-bottom:28px;">
            {{ $pageDesc ?? "We're working hard to bring this feature to you. Check back soon!" }}
        </p>

        {{-- Divider --}}
        <div style="height:1px;background:rgba(255,255,255,.06);margin-bottom:24px;"></div>

        {{-- What's available now --}}
        <p style="font-size:12px;font-weight:600;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:14px;">Available Now</p>
        <div style="display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-bottom:28px;">
            <a href="/subscriber/picks" style="text-decoration:none;padding:8px 16px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:8px;font-size:12px;font-weight:600;color:rgba(255,255,255,.6);transition:all .15s;" onmouseover="this.style.borderColor='rgba(253,181,21,.3)';this.style.color='#FDB515'" onmouseout="this.style.borderColor='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.6)'">✓ My Picks</a>
            <a href="/subscriber/articles" style="text-decoration:none;padding:8px 16px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:8px;font-size:12px;font-weight:600;color:rgba(255,255,255,.6);transition:all .15s;" onmouseover="this.style.borderColor='rgba(253,181,21,.3)';this.style.color='#FDB515'" onmouseout="this.style.borderColor='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.6)'">✓ Articles</a>
            <a href="/subscriber/dashboard" style="text-decoration:none;padding:8px 16px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:8px;font-size:12px;font-weight:600;color:rgba(255,255,255,.6);transition:all .15s;" onmouseover="this.style.borderColor='rgba(253,181,21,.3)';this.style.color='#FDB515'" onmouseout="this.style.borderColor='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.6)'">✓ Dashboard</a>
        </div>

        <a href="/subscriber/dashboard" style="display:inline-block;padding:11px 28px;background:var(--gold);color:#000;border-radius:50px;font-size:13px;font-weight:700;text-decoration:none;">
            ← Back to Dashboard
        </a>
    </div>
</div>
@endsection

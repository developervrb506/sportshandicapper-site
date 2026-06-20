@extends('layouts.subscriber')
@section('title','Live Odds | Sportshandicapper')
@section('page-title','Live Odds')

@section('content')
@php
$sportColors=['NFL'=>['rgba(59,130,246,.1)','rgba(59,130,246,.2)','#3B82F6'],'NBA'=>['rgba(239,68,68,.1)','rgba(239,68,68,.2)','#EF4444'],'MLB'=>['rgba(34,197,94,.1)','rgba(34,197,94,.2)','#22C55E'],'NHL'=>['rgba(168,85,247,.1)','rgba(168,85,247,.2)','#A855F7']];
@endphp

<div style="display:flex;flex-direction:column;gap:10px;">
    @forelse($consensus as $game)
    @php
        $sc=$sportColors[$game->league]??['rgba(253,181,21,.1)','rgba(253,181,21,.2)','#FDB515'];
        $mlA=$game->moneyline_away??'—'; $mlH=$game->moneyline_home??'—';
        $mlAC=(is_numeric(str_replace(['+'],'',$mlA))&&(int)str_replace('+','',$mlA)>0)?'#FDB515':'#fff';
        $mlHC=(is_numeric(str_replace(['+'],'',$mlH))&&(int)str_replace('+','',$mlH)>0)?'#FDB515':'#fff';
    @endphp
    <div class="s-card" style="overflow:hidden;">
        <div style="padding:12px 18px;border-bottom:1px solid rgba(255,255,255,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:{{ $sc[0] }};border:1px solid {{ $sc[1] }};color:{{ $sc[2] }};padding:2px 10px;border-radius:6px;font-size:10px;font-weight:700;">{{ $game->league }}</span>
                <span style="font-size:13px;font-weight:600;color:#fff;">{{ $game->away_team }} <span style="color:rgba(255,255,255,.3);font-size:11px;margin:0 4px;">@</span> {{ $game->home_team }}</span>
            </div>
            <span style="font-size:11px;color:rgba(255,255,255,.3);">{{ $game->game_date?->format('M d, g:i A')??' TBD' }} ET</span>
        </div>
        <div style="padding:14px 18px;display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
            <div><div style="font-size:9px;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;font-weight:600;">Moneyline</div><div style="font-size:13px;font-weight:600;color:{{ $mlAC }};margin-bottom:3px;">{{ $mlA }}</div><div style="font-size:13px;font-weight:600;color:{{ $mlHC }};">{{ $mlH }}</div></div>
            <div><div style="font-size:9px;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;font-weight:600;">Spread</div><div style="font-size:13px;color:rgba(255,255,255,.5);margin-bottom:3px;">{{ $game->spread_away??'—' }}</div><div style="font-size:13px;color:rgba(255,255,255,.5);">{{ $game->spread_home??'—' }}</div></div>
            <div><div style="font-size:9px;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;font-weight:600;">Total</div><div style="font-size:13px;font-weight:600;color:#00D15B;margin-bottom:3px;">{{ $game->total_over??'—' }}</div><div style="font-size:13px;font-weight:600;color:#EF4444;">{{ $game->total_under??'—' }}</div></div>
            <div><div style="font-size:9px;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;font-weight:600;">Game Time</div><div style="font-size:12px;color:rgba(255,255,255,.4);">{{ $game->game_date?->format('M d')??' TBD' }}</div><div style="font-size:12px;color:rgba(255,255,255,.4);">{{ $game->game_date&&$game->game_date->format('g:i A')!=='12:00 AM'?$game->game_date->format('g:i A').' ET':'TBD ET' }}</div></div>
        </div>
    </div>
    @empty
    <div class="s-card" style="text-align:center;padding:56px;"><p style="color:rgba(255,255,255,.3);">No odds data available.</p></div>
    @endforelse
</div>
@endsection

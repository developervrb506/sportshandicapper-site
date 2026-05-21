@extends('layouts.subscriber')
@section('title','Consensus - INSPIN')
@section('page-title','Top Consensus')

@push('styles')
<style>
.filter-pill { padding:6px 14px; border-radius:50px; font-size:12px; font-weight:600; text-decoration:none; border:1px solid rgba(255,255,255,.12); color:rgba(255,255,255,.4); background:transparent; transition:all .15s; }
.filter-pill.active { border-color:var(--gold); color:var(--gold); background:rgba(253,181,21,.06); }
</style>
@endpush

@section('content')
@php
$sportColors=['NFL'=>['rgba(59,130,246,.1)','rgba(59,130,246,.2)','#3B82F6'],'NBA'=>['rgba(239,68,68,.1)','rgba(239,68,68,.2)','#EF4444'],'MLB'=>['rgba(34,197,94,.1)','rgba(34,197,94,.2)','#22C55E'],'NHL'=>['rgba(168,85,247,.1)','rgba(168,85,247,.2)','#A855F7'],'NCAAF'=>['rgba(249,115,22,.1)','rgba(249,115,22,.2)','#F97316'],'NCAAB'=>['rgba(245,158,11,.1)','rgba(245,158,11,.2)','#F59E0B']];
@endphp

<div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:16px;">
    @foreach([''=>'All','NFL'=>'NFL','NCAAF'=>'NCAAF','NBA'=>'NBA','NCAAB'=>'NCAAB','MLB'=>'MLB','NHL'=>'NHL'] as $val=>$label)
    <a href="/subscriber/consensus{{ $val?'?sport='.$val:'' }}" class="filter-pill {{ ($sport??'')===$val?'active':'' }}">{{ $label }}</a>
    @endforeach
</div>

<div style="display:flex;flex-direction:column;gap:10px;">
    @forelse($consensus as $game)
    @php
        $sc=$sportColors[$game->league]??['rgba(253,181,21,.1)','rgba(253,181,21,.2)','#FDB515'];
        $pub=$game->public_pct_home??0; $mon=$game->money_pct_home??0;
        $mlA=$game->moneyline_away??'—'; $mlH=$game->moneyline_home??'—';
        $mlAC=(is_numeric(str_replace(['+'],'',$mlA))&&(int)str_replace('+','',$mlA)>0)?'#FDB515':'#fff';
        $mlHC=(is_numeric(str_replace(['+'],'',$mlH))&&(int)str_replace('+','',$mlH)>0)?'#FDB515':'#fff';
        $pubC=$pub>=60?'#00D15B':($pub>=45?'#FDB515':'#EF4444');
        $monC=$mon>=60?'#00D15B':($mon>=45?'#FDB515':'#EF4444');
    @endphp
    <div class="s-card" style="overflow:hidden;">
        <div style="padding:12px 18px;border-bottom:1px solid rgba(255,255,255,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:{{ $sc[0] }};border:1px solid {{ $sc[1] }};color:{{ $sc[2] }};padding:2px 10px;border-radius:6px;font-size:10px;font-weight:700;">{{ $game->league }}</span>
                <span style="font-size:13px;font-weight:600;color:#fff;">{{ $game->away_team }} <span style="color:rgba(255,255,255,.3);font-size:11px;margin:0 4px;">@</span> {{ $game->home_team }}</span>
            </div>
            <span style="font-size:11px;color:rgba(255,255,255,.3);">{{ $game->game_date?->format('M d, g:i A')??' TBD' }} ET</span>
        </div>
        <div style="padding:14px 18px;display:grid;grid-template-columns:1.2fr 1fr 1fr 180px 180px;gap:14px;align-items:center;">
            <div>
                <div style="font-size:10px;color:rgba(255,255,255,.3);font-weight:600;text-transform:uppercase;margin-bottom:6px;">Matchup</div>
                <div style="font-size:13px;font-weight:600;color:#fff;margin-bottom:3px;">{{ $game->away_team }}</div>
                <div style="font-size:13px;font-weight:600;color:#fff;">{{ $game->home_team }}</div>
            </div>
            <div>
                <div style="font-size:10px;color:rgba(255,255,255,.3);font-weight:600;text-transform:uppercase;margin-bottom:6px;">Moneyline</div>
                <div style="font-size:13px;font-weight:600;color:{{ $mlAC }};margin-bottom:3px;">{{ $mlA }}</div>
                <div style="font-size:13px;font-weight:600;color:{{ $mlHC }};">{{ $mlH }}</div>
            </div>
            <div>
                <div style="font-size:10px;color:rgba(255,255,255,.3);font-weight:600;text-transform:uppercase;margin-bottom:6px;">Total</div>
                <div style="font-size:13px;font-weight:600;color:#00D15B;margin-bottom:3px;">{{ $game->total_over??'—' }}</div>
                <div style="font-size:13px;font-weight:600;color:#EF4444;">{{ $game->total_under??'—' }}</div>
            </div>
            <div>
                <div style="font-size:10px;color:rgba(255,255,255,.3);font-weight:600;text-transform:uppercase;margin-bottom:6px;">Public {{ $pub }}%</div>
                <div style="height:5px;background:rgba(255,255,255,.08);border-radius:3px;overflow:hidden;"><div style="width:{{ $pub }}%;height:100%;background:{{ $pubC }};border-radius:3px;"></div></div>
                <div style="font-size:10px;color:rgba(255,255,255,.3);margin-top:4px;">Away {{ 100-$pub }}% · Home {{ $pub }}%</div>
            </div>
            <div>
                @if($mon)
                <div style="font-size:10px;color:rgba(255,255,255,.3);font-weight:600;text-transform:uppercase;margin-bottom:6px;">Sharp {{ $mon }}%</div>
                <div style="height:5px;background:rgba(255,255,255,.08);border-radius:3px;overflow:hidden;"><div style="width:{{ $mon }}%;height:100%;background:{{ $monC }};border-radius:3px;"></div></div>
                <div style="font-size:10px;color:rgba(255,255,255,.3);margin-top:4px;">Away {{ 100-$mon }}% · Home {{ $mon }}%</div>
                @else<div style="font-size:11px;color:rgba(255,255,255,.2);">No data</div>@endif
            </div>
        </div>
    </div>
    @empty
    <div class="s-card" style="text-align:center;padding:56px;"><p style="color:rgba(255,255,255,.3);">No consensus data available.</p></div>
    @endforelse
</div>
<div style="margin-top:20px;">{{ $consensus->links() }}</div>
@endsection

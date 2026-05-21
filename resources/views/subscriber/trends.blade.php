@extends('layouts.subscriber')
@section('title','Trends - INSPIN')
@section('page-title','Betting Trends')

@section('content')
@php
$sportColors=['NFL'=>['#3b82f6','rgba(59,130,246,.1)'],'NBA'=>['#ef4444','rgba(239,68,68,.1)'],'MLB'=>['#22c55e','rgba(34,197,94,.1)'],'NHL'=>['#a855f7','rgba(168,85,247,.1)'],'NCAAF'=>['#f97316','rgba(249,115,22,.1)'],'NCAAB'=>['#f59e0b','rgba(245,158,11,.1)']];
@endphp

{{-- Hot Streaks --}}
@if(!empty($hotStreaks)&&count($hotStreaks)>0)
<div style="background:rgba(0,209,91,.06);border:1px solid rgba(0,209,91,.2);border-radius:var(--r);padding:14px 18px;margin-bottom:16px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
    <div style="font-size:1.3rem;">🔥</div>
    <div style="flex:1;">
        <div style="font-size:11px;font-weight:700;color:#00D15B;text-transform:uppercase;letter-spacing:.4px;margin-bottom:5px;">Active Hot Streaks</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            @foreach($hotStreaks as $hot)
            <span style="background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.3);color:#00D15B;padding:3px 12px;border-radius:20px;font-size:12px;font-weight:700;">
                {{ $hot['sport'] }} · {{ $hot['streak'] }}W · {{ $hot['win_rate'] }}% · {{ $hot['units']>=0?'+':'' }}{{ number_format($hot['units'],1) }}u
            </span>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Sport summary cards --}}
@php
$sportSummary=[];
foreach($streaks as $sport=>$periods){$best=$periods['last_30_picks']??$periods['last_10_picks']??array_values($periods)[0]??null;if($best)$sportSummary[$sport]=$best;}
@endphp
@if(count($sportSummary)>0)
<h2 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:12px;">Performance by Sport <span style="font-size:11px;color:rgba(255,255,255,.3);font-weight:400;">(last 30 picks)</span></h2>
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;margin-bottom:20px;">
    @foreach($sportSummary as $sport=>$data)
    @php $sc=$sportColors[$sport]??['#FDB515','rgba(253,181,21,.1)']; $wr=$data['win_rate']??0; $u=$data['total_units']??0; $isHot=$data['is_hot']??false; @endphp
    <div class="s-card" style="padding:16px;border-color:{{ $isHot?'rgba(0,209,91,.25)':'rgba(255,255,255,.07)' }};">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:30px;height:30px;border-radius:8px;background:{{ $sc[1] }};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:{{ $sc[0] }};">{{ substr($sport,0,2) }}</div>
                <span style="font-size:14px;font-weight:600;color:#fff;">{{ $sport }}</span>
            </div>
            @if($isHot)<span style="background:rgba(0,209,91,.1);border:1px solid #00D15B;color:#00D15B;padding:2px 8px;border-radius:12px;font-size:10px;font-weight:700;">🔥 HOT</span>
            @else<span style="font-size:11px;color:rgba(255,255,255,.3);">{{ ($data['total_wins']??0)+($data['total_losses']??0) }} picks</span>@endif
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:10px;">
            <div><div style="font-size:9px;color:rgba(255,255,255,.3);margin-bottom:2px;">WIN RATE</div><div style="font-size:1rem;font-weight:700;color:{{ $wr>=55?'#00D15B':($wr>=45?'#FDB515':'#EF4444') }};">{{ $wr }}%</div></div>
            <div><div style="font-size:9px;color:rgba(255,255,255,.3);margin-bottom:2px;">UNITS</div><div style="font-size:1rem;font-weight:700;color:{{ $u>=0?'#00D15B':'#EF4444' }};">{{ $u>=0?'+':'' }}{{ number_format($u,1) }}</div></div>
            <div><div style="font-size:9px;color:rgba(255,255,255,.3);margin-bottom:2px;">RECORD</div><div style="font-size:.9rem;font-weight:600;color:rgba(255,255,255,.6);">{{ $data['total_wins']??0 }}-{{ $data['total_losses']??0 }}</div></div>
        </div>
        <div style="height:4px;background:rgba(255,255,255,.08);border-radius:3px;overflow:hidden;"><div style="width:{{ $wr }}%;height:100%;background:{{ $wr>=55?'#00D15B':($wr>=45?'#FDB515':'#EF4444') }};border-radius:3px;"></div></div>
    </div>
    @endforeach
</div>
@endif

{{-- Full table --}}
@if(!empty($streaks))
<div class="s-card" style="overflow:hidden;">
    <div style="padding:14px 18px;border-bottom:1px solid rgba(255,255,255,.07);"><h2 style="font-size:15px;font-weight:700;color:#fff;">Full Breakdown</h2></div>
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead><tr style="border-bottom:1px solid rgba(255,255,255,.08);">
                @foreach(['Sport','Period','Streak','Best','Win %','Record','Units','Status'] as $h)
                <th style="padding:10px 16px;text-align:left;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:rgba(255,255,255,.3);white-space:nowrap;">{{ $h }}</th>
                @endforeach
            </tr></thead>
            <tbody>
                @foreach($streaks as $sport=>$periods)
                @php $sc2=$sportColors[$sport]??['#FDB515','rgba(253,181,21,.1)']; @endphp
                @foreach($periods as $period=>$data)
                <tr style="border-bottom:1px solid rgba(255,255,255,.04);" onmouseover="this.style.background='rgba(255,255,255,.02)'" onmouseout="this.style.background='transparent'">
                    <td style="padding:10px 16px;"><div style="display:flex;align-items:center;gap:7px;"><div style="width:6px;height:6px;border-radius:50%;background:{{ $sc2[0] }};flex-shrink:0;"></div><span style="font-size:13px;font-weight:600;color:#fff;">{{ $sport }}</span></div></td>
                    <td style="padding:10px 16px;font-size:12px;color:rgba(255,255,255,.4);">{{ str_replace('_',' ',ucfirst($period)) }}</td>
                    <td style="padding:10px 16px;font-size:12px;color:rgba(255,255,255,.5);">{{ $data['current_streak'] }}W</td>
                    <td style="padding:10px 16px;font-size:12px;color:rgba(255,255,255,.5);">{{ $data['best_streak'] }}W</td>
                    <td style="padding:10px 16px;font-size:13px;font-weight:700;color:{{ $data['win_rate']>=55?'#00D15B':($data['win_rate']>=45?'#FDB515':'#EF4444') }};">{{ $data['win_rate'] }}%</td>
                    <td style="padding:10px 16px;font-size:12px;color:rgba(255,255,255,.5);">{{ $data['total_wins'] }}-{{ $data['total_losses'] }}-{{ $data['total_pushes'] }}</td>
                    <td style="padding:10px 16px;font-size:13px;font-weight:700;color:{{ $data['total_units']>=0?'#00D15B':'#EF4444' }};">{{ $data['total_units']>=0?'+':'' }}{{ number_format($data['total_units'],1) }}</td>
                    <td style="padding:10px 16px;">@if($data['is_hot'])<span style="background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.3);color:#00D15B;padding:2px 8px;border-radius:12px;font-size:10px;font-weight:700;">🔥 HOT</span>@else<span style="color:rgba(255,255,255,.2);font-size:12px;">—</span>@endif</td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

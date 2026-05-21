@extends('layouts.subscriber')
@section('title', 'My Picks - INSPIN')
@section('page-title', 'My Picks')

@push('styles')
<style>
.picks-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; }
@media(max-width:860px){ .picks-grid { grid-template-columns:1fr; } }

.tab-bar { display:flex; gap:4px; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08); border-radius:50px; padding:4px; margin-bottom:16px; }
.tab-btn { flex:1; padding:8px 12px; border-radius:50px; border:none; cursor:pointer; font-size:12.5px; font-weight:600; font-family:'Inter',sans-serif; background:transparent; color:rgba(255,255,255,.4); transition:all .18s; display:flex; align-items:center; justify-content:center; gap:6px; }
.tab-btn.active { background:var(--gold); color:#000; }
.tab-btn:hover:not(.active) { color:rgba(255,255,255,.7); }
.tab-count { font-size:10px; padding:1px 6px; border-radius:10px; background:rgba(255,255,255,.1); }
.tab-btn.active .tab-count { background:rgba(0,0,0,.2); }

.filter-pill { padding:6px 14px; border-radius:50px; font-size:12px; font-weight:600; text-decoration:none; border:1px solid rgba(255,255,255,.12); color:rgba(255,255,255,.4); background:transparent; transition:all .15s; }
.filter-pill.active { border-color:var(--gold); color:var(--gold); background:rgba(253,181,21,.06); }
.filter-pill:hover:not(.active) { border-color:rgba(255,255,255,.25); color:rgba(255,255,255,.7); }

.pick-card { background:var(--card); border:1px solid var(--bdr); border-radius:var(--r); overflow:hidden; }
</style>
@endpush

@section('content')
@php
    $sportColors=['MLB'=>['rgba(34,197,94,.1)','rgba(34,197,94,.2)','#22C55E'],'NFL'=>['rgba(59,130,246,.1)','rgba(59,130,246,.2)','#3B82F6'],'NBA'=>['rgba(239,68,68,.1)','rgba(239,68,68,.2)','#EF4444'],'NHL'=>['rgba(168,85,247,.1)','rgba(168,85,247,.2)','#A855F7'],'NCAAF'=>['rgba(249,115,22,.1)','rgba(249,115,22,.2)','#F97316'],'NCAAB'=>['rgba(245,158,11,.1)','rgba(245,158,11,.2)','#F59E0B']];
@endphp

{{-- Stats row --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px;">
    @foreach([['RECORD',$wins.'-'.$losses.($pushes?'-'.$pushes:''),'rgba(255,255,255,.4)'],['WIN RATE',$wr.'%',$wr>=55?'#00D15B':($wr>=45?'#FDB515':($total>0?'#EF4444':'rgba(255,255,255,.3)'))],['UNITS',($units>=0?'+':'').number_format($units,2),$units>=0?'#00D15B':'#EF4444'],['SINCE',$sub->starts_at->format('M d, Y'),'rgba(255,255,255,.4)']] as $s)
    <div class="s-card" style="padding:14px;">
        <div style="font-size:9px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:rgba(255,255,255,.4);margin-bottom:6px;">{{ $s[0] }}</div>
        <div style="font-size:1.2rem;font-weight:800;color:{{ $s[2] }};line-height:1;">{{ $s[1] }}</div>
        @if($loop->last)<div style="font-size:10px;color:rgba(255,255,255,.3);margin-top:4px;">{{ $sub->max_stars }}★ access</div>@endif
    </div>
    @endforeach
</div>

{{-- Tabs --}}
<div class="tab-bar">
    <a href="?{{ http_build_query(array_merge(['sport'=>$sport,'period'=>$period],['tab'=>'all'])) }}" class="tab-btn {{ $tab==='all'?'active':'' }}" style="text-decoration:none;">All <span class="tab-count">{{ $countAll }}</span></a>
    <a href="?{{ http_build_query(array_merge(['sport'=>$sport,'period'=>$period],['tab'=>'pending'])) }}" class="tab-btn {{ $tab==='pending'?'active':'' }}" style="text-decoration:none;">🟢 Pending <span class="tab-count">{{ $countPending }}</span></a>
    <a href="?{{ http_build_query(array_merge(['sport'=>$sport,'period'=>$period],['tab'=>'results'])) }}" class="tab-btn {{ $tab==='results'?'active':'' }}" style="text-decoration:none;">🏁 Results <span class="tab-count">{{ $countResults }}</span></a>
</div>

{{-- Filters --}}
<div style="display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;align-items:center;">
    <div style="display:flex;gap:6px;flex-wrap:wrap;">
        @foreach([''=>'All','NFL'=>'NFL','NCAAF'=>'NCAAF','NBA'=>'NBA','NCAAB'=>'NCAAB','MLB'=>'MLB','NHL'=>'NHL'] as $val=>$label)
        <a href="?{{ http_build_query(array_filter(['sport'=>$val,'period'=>$period,'tab'=>$tab])) }}" class="filter-pill {{ ($sport??'')===$val?'active':'' }}">{{ $label }}</a>
        @endforeach
    </div>
    <div style="width:1px;height:20px;background:rgba(255,255,255,.1);"></div>
    <div style="display:flex;gap:6px;">
        @foreach(['all'=>'All Time','month'=>'30 Days','week'=>'7 Days'] as $key=>$label)
        <a href="?{{ http_build_query(array_filter(['sport'=>$sport,'period'=>$key,'tab'=>$tab])) }}" class="filter-pill {{ $period===$key?'active':'' }}">{{ $label }}</a>
        @endforeach
    </div>
</div>

{{-- Pick cards --}}
@if($picks->count()>0)
<div class="picks-grid">
    @foreach($picks as $pick)
    @php
        $rawTime=$pick->game_time?(string)$pick->game_time:'00:00:00';
        $tStr=strlen($rawTime)===5?$rawTime.':00':substr($rawTime,0,8);
        $gameStart=\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$pick->game_date->format('Y-m-d').' '.$tStr,'America/New_York');
        $now=\Carbon\Carbon::now('America/New_York');
        $isGraded=in_array($pick->result,['win','loss','push']);
        $status=$isGraded?ucfirst($pick->result):($now->gte($gameStart)?'Started':'Active');
        $sBadge=['Win'=>'bw','Loss'=>'bl','Push'=>'bp','Started'=>'bstart','Active'=>'bact'];
        $sc=$sportColors[$pick->sport]??['rgba(253,181,21,.12)','rgba(253,181,21,.2)','#FDB515'];
        $t1=strtoupper(substr($pick->team1_name??'T1',0,2));
        $t2=strtoupper(substr($pick->team2_name??'T2',0,2));
        $conf=$pick->team1_percent;
    @endphp
    <div class="pick-card">
        {{-- Header --}}
        <div style="padding:12px 16px;border-bottom:1px solid rgba(255,255,255,.07);display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="spbadge" style="background:{{ $sc[0] }};border:1px solid {{ $sc[1] }};color:{{ $sc[2] }};font-size:11px;">{{ $pick->sport }}</span>
                <span style="font-size:11px;color:rgba(255,255,255,.4);">{{ $pick->game_date->format('M d') }}{{ $pick->game_time?' · '.\Carbon\Carbon::parse($pick->game_time)->format('g:i A').' ET':'' }}</span>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="sbadge {{ $sBadge[$status]??'badge-pending' }}">{{ strtoupper($status) }}</span>
                @if($pick->stars===10)<span style="font-size:10px;font-weight:800;color:var(--gold);">★10</span>
                @else<span style="font-size:13px;color:var(--gold);">{{ str_repeat('★',(int)$pick->stars) }}<span style="color:rgba(255,255,255,.15);">{{ str_repeat('★',max(0,5-(int)$pick->stars)) }}</span></span>@endif
            </div>
        </div>

        {{-- Teams + confidence --}}
        <div style="padding:14px 16px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;flex-wrap:wrap;">
                <div style="width:28px;height:28px;border-radius:50%;background:rgba(255,255,255,.08);flex-shrink:0;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    @if($pick->team1_logo)<img src="{{ asset('storage/'.$pick->team1_logo) }}" style="width:22px;height:22px;object-fit:contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span style="display:none;font-size:8px;font-weight:700;color:rgba(255,255,255,.5);">{{ $t1 }}</span>
                    @else<span style="font-size:8px;font-weight:700;color:rgba(255,255,255,.5);">{{ $t1 }}</span>@endif
                </div>
                <span style="font-size:13px;font-weight:600;color:#fff;">{{ $pick->team1_name }}</span>
                <span style="font-size:11px;color:rgba(255,255,255,.3);">vs</span>
                <div style="width:28px;height:28px;border-radius:50%;background:rgba(255,255,255,.08);flex-shrink:0;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    @if($pick->team2_logo)<img src="{{ asset('storage/'.$pick->team2_logo) }}" style="width:22px;height:22px;object-fit:contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span style="display:none;font-size:8px;font-weight:700;color:rgba(255,255,255,.5);">{{ $t2 }}</span>
                    @else<span style="font-size:8px;font-weight:700;color:rgba(255,255,255,.5);">{{ $t2 }}</span>@endif
                </div>
                <span style="font-size:13px;font-weight:600;color:#fff;">{{ $pick->team2_name }}</span>
            </div>
            @if($conf)
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                <span class="sbadge {{ $sBadge[$status]??'badge-pending' }}" style="font-size:10px;">{{ $status }} Pick</span>
                <span style="font-size:13px;font-weight:700;color:var(--gold);">{{ $conf }}% Confidence</span>
            </div>
            <div style="height:4px;background:rgba(255,255,255,.08);border-radius:4px;overflow:hidden;">
                <div style="width:{{ $conf }}%;height:100%;background:var(--gold);border-radius:4px;"></div>
            </div>
            @endif
        </div>

        {{-- The Pick --}}
        <div style="margin:0 14px 12px;background:rgba(253,181,21,.07);border:1px solid rgba(253,181,21,.15);border-radius:10px;padding:10px 14px;">
            <div style="font-size:9px;color:var(--gold);text-transform:uppercase;letter-spacing:.5px;font-weight:700;margin-bottom:4px;">The Pick</div>
            <div style="font-size:14px;font-weight:600;color:#fff;">{{ $pick->pick }}</div>
            @if($pick->pick_type)<div style="font-size:10px;color:rgba(255,255,255,.3);margin-top:2px;">{{ $pick->pick_type }}</div>@endif
        </div>

        {{-- Result footer --}}
        @if($isGraded)
        <div style="padding:9px 16px;border-top:1px solid rgba(255,255,255,.06);display:flex;align-items:center;justify-content:space-between;background:rgba({{ $pick->result==='win'?'0,209,91':($pick->result==='loss'?'239,68,68':'253,181,21') }},.04);">
            <span class="sbadge {{ $sBadge[$status]??'badge-pending' }}" style="font-size:11px;">{{ strtoupper($pick->result) }}</span>
            @if($pick->units_result!==null)<span style="font-size:1rem;font-weight:700;color:{{ $pick->units_result>=0?'#00D15B':'#EF4444' }};">{{ $pick->units_result>=0?'+':'' }}{{ $pick->units_result }} units</span>@endif
        </div>
        @endif

        @if($pick->expert_name)
        <div style="padding:8px 16px;border-top:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:7px;">
            <div style="width:20px;height:20px;border-radius:50%;background:var(--gold);color:#000;display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:800;">{{ substr($pick->expert_name,0,1) }}</div>
            <span style="font-size:11px;color:rgba(255,255,255,.4);">{{ $pick->expert_name }}</span>
        </div>
        @endif
    </div>
    @endforeach
</div>
<div style="margin-top:20px;">{{ $picks->links() }}</div>
@else
<div class="s-card" style="text-align:center;padding:56px 24px;">
    <div style="font-size:3rem;margin-bottom:14px;">{{ $tab==='results'?'🏁':($tab==='pending'?'⏳':'🏅') }}</div>
    <h3 style="font-size:1rem;font-weight:700;color:#fff;margin-bottom:6px;">{{ $tab==='results'?'No graded picks yet':($tab==='pending'?'No pending picks':'No picks found') }}</h3>
    <p style="font-size:13px;color:rgba(255,255,255,.3);">{{ $tab==='results'?'Results appear once picks are graded.':'Try adjusting the sport or time filter.' }}</p>
</div>
@endif
@endsection

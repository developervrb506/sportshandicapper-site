@extends('layouts.public')
@section('title', 'Expert Picks | Sportshandicapper')
@section('meta', 'Timestamped before lines move, graded after the final whistle. Expert picks across MLB, NBA, NFL, NHL, CFB and CBB.')

@push('styles')
<style>
.picks-board-header {
    display:grid;
    grid-template-columns:80px 1fr 190px 90px 130px 140px;
    gap:12px;
    padding:12px 24px;
    border-bottom:1px solid rgba(255,255,255,0.06);
    background:rgba(0,0,0,0.4);
    font-size:9px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:0.14em;
    color:#64748B;
}
.picks-board-row {
    display:grid;
    grid-template-columns:80px 1fr 190px 90px 130px 140px;
    gap:12px;
    padding:18px 24px;
    border-bottom:1px solid rgba(255,255,255,0.04);
    align-items:center;
    transition:background .15s;
}
.picks-board-row:last-of-type { border-bottom:none; }
.picks-board-row:hover { background:rgba(255,255,255,0.025); }

.sp-filter-btn {
    padding:8px 16px;
    border-radius:6px;
    font-size:10px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:0.12em;
    border:1px solid rgba(255,255,255,0.1);
    background:rgba(255,255,255,0.04);
    color:#94A3B8;
    cursor:pointer;
    transition:all .15s;
    font-family:Inter,sans-serif;
}
.sp-filter-btn.sp-active { border-color:#1E90FF;background:#1E90FF;color:white; }
.sp-filter-btn:hover:not(.sp-active) { border-color:rgba(255,255,255,0.2);color:white; }

.picks-pagination { display:flex;align-items:center;justify-content:center;gap:6px;margin-top:40px;flex-wrap:wrap; }
.picks-pagination a,
.picks-pagination span.pg-num {
    display:inline-flex;align-items:center;justify-content:center;
    width:36px;height:36px;border-radius:6px;
    font-size:12px;font-weight:700;
    text-decoration:none;transition:all .15s;
}
.picks-pagination a { border:1px solid rgba(255,255,255,0.1);color:#94A3B8;background:rgba(255,255,255,0.04); }
.picks-pagination a:hover { border-color:rgba(255,255,255,0.25);color:white; }
.picks-pagination .pg-current { border:1px solid #1E90FF;color:white;background:#1E90FF; }
.picks-pagination .pg-disabled { border:1px solid rgba(255,255,255,0.05);color:#334155;cursor:default;display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:6px;font-size:14px; }
.picks-pagination .pg-dots { color:#334155;font-size:12px;display:inline-flex;align-items:center;padding:0 4px; }

@media(max-width:900px){
    .picks-board-header { display:none!important; }
    .picks-board-row { grid-template-columns:60px 1fr 80px 80px!important;padding:14px 16px; }
    .picks-board-row>div:nth-child(3),
    .picks-board-row>div:nth-child(6) { display:none!important; }
}
@media(max-width:480px){
    .picks-board-row { grid-template-columns:56px 1fr 72px!important; }
    .picks-board-row>div:nth-child(4) { display:none!important; }
}
</style>
@endpush

@section('content')

@php
$sportColors = [
    'MLB'=>'#c0392b','NBA'=>'#e67e22','NHL'=>'#2980b9',
    'NFL'=>'#27ae60','CFB'=>'#8e44ad','CBB'=>'#1E90FF',
    'NCAAF'=>'#8e44ad','NCAAB'=>'#1E90FF',
];
$usingRealPicks = $picks->count() > 0;

$staticPicks = [
    ['MLB','Yankees','Red Sox','7:05 PM','DraftKings',92,3,'M. Rinner','NYY -1.5 (-115)'],
    ['NBA','Thunder','Spurs','8:30 PM','FanDuel',87,2,'M. Davis','OKC -4.5 (-110)'],
    ['NHL','Oilers','Kings','10:00 PM','BetMGM',81,2,'K. Pratt','EDM ML (+120)'],
    ['NFL','Chiefs','Chargers','8:20 PM','DraftKings',76,3,'M. Rinner','KC -3 (-115)'],
    ['MLB','Dodgers','Padres','10:10 PM','Caesars',84,2,'M. Davis','LAD/SD Under 8 (-110)'],
    ['NBA','Celtics','Bucks','7:30 PM','FanDuel',79,2,'D. Wilson','BOS -5.5 (-112)'],
    ['NHL','Rangers','Hurricanes','7:00 PM','BetMGM',88,3,'K. Pratt','NYR ML (+105)'],
    ['NFL','Eagles','Cowboys','8:20 PM','DraftKings',71,2,'M. Rinner','PHI -2.5 (-115)'],
    ['MLB','Cubs','Cardinals','2:20 PM','Caesars',77,1,'D. Wilson','STL ML (+130)'],
];
@endphp

{{-- ── Page Header ── --}}
<div style="border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(0,0,0,0.3);">
    <div class="container-x" style="padding:48px 0 40px;">
        <div class="reveal" style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:24px;">
            <div>
                <div style="display:inline-flex;align-items:center;gap:8px;padding:5px 12px;border-radius:6px;border:1px solid rgba(34,197,94,0.3);background:rgba(34,197,94,0.05);margin-bottom:20px;">
                    <span class="ping-soft" style="position:relative;display:inline-flex;width:6px;height:6px;border-radius:50%;background:#22c55e;"></span>
                    <span style="font-size:10px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#86efac;">
                        {{ $usingRealPicks ? $picks->total().' live picks today' : '10 live picks today' }}
                    </span>
                </div>
                <h1 style="font-size:clamp(2.5rem,5vw,4rem);font-weight:900;line-height:0.95;letter-spacing:-0.03em;color:white;margin:0 0 16px;">Expert Picks.</h1>
                <p style="font-size:14px;color:#64748B;line-height:1.7;max-width:480px;margin:0;">Timestamped before lines move, graded after the final whistle. Coverage across MLB, NBA, NFL, NHL, CFB and CBB.</p>
            </div>
            <div style="display:flex;gap:40px;">
                @foreach([['67%','30-day hit','#22c55e'],['+184u','YTD profit','#1E90FF'],['12.8%','ROI','#fbbf24']] as $s)
                <div style="text-align:right;">
                    <div style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:900;font-family:monospace;color:{{ $s[2] }};line-height:1;">{{ $s[0] }}</div>
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;color:#475569;margin-top:4px;">{{ $s[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ── Filters + Member callout ── --}}
<div class="container-x" style="padding:32px 0 64px;">

    <div class="reveal" style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px;margin-bottom:28px;">
        <div style="display:flex;flex-wrap:wrap;gap:6px;" id="spFilters">
            @foreach(['ALL','NFL','NCAAF','NBA','NCAAB','MLB','NHL'] as $l)
            <button onclick="filterSport('{{ $l }}')" data-sport="{{ $l }}" class="sp-filter-btn {{ $l==='ALL'?'sp-active':'' }}">{{ $l }}</button>
            @endforeach
        </div>
        <div style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:6px;border:1px solid rgba(30,144,255,0.25);background:rgba(30,144,255,0.05);">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#7DD3FC;">Full picks unlocked for members</span>
        </div>
    </div>

    {{-- ── Picks Board Table ── --}}
    <div class="card-premium reveal" style="overflow:hidden;margin-bottom:0;">

        {{-- Table header --}}
        <div class="picks-board-header">
            <div>League</div>
            <div>Matchup</div>
            <div>Pick</div>
            <div style="text-align:center;">Units</div>
            <div style="text-align:right;">Confidence</div>
            <div style="text-align:right;">Expert</div>
        </div>

        {{-- Real picks from DB --}}
        @if($usingRealPicks)
            @foreach($picks as $i=>$pick)
            @php
                $sc = $sportColors[$pick->sport] ?? '#1E90FF';
                try {
                    $rawTime = $pick->game_time ? (string)$pick->game_time : '00:00:00';
                    $timeStr = strlen($rawTime) === 5 ? $rawTime.':00' : substr($rawTime, 0, 8);
                    $gameStart = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pick->game_date->format('Y-m-d').' '.$timeStr, 'America/New_York');
                    $now = \Carbon\Carbon::now('America/New_York');
                    $status = $pick->result !== 'pending' ? 'graded' : ($now->gte($gameStart) ? 'live' : 'active');
                } catch(\Exception $e) {
                    $status = 'active';
                }
            @endphp
            <div class="picks-board-row" data-sport="{{ $pick->sport }}">
                {{-- League badge --}}
                <div>
                    <span style="padding:3px 7px;border-radius:4px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);font-size:9px;font-weight:700;letter-spacing:0.1em;color:#cbd5e1;">{{ $pick->sport }}</span>
                </div>
                {{-- Matchup --}}
                <div style="min-width:0;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;">
                        <div style="display:flex;align-items:center;flex-shrink:0;">
                            <div style="width:22px;height:22px;border-radius:50%;background:{{ $sc }};display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:900;color:white;border:1px solid rgba(255,255,255,0.2);">{{ strtoupper(substr($pick->team1_name??'?',0,2)) }}</div>
                            <div style="width:22px;height:22px;border-radius:50%;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:900;color:#94A3B8;border:1px solid rgba(255,255,255,0.12);margin-left:-6px;">{{ strtoupper(substr($pick->team2_name??'?',0,2)) }}</div>
                        </div>
                        <span style="font-size:13px;font-weight:700;color:white;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $pick->team1_name }} vs {{ $pick->team2_name }}</span>
                        @if($status === 'live')
                        <span class="ping-soft" style="position:relative;display:inline-flex;width:6px;height:6px;border-radius:50%;background:#22c55e;flex-shrink:0;"></span>
                        @endif
                    </div>
                    <div style="font-size:10px;color:#64748B;font-family:monospace;padding-left:38px;">
                        {{ $pick->game_date?->format('M d') }}{{ $pick->game_time ? ' · '.date('g:i A', strtotime($pick->game_time)).' ET' : '' }}
                        @if($status === 'graded')
                        &nbsp;<span style="color:{{ $pick->result==='win'?'#86efac':($pick->result==='loss'?'#f87171':'#fbbf24') }};font-weight:700;text-transform:uppercase;">{{ $pick->result }}</span>
                        @endif
                    </div>
                </div>
                {{-- Pick text --}}
                <div style="display:flex;align-items:center;gap:6px;">
                    @auth
                        @if(method_exists(auth()->user(),'canViewPick') && auth()->user()->canViewPick($pick))
                        <span style="font-size:12px;font-weight:700;font-family:monospace;color:#e2e8f0;">{{ $pick->pick }}</span>
                        @else
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <span style="font-size:11px;color:#64748B;">Upgrade to unlock</span>
                        @endif
                    @else
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    <span style="font-size:11px;font-weight:600;color:#64748B;cursor:pointer;" onclick="openModal()">Members only</span>
                    @endauth
                </div>
                {{-- Units --}}
                <div style="text-align:center;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:6px;background:rgba(30,144,255,0.12);border:1px solid rgba(30,144,255,0.3);color:#1E90FF;font-weight:900;font-size:11px;font-family:monospace;">{{ $pick->stars ?? 2 }}u</span>
                </div>
                {{-- Confidence --}}
                <div style="display:flex;align-items:center;justify-content:flex-end;gap:8px;">
                    @if($pick->team1_percent)
                    <div style="flex:1;max-width:70px;height:4px;border-radius:9999px;background:rgba(255,255,255,0.06);overflow:hidden;">
                        <div style="height:100%;border-radius:9999px;background:#4ade80;width:{{ $pick->team1_percent }}%;"></div>
                    </div>
                    <span style="font-size:11px;font-family:monospace;font-weight:700;color:#86efac;min-width:32px;text-align:right;">{{ $pick->team1_percent }}%</span>
                    @else
                    <span style="font-size:11px;color:#475569;font-family:monospace;">–</span>
                    @endif
                </div>
                {{-- Expert --}}
                <div style="display:flex;align-items:center;justify-content:flex-end;gap:8px;">
                    @if($pick->analyst)
                    <div style="width:28px;height:28px;border-radius:50%;background:#1E90FF;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:900;color:white;flex-shrink:0;">{{ strtoupper(substr($pick->analyst,0,2)) }}</div>
                    <span style="font-size:12px;font-weight:600;color:#94A3B8;white-space:nowrap;">{{ $pick->analyst }}</span>
                    @else
                    <span style="font-size:12px;color:#475569;">–</span>
                    @endif
                </div>
            </div>
            @endforeach

        {{-- Static sample picks --}}
        @else
            @foreach($staticPicks as $i=>$row)
            @php $sc = $sportColors[$row[0]] ?? '#1E90FF'; @endphp
            <div class="picks-board-row" data-sport="{{ $row[0] }}">
                <div>
                    <span style="padding:3px 7px;border-radius:4px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);font-size:9px;font-weight:700;letter-spacing:0.1em;color:#cbd5e1;">{{ $row[0] }}</span>
                </div>
                <div style="min-width:0;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;">
                        <div style="display:flex;align-items:center;flex-shrink:0;">
                            <div style="width:22px;height:22px;border-radius:50%;background:{{ $sc }};display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:900;color:white;border:1px solid rgba(255,255,255,0.2);">{{ strtoupper(substr($row[1],0,2)) }}</div>
                            <div style="width:22px;height:22px;border-radius:50%;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:900;color:#94A3B8;border:1px solid rgba(255,255,255,0.12);margin-left:-6px;">{{ strtoupper(substr($row[2],0,2)) }}</div>
                        </div>
                        <span style="font-size:13px;font-weight:700;color:white;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $row[1] }} vs {{ $row[2] }}</span>
                    </div>
                    <div style="font-size:10px;color:#64748B;font-family:monospace;padding-left:38px;">{{ $row[3] }} ET &middot; {{ $row[4] }}</div>
                </div>
                <div style="display:flex;align-items:center;gap:6px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    <span style="font-size:11px;font-weight:600;font-family:monospace;color:#94A3B8;">{{ $row[8] }}</span>
                </div>
                <div style="text-align:center;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:6px;background:rgba(30,144,255,0.12);border:1px solid rgba(30,144,255,0.3);color:#1E90FF;font-weight:900;font-size:11px;font-family:monospace;">{{ $row[6] }}u</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:flex-end;gap:8px;">
                    <div style="flex:1;max-width:70px;height:4px;border-radius:9999px;background:rgba(255,255,255,0.06);overflow:hidden;">
                        <div style="height:100%;border-radius:9999px;background:#4ade80;width:{{ $row[5] }}%;"></div>
                    </div>
                    <span style="font-size:11px;font-family:monospace;font-weight:700;color:#86efac;min-width:32px;text-align:right;">{{ $row[5] }}%</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:flex-end;gap:8px;">
                    <div style="width:28px;height:28px;border-radius:50%;background:#1E90FF;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:900;color:white;flex-shrink:0;">{{ strtoupper(substr($row[7],0,2)) }}</div>
                    <span style="font-size:12px;font-weight:600;color:#94A3B8;white-space:nowrap;">{{ $row[7] }}</span>
                </div>
            </div>
            @endforeach
        @endif

        {{-- Member CTA footer --}}
        @guest
        <div style="padding:20px 24px;background:rgba(30,144,255,0.04);border-top:1px solid rgba(30,144,255,0.15);display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                <div>
                    <div style="font-size:13px;font-weight:700;color:white;">Login or subscribe to unlock all picks</div>
                    <div style="font-size:11px;color:#64748B;margin-top:2px;">Members see full picks, expert reasoning, and graded results</div>
                </div>
            </div>
            <div style="display:flex;gap:10px;">
                <button onclick="openModal()" style="padding:9px 20px;border-radius:6px;border:1px solid rgba(255,255,255,0.15);background:transparent;color:#94A3B8;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;font-family:Inter,sans-serif;" onmouseover="this.style.borderColor='rgba(255,255,255,0.35)';this.style.color='white'" onmouseout="this.style.borderColor='rgba(255,255,255,0.15)';this.style.color='#94A3B8'">Log In</button>
                <a href="{{ route('join') }}" class="btn-primary" style="font-size:12px;padding:9px 20px;">
                    Subscribe
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        @endguest
    </div>

    {{-- Pagination --}}
    @if($usingRealPicks && $picks->lastPage() > 1)
    <div class="picks-pagination reveal" style="margin-top:40px;">
        @if($picks->onFirstPage())
            <span class="pg-disabled">&#8249;</span>
        @else
            <a href="{{ $picks->previousPageUrl() }}">&#8249;</a>
        @endif

        @for($p = 1; $p <= $picks->lastPage(); $p++)
            @if($p === $picks->currentPage())
                <span class="pg-num pg-current">{{ $p }}</span>
            @elseif($p === 1 || $p === $picks->lastPage() || abs($p - $picks->currentPage()) <= 2)
                <a href="{{ $picks->url($p) }}" class="pg-num">{{ $p }}</a>
            @elseif(abs($p - $picks->currentPage()) === 3)
                <span class="pg-dots">…</span>
            @endif
        @endfor

        @if($picks->hasMorePages())
            <a href="{{ $picks->nextPageUrl() }}">&#8250;</a>
        @else
            <span class="pg-disabled">&#8250;</span>
        @endif
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
function filterSport(sport) {
    document.querySelectorAll('.sp-filter-btn').forEach(function(btn) {
        var active = btn.dataset.sport === sport;
        btn.classList.toggle('sp-active', active);
    });
    document.querySelectorAll('.picks-board-row').forEach(function(row) {
        row.style.display = (sport === 'ALL' || row.dataset.sport === sport) ? '' : 'none';
    });
}

(function(){
    var els = document.querySelectorAll('.reveal');
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){ e.target.classList.add('is-visible'); obs.unobserve(e.target); }
        });
    },{threshold:0.08});
    els.forEach(function(el){ obs.observe(el); });
})();
</script>
@endpush

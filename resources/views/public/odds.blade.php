@extends('layouts.public')
@section('title', 'Live Odds - INSPIN')

@push('styles')
<style>
.odds-grid { display:flex; flex-direction:column; gap:12px; }

.odds-card {
    background:#212121;
    border:1px solid rgba(255,252,238,.08);
    border-radius:12px;
    overflow:hidden;
    transition:border-color .2s;
}
.odds-card:hover { border-color:rgba(253,181,21,.25); }

.odds-header {
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:12px 18px;
    border-bottom:1px solid rgba(255,252,238,.06);
    flex-wrap:wrap;
    gap:8px;
}

.odds-body {
    display:grid;
    grid-template-columns:1fr repeat(4,auto);
    gap:0;
}
@media(max-width:700px){ .odds-body { grid-template-columns:1fr; } }
@media(max-width:600px){
    .odds-col { border-left:none; border-top:1px solid rgba(255,252,238,.04); }
    .odds-col:first-child { border-top:none; }
    .odds-col-header { padding:5px 14px; }
    .odds-val { padding:7px 14px; }
    .odds-header { padding:10px 14px; flex-wrap:wrap; gap:6px; }
    .odds-team-row { padding:8px 14px; }
}

.odds-team-col { padding:0; }
.odds-team-row {
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px 18px;
}
.odds-team-row:first-child { border-bottom:1px solid rgba(255,252,238,.04); }

.odds-col {
    display:flex;
    flex-direction:column;
    border-left:1px solid rgba(255,252,238,.05);
}
.odds-col-header {
    font-size:9px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.8px;
    color:#4a4a4a;
    padding:6px 20px;
    border-bottom:1px solid rgba(255,252,238,.04);
    text-align:center;
    white-space:nowrap;
}
.odds-val {
    display:flex;
    align-items:center;
    justify-content:center;
    padding:10px 20px;
    font-size:13px;
    font-weight:600;
    text-align:center;
    white-space:nowrap;
}
.odds-val:first-of-type { border-bottom:1px solid rgba(255,252,238,.04); }

.sport-badge {
    display:inline-block;
    padding:2px 9px;
    border-radius:20px;
    font-size:10px;
    font-weight:700;
    letter-spacing:.3px;
}
.fav { color:#FFFCEE; }
.dog { color:#FDB515; }
.over-val { color:#00D15B; }
.under-val { color:#ef4444; }
</style>
@endpush

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Live Odds</h1>
        <p class="section-sub">Real-time odds from top sportsbooks</p>

        @if($consensus->count() > 0)
        <div class="odds-grid">
            @foreach($consensus as $game)
            @php
                $mlAway = $game->moneyline_away ?? '';
                $mlHome = $game->moneyline_home ?? '';
                $awayIsFav = is_numeric(str_replace(['+','-'],'',ltrim($mlAway,'+'))) && str_starts_with(ltrim($mlAway),' ') === false && $mlAway !== '' && (int)str_replace('+','',$mlAway) < 0;
                $sportColors = ['NFL'=>['#3b82f6','#1e3a5f'],'NBA'=>['#ef4444','#3b0000'],'MLB'=>['#22c55e','#0a2e1a'],'NHL'=>['#a855f7','#2e1a45'],'NCAAF'=>['#f97316','#3b1a00'],'NCAAB'=>['#f97316','#3b1a00']];
                $sc = $sportColors[$game->league] ?? ['#FDB515','#2a1f00'];
            @endphp
            <div class="odds-card">
                {{-- Card header: sport badge + game time --}}
                <div class="odds-header">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span class="sport-badge" style="background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[0] }}44;">{{ $game->league }}</span>
                        <span style="font-size:14px;font-weight:600;color:#FFFCEE;">
                            {{ $game->away_team }} <span style="color:#4a4a4a;font-weight:400;margin:0 6px;">@</span> {{ $game->home_team }}
                        </span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
                        <svg width="13" height="13" fill="none" stroke="#6e6e6e" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        <span style="font-size:12px;color:#6e6e6e;font-weight:500;">
                            {{ $game->game_date?->format('M d') ?? 'TBD' }}
                            @if($game->game_date && $game->game_date->format('g:i A') !== '12:00 AM')
                                · {{ $game->game_date->format('g:i A') }} ET
                            @else
                                · TBD ET
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Odds body --}}
                <div class="odds-body">
                    {{-- Teams column --}}
                    <div class="odds-team-col">
                        <div class="odds-team-row">
                            <span style="font-size:12px;color:#6e6e6e;width:30px;text-align:center;font-weight:600;">AWY</span>
                            <span style="font-size:13px;font-weight:600;color:#FFFCEE;">{{ $game->away_team }}</span>
                        </div>
                        <div class="odds-team-row">
                            <span style="font-size:12px;color:#6e6e6e;width:30px;text-align:center;font-weight:600;">HME</span>
                            <span style="font-size:13px;font-weight:600;color:#FFFCEE;">{{ $game->home_team }}</span>
                        </div>
                    </div>

                    {{-- Moneyline --}}
                    <div class="odds-col">
                        <div class="odds-col-header">Moneyline</div>
                        @php
                            $mlA = $game->moneyline_away ?? '—';
                            $mlH = $game->moneyline_home ?? '—';
                            $mlAColor = (is_numeric(str_replace(['+'],'',$mlA)) && (int)str_replace('+','',$mlA) > 0) ? '#FDB515' : '#FFFCEE';
                            $mlHColor = (is_numeric(str_replace(['+'],'',$mlH)) && (int)str_replace('+','',$mlH) > 0) ? '#FDB515' : '#FFFCEE';
                        @endphp
                        <div class="odds-val" style="color:{{ $mlAColor }}">{{ $mlA }}</div>
                        <div class="odds-val" style="color:{{ $mlHColor }}">{{ $mlH }}</div>
                    </div>

                    {{-- Spread --}}
                    <div class="odds-col">
                        <div class="odds-col-header">Spread</div>
                        <div class="odds-val" style="color:#9a9a9a;">{{ $game->spread_away ?? '—' }}</div>
                        <div class="odds-val" style="color:#9a9a9a;">{{ $game->spread_home ?? '—' }}</div>
                    </div>

                    {{-- Total --}}
                    <div class="odds-col">
                        <div class="odds-col-header">Total</div>
                        <div class="odds-val over-val">{{ $game->total_over ?? '—' }}</div>
                        <div class="odds-val under-val">{{ $game->total_under ?? '—' }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:60px 0;">
            <div style="font-size:3rem;margin-bottom:16px;">📊</div>
            <h3 style="color:#FFFCEE;margin-bottom:8px;">No odds data available</h3>
            <p style="color:#6e6e6e;">Check back soon for live odds.</p>
        </div>
        @endif

        <div style="text-align:center;margin-top:32px;">
            <a href="{{ route('consensus') }}" style="display:inline-block;padding:12px 32px;border:1px solid #FDB515;color:#FDB515;border-radius:50px;font-weight:600;text-decoration:none;transition:background .18s;" onmouseover="this.style.background='rgba(253,181,21,.1)'" onmouseout="this.style.background='transparent'">View Consensus Data →</a>
        </div>
    </div>
</div>
@endsection

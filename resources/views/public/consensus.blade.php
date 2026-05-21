@extends('layouts.public')
@section('title', 'Top Consensus - INSPIN')

@push('styles')
<style>
.con-grid { display:flex; flex-direction:column; gap:12px; }

.con-card {
    background:#212121;
    border:1px solid rgba(255,252,238,.08);
    border-radius:12px;
    overflow:hidden;
    transition:border-color .2s;
}
.con-card:hover { border-color:rgba(253,181,21,.25); }

.con-header {
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:12px 18px;
    border-bottom:1px solid rgba(255,252,238,.06);
    flex-wrap:wrap;
    gap:8px;
}

.con-body {
    display:grid;
    grid-template-columns:200px repeat(3,1fr) 180px 180px;
    gap:0;
}
@media(max-width:1100px){ .con-body { grid-template-columns:150px repeat(3,1fr) 150px 150px; } }
@media(max-width:900px){ .con-body { grid-template-columns:1fr 1fr; } }
@media(max-width:600px){
    .con-body { grid-template-columns:1fr; }
    .con-col { border-left:none; border-top:1px solid rgba(255,252,238,.04); }
    .con-col:first-child { border-top:none; }
    .con-col-hdr { padding:5px 12px; }
    .con-val { padding:7px 12px; }
    .con-header { padding:10px 14px; flex-wrap:wrap; gap:6px; }
    .pct-bar-full { width:50px; }
    .pct-row { padding:8px 12px; }
}

.con-col {
    display:flex;
    flex-direction:column;
    border-left:1px solid rgba(255,252,238,.05);
}
.con-col:first-child { border-left:none; }

.con-col-hdr {
    font-size:9px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.8px;
    color:#4a4a4a;
    padding:7px 16px;
    border-bottom:1px solid rgba(255,252,238,.04);
    white-space:nowrap;
}

.con-val {
    display:flex;
    align-items:center;
    padding:10px 16px;
    font-size:13px;
    font-weight:600;
    white-space:nowrap;
}
.con-val:first-of-type { border-bottom:1px solid rgba(255,252,238,.04); }

.pct-row {
    display:flex;
    flex-direction:column;
    justify-content:center;
    gap:6px;
    padding:8px 16px;
}
.pct-bar-full { height:6px; background:#2a2a2a; border-radius:4px; overflow:hidden; }
.pct-num { font-size:13px; font-weight:700; }

.sport-badge {
    display:inline-block;
    padding:2px 9px;
    border-radius:20px;
    font-size:10px;
    font-weight:700;
    letter-spacing:.3px;
}
</style>
@endpush

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Top Consensus</h1>
        <p class="section-sub">See where the betting public is placing their money across all major sports</p>

        <div class="sport-filter">
            <a href="{{ route('consensus') }}" class="{{ !$sport ? 'active' : '' }}">All</a>
            <a href="{{ route('consensus', ['sport' => 'NFL']) }}" class="{{ $sport === 'NFL' ? 'active' : '' }}">NFL</a>
            <a href="{{ route('consensus', ['sport' => 'NCAAF']) }}" class="{{ $sport === 'NCAAF' ? 'active' : '' }}">NCAAF</a>
            <a href="{{ route('consensus', ['sport' => 'NBA']) }}" class="{{ $sport === 'NBA' ? 'active' : '' }}">NBA</a>
            <a href="{{ route('consensus', ['sport' => 'NCAAB']) }}" class="{{ $sport === 'NCAAB' ? 'active' : '' }}">NCAAB</a>
            <a href="{{ route('consensus', ['sport' => 'MLB']) }}" class="{{ $sport === 'MLB' ? 'active' : '' }}">MLB</a>
            <a href="{{ route('consensus', ['sport' => 'NHL']) }}" class="{{ $sport === 'NHL' ? 'active' : '' }}">NHL</a>
        </div>

        @forelse($consensus as $game)
        @php
            $sportColors = ['NFL'=>['#3b82f6','#1e3a5f'],'NBA'=>['#ef4444','#3b0000'],'MLB'=>['#22c55e','#0a2e1a'],'NHL'=>['#a855f7','#2e1a45'],'NCAAF'=>['#f97316','#3b1a00'],'NCAAB'=>['#f97316','#3b1a00']];
            $sc = $sportColors[$game->league] ?? ['#FDB515','#2a1f00'];
            $pub = $game->public_pct_home ?? 0;
            $mon = $game->money_pct_home ?? 0;
            $pubColor = $pub >= 60 ? '#00D15B' : ($pub >= 45 ? '#FDB515' : '#ef4444');
            $monColor = $mon >= 60 ? '#00D15B' : ($mon >= 45 ? '#FDB515' : '#ef4444');
            $mlA = $game->moneyline_away ?? '—';
            $mlH = $game->moneyline_home ?? '—';
            $mlAColor = (is_numeric(str_replace(['+'],'',$mlA)) && (int)str_replace('+','',$mlA) > 0) ? '#FDB515' : '#FFFCEE';
            $mlHColor = (is_numeric(str_replace(['+'],'',$mlH)) && (int)str_replace('+','',$mlH) > 0) ? '#FDB515' : '#FFFCEE';
        @endphp
        <div class="con-card" style="margin-bottom:10px;">
            {{-- Header --}}
            <div class="con-header">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span class="sport-badge" style="background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[0] }}44;">{{ $game->league }}</span>
                    <span style="font-size:14px;font-weight:600;color:#FFFCEE;">
                        {{ $game->away_team }} <span style="color:#4a4a4a;font-weight:400;margin:0 5px;">@</span> {{ $game->home_team }}
                    </span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
                    <svg width="13" height="13" fill="none" stroke="#6e6e6e" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    <span style="font-size:12px;color:#6e6e6e;">
                        {{ $game->game_date?->format('M d') ?? 'TBD' }}
                        @if($game->game_date && $game->game_date->format('g:i A') !== '12:00 AM')
                            · {{ $game->game_date->format('g:i A') }} ET
                        @else
                            · TBD ET
                        @endif
                    </span>
                </div>
            </div>

            {{-- Body --}}
            <div class="con-body">
                {{-- Teams --}}
                <div class="con-col">
                    <div class="con-col-hdr">Matchup</div>
                    <div class="con-val" style="color:#FFFCEE;">
                        <span style="font-size:11px;color:#6e6e6e;width:28px;font-weight:600;">AWY</span>
                        {{ $game->away_team }}
                    </div>
                    <div class="con-val" style="color:#FFFCEE;">
                        <span style="font-size:11px;color:#6e6e6e;width:28px;font-weight:600;">HME</span>
                        {{ $game->home_team }}
                    </div>
                </div>

                {{-- Moneyline --}}
                <div class="con-col">
                    <div class="con-col-hdr">Moneyline</div>
                    <div class="con-val" style="color:{{ $mlAColor }}">{{ $mlA }}</div>
                    <div class="con-val" style="color:{{ $mlHColor }}">{{ $mlH }}</div>
                </div>

                {{-- Spread --}}
                <div class="con-col">
                    <div class="con-col-hdr">Spread</div>
                    <div class="con-val" style="color:#9a9a9a;">{{ $game->spread_away ?? '—' }}</div>
                    <div class="con-val" style="color:#9a9a9a;">{{ $game->spread_home ?? '—' }}</div>
                </div>

                {{-- Total --}}
                <div class="con-col">
                    <div class="con-col-hdr">Total</div>
                    <div class="con-val" style="color:#00D15B;">{{ $game->total_over ?? '—' }}</div>
                    <div class="con-val" style="color:#ef4444;">{{ $game->total_under ?? '—' }}</div>
                </div>

                {{-- Public % --}}
                <div class="con-col">
                    <div class="con-col-hdr">Public Bettors %</div>
                    <div style="padding:12px 16px;display:flex;flex-direction:column;justify-content:center;gap:5px;height:100%;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                            <span style="font-size:11px;color:#6e6e6e;">Home</span>
                            <span class="pct-num" style="color:{{ $pubColor }}">{{ $pub }}%</span>
                        </div>
                        <div class="pct-bar-full">
                            <div style="width:{{ $pub }}%;height:100%;background:{{ $pubColor }};border-radius:4px;transition:width .3s;"></div>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-top:2px;">
                            <span style="font-size:10px;color:#4a4a4a;">Away {{ 100-$pub }}%</span>
                            <span style="font-size:10px;color:#4a4a4a;">Home {{ $pub }}%</span>
                        </div>
                    </div>
                </div>

                {{-- Money % --}}
                <div class="con-col">
                    <div class="con-col-hdr">Sharp Money %</div>
                    @if($mon)
                    <div style="padding:12px 16px;display:flex;flex-direction:column;justify-content:center;gap:5px;height:100%;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                            <span style="font-size:11px;color:#6e6e6e;">Home</span>
                            <span class="pct-num" style="color:{{ $monColor }}">{{ $mon }}%</span>
                        </div>
                        <div class="pct-bar-full">
                            <div style="width:{{ $mon }}%;height:100%;background:{{ $monColor }};border-radius:4px;transition:width .3s;"></div>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-top:2px;">
                            <span style="font-size:10px;color:#4a4a4a;">Away {{ 100-$mon }}%</span>
                            <span style="font-size:10px;color:#4a4a4a;">Home {{ $mon }}%</span>
                        </div>
                    </div>
                    @else
                    <div style="padding:12px 16px;color:#4a4a4a;font-size:13px;">—</div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:60px 0;">
            <div style="font-size:3rem;margin-bottom:16px;">📊</div>
            <h3 style="color:#FFFCEE;margin-bottom:8px;">No consensus data available</h3>
            <p style="color:#6e6e6e;">Check back soon.</p>
        </div>
        @endforelse

        <div style="margin-top:24px;">{{ $consensus->links() }}</div>
    </div>
</div>
@endsection

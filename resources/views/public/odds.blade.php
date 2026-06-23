@extends('layouts.public')
@section('title', 'Live Odds | Sportshandicapper')
@section('meta', 'Compare real-time lines across top sportsbooks for MLB, NBA, NFL, NHL, CFB and CBB.')

@push('styles')
<style>
.market-toggle { display:flex; gap:8px; margin-bottom:24px; flex-wrap:wrap; }
.market-btn {
    padding:8px 20px; border-radius:50px; font-size:13px; font-weight:600;
    font-family:'Inter', sans-serif; background:#0C1020; border:1px solid rgba(255,255,255,0.08);
    color:#94A3B8; cursor:pointer; transition:all .18s;
}
.market-btn:hover { background:rgba(255,255,255,0.04); border-color:rgba(255,255,255,0.15); color:white; }
.market-btn.active { background:rgba(30,144,255,0.1); border-color:#1E90FF; color:#1E90FF; box-shadow:0 0 12px rgba(30,144,255,.15); }

.odds-grid { display:flex; flex-direction:column; gap:12px; }

.odds-card {
    background:#0C1020;
    border:1px solid rgba(255,255,255,0.08);
    border-radius:12px;
    overflow:hidden;
    transition:border-color .2s;
}
.odds-card:hover { border-color:rgba(30,144,255,.35); }

.odds-header {
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:12px 18px;
    border-bottom:1px solid rgba(255,255,255,0.08);
    flex-wrap:wrap;
    gap:8px;
}

.sport-badge {
    display:inline-block;
    padding:2px 9px;
    border-radius:20px;
    font-size:10px;
    font-weight:700;
    letter-spacing:.3px;
    font-family:'Inter', sans-serif;
}

.team-badge {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:28px;
    height:28px;
    border-radius:50%;
    font-size:10px;
    font-weight:800;
    letter-spacing:.2px;
    flex-shrink:0;
    font-family:'Inter', sans-serif;
    box-shadow:0 0 0 1px rgba(255,255,255,.08);
}
.team-badge-sm { width:22px; height:22px; font-size:9px; }
.matchup-team { display:inline-flex; align-items:center; gap:8px; }
.matchup-at { color:#475569; font-weight:400; margin:0 6px; }
.odds-team-cell { display:flex; align-items:center; gap:8px; }

.odds-table-wrap { overflow-x:auto; }
.odds-table { width:100%; border-collapse:collapse; min-width:480px; }
.odds-table th, .odds-table td {
    padding:10px 14px;
    text-align:center;
    font-size:13px;
    font-weight:600;
    white-space:nowrap;
    border-bottom:1px solid rgba(255,255,255,.04);
    font-family:'JetBrains Mono', monospace;
}
.odds-table th {
    font-size:9px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.8px;
    color:#475569;
    padding:8px 14px;
    font-family:'Inter', sans-serif;
}
.odds-table td:first-child, .odds-table th:first-child {
    text-align:left;
    font-size:13px;
    font-weight:600;
    color:white;
    text-transform:none;
    letter-spacing:0;
    font-family:'Inter', sans-serif;
    position:sticky;
    left:0;
    background:#0C1020;
}
.odds-table tr:last-child td { border-bottom:none; }
.odds-cell-price { color:#94A3B8; }
.odds-cell-best { color:#1E90FF; }
.odds-cell-best::after { content:'★'; font-size:9px; margin-left:4px; vertical-align:middle; }
.odds-cell-na { color:#334155; }

.market-block { display:none; }
.market-block.active { display:table-row-group; }

.odds-sync-note {
    font-size:12px; color:#475569; text-align:right; margin-bottom:16px; font-family:'Inter', sans-serif;
}
.odds-mock-badge {
    display:inline-block; padding:2px 10px; border-radius:20px; font-size:10px;
    font-weight:700; letter-spacing:.5px; background:rgba(30,144,255,.12); color:#1E90FF;
    border:1px solid rgba(30,144,255,.3); margin-left:8px; text-transform:uppercase;
    font-family:'Inter', sans-serif;
}

@media(max-width:600px){
    .odds-header { padding:10px 14px; flex-wrap:wrap; gap:6px; }
    .odds-table th, .odds-table td { padding:8px 10px; font-size:12px; }
}
</style>
@endpush

@section('content')
<div class="section">
    <div class="container-x">
        <h1 class="section-title">
            Live Odds
            @if(!$liveConfigured)
                <span class="odds-mock-badge">Preview Data</span>
            @endif
        </h1>
        <p class="section-sub">Compare real-time lines across top sportsbooks</p>

        <div class="sport-filter">
            <a href="{{ route('odds') }}" class="{{ !$sport ? 'active' : '' }}">All</a>
            @foreach($sports as $s)
                <a href="{{ route('odds', ['sport' => $s]) }}" class="{{ $sport === $s ? 'active' : '' }}">{{ $s }}</a>
            @endforeach
        </div>

        <div class="market-toggle">
            <button type="button" class="market-btn active" data-market="h2h" onclick="setOddsMarket('h2h', this)">Moneyline</button>
            <button type="button" class="market-btn" data-market="spreads" onclick="setOddsMarket('spreads', this)">Spread</button>
            <button type="button" class="market-btn" data-market="totals" onclick="setOddsMarket('totals', this)">Total</button>
        </div>

        @if($lastSync)
        <div class="odds-sync-note">Last updated {{ $lastSync->diffForHumans() }}</div>
        @endif

        @if($games->count() > 0)
        <div class="odds-grid">
            @foreach($games as $game)
            @php
                $sportColors = ['NFL'=>['#3b82f6','#101a33'],'NBA'=>['#ef4444','#330f0f'],'MLB'=>['#22c55e','#0e2818'],'NHL'=>['#a855f7','#251433'],'NCAAF'=>['#22d3ee','#0e2730'],'NCAAB'=>['#22d3ee','#0e2730']];
                $sc = $sportColors[$game['sport_title']] ?? ['#1E90FF','#0c1a33'];
            @endphp
            <div class="odds-card">
                <div class="odds-header">
                    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
                        <span class="sport-badge" style="background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[0] }}44;">{{ $game['sport_title'] }}</span>
                        <span style="font-size:14px;font-weight:600;color:white;font-family:'Inter',sans-serif;">
                            <span class="matchup-team">
                                <span class="team-badge" style="background:{{ $game['away_brand']['bg'] }};color:{{ $game['away_brand']['fg'] }};">{{ $game['away_brand']['abbr'] }}</span>
                                {{ $game['away_team'] }}
                            </span>
                            <span class="matchup-at">@</span>
                            <span class="matchup-team">
                                <span class="team-badge" style="background:{{ $game['home_brand']['bg'] }};color:{{ $game['home_brand']['fg'] }};">{{ $game['home_brand']['abbr'] }}</span>
                                {{ $game['home_team'] }}
                            </span>
                        </span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
                        <svg width="13" height="13" fill="none" stroke="#475569" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        <span style="font-size:12px;color:#475569;font-weight:500;font-family:'Inter',sans-serif;">
                            {{ $game['commence_time']?->format('M d · g:i A') ?? 'TBD' }} ET
                        </span>
                    </div>
                </div>

                <div class="odds-table-wrap">
                    <table class="odds-table">
                        <thead>
                            <tr>
                                <th></th>
                                @foreach($game['books'] as $book)
                                    <th>{{ $book }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="market-block active" data-market="h2h">
                            @foreach($game['markets']['h2h'] as $row)
                            @php $brand = $row['label'] === $game['away_team'] ? $game['away_brand'] : $game['home_brand']; @endphp
                            <tr>
                                <td>
                                    <span class="odds-team-cell">
                                        <span class="team-badge team-badge-sm" style="background:{{ $brand['bg'] }};color:{{ $brand['fg'] }};">{{ $brand['abbr'] }}</span>
                                        {{ $row['label'] }}
                                    </span>
                                </td>
                                @foreach($row['cells'] as $cell)
                                    <td>
                                        @if($cell['price'] === null)
                                            <span class="odds-cell-na">—</span>
                                        @else
                                            <span class="{{ $cell['is_best'] ? 'odds-cell-best' : 'odds-cell-price' }}">{{ $cell['price'] > 0 ? '+'.$cell['price'] : $cell['price'] }}</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                        <tbody class="market-block" data-market="spreads">
                            @foreach($game['markets']['spreads'] as $row)
                            @php $brand = $row['label'] === $game['away_team'] ? $game['away_brand'] : $game['home_brand']; @endphp
                            <tr>
                                <td>
                                    <span class="odds-team-cell">
                                        <span class="team-badge team-badge-sm" style="background:{{ $brand['bg'] }};color:{{ $brand['fg'] }};">{{ $brand['abbr'] }}</span>
                                        {{ $row['label'] }}
                                    </span>
                                </td>
                                @foreach($row['cells'] as $cell)
                                    <td>
                                        @if($cell['price'] === null)
                                            <span class="odds-cell-na">—</span>
                                        @else
                                            <span class="{{ $cell['is_best'] ? 'odds-cell-best' : 'odds-cell-price' }}">
                                                {{ $cell['point'] > 0 ? '+'.$cell['point'] : $cell['point'] }}
                                                <small style="opacity:.7;">({{ $cell['price'] > 0 ? '+'.$cell['price'] : $cell['price'] }})</small>
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                        <tbody class="market-block" data-market="totals">
                            @foreach($game['markets']['totals'] as $row)
                            <tr>
                                <td>
                                    <span class="odds-team-cell">
                                        <span class="team-badge team-badge-sm" style="background:{{ $sc[1] }};color:{{ $sc[0] }};">{{ $row['label'] === 'Over' ? 'O' : 'U' }}</span>
                                        {{ $row['label'] }} {{ $row['cells'][0]['point'] ?? '' }}
                                    </span>
                                </td>
                                @foreach($row['cells'] as $cell)
                                    <td>
                                        @if($cell['price'] === null)
                                            <span class="odds-cell-na">—</span>
                                        @else
                                            <span class="{{ $cell['is_best'] ? 'odds-cell-best' : 'odds-cell-price' }}">{{ $cell['price'] > 0 ? '+'.$cell['price'] : $cell['price'] }}</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:60px 0;">
            <div style="font-size:3rem;margin-bottom:16px;">📊</div>
            <h3 style="color:white;margin-bottom:8px;">No odds data available</h3>
            <p style="color:#475569;">Check back soon for live odds.</p>
        </div>
        @endif

        <div style="text-align:center;margin-top:32px;">
            <a href="{{ route('consensus') }}" style="display:inline-block;padding:12px 32px;border:1px solid #1E90FF;color:#1E90FF;border-radius:50px;font-weight:600;text-decoration:none;transition:background .18s;font-family:'Inter',sans-serif;" onmouseover="this.style.background='rgba(30,144,255,.1)'" onmouseout="this.style.background='transparent'">View Consensus Data →</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function setOddsMarket(market, btn) {
    document.querySelectorAll('.market-btn').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    document.querySelectorAll('.market-block').forEach(function(block){
        block.classList.toggle('active', block.dataset.market === market);
    });
}
</script>
@endpush

@extends('layouts.subscriber')
@section('title', 'Live Odds | Sportshandicapper')
@section('page-title', 'Live Odds')

@push('styles')
<style>
.market-toggle { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; }
.market-btn {
    padding:8px 20px; border-radius:50px; font-size:13px; font-weight:600;
    font-family:'Inter', sans-serif; background:var(--inner); border:1px solid var(--bdr);
    color:rgba(255,255,255,.5); cursor:pointer; transition:all .18s;
}
.market-btn:hover { background:rgba(255,255,255,.05); color:#fff; }
.market-btn.active { background:rgba(30,144,255,.1); border-color:var(--accent); color:var(--accent); }

.sport-filter { display:flex; gap:6px; margin-bottom:20px; flex-wrap:wrap; }
.sport-filter a {
    padding:7px 16px; border-radius:50px; font-size:12.5px; font-weight:600;
    background:var(--inner); border:1px solid var(--bdr); color:rgba(255,255,255,.5); text-decoration:none;
}
.sport-filter a.active { background:var(--accent); border-color:var(--accent); color:#fff; }
.sport-filter a:hover:not(.active) { color:#fff; background:rgba(255,255,255,.05); }

.odds-grid { display:flex; flex-direction:column; gap:12px; }

.odds-card { background:var(--inner); border:1px solid var(--bdr); border-radius:14px; overflow:hidden; transition:border-color .2s; }
.odds-card:hover { border-color:rgba(30,144,255,.35); }

.odds-header { display:flex; align-items:center; justify-content:space-between; padding:13px 18px; border-bottom:1px solid var(--bdr); flex-wrap:wrap; gap:8px; }

.sport-badge { display:inline-block; padding:2px 9px; border-radius:20px; font-size:10px; font-weight:700; letter-spacing:.3px; }
.team-badge { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:50%; font-size:10px; font-weight:800; flex-shrink:0; box-shadow:0 0 0 1px rgba(255,255,255,.08); }
.team-badge-sm { width:22px; height:22px; font-size:9px; }
.matchup-team { display:inline-flex; align-items:center; gap:8px; }
.matchup-at { color:#475569; font-weight:400; margin:0 6px; }
.odds-team-cell { display:flex; align-items:center; gap:8px; }

.odds-table-wrap { overflow-x:auto; }
.odds-table { width:100%; border-collapse:collapse; min-width:480px; }
.odds-table th, .odds-table td { padding:10px 14px; text-align:center; font-size:13px; font-weight:600; white-space:nowrap; border-bottom:1px solid rgba(255,255,255,.04); }
.odds-table th { font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:.8px; color:#475569; padding:8px 14px; }
.odds-table td:first-child, .odds-table th:first-child { text-align:left; font-size:13px; font-weight:600; color:#f1f5f9; text-transform:none; letter-spacing:0; position:sticky; left:0; background:var(--inner); }
.odds-table tr:last-child td { border-bottom:none; }
.odds-cell-price { color:rgba(255,255,255,.5); }
.odds-cell-best { color:var(--accent); }
.odds-cell-best::after { content:'★'; font-size:9px; margin-left:4px; vertical-align:middle; }
.odds-cell-na { color:#334155; }

.market-block { display:none; }
.market-block.active { display:table-row-group; }

.odds-sync-note { font-size:12px; color:#475569; text-align:right; margin-bottom:16px; }
.odds-mock-badge { display:inline-block; padding:2px 10px; border-radius:20px; font-size:10px; font-weight:700; letter-spacing:.5px; background:rgba(30,144,255,.12); color:var(--accent); border:1px solid rgba(30,144,255,.3); margin-left:8px; text-transform:uppercase; }

@media(max-width:600px){
    .odds-header { padding:10px 14px; flex-wrap:wrap; gap:6px; }
    .odds-table th, .odds-table td { padding:8px 10px; font-size:12px; }
}
</style>
@endpush

@section('content')
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:20px;">
    <div>
        <div style="font-size:clamp(24px,3vw,32px);font-weight:800;color:#fff;letter-spacing:-.02em;">
            Live Odds
            @if(!$liveConfigured)
                <span class="odds-mock-badge">Preview Data</span>
            @endif
        </div>
        <div style="font-size:14.5px;color:rgba(255,255,255,.4);margin-top:5px;">Compare real-time lines across top sportsbooks.</div>
    </div>
</div>

<div class="sport-filter">
    <a href="/subscriber/odds" class="{{ !$sport ? 'active' : '' }}">All</a>
    @foreach($sports as $s)
        <a href="/subscriber/odds?sport={{ $s }}" class="{{ $sport === $s ? 'active' : '' }}">{{ $s }}</a>
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
                <span style="font-size:14px;font-weight:600;color:#f1f5f9;">
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
                <span style="font-size:12px;color:#475569;font-weight:500;">
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
<div class="dk" style="text-align:center;padding:60px 0;">
    <div style="font-size:3rem;margin-bottom:16px;">📊</div>
    <h3 style="color:#f1f5f9;margin-bottom:8px;">No odds data available</h3>
    <p style="color:#475569;">Check back soon for live odds.</p>
</div>
@endif

<div style="text-align:center;margin-top:28px;">
    <a href="/subscriber/consensus" style="display:inline-block;padding:12px 32px;border:1px solid var(--accent);color:var(--accent);border-radius:50px;font-weight:600;text-decoration:none;transition:background .18s;" onmouseover="this.style.background='rgba(30,144,255,.1)'" onmouseout="this.style.background='transparent'">View Consensus Data →</a>
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

@extends('layouts.public')
@section('title', 'Betting Trends - INSPIN')

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Betting Trends & Hot Streaks</h1>
        <p class="section-sub">Track betting trends, winning streaks, and performance by sport</p>

        {{-- Hot Streaks --}}
        @if(!empty($hotStreaks) && count($hotStreaks) > 0)
        <div style="margin-bottom:48px;">
            <h2 style="font-family:'Clash Display',sans-serif;font-size:1.3rem;font-weight:500;color:#FFFCEE;margin-bottom:6px;">🔥 Hot Streaks</h2>
            <p style="color:#6e6e6e;font-size:14px;margin-bottom:24px;">Current winning streaks across all sports</p>
            <div class="grid grid-3" style="gap:16px;">
                @foreach($hotStreaks as $hot)
                <div style="background:#212121;border:1px solid rgba(255,252,238,.08);border-left:3px solid #00D15B;border-radius:12px;padding:20px;transition:border-color .2s;" onmouseover="this.style.borderColor='rgba(253,181,21,.3)'" onmouseout="this.style.borderColor='rgba(255,252,238,.08)'">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                        <span style="font-weight:600;font-size:1rem;color:#FFFCEE;font-family:'Clash Display',sans-serif;">{{ $hot['sport'] }}</span>
                        <span style="background:rgba(0,209,91,.15);color:#00D15B;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;border:1px solid #00D15B;">🔥 {{ $hot['streak'] }}W</span>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:5px;font-size:13px;">
                        <div style="display:flex;justify-content:space-between;"><span style="color:#6e6e6e;">Period</span><span style="color:#9a9a9a;">{{ str_replace('_',' ',ucfirst($hot['period'])) }}</span></div>
                        <div style="display:flex;justify-content:space-between;"><span style="color:#6e6e6e;">Win Rate</span><span style="color:#00D15B;font-weight:700;">{{ $hot['win_rate'] }}%</span></div>
                        <div style="display:flex;justify-content:space-between;"><span style="color:#6e6e6e;">Record</span><span style="color:#9a9a9a;">{{ $hot['total_wins'] }}W-{{ $hot['total_losses'] }}L-{{ $hot['total_pushes'] }}P</span></div>
                        <div style="display:flex;justify-content:space-between;"><span style="color:#6e6e6e;">Units</span><span style="color:{{ $hot['units']>=0?'#00D15B':'#ef4444' }};font-weight:700;">{{ $hot['units']>=0?'+':'' }}{{ number_format($hot['units'],1) }}</span></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Streak Table --}}
        @if(!empty($streaks))
        <div style="margin-bottom:48px;">
            <h2 style="font-family:'Clash Display',sans-serif;font-size:1.3rem;font-weight:500;color:#FFFCEE;margin-bottom:20px;">📊 Streak Details by Sport</h2>
            <div style="overflow-x:auto;">
                <table class="c-table">
                    <thead>
                        <tr>
                            <th>Sport</th>
                            <th>Period</th>
                            <th>Current Streak</th>
                            <th>Best Streak</th>
                            <th>Win Rate</th>
                            <th>Record</th>
                            <th>Units</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($streaks as $sport => $periods)
                            @foreach($periods as $period => $data)
                            <tr>
                                <td><strong style="color:#FFFCEE;">{{ $sport }}</strong></td>
                                <td style="color:#9a9a9a;">{{ str_replace('_',' ',ucfirst($period)) }}</td>
                                <td style="color:#9a9a9a;">{{ $data['current_streak'] }}W</td>
                                <td style="color:#9a9a9a;">{{ $data['best_streak'] }}W</td>
                                <td><span style="color:{{ $data['win_rate']>=50?'#00D15B':'#ef4444' }};font-weight:700;">{{ $data['win_rate'] }}%</span></td>
                                <td style="color:#9a9a9a;">{{ $data['total_wins'] }}-{{ $data['total_losses'] }}-{{ $data['total_pushes'] }}</td>
                                <td><span style="color:{{ $data['total_units']>=0?'#00D15B':'#ef4444' }};font-weight:600;">{{ $data['total_units']>=0?'+':'' }}{{ number_format($data['total_units'],1) }}</span></td>
                                <td>
                                    @if($data['is_hot'])
                                        <span style="background:rgba(0,209,91,.15);color:#00D15B;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;border:1px solid #00D15B;">🔥 HOT</span>
                                    @else
                                        <span style="background:rgba(74,74,74,.3);color:#6e6e6e;padding:3px 10px;border-radius:20px;font-size:11px;">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Info Cards --}}
        <div class="grid grid-2" style="gap:20px;margin-bottom:36px;">
            <div class="card">
                <div class="card-body">
                    <h3>Public Betting Splits</h3>
                    <p>See what percentage of the public is betting on each side. Heavy public action can indicate sharp movement or public bias.</p>
                    <a href="{{ route('consensus') }}" style="display:inline-block;margin-top:14px;padding:9px 22px;border:1px solid #FDB515;color:#FDB515;border-radius:50px;font-size:13px;font-weight:600;text-decoration:none;transition:background .18s;" onmouseover="this.style.background='rgba(253,181,21,.1)'" onmouseout="this.style.background='transparent'">View Consensus →</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Sharp vs Public</h3>
                    <p>When the money percentage differs significantly from the public percentage, sharps may be on the opposite side.</p>
                    <a href="{{ route('consensus') }}" style="display:inline-block;margin-top:14px;padding:9px 22px;border:1px solid #FDB515;color:#FDB515;border-radius:50px;font-size:13px;font-weight:600;text-decoration:none;transition:background .18s;" onmouseover="this.style.background='rgba(253,181,21,.1)'" onmouseout="this.style.background='transparent'">View Consensus →</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>ATS Trends</h3>
                    <p>Against-the-spread records for teams and situations. Our simulation model tracks thousands of data points.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Over/Under Trends</h3>
                    <p>Total betting trends and scoring patterns. Identify games where the total may be mispriced.</p>
                </div>
            </div>
        </div>

        <div style="text-align:center;">
            <a href="{{ route('join') }}" style="display:inline-block;padding:13px 40px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;text-decoration:none;font-size:15px;box-shadow:0 0 20px rgba(253,181,21,.3);">Get Full Access to Trends Data</a>
        </div>
    </div>
</div>
@endsection

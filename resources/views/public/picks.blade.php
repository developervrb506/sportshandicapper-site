@extends('layouts.public')
@section('title', 'Picks - INSPIN')

@push('styles')
<style>
@media(max-width:600px){
    .grid.grid-2 { grid-template-columns:1fr !important; }
    .home-pick-card, .card { padding:16px !important; }
}
</style>
@endpush

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Expert Picks</h1>
        <p class="section-sub">Our latest betting picks across all sports</p>

        <div class="sport-filter">
            <a href="{{ route('picks') }}" class="{{ !$sport ? 'active' : '' }}">All</a>
            <a href="{{ route('picks', ['sport' => 'NFL']) }}" class="{{ $sport === 'NFL' ? 'active' : '' }}">NFL</a>
            <a href="{{ route('picks', ['sport' => 'NCAAF']) }}" class="{{ $sport === 'NCAAF' ? 'active' : '' }}">NCAAF</a>
            <a href="{{ route('picks', ['sport' => 'NBA']) }}" class="{{ $sport === 'NBA' ? 'active' : '' }}">NBA</a>
            <a href="{{ route('picks', ['sport' => 'NCAAB']) }}" class="{{ $sport === 'NCAAB' ? 'active' : '' }}">NCAAB</a>
            <a href="{{ route('picks', ['sport' => 'MLB']) }}" class="{{ $sport === 'MLB' ? 'active' : '' }}">MLB</a>
            <a href="{{ route('picks', ['sport' => 'NHL']) }}" class="{{ $sport === 'NHL' ? 'active' : '' }}">NHL</a>
        </div>

        @guest
        <div style="background:rgba(253,181,21,.06);border:1px solid rgba(253,181,21,.2);border-radius:12px;padding:16px 22px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div>
                <strong style="color:#FFFCEE;font-size:14px;">Login or join to see full pick details.</strong>
                <span style="color:#6e6e6e;font-size:13px;"> Game info and status are visible to all.</span>
            </div>
            <div style="display:flex;gap:10px;">
                <button onclick="openModal()" style="padding:9px 22px;background:transparent;color:#FDB515;border:1px solid #FDB515;border-radius:50px;font-weight:600;cursor:pointer;font-size:13px;transition:background .18s;" onmouseover="this.style.background='rgba(253,181,21,.1)'" onmouseout="this.style.background='transparent'">Log In</button>
                <a href="{{ route('join') }}" style="padding:9px 22px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;text-decoration:none;font-size:13px;box-shadow:0 0 16px rgba(253,181,21,.3);">Join Now</a>
            </div>
        </div>
        @endguest

        @if($picks->count() > 0)
        <div class="grid grid-2" style="gap:20px;">
            @foreach($picks as $pick)
            @php
                $rawTime = $pick->game_time ? (string)$pick->game_time : '00:00:00';
                $timeStr = strlen($rawTime) === 5 ? $rawTime.':00' : substr($rawTime, 0, 8);
                $gameStart = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pick->game_date->format('Y-m-d').' '.$timeStr, 'America/New_York');
                $now = \Carbon\Carbon::now('America/New_York');
                $status = $pick->result !== 'pending' ? 'Graded' : ($now->gte($gameStart) ? 'Started' : 'Active');
                $sportEmojis = ['MLB'=>'⚾','NFL'=>'🏈','NBA'=>'🏀','NHL'=>'🏒','NCAAF'=>'🏈','NCAAB'=>'🏀','MMA'=>'🥊','GOLF'=>'⛳'];
                $sEmoji = $sportEmojis[$pick->sport] ?? '🏅';
                $t1init = strtoupper(substr($pick->team1_name ?? 'TM', 0, 2));
                $t2init = strtoupper(substr($pick->team2_name ?? 'TM', 0, 2));
                $conf = $pick->team1_percent;
            @endphp
            <div class="card">
                <div class="card-body">
                    {{-- Header: Sport + Stars --}}
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:38px;height:38px;border-radius:50%;background:#2a2a2a;display:flex;align-items:center;justify-content:center;font-size:20px;border:1px solid rgba(255,252,238,.08);">{{ $sEmoji }}</div>
                            <div>
                                <div style="color:#FFFCEE;font-size:14px;font-weight:600;">{{ $pick->sport }}</div>
                                <div style="display:flex;gap:5px;margin-top:4px;flex-wrap:wrap;">
                                    @php
                                        $statusStyles = [
                                            'Started'=>'background:rgba(239,68,68,.15);border:1px solid #ef4444;color:#ef4444;',
                                            'Active' =>'background:rgba(0,209,91,.15);border:1px solid #00D15B;color:#00D15B;',
                                            'Graded' =>'background:rgba(100,100,100,.12);border:1px solid #4a4a4a;color:#9a9a9a;',
                                        ];
                                    @endphp
                                    <span style="{{ $statusStyles[$status] ?? '' }}font-size:13px;font-weight:800;padding:3px 10px;border-radius:20px;letter-spacing:.1px;">{{ $status }}</span>
                                    @if($pick->is_whale_exclusive)
                                        <span style="background:rgba(253,181,21,.12);border:1px solid #FDB515;color:#FDB515;font-size:12px;font-weight:800;padding:3px 10px;border-radius:20px;">🐋 WHALE</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:10px;color:#4a4a4a;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px;">Stars</div>
                            @if($pick->stars === 10)
                                <span style="color:#FDB515;font-size:11px;font-weight:800;">★10 WHALE</span>
                            @else
                                <span style="color:#FDB515;font-size:15px;">{{ str_repeat('★',(int)$pick->stars) }}</span><span style="color:#3a3a3a;font-size:15px;">{{ str_repeat('★',max(0,5-(int)$pick->stars)) }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Date/Time --}}
                    <div style="color:#6e6e6e;font-size:12px;margin-bottom:14px;">
                        @if($status === 'Started')<span class="live-dot" style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#ef4444;margin-right:5px;animation:livePulse 1.4s infinite;"></span>@endif
                        {{ $pick->game_date?->format('M d, Y') }}{{ $pick->game_time ? ' @ '.\Carbon\Carbon::parse($pick->game_time)->format('g:i A').' ET' : '' }}
                        @if($pick->venue) · <span style="color:#4a4a4a;">{{ $pick->venue }}</span>@endif
                    </div>

                    {{-- Teams combined + confidence --}}
                    <div style="margin-bottom:14px;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                            <div style="width:30px;height:30px;border-radius:50%;background:#2a2a2a;flex-shrink:0;display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid rgba(255,252,238,.08);">
                                @if($pick->team1_logo)
                                    <img src="{{ asset('storage/'.$pick->team1_logo) }}" style="width:22px;height:22px;object-fit:contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                                    <span style="display:none;font-size:8px;font-weight:800;color:#9a9a9a;">{{ $t1init }}</span>
                                @else
                                    <span style="font-size:8px;font-weight:800;color:#9a9a9a;">{{ $t1init }}</span>
                                @endif
                            </div>
                            <span style="color:#FFFCEE;font-size:14px;font-weight:600;">{{ $pick->team1_name }}</span>
                            <span style="color:#4a4a4a;font-size:12px;font-weight:500;">vs</span>
                            <div style="width:30px;height:30px;border-radius:50%;background:#2a2a2a;flex-shrink:0;display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid rgba(255,252,238,.08);">
                                @if($pick->team2_logo)
                                    <img src="{{ asset('storage/'.$pick->team2_logo) }}" style="width:22px;height:22px;object-fit:contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                                    <span style="display:none;font-size:8px;font-weight:800;color:#9a9a9a;">{{ $t2init }}</span>
                                @else
                                    <span style="font-size:8px;font-weight:800;color:#9a9a9a;">{{ $t2init }}</span>
                                @endif
                            </div>
                            <span style="color:#FFFCEE;font-size:14px;font-weight:600;">{{ $pick->team2_name }}</span>
                        </div>
                        @if($conf)
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                            <span style="{{ $statusStyles[$status] ?? '' }}font-size:12px;font-weight:800;padding:3px 10px;border-radius:20px;flex-shrink:0;">{{ $status }} Pick</span>
                            <span style="font-size:13px;font-weight:700;color:#FDB515;">{{ $conf }}% Confidence</span>
                        </div>
                        <div style="height:5px;background:#2a2a2a;border-radius:4px;overflow:hidden;">
                            <div style="width:{{ $conf }}%;height:100%;background:#FDB515;border-radius:4px;"></div>
                        </div>
                        @endif
                    </div>

                    {{-- Pick access: tier-based for logged-in users, locked for guests --}}
                    @auth
                        @if(auth()->user()->canViewPick($pick))
                        <div style="background:rgba(253,181,21,.06);border:1px solid rgba(253,181,21,.15);border-radius:10px;padding:12px 16px;margin-bottom:10px;">
                            <div style="font-size:10px;color:#FDB515;text-transform:uppercase;font-weight:700;margin-bottom:4px;letter-spacing:.4px;">The Pick</div>
                            <div style="font-size:15px;font-weight:600;color:#FFFCEE;">{{ $pick->pick }}</div>
                            @if($pick->units_result !== null)
                                <div style="margin-top:5px;font-size:12px;font-weight:600;color:{{ $pick->result==='win'?'#00D15B':($pick->result==='loss'?'#ef4444':'#FDB515') }};">
                                    {{ $pick->result==='win'?'+':'' }}{{ $pick->units_result }} units
                                </div>
                            @endif
                        </div>
                        @else
                        {{-- Logged in but not enough tier --}}
                        <div style="background:rgba(99,102,241,.06);border:1px solid rgba(99,102,241,.2);border-radius:10px;padding:14px 16px;margin-bottom:10px;text-align:center;">
                            <div style="font-size:18px;margin-bottom:6px;">⭐</div>
                            <div style="font-size:13px;font-weight:700;color:#FFFCEE;margin-bottom:4px;">{{ $pick->stars }}★ Pick — Upgrade Required</div>
                            <div style="font-size:12px;color:#6e6e6e;margin-bottom:12px;">Your package includes up to <strong style="color:#FFFCEE;">{{ auth()->user()->maxAccessibleStars() }}★</strong> picks. Upgrade to unlock {{ $pick->stars }}★ picks.</div>
                            <a href="{{ route('join') }}" style="display:inline-block;padding:9px 20px;background:#6366f1;color:#fff;border-radius:50px;font-weight:700;text-decoration:none;font-size:12px;">Upgrade Package</a>
                        </div>
                        @endif
                    @else
                    <div style="background:rgba(253,181,21,.04);border:1px solid rgba(253,181,21,.15);border-radius:10px;padding:16px;margin-bottom:10px;text-align:center;">
                        <div style="font-size:20px;margin-bottom:6px;">🔒</div>
                        <div style="font-size:13px;font-weight:700;color:#FFFCEE;margin-bottom:4px;">Members Only Pick</div>
                        <div style="font-size:12px;color:#6e6e6e;margin-bottom:12px;">Login or subscribe to unlock this pick</div>
                        <div style="display:flex;gap:8px;justify-content:center;">
                            <button onclick="openModal()" style="padding:9px 20px;background:transparent;color:#FDB515;border:1px solid #FDB515;border-radius:50px;font-weight:600;cursor:pointer;font-size:12px;">Log In</button>
                            <button onclick="openModal('join')" style="padding:9px 20px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;border:none;cursor:pointer;font-size:12px;">Subscribe</button>
                        </div>
                    </div>
                    @endauth

                    @if($pick->expert_name)
                    <div style="padding-top:10px;border-top:1px solid rgba(255,252,238,.06);display:flex;align-items:center;gap:8px;">
                        <div style="width:26px;height:26px;border-radius:50%;background:#FDB515;color:#171818;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;flex-shrink:0;">{{ substr($pick->expert_name,0,1) }}</div>
                        <span style="font-size:13px;color:#9a9a9a;">{{ $pick->expert_name }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:32px;">{{ $picks->links() }}</div>
        @else
        <div style="text-align:center;padding:60px 0;color:#4a4a4a;">
            <div style="font-size:3rem;margin-bottom:16px;">🏅</div>
            <h3 style="color:#FFFCEE;margin-bottom:8px;">No picks at this time</h3>
            <p style="color:#6e6e6e;">Check back soon for our latest picks.</p>
        </div>
        @endif
    </div>
</div>
@endsection

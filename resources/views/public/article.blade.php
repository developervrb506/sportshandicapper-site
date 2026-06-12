@extends('layouts.public')
@section('title', $article->title . ' - INSPIN')

@push('styles')
<style>
.art-wrap { display:{{ $article->supplements->count() > 0 ? 'flex' : 'block' }}; gap:40px; align-items:flex-start; max-width:{{ $article->supplements->count() > 0 ? '1200px' : '800px' }}; margin:0 auto; padding:52px 20px; }
@media(max-width:900px) {
    .art-wrap { flex-direction:column; padding:32px 16px; }
    .art-sidebar { width:100% !important; position:static !important; }
    .art-sidebar > div { position:static !important; }
}
@media(max-width:480px) {
    .art-wrap { padding:24px 14px; gap:24px; }
}
</style>
@endpush

@section('content')
@php $hasSups = $article->supplements->count() > 0; @endphp
<div style="background:#171818;min-height:60vh;">
<div class="art-wrap">

{{-- Main article column --}}
<div class="article-detail" style="flex:1;min-width:0;padding:0;background:none;min-height:unset;">
    <div style="display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap;">
        @php $sp=strtolower($article->sport??'');$bc=$sp==='mlb'?'rgba(22,163,74,.15)':($sp==='nba'?'rgba(220,38,38,.15)':($sp==='nfl'?'rgba(29,78,216,.15)':'rgba(253,181,21,.12)'));$tc=$sp==='mlb'?'#4ade80':($sp==='nba'?'#f87171':($sp==='nfl'?'#93c5fd':'#FDB515')); @endphp
        <span style="background:{{ $bc }};color:{{ $tc }};padding:3px 10px;border-radius:5px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">{{ $article->sport }}</span>
        <span style="background:rgba(36,251,238,.1);border:1px solid rgba(36,251,238,.25);color:#24FBEE;padding:3px 10px;border-radius:5px;font-size:10px;font-weight:600;">{{ $article->category }}</span>
        @if($article->is_premium)<span style="background:rgba(253,181,21,.12);color:#FDB515;padding:3px 10px;border-radius:5px;font-size:10px;font-weight:700;">PREMIUM</span>@endif
    </div>

    <h1>{{ $article->title }}</h1>

    <div class="meta">
        @if($article->expert_name)
            <span style="color:#9a9a9a;">By <strong style="color:#FFFCEE;">{{ $article->expert_name }}</strong></span>
        @elseif($article->author)
            <span style="color:#9a9a9a;">By <strong style="color:#FFFCEE;">{{ $article->author }}</strong></span>
        @endif
        <span style="color:#4a4a4a;">{{ $article->published_at?->format('F d, Y') ?? '' }} ET</span>
    </div>

    @if($article->excerpt)
    <p style="color:#9a9a9a;font-style:italic;border-left:3px solid #FDB515;padding-left:16px;margin-bottom:24px;">{{ $article->excerpt }}</p>
    @endif

    @if($article->featured_image)
    @php $sportGrads=['NHL'=>'linear-gradient(135deg,#0d2137,#0a3d6b)','NBA'=>'linear-gradient(135deg,#1a0d37,#3b1a6b)','MLB'=>'linear-gradient(135deg,#1a0d0d,#6b1a1a)','NFL'=>'linear-gradient(135deg,#1a1a0d,#5c4a0a)']; @endphp
    <div id="artHero" style="position:relative;border-radius:12px;margin-bottom:28px;overflow:hidden;background:{{ $sportGrads[$article->sport] ?? 'linear-gradient(135deg,#0d1224,#0a1a3d)' }};">
        <img src="@inspinAsset($article->featured_image)" alt="{{ $article->title }}"
             style="width:100%;max-height:420px;object-fit:cover;display:block;"
             onerror="this.style.display='none';document.getElementById('artHero').style.minHeight='180px'">
    </div>
    @endif

    @if($article->is_premium && (!auth()->check() || auth()->user()->role === 'free'))
        <div style="background:#212121;border:1px solid rgba(253,181,21,.2);border-radius:12px;padding:36px;text-align:center;margin:24px 0;">
            <div style="font-size:2.5rem;margin-bottom:14px;">🔒</div>
            <h3 style="color:#FFFCEE;margin-bottom:8px;font-family:'Exo 2',sans-serif;font-weight:500;">Premium Content</h3>
            <p style="color:#6e6e6e;margin-bottom:20px;">This article requires an active subscription to read.</p>
            <a href="{{ route('join') }}" style="display:inline-block;padding:12px 32px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;text-decoration:none;box-shadow:0 0 20px rgba(253,181,21,.3);">View Packages</a>
            @guest
            <p style="color:#4a4a4a;margin-top:14px;font-size:13px;">Already a member? <button onclick="openModal()" style="background:none;border:none;color:#FDB515;cursor:pointer;font-size:13px;font-weight:600;">Login here</button></p>
            @endguest
        </div>
    @else
        <div class="content">
            {!! $article->content !!}
        </div>

        @php $linkedPick = $article->relatedPicks->where('is_active', true)->first(); @endphp
        @if($linkedPick)
        <div style="margin-top:36px;padding-top:28px;border-top:1px solid rgba(253,181,21,.2);">
            <h2 style="color:#FFFCEE;margin-bottom:16px;font-size:1.2rem;font-family:'Exo 2',sans-serif;font-weight:500;">Today's Pick for This Game</h2>
            <div style="background:#212121;border-radius:12px;padding:24px;border:1px solid rgba(253,181,21,.15);">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:14px;">
                    <div style="display:flex;gap:8px;align-items:center;">
                        @php
                            $tRaw=$linkedPick->game_time?(string)$linkedPick->game_time:'00:00:00';
                            $tStr=strlen($tRaw)===5?$tRaw.':00':substr($tRaw,0,8);
                            $gStart=\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$linkedPick->game_date->format('Y-m-d').' '.$tStr,'America/New_York');
                            $pNow=\Carbon\Carbon::now('America/New_York');
                            $pStatus=$linkedPick->result!=='pending'?'Graded':($pNow->gte($gStart)?'Started':'Active');
                            $pStatusStyles=['Started'=>'background:rgba(239,68,68,.15);border:1px solid #ef4444;color:#ef4444;','Active'=>'background:rgba(0,209,91,.15);border:1px solid #00D15B;color:#00D15B;','Graded'=>'background:rgba(100,100,100,.12);border:1px solid #4a4a4a;color:#9a9a9a;'];
                        @endphp
                        <span style="background:rgba(253,181,21,.1);color:#FDB515;padding:3px 10px;border-radius:5px;font-size:11px;font-weight:700;">{{ $linkedPick->sport }}</span>
                        <span style="{{ $pStatusStyles[$pStatus] ?? '' }}font-size:13px;font-weight:800;padding:3px 10px;border-radius:20px;">{{ $pStatus }}</span>
                    </div>
                    <div style="color:#FDB515;font-size:16px;">
                        @if($linkedPick->stars===10)<span style="font-weight:800;font-size:12px;">★10 WHALE</span>
                        @else{{ str_repeat('★',$linkedPick->stars) }}@endif
                    </div>
                </div>
                <div style="font-size:1.1rem;font-weight:600;color:#FFFCEE;margin-bottom:6px;font-family:'Exo 2',sans-serif;">
                    {{ $linkedPick->team1_name }} <span style="color:#4a4a4a;font-size:13px;margin:0 6px;">vs</span> {{ $linkedPick->team2_name }}
                </div>
                <div style="color:#6e6e6e;font-size:13px;margin-bottom:16px;">
                    {{ $linkedPick->game_date?->format('M d, Y') }}{{ $linkedPick->game_time?' @ '.\Carbon\Carbon::parse($linkedPick->game_time)->format('g:i A').' ET':'' }}@if($linkedPick->venue) · {{ $linkedPick->venue }}@endif
                </div>
                @auth
                <div style="background:rgba(253,181,21,.06);border:1px solid rgba(253,181,21,.15);border-radius:10px;padding:14px 18px;">
                    <div style="font-size:10px;color:#FDB515;text-transform:uppercase;font-weight:700;margin-bottom:4px;letter-spacing:.4px;">The Pick</div>
                    <div style="font-size:1rem;font-weight:600;color:#FFFCEE;">{{ $linkedPick->pick }}</div>
                </div>
                @else
                <button onclick="openModal('join')" style="display:block;width:100%;padding:13px;background:#FDB515;color:#171818;border:none;border-radius:50px;font-weight:700;cursor:pointer;font-size:15px;box-shadow:0 0 20px rgba(253,181,21,.3);">
                    View Pick — Login or Join Now
                </button>
                @endauth
            </div>
        </div>
        @endif
    @endif

    @if($related->count() > 0)
    <div style="margin-top:48px;padding-top:28px;border-top:1px solid rgba(255,252,238,.06);">
        <h2 style="color:#FFFCEE;margin-bottom:20px;font-family:'Exo 2',sans-serif;font-weight:500;">Related Articles</h2>
        <div class="grid grid-3" style="gap:16px;">
            @foreach($related as $r)
            <a href="{{ route('article.show', $r) }}" style="text-decoration:none;background:#212121;border:1px solid rgba(255,252,238,.08);border-radius:10px;padding:16px;transition:border-color .2s;" onmouseover="this.style.borderColor='rgba(253,181,21,.3)'" onmouseout="this.style.borderColor='rgba(255,252,238,.08)'">
                @php $sp2=strtolower($r->sport??'');$bc2=$sp2==='mlb'?'rgba(22,163,74,.15)':($sp2==='nba'?'rgba(220,38,38,.15)':($sp2==='nfl'?'rgba(29,78,216,.15)':'rgba(253,181,21,.12)'));$tc2=$sp2==='mlb'?'#4ade80':($sp2==='nba'?'#f87171':($sp2==='nfl'?'#93c5fd':'#FDB515')); @endphp
                <span style="background:{{ $bc2 }};color:{{ $tc2 }};padding:2px 8px;border-radius:4px;font-size:10px;font-weight:700;text-transform:uppercase;">{{ $r->sport }}</span>
                <h3 style="margin-top:8px;font-size:13px;color:#FFFCEE;line-height:1.4;font-weight:500;font-family:'Exo 2',sans-serif;">{{ Str::limit($r->title, 60) }}</h3>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>{{-- end article-detail --}}

{{-- Supplements sidebar (only rendered if supplements exist) --}}
@if($hasSups)
<aside class="art-sidebar" style="width:300px;flex-shrink:0;">
    <div style="position:sticky;top:90px;display:flex;flex-direction:column;gap:16px;">
        <div style="padding-bottom:12px;border-bottom:1px solid rgba(255,252,238,.08);margin-bottom:4px;">
            <div style="font-family:'Exo 2',sans-serif;font-size:1rem;font-weight:500;color:#FFFCEE;">Game Analysis</div>
            <div style="font-size:11px;color:#6e6e6e;margin-top:2px;">AI-powered breakdown · Audio · Flashcards</div>
        </div>
        @foreach($article->supplements as $sup)
        <div style="background:#212121;border:1px solid rgba(255,252,238,.08);border-radius:12px;overflow:hidden;">

            @if($sup->type === 'ai_generated' && $sup->ai_content)
            @php $ai = json_decode($sup->ai_content, true); $aiIdx = $loop->index; @endphp

            {{-- Executive Summary --}}
            @if(!empty($ai['executive_summary']))
            <div style="padding:14px 16px;border-bottom:1px solid rgba(255,252,238,.06);background:rgba(253,181,21,.03);">
                <div style="font-size:10px;color:#FDB515;text-transform:uppercase;letter-spacing:.6px;font-weight:700;margin-bottom:7px;">📋 Executive Summary</div>
                <p style="font-size:13px;color:#c0c0c0;line-height:1.65;margin:0;">{{ $ai['executive_summary'] }}</p>
            </div>
            @endif

            {{-- Tweet summary --}}
            @if(!empty($ai['tweet']))
            <div style="padding:12px 16px;border-bottom:1px solid rgba(255,252,238,.06);background:rgba(29,161,242,.04);">
                <div style="font-size:10px;color:#1da1f2;text-transform:uppercase;letter-spacing:.6px;font-weight:700;margin-bottom:6px;">🐦 Quick Take</div>
                <p style="font-size:12.5px;color:#FFFCEE;line-height:1.5;margin:0;font-style:italic;">"{{ $ai['tweet'] }}"</p>
            </div>
            @endif

            {{-- Key Insights --}}
            @if(!empty($ai['insights']))
            <div style="padding:14px 16px;border-bottom:1px solid rgba(255,252,238,.06);">
                <div style="font-size:10px;color:#6366f1;text-transform:uppercase;letter-spacing:.6px;font-weight:700;margin-bottom:8px;">✨ Key Insights</div>
                @foreach($ai['insights'] as $ins)
                <div style="display:flex;gap:8px;margin-bottom:7px;font-size:12.5px;color:#c0c0c0;line-height:1.5;">
                    <span style="color:#FDB515;flex-shrink:0;margin-top:1px;">•</span><span>{{ $ins }}</span>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Sharp vs Public --}}
            @if(!empty($ai['debate']))
            <div style="padding:14px 16px;border-bottom:1px solid rgba(255,252,238,.06);">
                <div style="font-size:10px;color:#6366f1;text-transform:uppercase;letter-spacing:.6px;font-weight:700;margin-bottom:10px;">💬 Sharp vs Public</div>
                <div style="background:rgba(0,209,91,.06);border-left:3px solid #00D15B;padding:8px 12px;border-radius:0 6px 6px 0;margin-bottom:8px;">
                    <div style="font-size:9px;color:#00D15B;font-weight:700;margin-bottom:3px;letter-spacing:.4px;">SHARP MONEY</div>
                    <div style="font-size:12.5px;color:#c0c0c0;line-height:1.5;">{{ $ai['debate']['sharp'] ?? '' }}</div>
                </div>
                <div style="background:rgba(253,181,21,.06);border-left:3px solid #FDB515;padding:8px 12px;border-radius:0 6px 6px 0;">
                    <div style="font-size:9px;color:#FDB515;font-weight:700;margin-bottom:3px;letter-spacing:.4px;">PUBLIC BETTORS</div>
                    <div style="font-size:12.5px;color:#c0c0c0;line-height:1.5;">{{ $ai['debate']['public'] ?? '' }}</div>
                </div>
            </div>
            @endif

            {{-- Quick Stats --}}
            @if(!empty($ai['stats']))
            <div style="padding:14px 16px;border-bottom:1px solid rgba(255,252,238,.06);">
                <div style="font-size:10px;color:#6366f1;text-transform:uppercase;letter-spacing:.6px;font-weight:700;margin-bottom:8px;">📊 Quick Stats</div>
                @foreach($ai['stats'] as $stat)
                <div style="display:flex;gap:8px;margin-bottom:6px;font-size:12.5px;color:#c0c0c0;line-height:1.5;">
                    <span style="color:#3b82f6;flex-shrink:0;">›</span><span>{{ $stat }}</span>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Flashcards --}}
            @if(!empty($ai['flashcards']))
            <div style="padding:14px 16px;">
                <div style="font-size:10px;color:#6366f1;text-transform:uppercase;letter-spacing:.6px;font-weight:700;margin-bottom:10px;">🃏 Flashcards <span style="color:#4a4a4a;font-weight:400;font-size:9px;">(tap to reveal)</span></div>
                @foreach($ai['flashcards'] as $fi => $card)
                @php $cid = 'fc-'.$aiIdx.'-'.$fi; @endphp
                <div style="background:#1a1a1a;border:1px solid rgba(255,252,238,.07);border-radius:8px;margin-bottom:8px;overflow:hidden;">
                    <button onclick="toggleFlashcard('{{ $cid }}')"
                        style="width:100%;text-align:left;background:none;border:none;padding:10px 14px;cursor:pointer;display:flex;align-items:flex-start;justify-content:space-between;gap:8px;">
                        <span style="font-size:12.5px;color:#FFFCEE;font-weight:600;line-height:1.4;">{{ $card['q'] ?? '' }}</span>
                        <span id="{{ $cid }}-icon" style="color:#FDB515;font-size:16px;flex-shrink:0;line-height:1;transition:transform .2s;">+</span>
                    </button>
                    <div id="{{ $cid }}" style="display:none;padding:0 14px 12px;font-size:12.5px;color:#9a9a9a;line-height:1.6;border-top:1px solid rgba(255,252,238,.05);">
                        <div style="padding-top:10px;">{{ $card['a'] ?? '' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @else
            @php
                $embedIsUrl = $sup->embed_code && (str_starts_with(trim($sup->embed_code), 'http://') || str_starts_with(trim($sup->embed_code), 'https://'));
                $linkUrl = $embedIsUrl ? trim($sup->embed_code) : $sup->external_url;
                $isVideo = $sup->type === 'video';
                $isAudio = $sup->type === 'audio';
                $typeColors = ['video'=>['#a855f7','rgba(168,85,247,.08)'],'audio'=>['#00D15B','rgba(0,209,91,.08)'],'infographic'=>['#3b82f6','rgba(59,130,246,.08)'],'debate'=>['#FDB515','rgba(253,181,21,.08)']];
                $tc = $typeColors[$sup->type] ?? ['#9a9a9a','rgba(255,252,238,.05)'];
            @endphp

            {{-- Manual supplement (audio, video, image, link) --}}

            @if($isAudio && $sup->image_path)
                {{-- AI-generated audio: premium player card --}}
                <div style="background:linear-gradient(135deg,rgba(0,209,91,.08) 0%,rgba(0,0,0,0) 100%);border-bottom:1px solid rgba(0,209,91,.12);padding:16px 18px 14px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:13px;">
                        <div style="width:40px;height:40px;border-radius:50%;background:rgba(0,209,91,.15);border:1.5px solid rgba(0,209,91,.4);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 0 14px rgba(0,209,91,.2);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#00D15B" stroke-width="2.5"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/></svg>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:700;color:#FFFCEE;letter-spacing:-.1px;">Listen to This Analysis</div>
                            <div style="font-size:10px;color:#00D15B;margin-top:2px;font-weight:500;">● Audio Summary · ~2 min</div>
                        </div>
                    </div>
                    <audio controls style="width:100%;height:38px;border-radius:50px;outline:none;accent-color:#00D15B;">
                        <source src="@inspinAsset($sup->image_path)" type="audio/mpeg">
                    </audio>
                </div>

            @elseif($sup->image_path)
                {{-- Infographic: full image display --}}
                <div style="padding:12px 16px 10px;display:flex;align-items:center;gap:8px;border-bottom:1px solid rgba(255,252,238,.06);">
                    <span style="width:28px;height:28px;border-radius:6px;background:{{ $tc[1] }};display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">{{ $sup->type_icon }}</span>
                    <div>
                        <div style="font-size:9px;color:{{ $tc[0] }};text-transform:uppercase;letter-spacing:.6px;font-weight:700;">{{ ucfirst($sup->type) }}</div>
                        @if($sup->title)<div style="font-size:12px;font-weight:600;color:#FFFCEE;line-height:1.3;">{{ $sup->title }}</div>@endif
                    </div>
                </div>
                <img src="@inspinAsset($sup->image_path)" alt="{{ $sup->title }}" style="width:100%;display:block;border-radius:0 0 12px 12px;">

            @elseif($sup->embed_code && !$embedIsUrl && preg_match('/<iframe\s[^>]*src=["\']https?:\/\/[^"\']+["\'][^>]*>/i', $sup->embed_code))
                {{-- Iframe embed — validated to contain only safe iframe tags --}}
                <div style="padding:10px 14px 8px;display:flex;align-items:center;gap:8px;border-bottom:1px solid rgba(255,252,238,.06);">
                    <span style="width:28px;height:28px;border-radius:6px;background:{{ $tc[1] }};display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">{{ $sup->type_icon }}</span>
                    @if($sup->title)<div style="font-size:12px;font-weight:600;color:#FFFCEE;">{{ $sup->title }}</div>@endif
                </div>
                <div style="padding:0;">{!! $sup->embed_code !!}</div>

            @elseif($linkUrl)
                {{-- Link-based content (NotebookLM URL, audio link, video link) --}}
                <div style="padding:16px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                        <div style="width:32px;height:32px;border-radius:8px;background:{{ $tc[1] }};border:1px solid {{ $tc[0] }}33;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">
                            @if($isVideo)
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $tc[0] }}"><path d="M8 5v14l11-7z"/></svg>
                            @elseif($isAudio)
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $tc[0] }}" stroke-width="2"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                            @else
                                <span style="font-size:13px;">{{ $sup->type_icon }}</span>
                            @endif
                        </div>
                        <div>
                            <div style="font-size:9px;color:{{ $tc[0] }};text-transform:uppercase;letter-spacing:.7px;font-weight:700;">{{ ucfirst($sup->type) }}</div>
                            @if($sup->title)<div style="font-size:13px;font-weight:600;color:#FFFCEE;line-height:1.3;">{{ $sup->title }}</div>@endif
                        </div>
                    </div>
                    <a href="{{ $linkUrl }}" target="_blank" rel="noopener"
                       style="display:flex;align-items:center;justify-content:center;gap:8px;background:{{ $tc[0] }};color:#171818;font-size:13px;font-weight:700;text-decoration:none;padding:10px 16px;border-radius:8px;width:100%;transition:opacity .18s;"
                       onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                        @if($isVideo)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#171818"><path d="M8 5v14l11-7z"/></svg> Watch Now
                        @elseif($isAudio)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#171818" stroke-width="2.5"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/></svg> Listen Now
                        @else
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#171818" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg> View Content
                        @endif
                    </a>
                </div>
            @endif
            @endif

        </div>
        @endforeach
    </div>
</aside>
@endif

</div>{{-- end flex container --}}
</div>{{-- end bg wrapper --}}

@push('scripts')
<script>
function toggleFlashcard(id) {
    var el  = document.getElementById(id);
    var ico = document.getElementById(id + '-icon');
    var open = el.style.display !== 'none';
    el.style.display  = open ? 'none' : 'block';
    ico.textContent   = open ? '+' : '×';
    ico.style.transform = open ? 'rotate(0deg)' : 'rotate(45deg)';
}
</script>
@endpush
@endsection

@extends('layouts.subscriber')
@section('title', $article->title . ' - INSPIN')
@section('page-title', Str::limit($article->title, 50))

@push('styles')
<style>
.sub-art-layout { display:flex; gap:28px; align-items:flex-start; }
.sub-art-main   { flex:1; min-width:0; }
.sub-art-aside  { width:260px; flex-shrink:0; position:sticky; top:76px; }

@media(max-width:1000px){
    .sub-art-layout { flex-direction:column; }
    .sub-art-aside  { width:100%; position:static; }
}

/* Article body typography */
.art-body { color:#c8c8c8; line-height:1.85; font-size:15px; }
.art-body p { margin-bottom:16px; }
.art-body h2 { font-family:'Clash Display',sans-serif; color:#FFFCEE; font-size:1.25rem; font-weight:500; margin:28px 0 12px; }
.art-body h3 { font-family:'Clash Display',sans-serif; color:#FFFCEE; font-size:1.05rem; font-weight:500; margin:22px 0 10px; }
.art-body strong { color:#FFFCEE; }
.art-body a { color:#FDB515; }
.art-body ul, .art-body ol { padding-left:20px; margin-bottom:16px; }
.art-body li { margin-bottom:6px; }
.art-body table { width:100%; border-collapse:collapse; margin:20px 0; border-radius:10px; overflow:hidden; border:1px solid rgba(255,252,238,.08); }
.art-body table thead tr { background:#111; }
.art-body table thead th { padding:10px 14px; text-align:left; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#FDB515; border-bottom:1px solid rgba(255,252,238,.1); }
.art-body table tbody tr { background:#1a1a1a; }
.art-body table tbody tr:nth-child(even) { background:#141414; }
.art-body table tbody tr:hover { background:#212121; }
.art-body table tbody td { padding:9px 14px; font-size:13.5px; color:#c0c0c0; border-bottom:1px solid rgba(255,252,238,.04); }
.art-body table tbody td:first-child { color:#FFFCEE; font-weight:600; }

/* Sidebar supplement cards */
.sup-card { background:#141414; border:1px solid rgba(255,252,238,.08); border-radius:10px; overflow:hidden; margin-bottom:10px; }
.sup-section-label { font-size:9px; text-transform:uppercase; letter-spacing:.6px; color:#6e6e6e; font-weight:700; margin-bottom:8px; }
</style>
@endpush

@section('content')
@php
    $sp = strtolower($article->sport ?? '');
    $tc = $sp==='mlb'?'#4ade80':($sp==='nba'?'#f87171':($sp==='nfl'?'#93c5fd':'#FDB515'));
    $bc = $sp==='mlb'?'rgba(22,163,74,.12)':($sp==='nba'?'rgba(220,38,38,.12)':($sp==='nfl'?'rgba(29,78,216,.12)':'rgba(253,181,21,.1)'));
    $hasSups = $article->supplements->count() > 0;
@endphp

<div class="sub-art-layout">
    {{-- Main article --}}
    <div class="sub-art-main">

        {{-- Back link --}}
        <a href="/subscriber/articles" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;color:#6e6e6e;text-decoration:none;margin-bottom:20px;transition:color .15s;" onmouseover="this.style.color='#FDB515'" onmouseout="this.style.color='#6e6e6e'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Back to Articles
        </a>

        {{-- Badges --}}
        <div style="display:flex;gap:7px;margin-bottom:14px;flex-wrap:wrap;align-items:center;">
            <span style="background:{{ $bc }};color:{{ $tc }};padding:3px 10px;border-radius:6px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;">{{ $article->sport }}</span>
            <span style="color:#24FBEE;font-size:10px;font-weight:600;border:1px solid rgba(36,251,238,.2);padding:2px 9px;border-radius:6px;background:rgba(36,251,238,.05);">{{ $article->category }}</span>
            @if($article->is_premium)<span style="color:#FDB515;font-size:10px;font-weight:700;border:1px solid rgba(253,181,21,.25);padding:2px 8px;border-radius:6px;">PREMIUM</span>@endif
        </div>

        {{-- Title --}}
        <h1 style="font-family:'Clash Display',sans-serif;font-size:1.75rem;font-weight:500;color:#FFFCEE;line-height:1.3;margin-bottom:14px;">{{ $article->title }}</h1>

        {{-- Meta --}}
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:20px;padding-bottom:18px;border-bottom:1px solid rgba(255,252,238,.07);flex-wrap:wrap;">
            @if($article->expert_name || $article->author)
            <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:28px;height:28px;border-radius:50%;background:#FDB515;color:#171818;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;">{{ strtoupper(substr($article->expert_name ?? $article->author ?? 'A',0,1)) }}</div>
                <span style="font-size:12px;color:#9a9a9a;">{{ $article->expert_name ?? $article->author }}</span>
            </div>
            @endif
            <span style="font-size:12px;color:#6e6e6e;">{{ $article->published_at?->format('F d, Y') }}</span>
            <span style="font-size:11px;color:#4a4a4a;">{{ ceil(str_word_count(strip_tags($article->content ?? '')) / 200) }} min read</span>
        </div>

        {{-- Excerpt --}}
        @if($article->excerpt)
        <div style="background:rgba(253,181,21,.04);border-left:3px solid #FDB515;padding:12px 16px;border-radius:0 8px 8px 0;margin-bottom:20px;">
            <p style="color:#9a9a9a;font-style:italic;font-size:14px;line-height:1.65;margin:0;">{{ $article->excerpt }}</p>
        </div>
        @endif

        {{-- Featured image --}}
        @if($article->featured_image)
        <img src="@inspinAsset($article->featured_image)" alt="{{ $article->title }}"
             style="width:100%;max-height:420px;object-fit:cover;border-radius:12px;margin-bottom:24px;border:1px solid rgba(255,252,238,.08);">
        @endif

        {{-- Article body --}}
        <div class="art-body">{!! $article->content !!}</div>

        {{-- Related articles --}}
        @if($related->count() > 0)
        <div style="margin-top:36px;padding-top:24px;border-top:1px solid rgba(255,252,238,.07);">
            <h3 style="font-family:'Clash Display',sans-serif;font-size:1rem;font-weight:500;color:#FFFCEE;margin-bottom:14px;">Related Articles</h3>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                @foreach($related as $r)
                @php $rt = strtolower($r->sport??''); $rtc = $rt==='mlb'?'#4ade80':($rt==='nba'?'#f87171':($rt==='nfl'?'#93c5fd':'#FDB515')); @endphp
                <a href="/subscriber/articles/{{ $r->slug }}"
                   style="text-decoration:none;background:#141414;border:1px solid rgba(255,252,238,.07);border-radius:8px;padding:12px;transition:border-color .15s;"
                   onmouseover="this.style.borderColor='rgba(253,181,21,.3)'" onmouseout="this.style.borderColor='rgba(255,252,238,.07)'">
                    <div style="font-size:9px;color:{{ $rtc }};font-weight:700;text-transform:uppercase;margin-bottom:5px;">{{ $r->sport }}</div>
                    <div style="font-size:12px;color:#FFFCEE;line-height:1.4;font-family:'Clash Display',sans-serif;font-weight:400;">{{ Str::limit($r->title, 55) }}</div>
                    <div style="font-size:10px;color:#4a4a4a;margin-top:6px;">{{ $r->published_at?->format('M d') }}</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Sidebar (AI analysis + supplements) --}}
    @if($hasSups)
    <aside class="sub-art-aside">
        <div style="font-family:'Clash Display',sans-serif;font-size:.9rem;font-weight:500;color:#FFFCEE;margin-bottom:12px;padding-bottom:10px;border-bottom:1px solid rgba(255,252,238,.07);">Game Analysis</div>

        @foreach($article->supplements->sortBy('sort_order') as $sup)
        <div class="sup-card">

            @if($sup->type === 'ai_generated' && $sup->ai_content)
            @php $ai = json_decode($sup->ai_content, true); @endphp

            @if(!empty($ai['executive_summary']))
            <div style="padding:12px 14px;border-bottom:1px solid rgba(255,252,238,.05);background:rgba(253,181,21,.03);">
                <div class="sup-section-label">📋 Summary</div>
                <p style="font-size:12px;color:#c0c0c0;line-height:1.6;margin:0;">{{ $ai['executive_summary'] }}</p>
            </div>
            @endif

            @if(!empty($ai['tweet']))
            <div style="padding:10px 14px;border-bottom:1px solid rgba(255,252,238,.05);background:rgba(29,161,242,.03);">
                <div class="sup-section-label">🐦 Quick Take</div>
                <p style="font-size:11.5px;color:#FFFCEE;font-style:italic;line-height:1.5;margin:0;">"{{ $ai['tweet'] }}"</p>
            </div>
            @endif

            @if(!empty($ai['insights']))
            <div style="padding:12px 14px;border-bottom:1px solid rgba(255,252,238,.05);">
                <div class="sup-section-label">✨ Key Insights</div>
                @foreach($ai['insights'] as $ins)
                <div style="display:flex;gap:7px;margin-bottom:5px;font-size:11.5px;color:#c0c0c0;line-height:1.5;">
                    <span style="color:#FDB515;flex-shrink:0;">•</span><span>{{ $ins }}</span>
                </div>
                @endforeach
            </div>
            @endif

            @if(!empty($ai['debate']))
            <div style="padding:12px 14px;border-bottom:1px solid rgba(255,252,238,.05);">
                <div class="sup-section-label">💬 Sharp vs Public</div>
                <div style="background:rgba(0,209,91,.05);border-left:2px solid #00D15B;padding:8px 10px;border-radius:0 6px 6px 0;margin-bottom:7px;">
                    <div style="font-size:9px;color:#00D15B;font-weight:700;margin-bottom:3px;">SHARP</div>
                    <div style="font-size:11.5px;color:#c0c0c0;line-height:1.5;">{{ $ai['debate']['sharp'] ?? '' }}</div>
                </div>
                <div style="background:rgba(253,181,21,.05);border-left:2px solid #FDB515;padding:8px 10px;border-radius:0 6px 6px 0;">
                    <div style="font-size:9px;color:#FDB515;font-weight:700;margin-bottom:3px;">PUBLIC</div>
                    <div style="font-size:11.5px;color:#c0c0c0;line-height:1.5;">{{ $ai['debate']['public'] ?? '' }}</div>
                </div>
            </div>
            @endif

            @if(!empty($ai['flashcards']))
            <div style="padding:12px 14px;">
                <div class="sup-section-label">🃏 Flashcards <span style="font-weight:400;color:#4a4a4a;">(tap)</span></div>
                @foreach($ai['flashcards'] as $fi => $card)
                @php $fid = 'fc-s-'.$loop->parent->index.'-'.$fi; @endphp
                <div style="background:#1a1a1a;border:1px solid rgba(255,252,238,.06);border-radius:7px;margin-bottom:6px;overflow:hidden;">
                    <button onclick="var d=document.getElementById('{{ $fid }}');var i=document.getElementById('{{ $fid }}-i');var o=d.style.display==='none';d.style.display=o?'block':'none';i.textContent=o?'×':'+'"
                        style="width:100%;text-align:left;background:none;border:none;padding:8px 10px;cursor:pointer;display:flex;align-items:flex-start;justify-content:space-between;gap:6px;">
                        <span style="font-size:11.5px;color:#FFFCEE;font-weight:600;line-height:1.4;">{{ $card['q'] ?? '' }}</span>
                        <span id="{{ $fid }}-i" style="color:#FDB515;font-size:14px;flex-shrink:0;line-height:1;">+</span>
                    </button>
                    <div id="{{ $fid }}" style="display:none;padding:0 10px 9px;font-size:11.5px;color:#9a9a9a;line-height:1.55;border-top:1px solid rgba(255,252,238,.04);">
                        <div style="padding-top:8px;">{{ $card['a'] ?? '' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @elseif($sup->type === 'audio' && $sup->image_path)
            {{-- AI-generated audio: inline player --}}
            <div style="padding:14px 16px;background:linear-gradient(135deg,rgba(0,209,91,.06),transparent);">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:11px;">
                    <div style="width:36px;height:36px;border-radius:50%;background:rgba(0,209,91,.12);border:1.5px solid rgba(0,209,91,.35);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="14" height="14" fill="none" stroke="#00D15B" stroke-width="2.5" viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/></svg>
                    </div>
                    <div>
                        <div style="font-size:12px;font-weight:700;color:#FFFCEE;">Listen to This Analysis</div>
                        <div style="font-size:10px;color:#00D15B;margin-top:1px;">● Audio Summary · ~2 min</div>
                    </div>
                </div>
                <audio controls style="width:100%;height:36px;border-radius:50px;outline:none;accent-color:#00D15B;">
                    <source src="@inspinAsset($sup->image_path)" type="audio/mpeg">
                </audio>
            </div>

            @elseif($sup->image_path)
            <img src="@inspinAsset($sup->image_path)" alt="{{ $sup->title }}" style="width:100%;display:block;">

            @elseif($sup->external_url || ($sup->embed_code && str_starts_with(trim($sup->embed_code),'http')))
            @php $url = $sup->external_url ?: trim($sup->embed_code); @endphp
            <div style="padding:12px 14px;">
                @if($sup->title)<div style="font-size:12px;font-weight:600;color:#FFFCEE;margin-bottom:8px;">{{ $sup->title }}</div>@endif
                <a href="{{ $url }}" target="_blank"
                   style="display:block;text-align:center;padding:9px;border-radius:7px;font-size:12px;font-weight:700;text-decoration:none;
                          background:{{ $sup->type==='audio'?'#00D15B':($sup->type==='video'?'#a855f7':'#FDB515') }};
                          color:#171818;">
                    {{ $sup->type==='audio'?'🎧 Listen Now':($sup->type==='video'?'▶ Watch Now':'🔗 View') }}
                </a>
            </div>

            @elseif($sup->embed_code)
            @php
                // Only allow <iframe> tags — strip everything else to prevent XSS
                $safeEmbed = preg_match('/<iframe\s[^>]*src=["\']https?:\/\/[^"\']+["\'][^>]*>/i', $sup->embed_code)
                    ? $sup->embed_code : '';
            @endphp
            @if($safeEmbed)
            <div style="overflow:hidden;border-radius:0 0 10px 10px;">{!! $safeEmbed !!}</div>
            @endif
            @endif

        </div>
        @endforeach
    </aside>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Flashcard toggle already inline above
</script>
@endpush

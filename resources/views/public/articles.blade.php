@extends('layouts.public')
@section('title', 'Exclusive Articles | Sportshandicapper')
@section('meta', 'Expert sports betting articles, consensus analysis, and betting trends across NBA, NFL, MLB, and NHL.')

@push('styles')
<style>
.art-filter-btn { transition: all .15s; }
.art-grid { display:grid; grid-template-columns: repeat(3,1fr); gap: 40px; }
@media(max-width:1024px){ .art-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:640px){ .art-grid { grid-template-columns: 1fr; } .feat-grid { grid-template-columns: 1fr !important; } }
.art-card h3 { transition: color .2s; }
.art-card:hover h3 { color: #1E90FF; }
.feat-grid { display:grid; grid-template-columns: 1fr 1.1fr; gap: 48px; align-items: center; }
</style>
@endpush

@section('content')

@php
$staticArticles = [
    (object)['id'=>'a1','sport'=>'NHL','category'=>'Game Preview','title'=>'Colorado Avalanche vs Las Vegas Knights — Playoff edge analysis','excerpt'=>'MacKinnon meets Marner in a playoff clash that could define the series. Who holds the edge in Game 3?','author'=>'Mike Davis','published_at'=>\Carbon\Carbon::parse('2026-05-24'),'read_time'=>'6 min','featured_image'=>null,'featured'=>true],
    (object)['id'=>'a2','sport'=>'NBA','category'=>'Game Preview','title'=>'Oklahoma City Thunder vs San Antonio Spurs — Where the smart money sits','excerpt'=>'OKC leads 2-1 but San Antonio fights back at home. Game 4 is a must-watch and the line has moved.','author'=>'David Wilson','published_at'=>\Carbon\Carbon::parse('2026-05-24'),'read_time'=>'5 min','featured_image'=>null,'featured'=>false],
    (object)['id'=>'a3','sport'=>'NFL','category'=>'Best Bets','title'=>'DC Defenders vs Orlando Storm — Full breakdown and best bets','excerpt'=>'The Defenders invade Orlando on May 22nd. Can the Storm\'s offense hold the fort? Full breakdown inside.','author'=>'Dave Johnson','published_at'=>\Carbon\Carbon::parse('2026-05-22'),'read_time'=>'7 min','featured_image'=>null,'featured'=>false],
    (object)['id'=>'a4','sport'=>'MLB','category'=>'Trends','title'=>'Phillies vs Rockies — Why the road dogs keep cashing at Coors','excerpt'=>'A look at three trends quietly moving the needle on NL West totals this month.','author'=>'M. Rinner','published_at'=>\Carbon\Carbon::parse('2026-05-21'),'read_time'=>'4 min','featured_image'=>null,'featured'=>false],
    (object)['id'=>'a5','sport'=>'NBA','category'=>'Consensus','title'=>'Where the public is wrong on tonight\'s NBA slate','excerpt'=>'Three games where the consensus and sharp money are heading in opposite directions.','author'=>'Mike Davis','published_at'=>\Carbon\Carbon::parse('2026-05-20'),'read_time'=>'5 min','featured_image'=>null,'featured'=>false],
    (object)['id'=>'a6','sport'=>'NHL','category'=>'Series Outlook','title'=>'Eastern Conference Final — Goalie matchup is the whole story','excerpt'=>'Save percentage, high-danger chances, and what the model says about the series price.','author'=>'D. Wilson','published_at'=>\Carbon\Carbon::parse('2026-05-19'),'read_time'=>'6 min','featured_image'=>null,'featured'=>false],
    (object)['id'=>'a7','sport'=>'NFL','category'=>'Futures','title'=>'Early Week 1 lines — Three sides worth grabbing now','excerpt'=>'The market is thin and the numbers are soft. Three lines that should move by August.','author'=>'Dave Johnson','published_at'=>\Carbon\Carbon::parse('2026-05-18'),'read_time'=>'5 min','featured_image'=>null,'featured'=>false],
];

$hasReal     = $articles->count() > 0;
$allItems    = $hasReal ? $articles->getCollection() : collect($staticArticles);
$totalCount  = $hasReal ? $articles->total() : count($staticArticles);
$featured    = $allItems->firstWhere('featured', true) ?? $allItems->first();
$rest        = $allItems->filter(fn($a) => $a->id !== $featured->id)->values();
@endphp

<div class="container-x" style="padding-top:48px;padding-bottom:80px;">

    {{-- HEADER --}}
    <div class="reveal" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:24px;padding-bottom:40px;border-bottom:1px solid rgba(255,255,255,0.06);">
        <div>
            <div style="display:inline-flex;align-items:center;gap:8px;padding:5px 12px;border-radius:6px;border:1px solid rgba(30,144,255,0.3);background:rgba(30,144,255,0.05);margin-bottom:20px;">
                <span style="width:6px;height:6px;border-radius:50%;background:#1E90FF;flex-shrink:0;"></span>
                <span style="font-size:10px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#1E90FF;">Editorial &middot; Updated daily</span>
            </div>
            <h1 style="font-size:clamp(2.5rem,5vw,4rem);font-weight:900;line-height:0.95;letter-spacing:-0.03em;color:white;margin:0 0 20px;">
                Articles &amp; <span style="color:#1E90FF;">Analysis.</span>
            </h1>
            <p style="color:#94A3B8;font-size:15px;line-height:1.7;max-width:520px;margin:0;">
                Expert betting articles, consensus reads, and trends. Written before the lines move, archived after the final whistle.
            </p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:32px;text-align:center;">
            @foreach([[str_pad($totalCount,2,'0',STR_PAD_LEFT),'This week'],['4','Leagues'],['3','Writers']] as $s)
            <div>
                <div style="font-size:2rem;font-weight:900;color:white;font-family:monospace;line-height:1;">{{ $s[0] }}</div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;color:#64748B;margin-top:4px;">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="reveal" style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;margin-top:32px;margin-bottom:40px;">
        <div style="display:flex;flex-wrap:wrap;gap:6px;">
            @foreach(['ALL','NFL','NBA','MLB','NHL'] as $l)
            <button onclick="filterArts('{{ $l }}')" data-league="{{ $l }}" class="art-filter-btn" style="padding:6px 14px;border-radius:6px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;border:1px solid {{ $l==='ALL'?'#1E90FF':'rgba(255,255,255,0.1)' }};background:{{ $l==='ALL'?'#1E90FF':'rgba(255,255,255,0.04)' }};color:{{ $l==='ALL'?'white':'#94A3B8' }};cursor:pointer;font-family:Inter,sans-serif;">{{ $l }}</button>
            @endforeach
        </div>
        <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#64748B;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>
            <span id="artCount">{{ $totalCount }} articles</span>
        </div>
    </div>

    {{-- FEATURED --}}
    @if($featured)
    <div class="reveal feat-grid art-item" data-league="{{ $featured->sport }}" id="featuredRow"
         style="padding-bottom:48px;border-bottom:1px solid rgba(255,255,255,0.06);margin-bottom:48px;cursor:pointer;"
         onclick="window.location='{{ $hasReal ? route('article.show', $featured) : route('articles') }}'">
        <div>
            <div style="display:flex;align-items:center;gap:10px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;margin-bottom:16px;">
                <span style="color:#1E90FF;">{{ $featured->sport }}</span>
                <span style="height:1px;width:20px;background:rgba(255,255,255,0.1);display:inline-block;"></span>
                <span style="color:#64748B;">{{ $featured->category ?? 'Featured' }}</span>
            </div>
            <h2 style="font-size:clamp(1.5rem,2.5vw,2.25rem);font-weight:900;line-height:1.05;letter-spacing:-0.02em;color:white;margin-bottom:16px;transition:color .2s;" onmouseover="this.style.color='#1E90FF'" onmouseout="this.style.color='white'">
                {{ $featured->title }}
            </h2>
            <p style="color:#94A3B8;font-size:14px;line-height:1.75;margin-bottom:24px;max-width:480px;">{{ $featured->excerpt ?? '' }}</p>
            <div style="display:flex;align-items:center;gap:16px;font-size:11px;color:#64748B;margin-bottom:24px;flex-wrap:wrap;">
                <span style="font-weight:600;color:#cbd5e1;">{{ $featured->author }}</span>
                <span>·</span>
                <span style="font-family:monospace;">{{ $featured->published_at?->format('M d, Y') }}</span>
                @if(isset($featured->read_time) && $featured->read_time)
                <span>·</span>
                <span style="display:flex;align-items:center;gap:4px;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $featured->read_time }}
                </span>
                @endif
            </div>
            <div style="display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#1E90FF;">
                Read article
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </div>
        </div>

        <div style="position:relative;aspect-ratio:16/10;border-radius:12px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);background:linear-gradient(135deg,#0A0C1C,#0d1024,rgba(30,144,255,0.08));">
            @if(!empty($featured->featured_image))
            <img src="{{ asset('storage/'.$featured->featured_image) }}" alt="{{ $featured->title }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.75;">
            @endif
            <div style="position:absolute;inset:0;opacity:0.04;background-image:repeating-linear-gradient(90deg,rgba(255,255,255,1) 0 1px,transparent 1px 80px);"></div>
            <div style="position:absolute;bottom:16px;left:16px;right:16px;display:flex;align-items:flex-end;justify-content:space-between;">
                <span style="font-size:5rem;font-weight:900;color:rgba(255,255,255,0.05);font-family:monospace;line-height:1;">{{ strtoupper(substr($featured->sport ?? 'SPT',0,3)) }}</span>
                <span style="padding:4px 10px;border-radius:4px;border:1px solid rgba(30,144,255,0.4);background:rgba(30,144,255,0.1);font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#1E90FF;">Featured</span>
            </div>
        </div>
    </div>
    @endif

    {{-- ARTICLE GRID --}}
    <div class="art-grid" id="artGrid">
        @foreach($rest as $i=>$art)
        <article class="art-card reveal art-item" data-league="{{ $art->sport }}"
                 style="display:flex;flex-direction:column;cursor:pointer;transition-delay:{{ min($i,6)*0.06 }}s;"
                 onclick="window.location='{{ $hasReal ? route('article.show', $art) : route('articles') }}'">
            <div style="display:flex;align-items:center;gap:10px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;margin-bottom:12px;">
                <span style="color:#1E90FF;">{{ $art->sport }}</span>
                <span style="height:1px;width:14px;background:rgba(255,255,255,0.1);display:inline-block;"></span>
                <span style="color:#64748B;">{{ $art->category ?? 'Analysis' }}</span>
            </div>
            <h3 style="font-size:15px;font-weight:700;line-height:1.4;color:white;margin-bottom:10px;flex:1;">{{ $art->title }}</h3>
            <p style="font-size:13px;color:#64748B;line-height:1.65;margin-bottom:16px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{{ $art->excerpt ?? '' }}</p>
            <div style="padding-top:14px;border-top:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:space-between;font-size:11px;color:#64748B;">
                <span style="font-weight:600;color:#94A3B8;">{{ $art->author }}</span>
                <span style="display:flex;align-items:center;gap:4px;font-family:monospace;">
                    @if(isset($art->read_time) && $art->read_time)
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $art->read_time }}
                    @else
                    {{ $art->published_at?->format('M d, Y') }}
                    @endif
                </span>
            </div>
        </article>
        @endforeach
    </div>

    {{-- NO RESULTS --}}
    <div id="artNoResults" style="display:none;padding:80px 0;text-align:center;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#334155" stroke-width="1.5" stroke-linecap="round" style="margin:0 auto 16px;display:block;"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>
        <p style="color:#64748B;font-size:13px;margin:0;">No articles in this league yet.</p>
    </div>

    {{-- PAGINATION --}}
    @if($hasReal && $articles->hasPages())
    <div style="margin-top:48px;display:flex;justify-content:center;">{{ $articles->links() }}</div>
    @endif

    {{-- CTA --}}
    <div class="reveal" style="margin-top:64px;padding-top:40px;border-top:1px solid rgba(255,255,255,0.06);display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:20px;">
        <div>
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;color:#64748B;margin-bottom:8px;">Members</div>
            <p style="font-size:18px;font-weight:700;color:white;margin:0;">Get every article the moment it's published.</p>
        </div>
        <a href="{{ route('join') }}" class="btn-primary">
            Become a Member
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
function filterArts(league) {
    document.querySelectorAll('.art-filter-btn').forEach(function(btn) {
        var active = btn.dataset.league === league;
        btn.style.background = active ? '#1E90FF' : 'rgba(255,255,255,0.04)';
        btn.style.borderColor = active ? '#1E90FF' : 'rgba(255,255,255,0.1)';
        btn.style.color = active ? 'white' : '#94A3B8';
    });
    var featured = document.getElementById('featuredRow');
    var items = document.querySelectorAll('#artGrid .art-item');
    var visible = 0;
    if(featured) {
        var show = league === 'ALL' || featured.dataset.league === league;
        featured.style.display = show ? '' : 'none';
        if(show) visible++;
    }
    items.forEach(function(item) {
        var show = league === 'ALL' || item.dataset.league === league;
        item.style.display = show ? '' : 'none';
        if(show) visible++;
    });
    var noRes = document.getElementById('artNoResults');
    if(noRes) noRes.style.display = visible === 0 ? 'block' : 'none';
    var cnt = document.getElementById('artCount');
    if(cnt) cnt.textContent = visible + ' articles';
}

(function(){
    var els = document.querySelectorAll('.reveal');
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('is-visible'); obs.unobserve(e.target); } });
    },{threshold:0.1});
    els.forEach(function(el){ obs.observe(el); });
})();
</script>
@endpush

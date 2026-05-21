@extends('layouts.public')
@section('title', 'Articles - INSPIN')

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Articles & Analysis</h1>
        <p class="section-sub">Expert sports betting articles, consensus analysis, and betting trends</p>

        <div class="sport-filter">
            <a href="{{ route('articles') }}" class="{{ !$sport ? 'active' : '' }}">All</a>
            <a href="{{ route('articles', ['sport' => 'NFL']) }}" class="{{ $sport === 'NFL' ? 'active' : '' }}">NFL</a>
            <a href="{{ route('articles', ['sport' => 'NBA']) }}" class="{{ $sport === 'NBA' ? 'active' : '' }}">NBA</a>
            <a href="{{ route('articles', ['sport' => 'MLB']) }}" class="{{ $sport === 'MLB' ? 'active' : '' }}">MLB</a>
            <a href="{{ route('articles', ['sport' => 'NHL']) }}" class="{{ $sport === 'NHL' ? 'active' : '' }}">NHL</a>
        </div>

        <div class="grid grid-3" style="gap:20px;">
            @forelse($articles as $article)
            <a href="{{ route('article.show', $article) }}" style="text-decoration:none;display:flex;flex-direction:column;background:#212121;border:1px solid rgba(255,252,238,.08);border-radius:12px;overflow:hidden;transition:border-color .2s,transform .2s,box-shadow .2s;" onmouseover="this.style.borderColor='rgba(253,181,21,.3)';this.style.transform='translateY(-3px)';this.style.boxShadow='0 16px 48px rgba(0,0,0,.6)'" onmouseout="this.style.borderColor='rgba(255,252,238,.08)';this.style.transform='none';this.style.boxShadow='none'">
                @if($article->featured_image)
                    <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}" style="width:100%;height:180px;object-fit:cover;display:block;">
                @else
                    <div style="width:100%;height:180px;background:#2a2a2a;display:flex;align-items:center;justify-content:center;font-size:2.5rem;">🏅</div>
                @endif
                <div style="padding:18px;display:flex;flex-direction:column;flex:1;">
                    <div style="display:flex;gap:6px;margin-bottom:10px;flex-wrap:wrap;">
                        @php
                            $sp = strtolower($article->sport ?? '');
                            $bc = $sp==='mlb'?'rgba(22,163,74,.15)':($sp==='nba'?'rgba(220,38,38,.15)':($sp==='nfl'?'rgba(29,78,216,.15)':'rgba(253,181,21,.12)'));
                            $tc = $sp==='mlb'?'#4ade80':($sp==='nba'?'#f87171':($sp==='nfl'?'#93c5fd':'#FDB515'));
                        @endphp
                        <span style="background:{{ $bc }};color:{{ $tc }};padding:3px 10px;border-radius:5px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">{{ $article->sport }}</span>
                        <span style="background:rgba(36,251,238,.1);border:1px solid rgba(36,251,238,.25);color:#24FBEE;padding:2px 8px;border-radius:5px;font-size:10px;font-weight:600;">{{ $article->category }}</span>
                        @if($article->is_premium)<span style="background:rgba(253,181,21,.12);color:#FDB515;padding:2px 8px;border-radius:5px;font-size:10px;font-weight:700;">PREMIUM</span>@endif
                    </div>
                    <h3 style="font-family:'Clash Display',sans-serif;font-size:14px;font-weight:500;color:#FFFCEE;line-height:1.4;margin-bottom:8px;flex:1;">{{ Str::limit($article->title, 80) }}</h3>
                    <p style="font-size:13px;color:#6e6e6e;line-height:1.55;margin-bottom:14px;">{{ Str::limit(strip_tags($article->excerpt ?? ''), 110) }}</p>
                    <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,252,238,.06);padding-top:11px;">
                        <div style="display:flex;align-items:center;gap:7px;">
                            <div style="width:24px;height:24px;border-radius:50%;background:#FDB515;color:#171818;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;flex-shrink:0;">{{ substr($article->author ?? 'A',0,1) }}</div>
                            <span style="font-size:12px;color:#9a9a9a;">{{ $article->author }}</span>
                        </div>
                        <span style="font-size:12px;color:#4a4a4a;">{{ $article->published_at?->format('M d, Y') ?? '' }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:#4a4a4a;">
                <div style="font-size:3rem;margin-bottom:16px;">📰</div>
                <h3 style="color:#FFFCEE;margin-bottom:8px;">No articles found</h3>
                <p style="color:#6e6e6e;">Check back soon for new articles.</p>
            </div>
            @endforelse
        </div>

        <div style="margin-top:32px;">{{ $articles->links() }}</div>
    </div>
</div>
@endsection

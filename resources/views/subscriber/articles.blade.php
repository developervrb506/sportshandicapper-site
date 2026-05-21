@extends('layouts.subscriber')
@section('title','Articles - INSPIN')
@section('page-title','Exclusive Articles')

@push('styles')
<style>
.art-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
@media(max-width:1100px){ .art-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:640px)  { .art-grid { grid-template-columns:1fr; } }
.filter-pill { padding:6px 14px; border-radius:50px; font-size:12px; font-weight:600; text-decoration:none; border:1px solid rgba(255,255,255,.12); color:rgba(255,255,255,.4); background:transparent; transition:all .15s; }
.filter-pill.active { border-color:var(--gold); color:var(--gold); background:rgba(253,181,21,.06); }
</style>
@endpush

@section('content')
@php
$sportColors=['MLB'=>['rgba(34,197,94,.1)','#22C55E'],'NFL'=>['rgba(59,130,246,.1)','#3B82F6'],'NBA'=>['rgba(239,68,68,.1)','#EF4444'],'NHL'=>['rgba(168,85,247,.1)','#A855F7'],'NCAAF'=>['rgba(249,115,22,.1)','#F97316'],'NCAAB'=>['rgba(245,158,11,.1)','#F59E0B']];
@endphp

{{-- Filters --}}
<div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:16px;">
    @foreach([''=>'All','NFL'=>'NFL','NCAAF'=>'NCAAF','NBA'=>'NBA','NCAAB'=>'NCAAB','MLB'=>'MLB','NHL'=>'NHL'] as $val=>$label)
    <a href="/subscriber/articles{{ $val?'?sport='.$val:'' }}" class="filter-pill {{ ($sport??'')===$val?'active':'' }}">{{ $label }}</a>
    @endforeach
</div>

<div class="art-grid">
    @forelse($articles as $article)
    @php $sc=$sportColors[$article->sport??'']??['rgba(253,181,21,.1)','#FDB515']; @endphp
    <a href="/subscriber/articles/{{ $article->slug }}" style="text-decoration:none;display:flex;flex-direction:column;background:var(--card);border:1px solid var(--bdr);border-radius:var(--r);overflow:hidden;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
        @if($article->featured_image)
            <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}" style="width:100%;height:160px;object-fit:cover;display:block;">
        @else
            <div style="width:100%;height:160px;background:rgba(255,255,255,.05);display:flex;align-items:center;justify-content:center;font-size:2.5rem;">🏅</div>
        @endif
        <div style="padding:14px;flex:1;display:flex;flex-direction:column;">
            <div style="display:flex;gap:6px;margin-bottom:8px;flex-wrap:wrap;">
                <span style="background:{{ $sc[0] }};color:{{ $sc[1] }};padding:2px 8px;border-radius:6px;font-size:10px;font-weight:700;text-transform:uppercase;">{{ $article->sport }}</span>
                <span style="background:rgba(36,251,238,.08);border:1px solid rgba(36,251,238,.2);color:#24FBEE;padding:2px 8px;border-radius:6px;font-size:10px;font-weight:600;">{{ $article->category }}</span>
                @if($article->is_premium)<span style="background:rgba(253,181,21,.1);border:1px solid rgba(253,181,21,.2);color:var(--gold);padding:2px 8px;border-radius:6px;font-size:10px;font-weight:700;">PREMIUM</span>@endif
            </div>
            <h3 style="font-size:13.5px;font-weight:700;color:#fff;line-height:1.4;flex:1;margin-bottom:10px;">{{ Str::limit($article->title,75) }}</h3>
            @if($article->excerpt)<p style="font-size:11.5px;color:rgba(255,255,255,.3);line-height:1.5;margin-bottom:10px;">{{ Str::limit(strip_tags($article->excerpt),90) }}</p>@endif
            <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,255,255,.07);padding-top:10px;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="width:22px;height:22px;border-radius:50%;background:var(--gold);color:#000;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;">{{ strtoupper(substr($article->author??$article->expert_name??'A',0,1)) }}</div>
                    <span style="font-size:11px;color:rgba(255,255,255,.4);">{{ $article->author??$article->expert_name }}</span>
                </div>
                <span style="font-size:11px;color:rgba(255,255,255,.25);">{{ $article->published_at?->format('M d, Y') }}</span>
            </div>
        </div>
    </a>
    @empty
    <div class="s-card" style="grid-column:1/-1;text-align:center;padding:56px;"><p style="color:rgba(255,255,255,.3);">No articles found.</p></div>
    @endforelse
</div>
<div style="margin-top:20px;">{{ $articles->links() }}</div>
@endsection

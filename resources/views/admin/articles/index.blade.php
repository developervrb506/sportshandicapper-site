@extends('admin.layouts.admin')
@section('title', 'Articles - INSPIN Admin')
@section('page-title', 'Articles')

@section('content')
<div class="page-header">
    <h1>Articles</h1>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        New Article
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="search-bar">
            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Search title, category, author…">
            <button type="submit" class="btn btn-ghost">Search</button>
            @if($search)<a href="{{ route('admin.articles.index') }}" class="btn btn-ghost">Clear</a>@endif
        </form>
    </div>

    <div class="table-wrap">
        @if($articles->count())
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Sport</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px;">{{ Str::limit($article->title, 55) }}</div>
                        @if($article->expert_name)<div style="font-size:11px;color:#94a3b8;">{{ $article->expert_name }}</div>@endif
                    </td>
                    <td><span style="font-size:13px;color:#475569;">{{ $article->category }}</span></td>
                    <td>@if($article->sport)<span class="badge badge-{{ strtolower($article->sport) }}">{{ $article->sport }}</span>@else<span style="color:#cbd5e1;">—</span>@endif</td>
                    <td style="font-size:13px;">{{ $article->author ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $article->is_published ? 'badge-success' : 'badge-neutral' }}">
                            {{ $article->is_published ? 'Published' : 'Draft' }}
                        </span>
                        @if($article->is_premium)<span class="badge badge-warning" style="margin-left:4px;">Premium</span>@endif
                    </td>
                    <td style="font-size:13px;color:#64748b;">{{ $article->published_at?->format('M d, Y') ?? '—' }}</td>
                    <td>
                        <div class="td-actions" style="justify-content:flex-end;">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Delete this article?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            <h3>No articles found</h3>
            <p>{{ $search ? 'Try a different search.' : 'Write your first article.' }}</p>
        </div>
        @endif
    </div>

    @if($articles->hasPages())
    <div class="card-body" style="padding-top:0;">
        {{ $articles->appends(request()->query())->links('vendor.pagination.simple-bootstrap-4') }}
    </div>
    @endif
</div>
@endsection

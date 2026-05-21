@extends('admin.layouts.admin')

@section('title', 'Picks - INSPIN Admin')
@section('page-title', 'Picks')
@section('breadcrumb')
    <span>Picks</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>All Picks</h2>
        <a href="{{ route('modules.tips.create') }}" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M12 4v16m8-8H4"/></svg>
            New Pick
        </a>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('modules.tips.index') }}" class="search-bar">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search picks by title, sport, or expert...">
            <button type="submit" class="btn btn-primary">Search</button>
            @if($search)<a href="{{ route('modules.tips.index') }}" class="btn btn-ghost">Clear</a>@endif
        </form>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Pick</th>
                        <th>Sport</th>
                        <th>Expert</th>
                        <th>Confidence</th>
                        <th>Result</th>
                        <th>Active</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tips as $tip)
                    <tr>
                        <td style="white-space:nowrap;color:#64748b;font-size:13px;">{{ $tip->display_date?->format('M d') ?? 'N/A' }}</td>
                        <td>
                            <div style="font-weight:600;">{{ Str::limit($tip->tip_title, 40) }}</div>
                            @if($tip->matchup)<div style="font-size:12px;color:#94a3b8;">{{ $tip->matchup }}</div>@endif
                        </td>
                        <td><span class="badge badge-{{ strtolower($tip->group_name) }}">{{ $tip->group_name }}</span></td>
                        <td style="font-size:13px;">{{ $tip->expert_name ?? '-' }}</td>
                        <td>
                            @if($tip->confidence)
                                <span style="color:#d97706;">{{ str_repeat('★', $tip->confidence) }}{{ str_repeat('☆', 5 - $tip->confidence) }}</span>
                            @else
                                <span style="color:#94a3b8;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($tip->result === 'win')
                                <span class="badge badge-success">Win</span>
                            @elseif($tip->result === 'loss')
                                <span class="badge badge-danger">Loss</span>
                            @elseif($tip->result === 'push')
                                <span class="badge badge-neutral">Push</span>
                            @else
                                <span class="badge badge-neutral">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($tip->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-neutral">Inactive</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('modules.tips.edit', $tip) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('modules.tips.destroy', $tip) }}" style="display:inline;" onsubmit="return confirm('Delete this pick?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8"><div class="empty-state"><h3>No picks yet</h3><p>Create your first pick to get started.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tips->hasPages())
    <div class="card-footer">{{ $tips->links() }}</div>
    @endif
</div>
@endsection

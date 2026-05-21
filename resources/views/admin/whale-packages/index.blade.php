@extends('admin.layouts.admin')
@section('title', 'Packages - INSPIN Admin')
@section('page-title', 'Whale Packages')

@section('content')
<div class="page-header">
    <h1>Packages</h1>
    <a href="{{ route('admin.whale-packages.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        New Package
    </a>
</div>

<div class="card">
    <div class="table-wrap">
        @if($packages->count())
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Features</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packages as $pkg)
                <tr>
                    <td style="color:#94a3b8;font-size:13px;">{{ $pkg->sort_order ?? '—' }}</td>
                    <td>
                        <div style="font-weight:600;font-size:14px;">{{ $pkg->title }}</div>
                        @if($pkg->description)<div style="font-size:12px;color:#94a3b8;">{{ Str::limit($pkg->description, 60) }}</div>@endif
                    </td>
                    <td style="font-weight:700;font-size:15px;">${{ number_format($pkg->price, 2) }}</td>
                    <td style="font-size:13px;color:#475569;">{{ $pkg->duration ?? ($pkg->duration_days ? $pkg->duration_days.' days' : '—') }}</td>
                    <td style="font-size:12px;color:#64748b;">
                        @if(is_array($pkg->features) && count($pkg->features))
                            {{ count($pkg->features) }} features
                        @else
                            —
                        @endif
                    </td>
                    <td><span class="badge {{ $pkg->is_active ? 'badge-success' : 'badge-neutral' }}">{{ $pkg->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <div class="td-actions" style="justify-content:flex-end;">
                            <a href="{{ route('admin.whale-packages.edit', $pkg) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.whale-packages.destroy', $pkg) }}" onsubmit="return confirm('Delete this package?')">
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
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h3>No packages yet</h3>
            <p>Create your first membership package.</p>
        </div>
        @endif
    </div>
</div>
@endsection

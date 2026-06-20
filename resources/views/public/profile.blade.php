@extends('layouts.subscriber')
@section('title','My Profile | Sportshandicapper')
@section('page-title','My Profile')

@section('content')
@php $user=auth()->user(); $sub=$user->activeSubscription()?->load('package'); @endphp

<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
    {{-- Account details --}}
    <div class="s-card" style="padding:20px;">
        <h3 style="font-size:14px;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:16px;">Account Details</h3>
        @foreach(['Name'=>$user->name,'Email'=>$user->email,'Phone'=>($user->phone??'Not set'),'Member Since'=>$user->created_at->format('M d, Y')] as $label=>$val)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid rgba(255,255,255,.06);">
            <span style="font-size:12px;color:rgba(255,255,255,.4);">{{ $label }}</span>
            <span style="font-size:13px;font-weight:600;color:#fff;">{{ $val }}</span>
        </div>
        @endforeach
        <div style="margin-top:14px;">
            <a href="/account/settings" style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);color:#fff;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,.12)'" onmouseout="this.style.background='rgba(255,255,255,.07)'">Edit Settings →</a>
        </div>
    </div>

    {{-- Package --}}
    <div class="s-card" style="padding:20px;">
        <h3 style="font-size:14px;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:16px;">Active Package</h3>
        @if($sub)
        <div style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">{{ $sub->packageName() }}</div>
        <div style="font-size:14px;color:var(--gold);font-weight:600;margin-bottom:12px;">{{ str_repeat('★',min($sub->max_stars,5)) }}{{ $sub->max_stars>5?'+':'' }} Access</div>
        <div class="stat-bar"></div>
        <div style="font-size:11px;color:rgba(255,255,255,.35);margin-bottom:14px;">
            @if($sub->status_note==='extended') <span style="color:#6366f1;">⟳ Extended</span>
            @elseif($sub->isExpired()) <span style="color:#ef4444;">Expired</span>
            @else Expires {{ $sub->expires_at->format('M d, Y') }} · {{ $sub->daysRemaining() }} days left @endif
        </div>
        @if($sub->max_stars<10)<a href="/subscriber/packages" style="display:inline-block;padding:8px 18px;background:var(--gold);color:#000;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;">Upgrade Package</a>@endif
        @else
        <p style="font-size:13px;color:rgba(255,255,255,.3);margin-bottom:16px;">No active package.</p>
        <a href="/subscriber/packages" style="display:inline-block;padding:8px 18px;background:var(--gold);color:#000;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;">View Packages</a>
        @endif
    </div>
</div>

{{-- Support tickets --}}
@if($tickets->count()>0)
<div class="s-card" style="overflow:hidden;">
    <div style="padding:14px 18px;border-bottom:1px solid rgba(255,255,255,.07);"><h3 style="font-size:15px;font-weight:700;color:#fff;">Support Tickets</h3></div>
    <table style="width:100%;border-collapse:collapse;">
        <thead><tr style="border-bottom:1px solid rgba(255,255,255,.07);">
            @foreach(['ID','Subject','Status','Date'] as $h)<th style="padding:10px 16px;text-align:left;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:rgba(255,255,255,.3);">{{ $h }}</th>@endforeach
        </tr></thead>
        <tbody>
            @foreach($tickets as $t)
            <tr style="border-bottom:1px solid rgba(255,255,255,.04);">
                <td style="padding:10px 16px;font-size:12px;color:rgba(255,255,255,.4);">#{{ $t->id }}</td>
                <td style="padding:10px 16px;font-size:13px;color:#fff;">{{ Str::limit($t->subject,40) }}</td>
                <td style="padding:10px 16px;"><span style="background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.2);color:#00D15B;padding:2px 8px;border-radius:10px;font-size:10px;font-weight:700;">{{ ucfirst($t->status) }}</span></td>
                <td style="padding:10px 16px;font-size:12px;color:rgba(255,255,255,.3);">{{ $t->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserPackage extends Model
{
    protected $fillable = [
        'user_id', 'package_id', 'starts_at', 'expires_at',
        'is_active', 'units_total', 'max_stars', 'status_note',
    ];

    protected $casts = [
        'starts_at'   => 'datetime',
        'expires_at'  => 'datetime',
        'is_active'   => 'boolean',
        'units_total' => 'decimal:2',
    ];

    // ── Package slug → max accessible stars ─────────────────────
    public static array $starMap = [
        'free-trial'   => 1,
        '1-week'       => 2,
        '2-weeks'      => 3,
        'monthly'      => 4,
        'quarterly'    => 5,
        'semi-annual'  => 5,
        'annual'       => 10,
        'whale-package'=> 10,
    ];

    // ── Relationships ────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // ── Status helpers ───────────────────────────────────────────
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function shouldExtend(): bool
    {
        return $this->isExpired() && $this->units_total < 0;
    }

    public function shouldTerminate(): bool
    {
        return $this->isExpired() && $this->units_total >= 0;
    }

    public function daysRemaining(): int
    {
        if (!$this->expires_at || $this->isExpired()) return 0;
        return (int) now()->diffInDays($this->expires_at);
    }

    public function packageName(): string
    {
        return $this->package?->name ?? 'Free Trial';
    }
}

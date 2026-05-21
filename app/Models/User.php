<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────────
    public function subscriptions()
    {
        return $this->hasMany(UserPackage::class)->orderByDesc('starts_at');
    }

    public function activeSubscription(): ?UserPackage
    {
        return $this->subscriptions()
            ->where('is_active', true)
            ->first();
    }

    // ── Subscription helpers ─────────────────────────────────────
    public function maxAccessibleStars(): int
    {
        $sub = $this->activeSubscription();
        if (!$sub) return 0;
        return $sub->max_stars;
    }

    public function canViewPick(\App\Models\Pick $pick): bool
    {
        $sub = $this->activeSubscription();
        if (!$sub) return false;
        return $pick->stars <= $sub->max_stars;
    }

    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription() !== null;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new \App\Notifications\VerifyEmailNotification());
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}

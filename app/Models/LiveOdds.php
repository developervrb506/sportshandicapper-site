<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveOdds extends Model
{
    protected $table = 'live_odds';

    protected $fillable = [
        'event_id',
        'sport_key',
        'sport_title',
        'commence_time',
        'home_team',
        'away_team',
        'bookmaker_key',
        'bookmaker_title',
        'market_key',
        'outcomes',
        'last_update',
    ];

    protected $casts = [
        'commence_time' => 'datetime',
        'last_update' => 'datetime',
        'outcomes' => 'array',
    ];

    public function scopeSport($query, string $sportKey)
    {
        return $query->where('sport_key', $sportKey);
    }

    public function scopeMarket($query, string $marketKey)
    {
        return $query->where('market_key', $marketKey);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('commence_time', '>=', now()->subHours(3))
            ->orderBy('commence_time');
    }
}

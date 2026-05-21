<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BettingConsensus extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport', 'league', 'home_team', 'away_team', 'game_date',
        'moneyline_home', 'moneyline_away', 'spread_home', 'spread_away',
        'total_over', 'total_under', 'public_pct_home', 'public_pct_away',
        'money_pct_home', 'money_pct_away', 'venue', 'broadcast',
    ];

    protected $casts = [
        'game_date' => 'datetime',
        'public_pct_home' => 'decimal:1',
        'public_pct_away' => 'decimal:1',
        'money_pct_home' => 'decimal:1',
        'money_pct_away' => 'decimal:1',
    ];

    public function scopeUpcoming($query)
    {
        return $query->where('game_date', '>=', now())->orderBy('game_date');
    }

    public function scopeSport($query, $sport)
    {
        // Filter by league column (NFL, NBA, MLB, NHL) not sport column (Basketball, Football)
        return $query->where('league', $sport);
    }

    public function scopeLeague($query, $league)
    {
        return $query->where('league', $league);
    }
}

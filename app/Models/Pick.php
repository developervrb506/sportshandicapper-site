<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pick extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport',
        'game_date',
        'game_time',
        'team1_name',
        'team1_logo',
        'team1_rotation',
        'team2_name',
        'team2_logo',
        'team2_rotation',
        'venue',
        'pick',
        'simulation_result',
        'stars',
        'result',
        'units',
        'units_result',
        'expert_name',
        'related_article_id',
        'is_active',
        'is_whale_exclusive',
        'team1_percent',
        'team2_percent',
        'pick_type',
    ];

    protected $casts = [
        'game_date' => 'date',
        'stars' => 'integer',
        'units' => 'decimal:2',
        'units_result' => 'decimal:2',
        'is_active' => 'boolean',
        'is_whale_exclusive' => 'boolean',
    ];

    // Scope: Active picks
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: By sport
    public function scopeSport($query, $sport)
    {
        return $query->where('sport', $sport);
    }

    // Scope: Today's picks
    public function scopeToday($query)
    {
        return $query->where('game_date', today());
    }

    // Scope: Whale exclusive
    public function scopeWhaleExclusive($query)
    {
        return $query->where('is_whale_exclusive', true);
    }

    // Scope: Pending result
    public function scopePending($query)
    {
        return $query->where('result', 'pending');
    }

    // Relationship: Related article
    public function relatedArticle(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'related_article_id');
    }

    // Accessor: Pick status (ACTIVE / STARTED / GRADED)
    public function getStatusAttribute(): string
    {
        if ($this->result !== 'pending') {
            return 'GRADED';
        }
        $timeStr = $this->game_time
            ? \Carbon\Carbon::parse($this->game_time)->format('H:i:s')
            : '00:00:00';
        $gameStart = \Carbon\Carbon::parse($this->game_date->format('Y-m-d') . ' ' . $timeStr);
        return $gameStart->isPast() ? 'STARTED' : 'ACTIVE';
    }

    // Accessor: Stars display text
    public function getStarsDisplayAttribute(): string
    {
        if ($this->stars === 10) {
            return '★10 - Exclusive Whale Package';
        }
        return str_repeat('★', $this->stars);
    }

    // Accessor: Result badge class
    public function getResultBadgeAttribute(): string
    {
        return match ($this->result) {
            'win' => 'bg-green-500 text-white',
            'loss' => 'bg-red-500 text-white',
            'push' => 'bg-yellow-500 text-black',
            default => 'bg-gray-500 text-white',
        };
    }
}

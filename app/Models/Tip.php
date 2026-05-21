<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'added_date', 'tip_title', 'tip_text', 'group_name', 'expert_name',
        'matchup', 'confidence', 'result', 'analysis',
        'display_yearly', 'display_date', 'shown_date', 'display_day', 'is_active',
    ];

    protected $casts = [
        'display_yearly' => 'boolean',
        'is_active' => 'boolean',
        'confidence' => 'integer',
        'added_date' => 'date',
        'display_date' => 'date',
        'shown_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSport($query, $sport)
    {
        return $query->where('group_name', 'like', "%{$sport}%");
    }
}

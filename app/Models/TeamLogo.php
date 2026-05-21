<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamLogo extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'sport',
        'logo_path',
        'abbreviation',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope: active logos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: by sport
    public function scopeSport($query, $sport)
    {
        return $query->where('sport', $sport);
    }

    // Accessor for logo URL
    public function getLogoUrlAttribute()
    {
        if ($this->logo_path) {
            return asset('storage/' . $this->logo_path);
        }
        return asset('images/default-team.png');
    }
}

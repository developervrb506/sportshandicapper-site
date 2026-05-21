<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Expert extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'bio',
        'avatar',
        'specialty',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Auto-generate slug from name
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($expert) {
            if (empty($expert->slug)) {
                $expert->slug = Str::slug($expert->name);
            }
        });
    }

    // Relationship: picks by this expert
    public function picks(): HasMany
    {
        return $this->hasMany(Pick::class, 'expert_name', 'name');
        // Note: currently picks use expert_name string, not foreign key
        // We'll update later to use expert_id
    }

    // Relationship: articles by this expert
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'expert_name', 'name');
        // Note: currently articles use expert_name string
    }

    // Accessor for avatar URL
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/uploads/experts/' . $this->avatar);
        }
        return asset('images/default-expert.png');
    }
}

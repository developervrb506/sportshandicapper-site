<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'featured_image',
        'category', 'sport', 'author', 'expert_name', 'is_premium', 'is_published', 'published_at',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderByDesc('published_at');
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSport($query, $sport)
    {
        return $query->where('sport', $sport);
    }

    // Relationship: Related picks for this article
    public function relatedPicks(): HasMany
    {
        return $this->hasMany(Pick::class, 'related_article_id');
    }

    // Relationship: NotebookLM supplemental content
    public function supplements(): HasMany
    {
        return $this->hasMany(ArticleSupplement::class)->orderBy('sort_order');
    }
}

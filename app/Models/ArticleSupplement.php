<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleSupplement extends Model
{
    protected $fillable = [
        'article_id', 'type', 'title', 'embed_code', 'external_url', 'image_path', 'ai_content', 'sort_order',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'video'        => '📺',
            'debate'       => '💬',
            'infographic'  => '📊',
            'flashcard'    => '🃏',
            'audio'        => '🎧',
            'ai_generated' => '✨',
            default        => '📎',
        };
    }
}

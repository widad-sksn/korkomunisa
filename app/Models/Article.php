<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'content'];

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'media_path',
        'status',
        'original_language',
        'translation_status',
        'translated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('stat_article_count');
        });
        static::deleted(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('stat_article_count');
        });
    }
}

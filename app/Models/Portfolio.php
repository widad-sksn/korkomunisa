<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Portfolio extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'description'];

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image_path',
        'url',
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
            \Illuminate\Support\Facades\Cache::forget('stat_portfolio_count');
        });
        static::deleted(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('stat_portfolio_count');
        });
    }
}

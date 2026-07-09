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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

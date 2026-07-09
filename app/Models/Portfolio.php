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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

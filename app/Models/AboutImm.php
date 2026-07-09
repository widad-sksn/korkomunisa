<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AboutImm extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'content'];

    protected $fillable = ['title', 'content'];
}

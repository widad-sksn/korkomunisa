<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Articles
        DB::table('articles')->get()->each(function ($article) {
            DB::table('articles')->where('id', $article->id)->update([
                'title' => json_encode(['id' => $article->title, 'en' => $article->title, 'ar' => $article->title]),
                'content' => json_encode(['id' => $article->content, 'en' => $article->content, 'ar' => $article->content]),
            ]);
        });

        // 2. Portfolios
        DB::table('portfolios')->get()->each(function ($portfolio) {
            DB::table('portfolios')->where('id', $portfolio->id)->update([
                'title' => json_encode(['id' => $portfolio->title, 'en' => $portfolio->title, 'ar' => $portfolio->title]),
                'description' => $portfolio->description ? json_encode(['id' => $portfolio->description, 'en' => $portfolio->description, 'ar' => $portfolio->description]) : null,
            ]);
        });

        // 3. About IMMs
        DB::table('about_imms')->get()->each(function ($about) {
            DB::table('about_imms')->where('id', $about->id)->update([
                'title' => json_encode(['id' => $about->title, 'en' => $about->title, 'ar' => $about->title]),
                'content' => json_encode(['id' => $about->content, 'en' => $about->content, 'ar' => $about->content]),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('articles')->get()->each(function ($article) {
            $title = json_decode($article->title, true);
            $content = json_decode($article->content, true);
            DB::table('articles')->where('id', $article->id)->update([
                'title' => is_array($title) ? ($title['id'] ?? '') : $article->title,
                'content' => is_array($content) ? ($content['id'] ?? '') : $article->content,
            ]);
        });

        DB::table('portfolios')->get()->each(function ($portfolio) {
            $title = json_decode($portfolio->title, true);
            $description = $portfolio->description ? json_decode($portfolio->description, true) : null;
            DB::table('portfolios')->where('id', $portfolio->id)->update([
                'title' => is_array($title) ? ($title['id'] ?? '') : $portfolio->title,
                'description' => is_array($description) ? ($description['id'] ?? '') : $portfolio->description,
            ]);
        });

        DB::table('about_imms')->get()->each(function ($about) {
            $title = json_decode($about->title, true);
            $content = json_decode($about->content, true);
            DB::table('about_imms')->where('id', $about->id)->update([
                'title' => is_array($title) ? ($title['id'] ?? '') : $about->title,
                'content' => is_array($content) ? ($content['id'] ?? '') : $about->content,
            ]);
        });
    }
};

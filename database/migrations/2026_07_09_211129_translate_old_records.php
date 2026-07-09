<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Article;
use App\Models\Portfolio;
use App\Services\AutoTranslationService;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Articles
        $articles = Article::all();
        foreach ($articles as $article) {
            $title = $article->getTranslations('title');
            $content = $article->getTranslations('content');
            
            $newTitle = AutoTranslationService::translateArray($title);
            $newContent = AutoTranslationService::translateArray($content);
            
            $article->title = $newTitle;
            $article->content = $newContent;
            $article->save();
        }

        // Portfolios
        $portfolios = Portfolio::all();
        foreach ($portfolios as $portfolio) {
            $title = $portfolio->getTranslations('title');
            $description = $portfolio->getTranslations('description');
            
            $newTitle = AutoTranslationService::translateArray($title);
            $newDescription = AutoTranslationService::translateArray($description);
            
            $portfolio->title = $newTitle;
            $portfolio->description = $newDescription;
            $portfolio->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot cleanly reverse auto-translations without wiping data
    }
};

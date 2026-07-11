<?php

// Update en.json
$en = json_decode(file_get_contents('lang/en.json'), true);
$en['Artikel'] = 'Articles';
$en['Gagasan, narasi, dan pemikiran dari kader.'] = 'Ideas, narratives, and thoughts from cadres.';
file_put_contents('lang/en.json', json_encode($en, JSON_PRETTY_PRINT));

// Update ar.json
$ar = json_decode(file_get_contents('lang/ar.json'), true);
$ar['Artikel'] = 'المقالات';
$ar['Gagasan, narasi, dan pemikiran dari kader.'] = 'الأفكار والروايات من الكوادر.';
file_put_contents('lang/ar.json', json_encode($ar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Translate old database entries
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use App\Models\Portfolio;
use App\Models\AboutImm;
use App\Services\AutoTranslationService;

// Articles
$articles = Article::all();
foreach ($articles as $article) {
    $title = $article->getTranslations('title');
    $content = $article->getTranslations('content');
    
    // Auto translate missing fields
    $newTitle = AutoTranslationService::translateArray($title);
    $newContent = AutoTranslationService::translateArray($content);
    
    // Update directly without triggering events if needed, but update is fine
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

echo "Database updated successfully!\n";

<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('content:translate-missing', function () {
    $this->info('Checking for articles with missing translations...');
    $articles = \App\Models\Article::all();
    foreach ($articles as $article) {
        $hasMissing = false;
        foreach (['title', 'content'] as $field) {
            $trans = $article->getTranslations($field);
            foreach (['en', 'ar', 'ja', 'jv'] as $loc) {
                if (empty(trim(strip_tags($trans[$loc] ?? '')))) {
                    $hasMissing = true;
                    break 2;
                }
            }
        }
        if ($hasMissing) {
            $this->info("Translating Article #{$article->id}...");
            try {
                \App\Jobs\TranslateContentJob::dispatchSync($article, true);
                $this->info("Article #{$article->id} translated successfully.");
            } catch (\Throwable $e) {
                $this->error("Failed translating Article #{$article->id}: " . $e->getMessage());
            }
        }
    }

    $this->info('Checking portfolios with missing translations...');
    $portfolios = \App\Models\Portfolio::all();
    foreach ($portfolios as $portfolio) {
        $hasMissing = false;
        foreach (['title', 'description'] as $field) {
            $trans = $portfolio->getTranslations($field);
            foreach (['en', 'ar', 'ja', 'jv'] as $loc) {
                if (empty(trim(strip_tags($trans[$loc] ?? '')))) {
                    $hasMissing = true;
                    break 2;
                }
            }
        }
        if ($hasMissing) {
            $this->info("Translating Portfolio #{$portfolio->id}...");
            try {
                \App\Jobs\TranslateContentJob::dispatchSync($portfolio, true);
                $this->info("Portfolio #{$portfolio->id} translated successfully.");
            } catch (\Throwable $e) {
                $this->error("Failed translating Portfolio #{$portfolio->id}: " . $e->getMessage());
            }
        }
    }

    $this->info('Translation check completed.');
})->purpose('Translate all articles and portfolios with missing translations');

<?php
$article = \App\Models\Article::first();
if($article) {
    echo "Article ID: " . $article->id . "\n";
    \App\Jobs\TranslateContentJob::dispatchSync($article, true);
    echo "Translation Status: " . $article->fresh()->translation_status . "\n";
    echo "Translated at: " . $article->fresh()->translated_at . "\n";
} else {
    echo "No article found.\n";
}

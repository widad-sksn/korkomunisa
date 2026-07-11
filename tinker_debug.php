<?php
try {
    $article = \App\Models\Article::where('status', 'published')->first();
    if($article) {
        echo "User: " . ($article->user ? $article->user->name : 'null') . "\n";
        echo "Title: " . print_r($article->title, true) . "\n";
        echo "Str::limit: " . \Illuminate\Support\Str::limit($article->title, 50) . "\n";
    } else {
        echo "No published article found.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

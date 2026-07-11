<?php
try {
    // Make sure we have a user
    $user = \App\Models\User::first() ?? \App\Models\User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => bcrypt('password')]);
    
    // Create an article with plain string
    $article = \App\Models\Article::create([
        'user_id' => $user->id,
        'title' => 'This is a normal string title',
        'content' => 'This is content',
        'status' => 'published',
        'media_path' => 'dummy.jpg',
    ]);
    
    // Render the view
    $html = view('admin.articles.history', [
        'historyArticles' => \App\Models\Article::with('user')->where('status', 'published')->latest()->get(),
        'title' => 'Riwayat Tulisan Diterima'
    ])->render();
    
    echo "RENDER SUCCESSFUL!\n";
    // echo substr($html, 0, 100);
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . " LINE: " . $e->getLine() . "\n";
}

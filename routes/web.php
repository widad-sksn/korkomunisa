<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $articles = \App\Models\Article::where('status', 'published')->latest()->take(3)->get();
    $portfolios = \App\Models\Portfolio::where('status', 'published')->latest()->take(4)->get();
    
    $userCount = \App\Models\User::count();
    $articleCount = \App\Models\Article::where('status', 'published')->count();
    $portfolioCount = \App\Models\Portfolio::where('status', 'published')->count();
    
    return view('welcome', compact('articles', 'portfolios', 'userCount', 'articleCount', 'portfolioCount'));
});

// Public article viewing route
Route::get('/kabar/{article}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show_public');
Route::get('/tulisan-kader', [\App\Http\Controllers\ArticleController::class, 'publicIndex'])->name('articles.public_index');

// Public portfolio viewing route
Route::get('/kegiatan/{portfolio}', [\App\Http\Controllers\PortfolioController::class, 'show'])->name('portfolios.show_public');
Route::get('/kegiatan', [\App\Http\Controllers\PortfolioController::class, 'publicIndex'])->name('portfolios.public_index');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en', 'ar'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/tentang-imm', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PortfolioController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Kader/User routes
    Route::resource('articles', ArticleController::class);
    Route::resource('portfolios', PortfolioController::class);
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/articles', [ArticleController::class, 'adminIndex'])->name('articles.index');
    Route::get('/articles/approved', [ArticleController::class, 'approvedIndex'])->name('articles.approved');
    Route::get('/articles/rejected', [ArticleController::class, 'rejectedIndex'])->name('articles.rejected');
    Route::patch('/articles/{article}/approve', [ArticleController::class, 'approve'])->name('articles.approve');
    
    Route::get('/portfolios', [PortfolioController::class, 'adminIndex'])->name('portfolios.index');
    Route::get('/portfolios/approved', [PortfolioController::class, 'approvedIndex'])->name('portfolios.approved');
    Route::get('/portfolios/rejected', [PortfolioController::class, 'rejectedIndex'])->name('portfolios.rejected');
    Route::patch('/portfolios/{portfolio}/approve', [PortfolioController::class, 'approve'])->name('portfolios.approve');
});

require __DIR__.'/auth.php';

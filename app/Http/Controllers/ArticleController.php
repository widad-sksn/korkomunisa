<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\AutoTranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource for the user.
     */
    public function index()
    {
        $articles = auth()->user()->articles()->latest()->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * Display public listing of articles.
     */
    public function publicIndex(Request $request)
    {
        $query = Article::with('user')->where('status', 'published');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->latest()->paginate(9)->withQueryString();
        return view('articles.public_index', compact('articles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        // Only allow viewing if published, or if the user is the author, or if admin
        if ($article->status !== 'published') {
            if (!auth()->check() || (auth()->id() !== $article->user_id && auth()->user()->role !== 'admin')) {
                abort(404);
            }
        }
        
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'content' => 'required|array',
            'content.id' => 'required|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi|max:20480', // Max 20MB
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('articles_media', 'public');
        }

        $article = auth()->user()->articles()->create([
            'title' => $request->title,
            'content' => $request->content,
            'media_path' => $mediaPath,
            'status' => 'pending', // Requires admin approval
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dikirim dan menunggu persetujuan admin.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        if ($article->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        if ($article->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'content' => 'required|array',
            'content.id' => 'required|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi|max:20480',
        ]);

        $mediaPath = $article->media_path;
        if ($request->hasFile('media')) {
            if ($mediaPath) {
                Storage::disk('public')->delete($mediaPath);
            }
            $mediaPath = $request->file('media')->store('articles_media', 'public');
        }

        $newStatus = $article->status;
        if (auth()->user()->role !== 'admin') {
            $newStatus = 'pending';
        }

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'media_path' => $mediaPath,
            'status' => $newStatus,
        ]);

        if (auth()->user()->role === 'admin') {
            return redirect()->route('dashboard')->with('success', 'Tulisan berhasil diperbarui oleh Admin. Terjemahan otomatis tidak berjalan saat edit, gunakan tombol Perbarui Terjemahan jika perlu.');
        }

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui dan kembali menunggu persetujuan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($article->media_path) {
            Storage::disk('public')->delete($article->media_path);
        }

        $article->delete();

        return redirect()->back()->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * Admin view to see all pending articles.
     */
    public function adminIndex()
    {
        $pendingArticles = Article::with('user')->where('status', 'pending')->latest()->get();
        return view('admin.articles.index', compact('pendingArticles'));
    }

    public function approvedIndex()
    {
        $historyArticles = Article::with('user')->where('status', 'published')->latest()->get();
        $title = "Riwayat Tulisan Diterima";
        return view('admin.articles.history', compact('historyArticles', 'title'));
    }

    public function rejectedIndex()
    {
        $historyArticles = Article::with('user')->where('status', 'draft')->latest()->get();
        $title = "Riwayat Tulisan Ditolak";
        return view('admin.articles.history', compact('historyArticles', 'title'));
    }

    /**
     * Approve or reject an article.
     */
    public function approve(Request $request, Article $article)
    {
        $request->validate([
            'status' => 'required|in:published,draft,pending'
        ]);

        $oldStatus = $article->status;
        $article->update(['status' => $request->status]);

        if ($request->status === 'published' && $oldStatus !== 'published') {
            // Translate only when first published
            \App\Jobs\TranslateContentJob::dispatch($article);
            // Send Approval Mail
            \Illuminate\Support\Facades\Mail::to($article->user->email)->queue(new \App\Mail\ContentApproved($article));
        }

        if ($request->status === 'draft' && $oldStatus === 'pending') {
            // Send Rejection Mail
            \Illuminate\Support\Facades\Mail::to($article->user->email)->queue(new \App\Mail\ContentRejected($article));
        }

        return redirect()->route('admin.articles.index')->with('success', 'Status artikel berhasil diperbarui.');
    }

    public function forceTranslate(Article $article)
    {
        \App\Jobs\TranslateContentJob::dispatch($article, true);
        return redirect()->back()->with('success', 'Permintaan terjemahan sedang diproses di latar belakang.');
    }
}

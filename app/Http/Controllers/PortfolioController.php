<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Services\AutoTranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Display public listing of portfolios.
     */
    public function publicIndex(Request $request)
    {
        $query = Portfolio::where('status', 'published');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $portfolios = $query->latest()->paginate(12)->withQueryString();
        return view('portfolios.public_index', compact('portfolios'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = auth()->user()->portfolios()->latest()->get();
        return view('portfolios.index', compact('portfolios'));
    }

    public function show(Portfolio $portfolio)
    {
        if ($portfolio->status !== 'published') {
            if (!auth()->check() || (auth()->id() !== $portfolio->user_id && auth()->user()->role !== 'admin')) {
                abort(404);
            }
        }
        return view('portfolios.show', compact('portfolio'));
    }

    public function create()
    {
        return view('portfolios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'description' => 'nullable|array',
            'description.id' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'url' => 'nullable|url|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('portfolios', 'public');
        }

        $portfolio = auth()->user()->portfolios()->create([
            'title' => $request->title,
            'description' => $request->description ?? [],
            'image_path' => $imagePath,
            'url' => $request->url,
            'status' => 'pending',
        ]);

        return redirect()->route('portfolios.index')->with('success', 'Kegiatan berhasil diposting dan menunggu persetujuan admin.');
    }

    public function edit(Portfolio $portfolio)
    {
        if ($portfolio->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }
        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        if ($portfolio->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'description' => 'nullable|array',
            'description.id' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'url' => 'nullable|url|max:255',
        ]);

        $imagePath = $portfolio->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('portfolios', 'public');
        }

        $newStatus = $portfolio->status;
        if (auth()->user()->role !== 'admin') {
            $newStatus = 'pending';
        }

        $portfolio->update([
            'title' => $request->title,
            'description' => $request->description ?? [],
            'image_path' => $imagePath,
            'url' => $request->url,
            'status' => $newStatus,
        ]);

        if (auth()->user()->role === 'admin') {
            return redirect()->route('dashboard')->with('success', 'Kegiatan berhasil diperbarui oleh Admin. Terjemahan otomatis tidak berjalan saat edit, gunakan tombol Perbarui Terjemahan jika perlu.');
        }

        return redirect()->route('portfolios.index')->with('success', 'Kegiatan berhasil diperbarui dan kembali menunggu persetujuan.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($portfolio->image_path) {
            Storage::disk('public')->delete($portfolio->image_path);
        }
        $portfolio->delete();

        return redirect()->back()->with('success', 'Kegiatan berhasil dihapus.');
    }

    // Admin methods
    public function adminIndex()
    {
        $pendingPortfolios = Portfolio::with('user')->where('status', 'pending')->latest()->get();
        return view('admin.portfolios.index', compact('pendingPortfolios'));
    }

    public function approvedIndex()
    {
        $historyPortfolios = Portfolio::with('user')->where('status', 'published')->latest()->get();
        $title = "Riwayat Kegiatan Diterima";
        return view('admin.portfolios.history', compact('historyPortfolios', 'title'));
    }

    public function rejectedIndex()
    {
        $historyPortfolios = Portfolio::with('user')->where('status', 'draft')->latest()->get();
        $title = "Riwayat Kegiatan Ditolak";
        return view('admin.portfolios.history', compact('historyPortfolios', 'title'));
    }

    public function approve(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'status' => 'required|in:published,draft,pending'
        ]);

        $oldStatus = $portfolio->status;
        $portfolio->update(['status' => $request->status]);

        if ($request->status === 'published' && $oldStatus !== 'published') {
            \App\Jobs\TranslateContentJob::dispatch($portfolio);
            \Illuminate\Support\Facades\Mail::to($portfolio->user->email)->queue(new \App\Mail\ContentApproved($portfolio));
        }

        if ($request->status === 'draft' && $oldStatus === 'pending') {
            \Illuminate\Support\Facades\Mail::to($portfolio->user->email)->queue(new \App\Mail\ContentRejected($portfolio));
        }

        return redirect()->route('admin.portfolios.index')->with('success', 'Status kegiatan berhasil diperbarui.');
    }

    public function forceTranslate(Portfolio $portfolio)
    {
        \App\Jobs\TranslateContentJob::dispatch($portfolio, true);
        return redirect()->back()->with('success', 'Permintaan terjemahan sedang diproses di latar belakang.');
    }
}

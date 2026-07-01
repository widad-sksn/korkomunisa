<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutImm;
use App\Http\Requests\UpdateAboutImmRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutImmController extends Controller
{
    public function edit()
    {
        $about = AboutImm::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'Tentang IMM',
                'content' => '<p>Sejarah dan penjelasan tentang Ikatan Mahasiswa Muhammadiyah.</p>'
            ]
        );

        return view('admin.about-imm.edit', compact('about'));
    }

    public function update(UpdateAboutImmRequest $request)
    {
        $about = AboutImm::firstOrCreate(['id' => 1]);
        
        $about->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.about-imm.edit')->with('success', 'Data Tentang IMM berhasil diperbarui.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->file('file')) {
            $path = $request->file('file')->store('about-imm', 'public');
            $url = asset('storage/' . $path);
            return response()->json(['location' => $url]);
        }

        return response()->json(['error' => 'Gagal mengupload gambar.'], 400);
    }
}

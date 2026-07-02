<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,webp|max:51200'
        ]);

        if ($request->file('upload')) {
            $module = $request->input('module', 'general');
            
            // Sanitasi nama module untuk keamanan
            $module = preg_replace('/[^a-zA-Z0-9_-]/', '', $module);
            $path = $request->file('upload')->store("uploads/{$module}", 'public');
            
            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Gagal mengupload gambar.'], 400);
    }
}

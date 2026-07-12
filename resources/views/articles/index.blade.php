<x-app-layout title="Tulisan Saya">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tulisan Kader') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Daftar Tulisan Anda</h3>
                        <a href="{{ route('articles.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Buat Tulisan Baru</a>
                    </div>
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($articles->isEmpty())
                        <p class="text-gray-500 text-center py-4">Belum ada tulisan. Silakan buat yang baru!</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b dark:border-gray-700">
                                        <th class="py-3 px-4 w-24">Gambar</th>
                                        <th class="py-3 px-4">Judul</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($articles as $article)
                                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="py-3 px-4">
                                                @if($article->media_path)
                                                    @php
                                                        $ext = pathinfo($article->media_path, PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if(in_array(strtolower($ext), ['mp4', 'mov', 'avi']))
                                                        <div class="h-16 w-16 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center text-xs text-gray-500">Video</div>
                                                    @else
                                                        <img src="{{ asset('storage/' . $article->media_path) }}" class="h-16 w-16 object-cover rounded">
                                                    @endif
                                                @else
                                                    <div class="h-16 w-16 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center text-xs text-gray-500">No Img</div>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="font-semibold">{{ $article->title }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit(strip_tags($article->content), 50) }}</div>
                                                <div class="text-xs text-gray-400 mt-1">{{ $article->created_at->format('d M Y') }}</div>
                                            </td>
                                            <td class="py-3 px-4">
                                                @if($article->status == 'published')
                                                    <span class="inline-block whitespace-nowrap px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Diterima / Diterbitkan</span>
                                                @elseif($article->status == 'pending')
                                                    <span class="inline-block whitespace-nowrap px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Menunggu Persetujuan</span>
                                                @else
                                                    <span class="inline-block whitespace-nowrap px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Ditolak / Draft</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="flex flex-wrap gap-2 justify-end items-center">
                                                    <a href="{{ route('articles.show_public', $article) }}" class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded-md hover:bg-blue-600 font-medium whitespace-nowrap">Lihat</a>
                                                    <a href="{{ route('articles.edit', $article) }}" class="px-3 py-1.5 bg-yellow-500 text-white text-xs rounded-md hover:bg-yellow-600 font-medium whitespace-nowrap">Edit</a>
                                                    <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="inline-block m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1.5 bg-red-500 text-white text-xs rounded-md hover:bg-red-600 font-medium whitespace-nowrap">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

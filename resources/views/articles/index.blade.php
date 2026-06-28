<x-app-layout>
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
                                        <th class="py-3 px-4">Judul</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4">Tanggal Dibuat</th>
                                        <th class="py-3 px-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($articles as $article)
                                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="py-3 px-4">{{ $article->title }}</td>
                                            <td class="py-3 px-4">
                                                @if($article->status == 'published')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Diterbitkan</span>
                                                @elseif($article->status == 'pending')
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Menunggu Persetujuan</span>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Draft</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">{{ $article->created_at->format('d M Y') }}</td>
                                            <td class="py-3 px-4 flex space-x-2">
                                                <a href="{{ route('articles.edit', $article) }}" class="text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                                </form>
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

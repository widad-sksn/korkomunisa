<x-app-layout title="Riwayat Tulisan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($title ?? 'Riwayat Persetujuan Tulisan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-bold mb-4">{{ $title ?? 'Riwayat Keputusan Admin' }} ({{ $historyArticles->count() }})</h3>
                    @if($historyArticles->isEmpty())
                        <p class="text-gray-500 py-4">Belum ada riwayat persetujuan tulisan.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                        <th class="py-3 px-4">Judul</th>
                                        <th class="py-3 px-4">Penulis</th>
                                        <th class="py-3 px-4">Status Keputusan</th>
                                        <th class="py-3 px-4">Tanggal Diajukan</th>
                                        <th class="py-3 px-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historyArticles as $article)
                                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="py-3 px-4">{{ Str::limit($article->title, 50) }}</td>
                                            <td class="py-3 px-4">{{ optional($article->user)->name ?? 'User Dihapus' }}</td>
                                            <td class="py-3 px-4">
                                                @if($article->status == 'published')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Diterima / Diterbitkan</span>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Ditolak / Dikembalikan</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">{{ optional($article->created_at)->format('d M Y') ?? '-' }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex flex-wrap gap-2 items-center">
                                                    <a href="{{ route('articles.show_public', $article) }}" class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded-md hover:bg-blue-600 font-medium whitespace-nowrap">Lihat Halaman</a>
                                                    <a href="{{ route('articles.edit', $article) }}" class="px-3 py-1.5 bg-yellow-500 text-white text-xs rounded-md hover:bg-yellow-600 font-medium whitespace-nowrap">Edit</a>
                                                    <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tulisan ini selamanya?');" class="inline-block m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1.5 bg-red-500 text-white text-xs rounded-md hover:bg-red-600 font-medium whitespace-nowrap">Hapus</button>
                                                    </form>
                                                    @if($article->status === 'published')
                                                        @if($article->translation_status === 'failed')
                                                            <span class="px-3 py-1.5 bg-red-100 text-red-800 text-xs rounded-md font-bold whitespace-nowrap">Translation Failed</span>
                                                            <form action="{{ route('admin.articles.translate', $article) }}" method="POST" class="inline-block m-0">
                                                                @csrf
                                                                <button type="submit" class="px-3 py-1.5 bg-indigo-500 text-white text-xs rounded-md hover:bg-indigo-600 font-medium whitespace-nowrap">🔄 Retry</button>
                                                            </form>
                                                        @elseif($article->translation_status === 'processing')
                                                            <span class="px-3 py-1.5 bg-yellow-100 text-yellow-800 text-xs rounded-md font-bold whitespace-nowrap">Translating...</span>
                                                        @else
                                                            <form action="{{ route('admin.articles.translate', $article) }}" method="POST" class="inline-block m-0">
                                                                @csrf
                                                                <button type="submit" class="px-3 py-1.5 bg-indigo-500 text-white text-xs rounded-md hover:bg-indigo-600 font-medium whitespace-nowrap">🔄 Perbarui Terjemahan</button>
                                                            </form>
                                                        @endif
                                                    @endif
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

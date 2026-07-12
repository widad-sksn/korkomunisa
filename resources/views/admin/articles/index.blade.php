<x-app-layout title="Kelola Tulisan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Persetujuan Tulisan Kader') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-bold mb-4">Daftar Menunggu Keputusan ({{ $pendingArticles->count() }})</h3>
                    @if($pendingArticles->isEmpty())
                        <p class="text-gray-500 py-4">Semua tulisan telah direview.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                        <th class="py-3 px-4">Judul</th>
                                        <th class="py-3 px-4">Penulis</th>
                                        <th class="py-3 px-4">Tanggal Pengajuan</th>
                                        <th class="py-3 px-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingArticles as $article)
                                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="py-3 px-4">{{ Str::limit($article->title, 50) }}</td>
                                            <td class="py-3 px-4">{{ optional($article->user)->name ?? 'User Dihapus' }}</td>
                                            <td class="py-3 px-4">{{ optional($article->created_at)->format('d M Y') ?? '-' }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex flex-wrap gap-2 items-center">
                                                    <a href="{{ route('articles.show_public', $article) }}" class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded-md hover:bg-blue-600 font-medium whitespace-nowrap">Baca Detail</a>
                                                    <a href="{{ route('articles.edit', $article) }}" class="px-3 py-1.5 bg-yellow-500 text-white text-xs rounded-md hover:bg-yellow-600 font-medium whitespace-nowrap">Edit</a>
                                                    <form action="{{ route('admin.articles.approve', $article) }}" method="POST" class="inline-block m-0">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="published">
                                                        <button type="submit" class="px-3 py-1.5 bg-green-500 text-white text-xs rounded-md hover:bg-green-600 font-medium whitespace-nowrap">Setujui</button>
                                                    </form>
                                                    <form action="{{ route('admin.articles.approve', $article) }}" method="POST" class="inline-block m-0">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="draft">
                                                        <button type="submit" class="px-3 py-1.5 bg-gray-500 text-white text-xs rounded-md hover:bg-gray-600 font-medium whitespace-nowrap">Tolak (Draft)</button>
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

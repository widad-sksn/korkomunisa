<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Persetujuan Kegiatan') }}
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

                    <h3 class="text-lg font-bold mb-4">Daftar Menunggu Keputusan ({{ $pendingPortfolios->count() }})</h3>
                    @if($pendingPortfolios->isEmpty())
                        <p class="text-gray-500 py-4">Semua postingan kegiatan telah direview.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                        <th class="py-3 px-4">Judul Kegiatan</th>
                                        <th class="py-3 px-4">Pengaju</th>
                                        <th class="py-3 px-4">Tanggal Diposting</th>
                                        <th class="py-3 px-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingPortfolios as $portfolio)
                                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="py-3 px-4">{{ Str::limit($portfolio->title, 50) }}</td>
                                            <td class="py-3 px-4">{{ optional($portfolio->user)->name ?? 'Admin / Anonim' }}</td>
                                            <td class="py-3 px-4">{{ $portfolio->created_at->format('d M Y') }}</td>
                                            <td class="py-3 px-4 flex flex-wrap gap-2 items-center">
                                                <a href="{{ route('portfolios.show_public', $portfolio) }}" class="px-2 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 font-medium">Baca Detail</a>
                                                <a href="{{ route('portfolios.edit', $portfolio) }}" class="px-2 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600 font-medium">Edit</a>
                                                <form action="{{ route('admin.portfolios.approve', $portfolio) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="published">
                                                    <button type="submit" class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">Setujui</button>
                                                </form>
                                                <form action="{{ route('admin.portfolios.approve', $portfolio) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="draft">
                                                    <button type="submit" class="px-2 py-1 bg-gray-500 text-white text-xs rounded hover:bg-gray-600">Tolak (Draft)</button>
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

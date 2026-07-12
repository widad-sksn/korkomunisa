<x-app-layout title="Riwayat Kegiatan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($title ?? 'Riwayat Persetujuan Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-bold mb-4">{{ $title ?? 'Riwayat Keputusan Admin' }} ({{ $historyPortfolios->count() }})</h3>
                    @if($historyPortfolios->isEmpty())
                        <p class="text-gray-500 py-4">Belum ada riwayat persetujuan portofolio.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                        <th class="py-3 px-4">Judul Kegiatan</th>
                                        <th class="py-3 px-4">Pengaju</th>
                                        <th class="py-3 px-4">Status Keputusan</th>
                                        <th class="py-3 px-4">Tanggal Diposting</th>
                                        <th class="py-3 px-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historyPortfolios as $portfolio)
                                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="py-3 px-4">{{ Str::limit($portfolio->title, 50) }}</td>
                                            <td class="py-3 px-4">{{ optional($portfolio->user)->name ?? 'Admin / Anonim' }}</td>
                                            <td class="py-3 px-4">
                                                @if($portfolio->status == 'published')
                                                    <span class="inline-block whitespace-nowrap px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Diterima / Diterbitkan</span>
                                                @else
                                                    <span class="inline-block whitespace-nowrap px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Ditolak / Dikembalikan</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">{{ optional($portfolio->created_at)->format('d M Y') ?? '-' }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex flex-wrap gap-2 items-center">
                                                    <a href="{{ route('portfolios.show_public', $portfolio) }}" class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded-md hover:bg-blue-600 font-medium whitespace-nowrap">Lihat Halaman</a>
                                                    <a href="{{ route('portfolios.edit', $portfolio) }}" class="px-3 py-1.5 bg-yellow-500 text-white text-xs rounded-md hover:bg-yellow-600 font-medium whitespace-nowrap">Edit</a>
                                                    <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini selamanya?');" class="inline-block m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1.5 bg-red-500 text-white text-xs rounded-md hover:bg-red-600 font-medium whitespace-nowrap">Hapus</button>
                                                    </form>
                                                    @if($portfolio->status === 'published')
                                                        @if($portfolio->translation_status === 'failed')
                                                            <span class="px-3 py-1.5 bg-red-100 text-red-800 text-xs rounded-md font-bold whitespace-nowrap">Translation Failed</span>
                                                            <form action="{{ route('admin.portfolios.translate', $portfolio) }}" method="POST" class="inline-block m-0">
                                                                @csrf
                                                                <button type="submit" class="px-3 py-1.5 bg-indigo-500 text-white text-xs rounded-md hover:bg-indigo-600 font-medium whitespace-nowrap">🔄 Retry</button>
                                                            </form>
                                                        @elseif($portfolio->translation_status === 'processing')
                                                            <span class="px-3 py-1.5 bg-yellow-100 text-yellow-800 text-xs rounded-md font-bold whitespace-nowrap">Translating...</span>
                                                        @else
                                                            <form action="{{ route('admin.portfolios.translate', $portfolio) }}" method="POST" class="inline-block m-0">
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

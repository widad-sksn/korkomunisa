<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Pengguna') }}
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
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-bold mb-4">Daftar Semua Pengguna ({{ $users->total() }})</h3>
                    @if($users->isEmpty())
                        <p class="text-gray-500 py-4">Belum ada pengguna terdaftar.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                        <th class="py-3 px-4">Nama</th>
                                        <th class="py-3 px-4">Email</th>
                                        <th class="py-3 px-4">Komisariat</th>
                                        <th class="py-3 px-4">Peran</th>
                                        <th class="py-3 px-4">Tanggal Daftar</th>
                                        <th class="py-3 px-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="py-3 px-4 flex items-center gap-3">
                                                @if ($user->avatar)
                                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-xs">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                {{ $user->name }}
                                            </td>
                                            <td class="py-3 px-4">
                                                {{ $user->email }}
                                                @if($user->hasVerifiedEmail())
                                                    <span class="inline-flex ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Verified</span>
                                                @else
                                                    <span class="inline-flex ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Unverified</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">{{ $user->komisariat ?? '-' }}</td>
                                            <td class="py-3 px-4">
                                                <span class="px-2 py-1 text-xs rounded {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">{{ $user->created_at->format('d M Y') }}</td>
                                            <td class="py-3 px-4">
                                                @if(auth()->id() !== $user->id)
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Semua data terkait (artikel, kegiatan) mungkin juga akan terpengaruh atau hilang.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 font-medium transition-colors">Hapus</button>
                                                    </form>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">Anda</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

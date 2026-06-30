<x-app-layout title="Dashboard">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Dashboard Kader') }}
        </h2>
    </x-slot>

    @php
        $user = Auth::user();
        $totalTulisan = $user->articles()->count();
        $totalKegiatan = $user->portfolios()->count();
        $publishedArticles = $user->articles()->where('status', 'published')->count();
        $publishedPortfolios = $user->portfolios()->where('status', 'published')->count();
        $pendingArticles = $user->articles()->where('status', 'pending')->count();
        $pendingPortfolios = $user->portfolios()->where('status', 'pending')->count();
        $totalPending = $pendingArticles + $pendingPortfolios;
        $totalPublished = $publishedArticles + $publishedPortfolios;
        
        $recentArticles = $user->articles()->latest()->take(5)->get()->map(function($item) {
            $item->activity_type = 'Tulisan';
            $item->icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3L22 4"></path>';
            $item->route = route('articles.edit', $item);
            return $item;
        });
        
        $recentPortfolios = $user->portfolios()->latest()->take(5)->get()->map(function($item) {
            $item->activity_type = 'Kegiatan';
            $item->icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>';
            $item->route = route('portfolios.edit', $item);
            return $item;
        });
        
        $recentActivities = $recentArticles->concat($recentPortfolios)->sortByDesc('created_at')->take(5);
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 1. IDENTITAS PENGGUNA (Hero Card) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden relative">
                <div class="absolute top-0 w-full h-32 bg-gradient-to-r from-theme-primary to-indigo-600"></div>
                <div class="p-6 sm:p-8 pt-16 sm:pt-20 relative">
                    <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6 sm:gap-8">
                        <!-- Avatar -->
                        <div class="relative shrink-0">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg bg-white dark:bg-gray-800">
                            @else
                                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-white dark:border-gray-800 shadow-lg bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 flex items-center justify-center text-5xl font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- User Info -->
                        <div class="flex-grow text-center sm:text-left">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $user->name }}</h3>
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 text-sm font-medium text-gray-600 dark:text-gray-400">
                                <span class="flex items-center bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $user->komisariat ?? 'Belum ada komisariat' }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ $user->email }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Bergabung {{ $user->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-3 w-full sm:w-auto justify-center sm:justify-start">
                            <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit Profil
                            </a>
                            <a href="{{ url('/') }}" target="_blank" class="px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm flex items-center">
                                Lihat Web
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if($totalTulisan == 0 && $totalKegiatan == 0)
                <!-- 5. EMPTY STATE -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 sm:p-12 text-center">
                    <div class="w-24 h-24 bg-indigo-50 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Belum ada aktivitas</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">Anda belum mempublikasikan tulisan atau kegiatan apapun. Mari mulai bagikan karya dan dokumentasi kegiatan komisariat Anda.</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('articles.create') }}" class="px-6 py-3 bg-theme-primary text-white font-semibold rounded-xl hover:bg-theme-primary-hover transition-colors shadow-sm shadow-theme-primary/30 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Tulisan Baru
                        </a>
                        <a href="{{ route('portfolios.create') }}" class="px-6 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Posting Kegiatan
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <!-- 2. STATISTIK PRIBADI -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col items-center justify-center text-center">
                                <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3L22 4"></path></svg>
                                </div>
                                <span class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $totalTulisan }}</span>
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tulisan</span>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col items-center justify-center text-center">
                                <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $totalKegiatan }}</span>
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</span>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col items-center justify-center text-center relative overflow-hidden">
                                <div class="absolute inset-0 bg-green-500 opacity-0 hover:opacity-5 transition-opacity"></div>
                                <div class="w-10 h-10 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $totalPublished }}</span>
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Dipublikasi</span>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col items-center justify-center text-center relative overflow-hidden">
                                <div class="absolute inset-0 bg-amber-500 opacity-0 hover:opacity-5 transition-opacity"></div>
                                <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $totalPending }}</span>
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Menunggu</span>
                            </div>
                        </div>

                        <!-- 3. AKTIVITAS TERBARU -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
                            </div>
                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($recentActivities as $activity)
                                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <div class="flex items-start gap-4">
                                            <div class="p-2.5 rounded-xl shrink-0 {{ $activity->activity_type == 'Tulisan' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $activity->icon !!}</svg>
                                            </div>
                                            <div class="flex-grow min-w-0">
                                                <div class="flex items-center justify-between gap-4 mb-1">
                                                    <h4 class="text-base font-semibold text-gray-900 dark:text-white truncate">
                                                        {{ $activity->title }}
                                                    </h4>
                                                    @if($activity->status == 'published')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800 shrink-0">
                                                            Dipublikasi
                                                        </span>
                                                    @elseif($activity->status == 'pending')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800 shrink-0">
                                                            Menunggu
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800 shrink-0">
                                                            Ditolak
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                    <span>{{ $activity->activity_type }}</span>
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $activity->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ $activity->route }}" class="text-gray-400 hover:text-theme-primary shrink-0 transition-colors p-2" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <!-- This shouldn't happen due to the outer if-else, but just in case -->
                                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada aktivitas.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <!-- 4. QUICK ACTION -->
                    <div class="space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Aksi Cepat</h3>
                            </div>
                            <div class="p-6 flex flex-col gap-3">
                                <a href="{{ route('articles.create') }}" class="flex items-center p-3 sm:p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-theme-primary dark:hover:border-theme-primary hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all group">
                                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-lg group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Buat Tulisan</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Tulis artikel atau opini baru</p>
                                    </div>
                                </a>
                                
                                <a href="{{ route('portfolios.create') }}" class="flex items-center p-3 sm:p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-theme-primary dark:hover:border-theme-primary hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all group">
                                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-lg group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Posting Kegiatan</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Dokumentasikan kegiatan</p>
                                    </div>
                                </a>
                                
                                <a href="{{ route('articles.index') }}" class="flex items-center p-3 sm:p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all group mt-2">
                                    <div class="p-2 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-lg group-hover:scale-110 transition-transform border border-gray-200 dark:border-gray-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Kelola Tulisan</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Lihat semua tulisan Anda</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

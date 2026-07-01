<!-- Sidebar Navigation -->
<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 w-72 bg-theme-surface border-r border-theme-border transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col h-full shadow-2xl lg:shadow-none">
    
    <!-- Sidebar Header (Logo) -->
    <div class="flex items-center justify-center h-20 border-b border-theme-border px-4 bg-theme-bg/30">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-4 group">
            <img src="{{ asset('images/Logo Korkom Unisa v1 transparan.png') }}" class="h-10 w-auto group-hover:scale-110 transition-transform duration-300 drop-shadow-md" alt="Logo">
            <span class="text-xl font-extrabold text-theme-text tracking-tight group-hover:text-theme-primary transition-colors">CMS KORKOM</span>
        </a>
    </div>

    <!-- Sidebar Links -->
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-2 custom-scrollbar">
        
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            {{ __('Dasbor Utama') }}
        </x-nav-link>

        @if(Auth::user()->role === 'admin')
            <div class="pt-6 pb-2">
                <p class="px-2 text-xs font-bold text-theme-secondary uppercase tracking-widest">Admin Area</p>
            </div>
            
            <div class="pt-2 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Halaman
                </p>
            </div>
            <x-nav-link :href="route('admin.about-imm.edit')" :active="request()->routeIs('admin.about-imm.*')">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ __('Tentang IMM') }}
            </x-nav-link>
            
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Tulisan
                </p>
            </div>
            <x-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.index')">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                {{ __('Menunggu Persetujuan') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.articles.approved')" :active="request()->routeIs('admin.articles.approved')">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ __('Diterima') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.articles.rejected')" :active="request()->routeIs('admin.articles.rejected')">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                {{ __('Ditolak') }}
            </x-nav-link>

            <div class="pt-4 pb-2 border-t border-gray-200 dark:border-gray-700 mt-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Kegiatan
                </p>
            </div>
            <x-nav-link :href="route('admin.portfolios.index')" :active="request()->routeIs('admin.portfolios.index')">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                {{ __('Menunggu Persetujuan') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.portfolios.approved')" :active="request()->routeIs('admin.portfolios.approved')">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ __('Diterima') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.portfolios.rejected')" :active="request()->routeIs('admin.portfolios.rejected')">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                {{ __('Ditolak') }}
            </x-nav-link>
            <div class="pt-4 pb-2 border-t border-gray-200 dark:border-gray-700 mt-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Pengguna
                </p>
            </div>
            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                {{ __('Kelola Pengguna') }}
            </x-nav-link>
        @endif

        <div class="pt-6 pb-2">
            <p class="px-2 text-xs font-bold text-theme-secondary uppercase tracking-widest">Kader Area</p>
        </div>

        <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
            <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            {{ __('Tulisan Saya') }}
        </x-nav-link>
        
        <x-nav-link :href="route('portfolios.index')" :active="request()->routeIs('portfolios.*')">
            <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            {{ __('Kegiatan Saya') }}
        </x-nav-link>
        
    </div>

    <!-- Sidebar Footer / User Profile -->
    <div class="p-4 border-t border-theme-border bg-theme-bg/30">
        <div class="flex items-center px-4 py-3 mb-2 bg-theme-surface rounded-xl shadow-sm border border-theme-border">
            <div class="flex-shrink-0">
                <div class="h-8 w-8 rounded-full bg-theme-primary flex items-center justify-center text-white font-bold text-sm shadow-inner">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
            <div class="ml-3 overflow-hidden">
                <p class="text-sm font-bold text-theme-text truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-theme-secondary truncate capitalize">{{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-30 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

<style>
/* Custom Scrollbar for Sidebar */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: var(--color-border);
    border-radius: 20px;
}
</style>

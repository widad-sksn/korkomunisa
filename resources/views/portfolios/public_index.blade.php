@extends('layouts.public')

@section('title', 'Kegiatan')

@section('content')
<div class="py-24 bg-theme-bg transition-colors duration-300 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-theme-text tracking-tight">{{ __('Kegiatan') }}</h1>
            <div class="w-24 h-1 bg-theme-primary mx-auto mt-6 rounded-full"></div>
            <p class="mt-6 text-theme-secondary text-lg">{{ __('Jejak langkah dan dokumentasi kegiatan IMM Korkom UNISA.') }}</p>
            
            <form action="{{ route('portfolios.public_index') }}" method="GET" class="mt-8 max-w-md mx-auto relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Cari Kegiatan...') }}" class="w-full px-4 py-3 rounded-full border border-theme-border bg-theme-surface text-theme-text focus:outline-none focus:ring-2 focus:ring-theme-primary transition-all">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-theme-primary text-white rounded-full hover:bg-theme-hover transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </form>
        </div>

        @if($portfolios->isEmpty())
            <p class="text-center text-theme-secondary text-lg">{{ __('Belum ada kegiatan yang ditampilkan.') }}</p>
        @else
            <div class="flex flex-wrap justify-center gap-8 mb-12">
                @foreach($portfolios as $portfolio)
                    <a href="{{ route('portfolios.show_public', $portfolio) }}" class="w-full max-w-[300px] block group bg-theme-surface border border-theme-border rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                        @if($portfolio->image_path)
                            <div class="overflow-hidden h-44 shrink-0 relative">
                                <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                            </div>
                        @else
                            <div class="w-full h-44 shrink-0 bg-theme-bg flex items-center justify-center text-theme-secondary text-sm border-b border-theme-border">No Image</div>
                        @endif
                        <div class="p-5 flex-grow flex flex-col">
                            <div class="flex items-center text-xs text-theme-primary font-bold uppercase tracking-wider mb-2">
                                <span class="text-theme-secondary">{{ $portfolio->created_at ? $portfolio->created_at->format('d M Y') : 'Terbaru' }}</span>
                            </div>
                            <h4 class="font-extrabold text-theme-text mb-2 text-lg group-hover:text-theme-primary transition-colors leading-snug line-clamp-2">{{ $portfolio->title }}</h4>
                            <p class="text-sm text-theme-secondary mb-4 leading-relaxed flex-grow line-clamp-3">{{ Str::limit(strip_tags($portfolio->description), 120) }}</p>
                            <div class="mt-auto pt-4 border-t border-theme-border/50">
                                <span class="inline-flex items-center text-theme-primary hover:text-theme-hover text-xs font-bold transition-colors">
                                    {{ __('Baca Selengkapnya') }} 
                                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $portfolios->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

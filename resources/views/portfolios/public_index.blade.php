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
            <!-- Desktop Grid View (md:flex) -->
            <div class="hidden md:flex flex-wrap justify-center gap-8 mb-12">
                @foreach($portfolios as $portfolio)
                    <a href="{{ route('portfolios.show_public', $portfolio) }}" class="w-full max-w-[300px] block group bg-theme-surface border border-theme-border rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                        @if($portfolio->image_path)
                            <div class="overflow-hidden h-44 shrink-0 relative">
                                <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" decoding="async">
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
                            <p class="text-sm text-theme-secondary mb-4 leading-relaxed flex-grow line-clamp-3">{{ Str::limit(html_entity_decode(strip_tags($portfolio->description)), 120) }}</p>
                            <div class="flex items-center text-xs text-theme-secondary mt-auto pt-4 border-t border-theme-border/50">
                                <span class="font-medium text-theme-text">{{ __('Oleh:') }} {{ $portfolio->penulis ?? $portfolio->author ?? optional($portfolio->user)->name ?? __('Anonim') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Mobile News Portal Feed / Kompas Style (block md:hidden) -->
            <div class="block md:hidden space-y-3 mb-8">
                @php
                    $headlinePortfolio = $portfolios->first();
                    $otherPortfolios = $portfolios->slice(1);
                @endphp

                @if($headlinePortfolio)
                    <a href="{{ route('portfolios.show_public', $headlinePortfolio) }}" class="block group bg-theme-surface border border-theme-border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                        @if($headlinePortfolio->image_path)
                            <div class="relative w-full aspect-[16/9] overflow-hidden bg-theme-bg">
                                <img src="{{ asset('storage/' . $headlinePortfolio->image_path) }}" alt="{{ $headlinePortfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" decoding="async">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-3 left-3 right-3 text-white">
                                    <span class="inline-block bg-red-600 text-white text-[10px] font-extrabold uppercase px-2 py-0.5 rounded shadow mb-1">
                                        KEGIATAN UTAMA
                                    </span>
                                </div>
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="flex items-center gap-2 text-[11px] text-theme-secondary mb-1.5">
                                <span class="text-theme-primary font-bold uppercase tracking-wider">KEGIATAN</span>
                                <span>•</span>
                                <span>{{ $headlinePortfolio->created_at ? $headlinePortfolio->created_at->format('d M Y') : 'Terbaru' }}</span>
                            </div>
                            <h3 class="font-extrabold text-base text-theme-text group-hover:text-theme-primary transition-colors leading-snug line-clamp-2 mb-2">
                                {{ $headlinePortfolio->title }}
                            </h3>
                            <p class="text-xs text-theme-secondary line-clamp-2 mb-3 leading-relaxed">
                                {{ Str::limit(html_entity_decode(strip_tags($headlinePortfolio->description)), 120) }}
                            </p>
                            <div class="flex items-center justify-between text-[11px] text-theme-secondary pt-2.5 border-t border-theme-border">
                                <span class="font-medium text-theme-text">{{ __('Oleh:') }} {{ $headlinePortfolio->penulis ?? $headlinePortfolio->author ?? optional($headlinePortfolio->user)->name ?? __('Anonim') }}</span>
                                <span class="text-theme-primary font-semibold flex items-center gap-0.5">Lihat <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>
                            </div>
                        </div>
                    </a>
                @endif

                @if($otherPortfolios->isNotEmpty())
                    <div class="bg-theme-surface border border-theme-border rounded-2xl px-4 divide-y divide-theme-border/70 shadow-sm">
                        @foreach($otherPortfolios as $portfolio)
                            <a href="{{ route('portfolios.show_public', $portfolio) }}" class="py-3.5 flex items-center justify-between gap-3 group">
                                <div class="flex-1 min-w-0 pr-1">
                                    <div class="flex items-center gap-1.5 text-[10px] text-theme-secondary mb-1">
                                        <span class="text-red-500 font-bold uppercase tracking-wider">KEGIATAN</span>
                                        <span>•</span>
                                        <span>{{ $portfolio->created_at ? $portfolio->created_at->format('d M Y') : 'Terbaru' }}</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-theme-text group-hover:text-theme-primary transition-colors line-clamp-2 leading-snug mb-1">
                                        {{ $portfolio->title }}
                                    </h4>
                                    <div class="text-[11px] text-theme-secondary truncate">
                                        {{ __('Oleh:') }} <span class="font-medium text-theme-text">{{ $portfolio->penulis ?? $portfolio->author ?? optional($portfolio->user)->name ?? __('Anonim') }}</span>
                                    </div>
                                </div>
                                @if($portfolio->image_path)
                                    <div class="w-24 h-20 rounded-xl overflow-hidden shrink-0 bg-theme-bg border border-theme-border">
                                        <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" decoding="async">
                                    </div>
                                @else
                                    <div class="w-24 h-20 rounded-xl shrink-0 bg-theme-bg border border-theme-border flex items-center justify-center text-[10px] text-theme-secondary">
                                        No Image
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $portfolios->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

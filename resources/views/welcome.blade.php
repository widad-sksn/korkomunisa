@extends('layouts.public')

@section('content')
    <!-- Premium Hero Section -->
    <div class="relative text-white py-32 md:py-48 text-center transition-colors duration-300 overflow-hidden flex flex-col items-center justify-center min-h-[90vh]"
         style="background: radial-gradient(circle at top left, #111827 0%, transparent 40%), linear-gradient(135deg, #111827 0%, #5C1026 50%, #9B1238 100%);">
        
        <!-- Abstract Campus Overlay -->
        <div class="absolute inset-0 z-0 opacity-[0.06] pointer-events-none mix-blend-overlay bg-cover bg-center" style="background-image: url('{{ asset('images/campus_bg.png') }}');"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center relative z-10">
            <!-- Glow Logo -->
            <div class="relative mb-6">
                <div class="absolute inset-0 bg-white/20 blur-2xl rounded-full scale-150"></div>
                <img src="{{ asset('images/Logo Korkom Unisa v2 trannsparan.png') }}" alt="Logo IMM" class="relative drop-shadow-2xl opacity-100" style="width: 160px; height: auto;">
            </div>
            
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight drop-shadow-xl">KORKOM UNISA</h1>
            <p class="text-lg md:text-2xl italic font-light mb-12 text-white/90 drop-shadow-md leading-relaxed">
                {{ __('"Anggun dalam Moral, Unggul dalam Intelektual"') }}
            </p>
            
            <!-- CTA Button with Vercel Style -->
            <a href="{{ route('articles.public_index') }}" 
               class="group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white transition-all duration-200 bg-gradient-to-r from-[#EA580C] to-[#F97316] rounded-full hover:scale-[1.03] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 shadow-[0_0_30px_rgba(249,115,22,0.35)]">
                <span class="mr-2">{{ __('Jelajahi Artikel') }}</span>
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
        
        <!-- SVG Shape Divider -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-20 pointer-events-none">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="display: block; width: 100%; height: 48px;">
                <path d="M0,120 L0,120 C300,0 900,0 1200,120 Z" style="fill: var(--color-surface); transition: fill 0.3s;"></path>
            </svg>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-theme-surface border-b border-theme-border transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 divide-y md:divide-y-0 md:divide-x divide-theme-border">
                <div class="flex flex-col items-center justify-center p-2">
                    <span class="text-3xl mb-1">👥</span>
                    <h3 class="text-2xl font-extrabold text-theme-text tracking-tight">{{ $userCount }}</h3>
                    <p class="text-theme-secondary text-sm font-medium">{{ __('Anggota Aktif') }}</p>
                </div>
                <div class="flex flex-col items-center justify-center p-2">
                    <span class="text-3xl mb-1">📰</span>
                    <h3 class="text-2xl font-extrabold text-theme-text tracking-tight">{{ $articleCount }}</h3>
                    <p class="text-theme-secondary text-sm font-medium">{{ __('Artikel Diterbitkan') }}</p>
                </div>
                <div class="flex flex-col items-center justify-center p-2">
                    <span class="text-3xl mb-1">🎉</span>
                    <h3 class="text-2xl font-extrabold text-theme-text tracking-tight">{{ $portfolioCount }}</h3>
                    <p class="text-theme-secondary text-sm font-medium">{{ __('Kegiatan') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Komisariat Section -->
    <div id="komisariat" class="py-24 bg-theme-bg transition-colors duration-300 border-b border-theme-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-theme-text tracking-tight">{{ __('IMM Komisariat UNISA') }}</h2>
                <div class="w-24 h-1 bg-theme-primary mx-auto mt-6 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- IMM FST -->
                <div class="bg-theme-surface border border-theme-border rounded-2xl p-8 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group">
                    <div class="h-20 w-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/IMM-FST.png') }}" alt="Logo IMM FST" class="h-full w-auto object-contain drop-shadow-md">
                    </div>
                    <h3 class="text-xl font-bold text-theme-text">IMM FST</h3>
                </div>

                <!-- IMM Rosyad Sholeh -->
                <div class="bg-theme-surface border border-theme-border rounded-2xl p-8 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group">
                    <div class="h-20 w-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/rosyad sholeh.png') }}" alt="Logo IMM Rosyad Sholeh" class="h-full w-auto object-contain drop-shadow-md">
                    </div>
                    <h3 class="text-xl font-bold text-theme-text">IMM Rosyad Sholeh</h3>
                </div>

                <!-- IMM Fikes -->
                <div class="bg-theme-surface border border-theme-border rounded-2xl p-8 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group">
                    <div class="h-20 w-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/fikes.png') }}" alt="Logo IMM Fikes" class="h-full w-auto object-contain drop-shadow-md">
                    </div>
                    <h3 class="text-xl font-bold text-theme-text">IMM Fikes</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tulisan Kader Section -->
    <div id="tulisan-kader" class="py-24 bg-theme-surface transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-theme-text tracking-tight">{{ __('Tulisan Kader') }}</h2>
                <div class="w-24 h-1 bg-theme-primary mx-auto mt-6 rounded-full"></div>
                <p class="mt-6 text-theme-secondary text-lg">{{ __('Gagasan, narasi, dan pemikiran dari kader IMM Korkom UNISA.') }}</p>
            </div>

            @if($articles->isEmpty())
                <p class="text-center text-theme-secondary text-lg">{{ __('Belum ada tulisan kader yang dipublikasikan.') }}</p>
            @else
                <div class="flex flex-wrap justify-center gap-8">
                    @foreach($articles as $article)
                        <a href="{{ route('articles.show_public', $article) }}" class="w-full max-w-[340px] block group bg-theme-bg border border-theme-border rounded-2xl shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col">
                            @if($article->media_path)
                                @php
                                    $ext = pathinfo($article->media_path, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array(strtolower($ext), ['mp4', 'mov', 'avi']))
                                    <video src="{{ asset('storage/' . $article->media_path) }}" class="w-full h-40 object-cover shrink-0" controls></video>
                                @else
                                    <div class="overflow-hidden h-40 shrink-0">
                                        <img src="{{ asset('storage/' . $article->media_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                @endif
                            @else
                                <div class="w-full h-40 shrink-0 bg-theme-surface flex items-center justify-center border-b border-theme-border">
                                    <span class="text-theme-secondary text-sm italic">{{ __('Tanpa Media') }}</span>
                                </div>
                            @endif
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-extrabold text-lg mb-3 text-theme-text line-clamp-2 group-hover:text-theme-primary transition-colors">{{ $article->title }}</h3>
                                <p class="text-theme-secondary text-sm mb-4 line-clamp-3 leading-relaxed flex-grow">{{ strip_tags($article->content) }}</p>
                                <div class="flex justify-between items-center text-xs text-theme-secondary pt-4 border-t border-theme-border mt-auto">
                                    <span class="font-semibold text-theme-text line-clamp-1 mr-2">{{ __('Oleh:') }} {{ optional($article->user)->name ?? __('Anonim') }}</span>
                                    <span class="shrink-0">{{ $article->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-12 text-center">
                    <a href="{{ route('articles.public_index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-theme-primary hover:bg-theme-hover transition-colors">
                        {{ __('Lihat Semua Tulisan') }}
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Portfolio Section -->
    <div id="portofolio" class="bg-theme-bg py-24 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-theme-text tracking-tight">{{ __('Kegiatan') }}</h2>
                <div class="w-24 h-1 bg-theme-primary mx-auto mt-6 rounded-full"></div>
            </div>

            @if($portfolios->isEmpty())
                <p class="text-center text-theme-secondary text-lg">{{ __('Belum ada kegiatan yang ditampilkan.') }}</p>
            @else
                <div class="flex flex-wrap justify-center gap-6">
                    @foreach($portfolios as $portfolio)
                        <a href="{{ route('portfolios.show_public', $portfolio) }}" class="w-full max-w-[280px] block group bg-theme-surface border border-theme-border rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                            @if($portfolio->image_path)
                                <div class="overflow-hidden h-36 shrink-0">
                                    <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @else
                                <div class="w-full h-36 shrink-0 bg-theme-bg flex items-center justify-center text-theme-secondary text-sm border-b border-theme-border">No Image</div>
                            @endif
                            <div class="p-5 text-center flex-grow flex flex-col">
                                <h4 class="font-extrabold text-theme-text mb-2 text-base group-hover:text-theme-primary transition-colors">{{ $portfolio->title }}</h4>
                                <p class="text-sm text-theme-secondary mb-4 leading-relaxed flex-grow">{{ Str::limit($portfolio->description, 50) }}</p>
                                @if($portfolio->url)
                                    <span class="inline-flex justify-center items-center text-theme-primary hover:text-theme-hover text-xs font-bold transition-colors mt-auto">
                                        {{ __('Selengkapnya') }} 
                                        <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-12 text-center">
                    <a href="{{ route('portfolios.public_index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-theme-primary hover:bg-theme-hover transition-colors">
                        {{ __('Lihat Semua Kegiatan') }}
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

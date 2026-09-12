@extends('layouts.public')

@section('title', 'Beranda')
@section('meta_title', 'IMM KORKOM UNISA - Beranda')

@section('content')
    @php
        if (!function_exists('localizeNumber')) {
            function localizeNumber($num) {
                if(app()->getLocale() == 'ar') {
                    return str_replace(['0','1','2','3','4','5','6','7','8','9'], ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'], $num);
                }
                return $num;
            }
        }
    @endphp
    <!-- Premium Hero Section -->
    <div class="relative py-4 md:py-12 text-center transition-colors duration-300 overflow-hidden flex flex-col items-center justify-center min-h-[25vh] md:min-h-[35vh] bg-theme-bg">
        
        <!-- Abstract Campus Overlay -->
        <div class="absolute inset-0 z-0 opacity-5 dark:opacity-[0.03] pointer-events-none mix-blend-multiply dark:mix-blend-screen bg-cover bg-center" style="background-image: url('{{ asset('images/campus_bg.webp') }}');"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center relative z-10">
            <!-- Logo -->
            <div class="relative mb-0 z-10">
                <img src="{{ asset('images/Logo_v2.webp') }}" alt="Logo IMM" class="relative drop-shadow-lg w-48 md:w-80 lg:w-96 xl:w-[450px] h-auto" fetchpriority="high" decoding="async">
            </div>
            
            <p class="text-lg md:text-2xl font-light mt-2 mb-4 md:mt-6 md:mb-8 text-theme-secondary drop-shadow-sm leading-relaxed relative z-20">
                {{ __('Anggun dalam Moral, Unggul dalam Intelektual') }}
            </p>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-theme-surface border-b border-theme-border transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-3 md:py-4">
            <div class="flex justify-evenly items-center">
                
                <!-- Tentang IMM -->
                <a href="{{ route('about') }}" class="group flex flex-col items-center justify-center text-center w-1/3 cursor-pointer">
                    <div class="bg-theme-primary/10 text-theme-primary p-1.5 md:p-2 rounded-full mb-1 group-hover:scale-110 group-hover:bg-theme-primary group-hover:text-white group-hover:shadow-sm transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 md:w-4 md:h-4"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-black text-theme-text tracking-tight leading-none mb-0.5">{{ __('Profil') }}</h3>
                    <p class="text-theme-secondary text-[10px] md:text-xs font-semibold capitalize tracking-wide">{{ __('Tentang IMM') }}</p>
                </a>

                <div class="h-8 md:h-10 w-px bg-theme-border/50"></div>

                <!-- Artikel -->
                <a href="{{ route('articles.public_index') }}" class="group flex flex-col items-center justify-center text-center w-1/3 cursor-pointer">
                    <div class="bg-theme-primary/10 text-theme-primary p-1.5 md:p-2 rounded-full mb-1 group-hover:scale-110 group-hover:bg-theme-primary group-hover:text-white group-hover:shadow-sm transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 md:w-4 md:h-4"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                    </div>
                    <h3 class="text-lg md:text-2xl font-black text-theme-text tracking-tight leading-none mb-0.5">{{ localizeNumber($articleCount) }}</h3>
                    <p class="text-theme-secondary text-[10px] md:text-xs font-semibold capitalize tracking-wide">{{ __('Artikel') }}</p>
                </a>

                <div class="h-8 md:h-10 w-px bg-theme-border/50"></div>

                <!-- Kegiatan -->
                <a href="{{ route('portfolios.public_index') }}" class="group flex flex-col items-center justify-center text-center w-1/3 cursor-pointer">
                    <div class="bg-theme-primary/10 text-theme-primary p-1.5 md:p-2 rounded-full mb-1 group-hover:scale-110 group-hover:bg-theme-primary group-hover:text-white group-hover:shadow-sm transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 md:w-4 md:h-4"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                    </div>
                    <h3 class="text-lg md:text-2xl font-black text-theme-text tracking-tight leading-none mb-0.5">{{ localizeNumber($portfolioCount) }}</h3>
                    <p class="text-theme-secondary text-[10px] md:text-xs font-semibold capitalize tracking-wide">{{ __('Kegiatan') }}</p>
                </a>

            </div>
        </div>
    </div>

    <!-- Komisariat Section -->
    <div id="komisariat" class="py-10 md:py-24 bg-theme-bg transition-colors duration-300 border-b border-theme-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 md:mb-16">
                <h2 class="text-2xl md:text-3xl font-extrabold text-theme-text tracking-tight">{{ __('IMM Komisariat UNISA') }}</h2>
                <div class="w-24 h-1 bg-theme-primary mx-auto mt-4 md:mt-6 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-3 gap-2 sm:gap-4 md:gap-8 max-w-5xl mx-auto">
                <!-- IMM FST -->
                <div class="bg-theme-surface border border-theme-border rounded-xl md:rounded-2xl p-2.5 sm:p-4 md:p-8 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group">
                    <div class="h-10 sm:h-14 md:h-20 w-full flex items-center justify-center mb-1.5 sm:mb-3 md:mb-6 group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/IMM-FST.webp') }}" alt="Logo IMM FST" class="h-full w-auto object-contain drop-shadow-md" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-xs sm:text-sm md:text-xl font-bold text-theme-text truncate w-full">IMM FST</h3>
                </div>

                <!-- IMM Rosyad Sholeh -->
                <div class="bg-theme-surface border border-theme-border rounded-xl md:rounded-2xl p-2.5 sm:p-4 md:p-8 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group">
                    <div class="h-10 sm:h-14 md:h-20 w-full flex items-center justify-center mb-1.5 sm:mb-3 md:mb-6 group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/rosyad_sholeh.webp') }}" alt="Logo IMM Rosyad Sholeh" class="h-full w-auto object-contain drop-shadow-md" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-xs sm:text-sm md:text-xl font-bold text-theme-text truncate w-full">IMM Rosyad Sholeh</h3>
                </div>

                <!-- IMM Fikes -->
                <div class="bg-theme-surface border border-theme-border rounded-xl md:rounded-2xl p-2.5 sm:p-4 md:p-8 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group">
                    <div class="h-10 sm:h-14 md:h-20 w-full flex items-center justify-center mb-1.5 sm:mb-3 md:mb-6 group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/fikes.webp') }}" alt="Logo IMM Fikes" class="h-full w-auto object-contain drop-shadow-md" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-xs sm:text-sm md:text-xl font-bold text-theme-text truncate w-full">IMM Fikes</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tulisan Kader Section -->
    <div id="tulisan-kader" class="py-10 md:py-24 bg-theme-surface transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 md:mb-16">
                <h2 class="text-2xl md:text-3xl font-extrabold text-theme-text tracking-tight">{{ __('Tulisan Kader') }}</h2>
                <div class="w-24 h-1 bg-theme-primary mx-auto mt-4 md:mt-6 rounded-full"></div>
                <p class="mt-4 md:mt-6 text-theme-secondary text-base md:text-lg">{{ __('Gagasan, narasi, dan pemikiran dari kader.') }}</p>
            </div>

            @if($articles->isEmpty())
                <p class="text-center text-theme-secondary text-base md:text-lg">{{ __('Belum ada tulisan kader yang dipublikasikan.') }}</p>
            @else
                <!-- Desktop Carousel (md:block) -->
                <div class="hidden md:block">
                    <div x-data="{ swiper: null }"
                         x-init="
                            if (window.innerWidth >= 768) {
                                swiper = new Swiper($refs.swiperContainer, {
                                    loop: {{ count($articles) > 4 ? 'true' : 'false' }},
                                    autoplay: { delay: 5000, disableOnInteraction: false, pauseOnMouseEnter: true },
                                    slidesPerView: 1,
                                    spaceBetween: 16,
                                    breakpoints: {
                                        640: { slidesPerView: 2, spaceBetween: 16 },
                                        768: { slidesPerView: 3, spaceBetween: 24 },
                                        1024: { slidesPerView: 4, spaceBetween: 24 }
                                    },
                                    navigation: { nextEl: $refs.nextBtn, prevEl: $refs.prevBtn }
                                });
                            }
                         "
                         class="relative group/slider w-full">
                        
                        <!-- Desktop Prev Button -->
                        <button x-ref="prevBtn" class="hidden md:flex absolute -left-4 lg:-left-6 top-1/2 -translate-y-1/2 z-10 bg-theme-surface border border-theme-border shadow-lg rounded-full w-12 h-12 items-center justify-center text-theme-text hover:text-theme-primary hover:scale-110 transition-all opacity-0 group-hover/slider:opacity-100 disabled:opacity-0 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>

                        <!-- Carousel Container -->
                        <div x-ref="swiperContainer" class="swiper w-full pb-2 md:pb-10 pt-4 px-4 sm:px-0">
                            <div class="swiper-wrapper flex items-stretch">
                                @foreach($articles as $article)
                                    <div class="swiper-slide !h-auto">
                                        <a href="{{ route('articles.show_public', $article) }}" class="w-full h-full group bg-theme-surface border border-theme-border rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col">
                                            @if($article->media_path)
                                                @php
                                                    $ext = pathinfo($article->media_path, PATHINFO_EXTENSION);
                                                @endphp
                                                @if(in_array(strtolower($ext), ['mp4', 'mov', 'avi']))
                                                    <video src="{{ asset('storage/' . $article->media_path) }}" class="w-full h-40 object-cover shrink-0" controls></video>
                                                @else
                                                    <div class="overflow-hidden h-40 shrink-0 relative">
                                                        <img src="{{ asset('storage/' . $article->media_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" decoding="async">
                                                        <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="w-full h-40 shrink-0 bg-theme-bg flex items-center justify-center border-b border-theme-border">
                                                    <span class="text-theme-secondary text-sm italic">{{ __('Tanpa Media') }}</span>
                                                </div>
                                            @endif
                                            <div class="p-4 md:p-5 flex-grow flex flex-col">
                                                <div class="flex items-center text-[10px] md:text-xs text-theme-primary font-bold uppercase tracking-wider mb-2">
                                                    <span class="text-theme-secondary">{{ $article->created_at->format('d M Y') }}</span>
                                                </div>
                                                <h3 class="font-extrabold text-base md:text-lg mb-1 md:mb-2 text-theme-text line-clamp-2 group-hover:text-theme-primary transition-colors leading-snug">{{ $article->title }}</h3>
                                                <p class="text-theme-secondary text-sm mb-4 line-clamp-3 leading-relaxed flex-grow">{{ html_entity_decode(strip_tags($article->content)) }}</p>
                                                <div class="flex items-center text-[10px] md:text-xs text-theme-secondary mt-auto pt-3 md:pt-4 border-t border-theme-border/50">
                                                    <span class="font-medium text-theme-text">{{ __('Oleh:') }} {{ optional($article->user)->name ?? __('Anonim') }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Desktop Next Button -->
                        <button x-ref="nextBtn" class="hidden md:flex absolute -right-4 lg:-right-6 top-1/2 -translate-y-1/2 z-10 bg-theme-surface border border-theme-border shadow-lg rounded-full w-12 h-12 items-center justify-center text-theme-text hover:text-theme-primary hover:scale-110 transition-all opacity-0 group-hover/slider:opacity-100 disabled:opacity-0 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile News Portal Feed / Kompas Style (block md:hidden) -->
                <div class="block md:hidden space-y-3">
                    @php
                        $headlineArticle = $articles->first();
                        $otherArticles = $articles->slice(1, 4);
                    @endphp

                    @if($headlineArticle)
                        <!-- Headline Utama -->
                        <a href="{{ route('articles.show_public', $headlineArticle) }}" class="block group bg-theme-bg border border-theme-border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                            @if($headlineArticle->media_path)
                                @php
                                    $ext = pathinfo($headlineArticle->media_path, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array(strtolower($ext), ['mp4', 'mov', 'avi']))
                                    <div class="w-full aspect-[16/9] bg-black">
                                        <video src="{{ asset('storage/' . $headlineArticle->media_path) }}" class="w-full h-full object-cover"></video>
                                    </div>
                                @else
                                    <div class="relative w-full aspect-[16/9] overflow-hidden bg-theme-surface">
                                        <img src="{{ asset('storage/' . $headlineArticle->media_path) }}" alt="{{ $headlineArticle->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" decoding="async">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                        <div class="absolute bottom-3 left-3 right-3 text-white">
                                            <span class="inline-block bg-theme-primary text-white text-[10px] font-extrabold uppercase px-2 py-0.5 rounded shadow mb-1">
                                                HEADLINE
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <div class="p-4">
                                <div class="flex items-center gap-2 text-[11px] text-theme-secondary mb-1.5">
                                    <span class="text-theme-primary font-bold uppercase tracking-wider">TULISAN KADER</span>
                                    <span>•</span>
                                    <span>{{ $headlineArticle->created_at->format('d M Y') }}</span>
                                </div>
                                <h3 class="font-extrabold text-base text-theme-text group-hover:text-theme-primary transition-colors leading-snug line-clamp-2 mb-2">
                                    {{ $headlineArticle->title }}
                                </h3>
                                <p class="text-xs text-theme-secondary line-clamp-2 mb-3 leading-relaxed">
                                    {{ html_entity_decode(strip_tags($headlineArticle->content)) }}
                                </p>
                                <div class="flex items-center justify-between text-[11px] text-theme-secondary pt-2.5 border-t border-theme-border">
                                    <span class="font-medium text-theme-text">{{ __('Oleh:') }} {{ optional($headlineArticle->user)->name ?? __('Anonim') }}</span>
                                    <span class="text-theme-primary font-semibold flex items-center gap-0.5">Baca <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>
                                </div>
                            </div>
                        </a>
                    @endif

                    @if($otherArticles->isNotEmpty())
                        <!-- Kompas-style Horizontal News Feed -->
                        <div class="bg-theme-bg border border-theme-border rounded-2xl px-4 divide-y divide-theme-border/70 shadow-sm">
                            @foreach($otherArticles as $article)
                                <a href="{{ route('articles.show_public', $article) }}" class="py-3.5 flex items-center justify-between gap-3 group">
                                    <div class="flex-1 min-w-0 pr-1">
                                        <div class="flex items-center gap-1.5 text-[10px] text-theme-secondary mb-1">
                                            <span class="text-theme-primary font-bold uppercase tracking-wider">TULISAN</span>
                                            <span>•</span>
                                            <span>{{ $article->created_at->format('d M Y') }}</span>
                                        </div>
                                        <h4 class="text-sm font-bold text-theme-text group-hover:text-theme-primary transition-colors line-clamp-2 leading-snug mb-1">
                                            {{ $article->title }}
                                        </h4>
                                        <div class="text-[11px] text-theme-secondary truncate">
                                            {{ __('Oleh:') }} <span class="font-medium text-theme-text">{{ optional($article->user)->name ?? __('Anonim') }}</span>
                                        </div>
                                    </div>
                                    @if($article->media_path)
                                        <div class="w-24 h-20 rounded-xl overflow-hidden shrink-0 bg-theme-surface border border-theme-border">
                                            <img src="{{ asset('storage/' . $article->media_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" decoding="async">
                                        </div>
                                    @else
                                        <div class="w-24 h-20 rounded-xl shrink-0 bg-theme-surface border border-theme-border flex items-center justify-center text-[10px] text-theme-secondary">
                                            No Media
                                        </div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mt-4 md:mt-12 text-center">
                    <a href="{{ route('articles.public_index') }}" class="inline-flex items-center px-4 py-2 md:px-6 md:py-3 border border-transparent text-sm md:text-base font-medium rounded-full shadow-sm text-white bg-theme-primary hover:bg-theme-hover transition-colors">
                        {{ __('Lihat Semua Tulisan') }}
                        <svg class="ml-2 -mr-1 w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Portfolio Section -->
    <div id="portofolio" class="bg-theme-bg py-10 md:py-24 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 md:mb-16">
                <h2 class="text-2xl md:text-3xl font-extrabold text-theme-text tracking-tight">{{ __('Kegiatan') }}</h2>
                <div class="w-24 h-1 bg-theme-primary mx-auto mt-4 md:mt-6 rounded-full"></div>
            </div>

            @if($portfolios->isEmpty())
                <p class="text-center text-theme-secondary text-base md:text-lg">{{ __('Belum ada kegiatan yang ditampilkan.') }}</p>
            @else
                <!-- Desktop Carousel (md:block) -->
                <div class="hidden md:block">
                    <div x-data="{ swiper: null }"
                         x-init="
                            if (window.innerWidth >= 768) {
                                swiper = new Swiper($refs.swiperContainer, {
                                    loop: {{ count($portfolios) > 4 ? 'true' : 'false' }},
                                    autoplay: { delay: 5000, disableOnInteraction: false, pauseOnMouseEnter: true },
                                    slidesPerView: 1,
                                    spaceBetween: 16,
                                    breakpoints: {
                                        640: { slidesPerView: 2, spaceBetween: 16 },
                                        768: { slidesPerView: 3, spaceBetween: 24 },
                                        1024: { slidesPerView: 4, spaceBetween: 24 }
                                    },
                                    navigation: { nextEl: $refs.nextBtn, prevEl: $refs.prevBtn }
                                });
                            }
                         "
                         class="relative group/slider w-full">
                        
                        <!-- Desktop Prev Button -->
                        <button x-ref="prevBtn" class="hidden md:flex absolute -left-4 lg:-left-6 top-1/2 -translate-y-1/2 z-10 bg-theme-surface border border-theme-border shadow-lg rounded-full w-12 h-12 items-center justify-center text-theme-text hover:text-theme-primary hover:scale-110 transition-all opacity-0 group-hover/slider:opacity-100 disabled:opacity-0 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>

                        <!-- Carousel Container -->
                        <div x-ref="swiperContainer" class="swiper w-full pb-2 md:pb-10 pt-4 px-4 sm:px-0">
                            <div class="swiper-wrapper flex items-stretch">
                                @foreach($portfolios as $portfolio)
                                    <div class="swiper-slide !h-auto">
                                        <a href="{{ route('portfolios.show_public', $portfolio) }}" class="w-full h-full group bg-theme-surface border border-theme-border rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col">
                                            @if($portfolio->image_path)
                                                <div class="overflow-hidden h-40 shrink-0 relative">
                                                    <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" decoding="async">
                                                    <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                                                </div>
                                            @else
                                                <div class="w-full h-40 shrink-0 bg-theme-bg flex items-center justify-center text-theme-secondary text-sm border-b border-theme-border">No Image</div>
                                            @endif
                                            <div class="p-4 md:p-5 flex-grow flex flex-col">
                                                <div class="flex items-center text-[10px] md:text-xs text-theme-primary font-bold uppercase tracking-wider mb-2">
                                                    <span class="text-theme-secondary">{{ $portfolio->created_at ? $portfolio->created_at->format('d M Y') : 'Terbaru' }}</span>
                                                </div>
                                                <h4 class="font-extrabold text-theme-text mb-1 md:mb-2 text-base md:text-lg group-hover:text-theme-primary transition-colors leading-snug line-clamp-2">{{ $portfolio->title }}</h4>
                                                <p class="text-sm text-theme-secondary mb-4 leading-relaxed flex-grow line-clamp-3">{{ Str::limit(html_entity_decode(strip_tags($portfolio->description)), 120) }}</p>
                                                <div class="flex items-center text-[10px] md:text-xs text-theme-secondary mt-auto pt-3 md:pt-4 border-t border-theme-border/50">
                                                    <span class="font-medium text-theme-text">{{ __('Oleh:') }} {{ $portfolio->penulis ?? $portfolio->author ?? optional($portfolio->user)->name ?? __('Anonim') }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Desktop Next Button -->
                        <button x-ref="nextBtn" class="hidden md:flex absolute -right-4 lg:-right-6 top-1/2 -translate-y-1/2 z-10 bg-theme-surface border border-theme-border shadow-lg rounded-full w-12 h-12 items-center justify-center text-theme-text hover:text-theme-primary hover:scale-110 transition-all opacity-0 group-hover/slider:opacity-100 disabled:opacity-0 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile News Portal Feed / Kompas Style (block md:hidden) -->
                <div class="block md:hidden space-y-3">
                    @php
                        $headlinePortfolio = $portfolios->first();
                        $otherPortfolios = $portfolios->slice(1, 4);
                    @endphp

                    @if($headlinePortfolio)
                        <!-- Headline Kegiatan Utama -->
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
                        <!-- Kompas-style Horizontal News Feed -->
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

                <div class="mt-4 md:mt-12 text-center">
                    <a href="{{ route('portfolios.public_index') }}" class="inline-flex items-center px-4 py-2 md:px-6 md:py-3 border border-transparent text-sm md:text-base font-medium rounded-full shadow-sm text-white bg-theme-primary hover:bg-theme-hover transition-colors">
                        {{ __('Lihat Semua Kegiatan') }}
                        <svg class="ml-2 -mr-1 w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

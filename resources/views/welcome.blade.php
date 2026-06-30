@extends('layouts.public')

@section('content')
    <!-- Premium Hero Section -->
    <div class="relative py-4 md:py-12 text-center transition-colors duration-300 overflow-hidden flex flex-col items-center justify-center min-h-[25vh] md:min-h-[35vh] bg-theme-bg">
        
        <!-- Abstract Campus Overlay -->
        <div class="absolute inset-0 z-0 opacity-5 dark:opacity-[0.03] pointer-events-none mix-blend-multiply dark:mix-blend-screen bg-cover bg-center" style="background-image: url('{{ asset('images/campus_bg.png') }}');"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center relative z-10">
            <!-- Logo -->
            <div class="relative mb-0 z-10">
                <img src="{{ asset('images/Logo Korkom Unisa v2 trannsparan.png') }}" alt="Logo IMM" class="relative drop-shadow-lg w-48 md:w-80 lg:w-96 xl:w-[450px] h-auto">
            </div>
            
            <p class="text-lg md:text-2xl italic font-light mt-2 mb-4 md:mt-6 md:mb-8 text-theme-secondary drop-shadow-sm leading-relaxed relative z-20">
                {{ __('"Anggun dalam Moral, Unggul dalam Intelektual"') }}
            </p>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-theme-surface border-b border-theme-border transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-8">
            <div class="grid grid-cols-3 gap-2 md:gap-6 divide-x divide-theme-border">
                <div class="flex flex-col items-center justify-start text-center p-1 md:p-2">
                    <span class="text-xl md:text-3xl mb-1">👥</span>
                    <h3 class="text-lg md:text-2xl font-extrabold text-theme-text tracking-tight">{{ $userCount }}</h3>
                    <p class="text-theme-secondary text-[10px] md:text-sm font-medium mt-1 md:mt-0 leading-tight">{{ __('Anggota Aktif') }}</p>
                </div>
                <div class="flex flex-col items-center justify-start text-center p-1 md:p-2">
                    <span class="text-xl md:text-3xl mb-1">📰</span>
                    <h3 class="text-lg md:text-2xl font-extrabold text-theme-text tracking-tight">{{ $articleCount }}</h3>
                    <p class="text-theme-secondary text-[10px] md:text-sm font-medium mt-1 md:mt-0 leading-tight">{{ __('Artikel Diterbitkan') }}</p>
                </div>
                <div class="flex flex-col items-center justify-start text-center p-1 md:p-2">
                    <span class="text-xl md:text-3xl mb-1">🎉</span>
                    <h3 class="text-lg md:text-2xl font-extrabold text-theme-text tracking-tight">{{ $portfolioCount }}</h3>
                    <p class="text-theme-secondary text-[10px] md:text-sm font-medium mt-1 md:mt-0 leading-tight">{{ __('Kegiatan') }}</p>
                </div>
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
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-8 max-w-5xl mx-auto">
                <!-- IMM FST -->
                <div class="bg-theme-surface border border-theme-border rounded-2xl p-4 md:p-8 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group">
                    <div class="h-12 md:h-20 w-full flex items-center justify-center mb-3 md:mb-6 group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/IMM-FST.png') }}" alt="Logo IMM FST" class="h-full w-auto object-contain drop-shadow-md">
                    </div>
                    <h3 class="text-sm md:text-xl font-bold text-theme-text">IMM FST</h3>
                </div>

                <!-- IMM Rosyad Sholeh -->
                <div class="bg-theme-surface border border-theme-border rounded-2xl p-4 md:p-8 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group">
                    <div class="h-12 md:h-20 w-full flex items-center justify-center mb-3 md:mb-6 group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/rosyad sholeh.png') }}" alt="Logo IMM Rosyad Sholeh" class="h-full w-auto object-contain drop-shadow-md">
                    </div>
                    <h3 class="text-sm md:text-xl font-bold text-theme-text">IMM Rosyad Sholeh</h3>
                </div>

                <!-- IMM Fikes -->
                <div class="bg-theme-surface border border-theme-border rounded-2xl p-4 md:p-8 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group">
                    <div class="h-12 md:h-20 w-full flex items-center justify-center mb-3 md:mb-6 group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/fikes.png') }}" alt="Logo IMM Fikes" class="h-full w-auto object-contain drop-shadow-md">
                    </div>
                    <h3 class="text-sm md:text-xl font-bold text-theme-text">IMM Fikes</h3>
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
                <p class="mt-4 md:mt-6 text-theme-secondary text-base md:text-lg">{{ __('Gagasan, narasi, dan pemikiran dari kader IMM Korkom UNISA.') }}</p>
            </div>

            @if($articles->isEmpty())
                <p class="text-center text-theme-secondary text-base md:text-lg">{{ __('Belum ada tulisan kader yang dipublikasikan.') }}</p>
            @else
                <div x-data="{
                        autoPlay: null,
                        currentIndex: 0,
                        totalSlides: {{ $articles->count() }},
                        init() {
                            this.startAutoPlay();
                            this.$refs.container.addEventListener('scroll', () => {
                                let container = this.$refs.container;
                                if(container.firstElementChild) {
                                    let slideWidth = container.firstElementChild.getBoundingClientRect().width;
                                    let gap = parseFloat(getComputedStyle(container).gap) || 0;
                                    this.currentIndex = Math.round(container.scrollLeft / (slideWidth + gap));
                                }
                            });
                        },
                        startAutoPlay() {
                            this.autoPlay = setInterval(() => { this.next(); }, 4000);
                        },
                        stopAutoPlay() {
                            clearInterval(this.autoPlay);
                        },
                        next() {
                            let container = this.$refs.container;
                            if(!container.firstElementChild) return;
                            let slideWidth = container.firstElementChild.getBoundingClientRect().width;
                            let gap = parseFloat(getComputedStyle(container).gap) || 0;
                            if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                                container.scrollTo({left: 0, behavior: 'smooth'});
                            } else {
                                container.scrollBy({left: slideWidth + gap, behavior: 'smooth'});
                            }
                        },
                        prev() {
                            let container = this.$refs.container;
                            if(!container.firstElementChild) return;
                            let slideWidth = container.firstElementChild.getBoundingClientRect().width;
                            let gap = parseFloat(getComputedStyle(container).gap) || 0;
                            if (container.scrollLeft <= 0) {
                                container.scrollTo({left: container.scrollWidth, behavior: 'smooth'});
                            } else {
                                container.scrollBy({left: -(slideWidth + gap), behavior: 'smooth'});
                            }
                        },
                        goTo(index) {
                            let container = this.$refs.container;
                            if(!container.firstElementChild) return;
                            let slideWidth = container.firstElementChild.getBoundingClientRect().width;
                            let gap = parseFloat(getComputedStyle(container).gap) || 0;
                            container.scrollTo({left: index * (slideWidth + gap), behavior: 'smooth'});
                        }
                    }" 
                    @mouseenter="stopAutoPlay()" 
                    @mouseleave="startAutoPlay()" 
                    @touchstart="stopAutoPlay()"
                    @touchend="startAutoPlay()"
                    class="relative group/slider w-full">
                    
                    <!-- Desktop Prev Button -->
                    <button @click="prev()" class="hidden md:flex absolute -left-4 lg:-left-6 top-1/2 -translate-y-1/2 z-10 bg-theme-surface border border-theme-border shadow-lg rounded-full w-12 h-12 items-center justify-center text-theme-text hover:text-theme-primary hover:scale-110 transition-all opacity-0 group-hover/slider:opacity-100 disabled:opacity-0 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>

                    <!-- Carousel Container -->
                    <div x-ref="container" class="flex overflow-x-auto snap-x snap-mandatory gap-4 md:gap-6 pb-8 pt-4 px-4 sm:px-0 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        @foreach($articles as $article)
                            <div class="snap-center shrink-0 w-[85%] sm:w-[45%] md:w-[30%] lg:w-[23%] flex">
                                <a href="{{ route('articles.show_public', $article) }}" class="w-full group bg-theme-surface border border-theme-border rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col">
                                    @if($article->media_path)
                                        @php
                                            $ext = pathinfo($article->media_path, PATHINFO_EXTENSION);
                                        @endphp
                                        @if(in_array(strtolower($ext), ['mp4', 'mov', 'avi']))
                                            <video src="{{ asset('storage/' . $article->media_path) }}" class="w-full h-40 object-cover shrink-0" controls></video>
                                        @else
                                            <div class="overflow-hidden h-40 shrink-0 relative">
                                                <img src="{{ asset('storage/' . $article->media_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
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
                                            <span>{{ __('Opini') }}</span>
                                            <span class="mx-2 text-theme-secondary">•</span>
                                            <span class="text-theme-secondary">{{ $article->created_at->format('d M Y') }}</span>
                                        </div>
                                        <h3 class="font-extrabold text-base md:text-lg mb-1 md:mb-2 text-theme-text line-clamp-2 group-hover:text-theme-primary transition-colors leading-snug">{{ $article->title }}</h3>
                                        <p class="text-theme-secondary text-sm mb-4 line-clamp-3 leading-relaxed flex-grow">{{ strip_tags($article->content) }}</p>
                                        <div class="flex items-center text-[10px] md:text-xs text-theme-secondary mt-auto pt-3 md:pt-4 border-t border-theme-border/50">
                                            <span class="font-medium text-theme-text">{{ __('Oleh:') }} {{ optional($article->user)->name ?? __('Anonim') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Next Button -->
                    <button @click="next()" class="hidden md:flex absolute -right-4 lg:-right-6 top-1/2 -translate-y-1/2 z-10 bg-theme-surface border border-theme-border shadow-lg rounded-full w-12 h-12 items-center justify-center text-theme-text hover:text-theme-primary hover:scale-110 transition-all opacity-0 group-hover/slider:opacity-100 disabled:opacity-0 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>

                    <!-- Mobile Dots -->
                    <div class="flex md:hidden justify-center space-x-2 mt-2 px-4 flex-wrap gap-y-2">
                        <template x-for="i in totalSlides" :key="i">
                            <button @click="goTo(i - 1)" 
                                    :class="currentIndex === (i - 1) ? 'bg-theme-primary w-6' : 'bg-theme-secondary/30 w-2 hover:bg-theme-secondary/50'" 
                                    class="h-2 rounded-full transition-all duration-300 focus:outline-none"
                                    aria-label="Go to slide"></button>
                        </template>
                    </div>
                </div>
                <div class="mt-8 md:mt-12 text-center">
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
                <div x-data="{
                        autoPlay: null,
                        currentIndex: 0,
                        totalSlides: {{ $portfolios->count() }},
                        init() {
                            this.startAutoPlay();
                            this.$refs.container.addEventListener('scroll', () => {
                                let container = this.$refs.container;
                                if(container.firstElementChild) {
                                    let slideWidth = container.firstElementChild.getBoundingClientRect().width;
                                    let gap = parseFloat(getComputedStyle(container).gap) || 0;
                                    this.currentIndex = Math.round(container.scrollLeft / (slideWidth + gap));
                                }
                            });
                        },
                        startAutoPlay() {
                            this.autoPlay = setInterval(() => { this.next(); }, 4500);
                        },
                        stopAutoPlay() {
                            clearInterval(this.autoPlay);
                        },
                        next() {
                            let container = this.$refs.container;
                            if(!container.firstElementChild) return;
                            let slideWidth = container.firstElementChild.getBoundingClientRect().width;
                            let gap = parseFloat(getComputedStyle(container).gap) || 0;
                            if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                                container.scrollTo({left: 0, behavior: 'smooth'});
                            } else {
                                container.scrollBy({left: slideWidth + gap, behavior: 'smooth'});
                            }
                        },
                        prev() {
                            let container = this.$refs.container;
                            if(!container.firstElementChild) return;
                            let slideWidth = container.firstElementChild.getBoundingClientRect().width;
                            let gap = parseFloat(getComputedStyle(container).gap) || 0;
                            if (container.scrollLeft <= 0) {
                                container.scrollTo({left: container.scrollWidth, behavior: 'smooth'});
                            } else {
                                container.scrollBy({left: -(slideWidth + gap), behavior: 'smooth'});
                            }
                        },
                        goTo(index) {
                            let container = this.$refs.container;
                            if(!container.firstElementChild) return;
                            let slideWidth = container.firstElementChild.getBoundingClientRect().width;
                            let gap = parseFloat(getComputedStyle(container).gap) || 0;
                            container.scrollTo({left: index * (slideWidth + gap), behavior: 'smooth'});
                        }
                    }" 
                    @mouseenter="stopAutoPlay()" 
                    @mouseleave="startAutoPlay()" 
                    @touchstart="stopAutoPlay()"
                    @touchend="startAutoPlay()"
                    class="relative group/slider w-full">
                    
                    <!-- Desktop Prev Button -->
                    <button @click="prev()" class="hidden md:flex absolute -left-4 lg:-left-6 top-1/2 -translate-y-1/2 z-10 bg-theme-surface border border-theme-border shadow-lg rounded-full w-12 h-12 items-center justify-center text-theme-text hover:text-theme-primary hover:scale-110 transition-all opacity-0 group-hover/slider:opacity-100 disabled:opacity-0 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>

                    <!-- Carousel Container -->
                    <div x-ref="container" class="flex overflow-x-auto snap-x snap-mandatory gap-4 md:gap-6 pb-8 pt-4 px-4 sm:px-0 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        @foreach($portfolios as $portfolio)
                            <div class="snap-center shrink-0 w-[85%] sm:w-[45%] md:w-[30%] lg:w-[23%] flex">
                                <a href="{{ route('portfolios.show_public', $portfolio) }}" class="w-full group bg-theme-surface border border-theme-border rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col">
                                    @if($portfolio->image_path)
                                        <div class="overflow-hidden h-40 shrink-0 relative">
                                            <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                            <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                                        </div>
                                    @else
                                        <div class="w-full h-40 shrink-0 bg-theme-bg flex items-center justify-center text-theme-secondary text-sm border-b border-theme-border">No Image</div>
                                    @endif
                                    <div class="p-4 md:p-5 flex-grow flex flex-col">
                                        <div class="flex items-center text-[10px] md:text-xs text-theme-primary font-bold uppercase tracking-wider mb-2">
                                            <span>{{ __('Kegiatan') }}</span>
                                            <span class="mx-2 text-theme-secondary">•</span>
                                            <span class="text-theme-secondary">{{ $portfolio->created_at ? $portfolio->created_at->format('d M Y') : 'Terbaru' }}</span>
                                        </div>
                                        <h4 class="font-extrabold text-theme-text mb-1 md:mb-2 text-base md:text-lg group-hover:text-theme-primary transition-colors leading-snug">{{ $portfolio->title }}</h4>
                                        <p class="text-sm text-theme-secondary mb-4 leading-relaxed flex-grow">{{ Str::limit($portfolio->description, 80) }}</p>
                                        <div class="mt-auto pt-3 md:pt-4 border-t border-theme-border/50">
                                            <span class="inline-flex items-center text-theme-primary hover:text-theme-hover text-[10px] md:text-xs font-bold transition-colors">
                                                {{ __('Baca Selengkapnya') }} 
                                                <svg class="w-3 h-3 md:w-4 md:h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Next Button -->
                    <button @click="next()" class="hidden md:flex absolute -right-4 lg:-right-6 top-1/2 -translate-y-1/2 z-10 bg-theme-surface border border-theme-border shadow-lg rounded-full w-12 h-12 items-center justify-center text-theme-text hover:text-theme-primary hover:scale-110 transition-all opacity-0 group-hover/slider:opacity-100 disabled:opacity-0 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>

                    <!-- Mobile Dots -->
                    <div class="flex md:hidden justify-center space-x-2 mt-2 px-4 flex-wrap gap-y-2">
                        <template x-for="i in totalSlides" :key="i">
                            <button @click="goTo(i - 1)" 
                                    :class="currentIndex === (i - 1) ? 'bg-theme-primary w-6' : 'bg-theme-secondary/30 w-2 hover:bg-theme-secondary/50'" 
                                    class="h-2 rounded-full transition-all duration-300 focus:outline-none"
                                    aria-label="Go to slide"></button>
                        </template>
                    </div>
                </div>
                <div class="mt-8 md:mt-12 text-center">
                    <a href="{{ route('portfolios.public_index') }}" class="inline-flex items-center px-4 py-2 md:px-6 md:py-3 border border-transparent text-sm md:text-base font-medium rounded-full shadow-sm text-white bg-theme-primary hover:bg-theme-hover transition-colors">
                        {{ __('Lihat Semua Kegiatan') }}
                        <svg class="ml-2 -mr-1 w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

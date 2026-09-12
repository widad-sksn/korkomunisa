@extends('layouts.public')

@section('title', 'Tulisan Kader')

@section('content')
<div class="py-24 bg-theme-surface transition-colors duration-300 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-theme-text tracking-tight">{{ __('Tulisan Kader') }}</h1>
            <div class="w-24 h-1 bg-theme-primary mx-auto mt-6 rounded-full"></div>
            <p class="mt-6 text-theme-secondary text-lg">{{ __('Gagasan, narasi, dan pemikiran dari seluruh kader IMM Korkom UNISA.') }}</p>
            
            <form action="{{ route('articles.public_index') }}" method="GET" class="mt-8 max-w-md mx-auto relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Cari Tulisan...') }}" class="w-full px-4 py-3 rounded-full border border-theme-border bg-theme-bg text-theme-text focus:outline-none focus:ring-2 focus:ring-theme-primary transition-all">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-theme-primary text-white rounded-full hover:bg-theme-hover transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </form>
        </div>

        @if($articles->isEmpty())
            <p class="text-center text-theme-secondary text-lg">{{ __('Belum ada tulisan kader yang dipublikasikan.') }}</p>
        @else
            <!-- Desktop Grid View (md:flex) -->
            <div class="hidden md:flex flex-wrap justify-center gap-8 mb-12">
                @foreach($articles as $article)
                    <a href="{{ route('articles.show_public', $article) }}" class="w-full max-w-[300px] block group bg-theme-surface border border-theme-border rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                        @if($article->media_path)
                            @php
                                $ext = pathinfo($article->media_path, PATHINFO_EXTENSION);
                            @endphp
                            @if(in_array(strtolower($ext), ['mp4', 'mov', 'avi']))
                                <video src="{{ asset('storage/' . $article->media_path) }}" class="w-full h-44 object-cover shrink-0" controls></video>
                            @else
                                <div class="overflow-hidden h-44 shrink-0 relative">
                                    <img src="{{ asset('storage/' . $article->media_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                                </div>
                            @endif
                        @else
                            <div class="w-full h-44 shrink-0 bg-theme-bg flex items-center justify-center border-b border-theme-border">
                                <span class="text-theme-secondary text-sm italic">{{ __('Tanpa Media') }}</span>
                            </div>
                        @endif
                        <div class="p-5 flex-grow flex flex-col">
                            <div class="flex items-center text-xs text-theme-primary font-bold uppercase tracking-wider mb-2">
                                <span class="text-theme-secondary">{{ $article->created_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="font-extrabold text-lg mb-2 text-theme-text line-clamp-2 group-hover:text-theme-primary transition-colors leading-snug">{{ $article->title }}</h3>
                            <p class="text-theme-secondary text-sm mb-4 line-clamp-3 leading-relaxed flex-grow">{{ html_entity_decode(strip_tags($article->content)) }}</p>
                            <div class="flex items-center text-xs text-theme-secondary mt-auto pt-4 border-t border-theme-border/50">
                                <span class="font-medium text-theme-text">{{ __('Oleh:') }} {{ optional($article->user)->name ?? __('Anonim') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Mobile News Portal Feed / Kompas Style (block md:hidden) -->
            <div class="block md:hidden space-y-3 mb-8">
                @php
                    $headlineArticle = $articles->first();
                    $otherArticles = $articles->slice(1);
                @endphp

                @if($headlineArticle)
                    <a href="{{ route('articles.show_public', $headlineArticle) }}" class="block group bg-theme-surface border border-theme-border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                        @if($headlineArticle->media_path)
                            @php
                                $ext = pathinfo($headlineArticle->media_path, PATHINFO_EXTENSION);
                            @endphp
                            @if(in_array(strtolower($ext), ['mp4', 'mov', 'avi']))
                                <div class="w-full aspect-[16/9] bg-black">
                                    <video src="{{ asset('storage/' . $headlineArticle->media_path) }}" class="w-full h-full object-cover"></video>
                                </div>
                            @else
                                <div class="relative w-full aspect-[16/9] overflow-hidden bg-theme-bg">
                                    <img src="{{ asset('storage/' . $headlineArticle->media_path) }}" alt="{{ $headlineArticle->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                    <div class="bg-theme-surface border border-theme-border rounded-2xl px-4 divide-y divide-theme-border/70 shadow-sm">
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
                                    <div class="w-24 h-20 rounded-xl overflow-hidden shrink-0 bg-theme-bg border border-theme-border">
                                        <img src="{{ asset('storage/' . $article->media_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                @else
                                    <div class="w-24 h-20 rounded-xl shrink-0 bg-theme-bg border border-theme-border flex items-center justify-center text-[10px] text-theme-secondary">
                                        No Media
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

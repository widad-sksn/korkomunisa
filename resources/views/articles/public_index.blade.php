@extends('layouts.public')

@section('title', 'Tulisan Kader')

@section('content')
<div class="py-24 bg-theme-surface transition-colors duration-300 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-theme-text tracking-tight">{{ __('Tulisan Kader') }}</h1>
            <div class="w-24 h-1 bg-theme-primary mx-auto mt-6 rounded-full"></div>
            <p class="mt-6 text-theme-secondary text-lg">{{ __('Gagasan, narasi, dan pemikiran dari seluruh kader IMM Korkom UNISA.') }}</p>
        </div>

        @if($articles->isEmpty())
            <p class="text-center text-theme-secondary text-lg">{{ __('Belum ada tulisan kader yang dipublikasikan.') }}</p>
        @else
            <div class="flex flex-wrap justify-center gap-8 mb-12">
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
                                <span>{{ __('Opini') }}</span>
                                <span class="mx-2 text-theme-secondary">•</span>
                                <span class="text-theme-secondary">{{ $article->created_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="font-extrabold text-lg mb-2 text-theme-text line-clamp-2 group-hover:text-theme-primary transition-colors leading-snug">{{ $article->title }}</h3>
                            <p class="text-theme-secondary text-sm mb-4 line-clamp-3 leading-relaxed flex-grow">{{ strip_tags($article->content) }}</p>
                            <div class="flex items-center text-xs text-theme-secondary mt-auto pt-4 border-t border-theme-border/50">
                                <span class="font-medium text-theme-text">{{ __('Oleh:') }} {{ optional($article->user)->name ?? __('Anonim') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

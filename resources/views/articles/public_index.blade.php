@extends('layouts.public')

@section('content')
<div class="py-24 bg-theme-surface transition-colors duration-300 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-theme-text tracking-tight">{{ __('Semua Tulisan Kader') }}</h1>
            <div class="w-24 h-1 bg-theme-primary mx-auto mt-6 rounded-full"></div>
            <p class="mt-6 text-theme-secondary text-lg">{{ __('Gagasan, narasi, dan pemikiran dari seluruh kader IMM Korkom UNISA.') }}</p>
        </div>

        @if($articles->isEmpty())
            <p class="text-center text-theme-secondary text-lg">{{ __('Belum ada tulisan kader yang dipublikasikan.') }}</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mb-12">
                @foreach($articles as $article)
                    <a href="{{ route('articles.show_public', $article) }}" class="block group bg-theme-bg border border-theme-border rounded-2xl shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col h-full">
                        @if($article->media_path)
                            @php
                                $ext = pathinfo($article->media_path, PATHINFO_EXTENSION);
                            @endphp
                            @if(in_array(strtolower($ext), ['mp4', 'mov', 'avi']))
                                <video src="{{ asset('storage/' . $article->media_path) }}" class="w-full h-60 object-cover" controls></video>
                            @else
                                <div class="overflow-hidden h-60">
                                    <img src="{{ asset('storage/' . $article->media_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @endif
                        @else
                            <div class="w-full h-60 bg-theme-surface flex items-center justify-center border-b border-theme-border">
                                <span class="text-theme-secondary italic">{{ __('Tanpa Media') }}</span>
                            </div>
                        @endif
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-extrabold text-xl mb-4 text-theme-text line-clamp-2 group-hover:text-theme-primary transition-colors">{{ $article->title }}</h3>
                            <p class="text-theme-secondary text-base mb-6 line-clamp-3 leading-relaxed flex-grow">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                            <div class="flex justify-between items-center text-sm text-theme-secondary pt-6 border-t border-theme-border mt-auto">
                                <span class="font-semibold text-theme-text">{{ __('Oleh:') }} {{ optional($article->user)->name ?? __('Anonim') }}</span>
                                <span>{{ $article->created_at->format('d M Y') }}</span>
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

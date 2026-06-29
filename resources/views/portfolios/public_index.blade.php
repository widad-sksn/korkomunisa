@extends('layouts.public')

@section('content')
<div class="py-24 bg-theme-bg transition-colors duration-300 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-theme-text tracking-tight">{{ __('Semua Kegiatan') }}</h1>
            <div class="w-24 h-1 bg-theme-primary mx-auto mt-6 rounded-full"></div>
            <p class="mt-6 text-theme-secondary text-lg">{{ __('Jejak langkah dan dokumentasi kegiatan IMM Korkom UNISA.') }}</p>
        </div>

        @if($portfolios->isEmpty())
            <p class="text-center text-theme-secondary text-lg">{{ __('Belum ada kegiatan yang ditampilkan.') }}</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                @foreach($portfolios as $portfolio)
                    <a href="{{ route('portfolios.show_public', $portfolio) }}" class="block group bg-theme-surface border border-theme-border rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full">
                        @if($portfolio->image_path)
                            <div class="overflow-hidden h-48 shrink-0">
                                <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div class="w-full h-48 shrink-0 bg-theme-bg flex items-center justify-center text-theme-secondary border-b border-theme-border">No Image</div>
                        @endif
                        <div class="p-6 text-center flex-grow flex flex-col">
                            <h4 class="font-extrabold text-theme-text mb-3 text-lg group-hover:text-theme-primary transition-colors">{{ $portfolio->title }}</h4>
                            <p class="text-base text-theme-secondary mb-6 leading-relaxed flex-grow">{{ Str::limit($portfolio->description, 80) }}</p>
                            @if($portfolio->url)
                                <span class="inline-flex justify-center items-center text-theme-primary hover:text-theme-hover text-sm font-bold transition-colors mt-auto">
                                    {{ __('Selengkapnya') }} 
                                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                            @endif
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

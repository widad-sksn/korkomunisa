@extends('layouts.public')

@section('title', 'Tentang IMM')

@section('content')
    <!-- Sejarah Section -->
    <div id="sejarah" class="py-24 bg-theme-bg transition-colors duration-300 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-theme-text tracking-tight">{{ $about->title }}</h2>
                <div class="w-24 h-1 bg-theme-primary mx-auto mt-6 rounded-full"></div>
            </div>
            
            <div class="prose prose-lg dark:prose-invert mx-auto text-theme-text">
                {!! $about->content !!}
            </div>
        </div>
    </div>
@endsection

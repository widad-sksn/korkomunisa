<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $portfolio->title }} - IMM KORKOM UNISA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/Logo Korkom Unisa v1 transparan.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (!('theme' in localStorage)) {
            localStorage.theme = 'dark';
        }
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body x-data="themeSwitcher" class="font-sans antialiased text-theme-text bg-theme-bg transition-colors duration-300">

    <nav class="bg-theme-navbar shadow-sm border-b border-theme-border/20 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="/">
                        <img src="{{ asset('images/Logo Korkom Unisa v1 transparan.png') }}" alt="Logo" class="mr-3" style="height: 48px; width: auto;">
                    </a>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="/#kegiatan" onclick="if(document.referrer.includes(window.location.hostname)) { history.back(); return false; }" class="text-theme-text hover:text-theme-primary font-medium transition-colors">{{ __('Kembali') }}</a>
                    
                    <!-- Language Switcher -->
                    <div class="relative" x-data="{ openLang: false }">
                        <button @click="openLang = !openLang" class="text-theme-text hover:text-theme-primary font-medium flex items-center transition-colors">
                            {{ strtoupper(app()->getLocale()) }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openLang" @click.away="openLang = false" x-transition class="absolute right-0 mt-2 w-24 bg-theme-surface border border-theme-border rounded-xl shadow-lg py-2 z-50">
                            <a href="{{ route('lang.switch', 'id') }}" class="block px-4 py-2 text-sm text-theme-text hover:bg-theme-bg transition-colors">ID</a>
                            <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-theme-text hover:bg-theme-bg transition-colors">EN</a>
                            <a href="{{ route('lang.switch', 'ar') }}" class="block px-4 py-2 text-sm text-theme-text hover:bg-theme-bg transition-colors">AR</a>
                        </div>
                    </div>

                    <button @click="toggleTheme()" class="text-theme-text hover:text-theme-primary focus:outline-none transition-colors">
                        <svg x-show="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="isDark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <article class="py-16 md:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <header class="mb-12 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-theme-text tracking-tight mb-6 leading-tight">{{ $portfolio->title }}</h1>
                <div class="flex items-center justify-center space-x-4 text-theme-secondary text-sm font-medium">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Oleh: {{ optional($portfolio->user)->name ?? 'Admin / Anonim' }}
                    </span>
                    <span>&bull;</span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $portfolio->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
            </header>

            @if($portfolio->image_path)
                <div class="mb-12 rounded-3xl overflow-hidden shadow-2xl border border-theme-border/50 bg-theme-surface">
                    <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full max-h-[600px] object-cover hover:scale-105 transition-transform duration-700">
                </div>
            @endif

            <div class="prose prose-lg dark:prose-invert max-w-none text-theme-text leading-relaxed">
                {!! nl2br(e($portfolio->description)) !!}
            </div>
            
            @if($portfolio->url)
                <div class="mt-8 text-center md:text-left">
                    <a href="{{ $portfolio->url }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-theme-primary text-white rounded-full font-bold text-sm hover:bg-theme-hover transition-colors shadow-md">
                        Kunjungi Tautan Terkait
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            @endif
            
            <div class="mt-16 pt-8 border-t border-theme-border text-center">
                <a href="/#kegiatan" onclick="if(document.referrer.includes(window.location.hostname)) { history.back(); return false; }" class="inline-flex items-center px-6 py-3 bg-theme-surface border border-theme-border rounded-full font-bold text-sm text-theme-text hover:bg-theme-bg hover:text-theme-primary transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

        </div>
    </article>

    <footer class="bg-theme-navbar border-t border-theme-border py-12 transition-colors duration-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-6 md:mb-0">
                <img src="{{ asset('images/Logo Korkom Unisa v2 trannsparan.png') }}" alt="Logo" class="mr-4 grayscale opacity-60" style="height: 40px; width: auto;">
                <span class="font-bold text-theme-secondary text-lg tracking-tight">IMM Korkom UNISA</span>
            </div>
            <p class="text-theme-secondary text-sm font-medium">&copy; {{ date('Y') }} Ikatan Mahasiswa Muhammadiyah Korkom UNISA.</p>
        </div>
    </footer>

</body>
</html>

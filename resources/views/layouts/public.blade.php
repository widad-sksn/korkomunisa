<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @hasSection('title')
            @yield('title') - KORKOM UNISA
        @else
            KORKOM UNISA
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/Logo Korkom Unisa v1 transparan.png') }}" type="image/png">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Set dark mode early to prevent flicker
        if (!('theme' in localStorage)) {
            localStorage.theme = 'light'; // Default to light mode
        }
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body x-data="themeSwitcher" class="font-sans antialiased text-theme-text bg-theme-bg transition-colors duration-300">

    <!-- Navbar (Floating Pill) -->
    <div class="sticky top-4 z-50 w-full transition-all duration-300" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300" :class="{ 'px-2 sm:px-4': scrolled, 'px-4 sm:px-6': !scrolled }">
            <div class="flex justify-between items-center h-14 md:h-16 px-4 md:px-6 bg-theme-navbar border border-theme-border rounded-full shadow-md transition-colors duration-300">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center group">
                        <img src="{{ asset('images/Logo Korkom Unisa v1 transparan.png') }}" alt="Logo" class="mr-2 md:mr-3 h-8 md:h-10 w-auto group-hover:scale-105 transition-transform">
                        <span class="font-extrabold text-theme-text text-sm md:text-base hidden lg:block tracking-tight">KORKOM UNISA</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="{{ url('/') }}" class="px-4 py-2 rounded-full font-bold transition-all duration-300 text-xs lg:text-sm {{ request()->is('/') ? 'bg-theme-primary text-white shadow-md' : 'text-theme-text hover:text-theme-primary hover:bg-theme-primary/10' }}">{{ __('Beranda') }}</a>
                    
                    <a href="{{ route('about') }}" class="px-4 py-2 rounded-full font-bold transition-all duration-300 text-xs lg:text-sm {{ request()->routeIs('about') ? 'bg-theme-primary text-white shadow-md' : 'text-theme-text hover:text-theme-primary hover:bg-theme-primary/10' }}">{{ __('Tentang IMM') }}</a>

                    <a href="{{ route('articles.public_index') }}" class="px-4 py-2 rounded-full font-bold transition-all duration-300 text-xs lg:text-sm {{ request()->routeIs('articles.public_index') || request()->routeIs('articles.show_public') ? 'bg-theme-primary text-white shadow-md' : 'text-theme-text hover:text-theme-primary hover:bg-theme-primary/10' }}">{{ __('Tulisan Kader') }}</a>
                    
                    <a href="{{ route('portfolios.public_index') }}" class="px-4 py-2 rounded-full font-bold transition-all duration-300 text-xs lg:text-sm {{ request()->routeIs('portfolios.public_index') || request()->routeIs('portfolios.show_public') ? 'bg-theme-primary text-white shadow-md' : 'text-theme-text hover:text-theme-primary hover:bg-theme-primary/10' }}">{{ __('Kegiatan') }}</a>
                </div>

                <div class="hidden md:flex items-center space-x-2">
                    <!-- Language Switcher -->
                    <div class="relative" x-data="{ openLang: false }">
                        <button @click="openLang = !openLang" class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center font-bold text-[10px] md:text-xs bg-theme-text text-theme-bg hover:scale-105 transition-transform shadow-sm">
                            {{ strtoupper(app()->getLocale()) }}
                        </button>
                        <div x-show="openLang" @click.away="openLang = false" x-transition class="absolute right-0 mt-2 w-24 bg-theme-surface border border-theme-border rounded-xl shadow-lg py-2 z-50">
                            <a href="{{ route('lang.switch', 'id') }}" class="block px-4 py-2 text-sm text-theme-text hover:bg-theme-primary/10 transition-colors">ID</a>
                            <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-theme-text hover:bg-theme-primary/10 transition-colors">EN</a>
                            <a href="{{ route('lang.switch', 'ar') }}" class="block px-4 py-2 text-sm text-theme-text hover:bg-theme-primary/10 transition-colors">AR</a>
                        </div>
                    </div>

                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()" class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center border border-theme-border text-theme-text hover:bg-theme-primary/10 hover:scale-105 transition-all focus:outline-none">
                        <svg x-show="!isDark" class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="isDark" x-cloak class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>

                    <!-- Akun -->
                    <div class="relative group">
                        <button class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center border border-theme-border text-theme-text hover:bg-theme-primary/10 hover:scale-105 transition-all">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-theme-surface border border-theme-border rounded-xl shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-theme-text hover:bg-theme-primary/10 transition-colors font-medium">{{ __('Dashboard') }}</a>
                                @else
                                    <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-theme-text hover:bg-theme-primary/10 transition-colors font-medium">{{ __('Log in') }}</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-theme-text hover:bg-theme-primary/10 transition-colors font-medium">{{ __('Register') }}</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-theme-text hover:text-theme-primary focus:outline-none p-2 rounded-full hover:bg-theme-primary/10 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden mt-2 bg-theme-navbar border border-theme-border rounded-2xl shadow-xl overflow-hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="{{ url('/') }}" class="block px-3 py-2 rounded-xl text-base font-bold transition-colors {{ request()->is('/') ? 'bg-theme-primary text-white' : 'text-theme-text hover:text-theme-primary hover:bg-theme-primary/10' }}">{{ __('Beranda') }}</a>
                    
                    <a href="{{ route('about') }}" class="block px-3 py-2 rounded-xl text-base font-bold transition-colors {{ request()->routeIs('about') ? 'bg-theme-primary text-white' : 'text-theme-text hover:text-theme-primary hover:bg-theme-primary/10' }}">{{ __('Tentang IMM') }}</a>
                    
                    <a href="{{ route('articles.public_index') }}" class="block px-3 py-2 rounded-xl text-base font-bold transition-colors {{ request()->routeIs('articles.public_index') || request()->routeIs('articles.show_public') ? 'bg-theme-primary text-white' : 'text-theme-text hover:text-theme-primary hover:bg-theme-primary/10' }}">{{ __('Tulisan Kader') }}</a>
                    
                    <a href="{{ route('portfolios.public_index') }}" class="block px-3 py-2 rounded-xl text-base font-bold transition-colors {{ request()->routeIs('portfolios.public_index') || request()->routeIs('portfolios.show_public') ? 'bg-theme-primary text-white' : 'text-theme-text hover:text-theme-primary hover:bg-theme-primary/10' }}">{{ __('Kegiatan') }}</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded-xl text-base font-bold text-theme-text hover:text-theme-primary hover:bg-theme-primary/10">{{ __('Dashboard') }}</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-xl text-base font-bold text-theme-text hover:text-theme-primary hover:bg-theme-primary/10">{{ __('Log in') }}</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-xl text-base font-bold text-theme-text hover:text-theme-primary hover:bg-theme-primary/10">{{ __('Register') }}</a>
                            @endif
                        @endauth
                    @endif
                    
                    <div class="h-px bg-theme-border my-2 mx-3"></div>
                    
                    <div class="flex items-center justify-between px-3 py-2">
                        <div class="flex space-x-2">
                            <a href="{{ route('lang.switch', 'id') }}" class="px-3 py-1.5 rounded-lg text-sm font-bold {{ app()->getLocale() == 'id' ? 'bg-theme-text text-theme-bg' : 'text-theme-text hover:bg-theme-primary/10' }}">ID</a>
                            <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1.5 rounded-lg text-sm font-bold {{ app()->getLocale() == 'en' ? 'bg-theme-text text-theme-bg' : 'text-theme-text hover:bg-theme-primary/10' }}">EN</a>
                            <a href="{{ route('lang.switch', 'ar') }}" class="px-3 py-1.5 rounded-lg text-sm font-bold {{ app()->getLocale() == 'ar' ? 'bg-theme-text text-theme-bg' : 'text-theme-text hover:bg-theme-primary/10' }}">AR</a>
                        </div>
                        
                        <button @click="toggleTheme()" class="text-theme-text hover:text-theme-primary focus:outline-none p-2 rounded-xl bg-theme-surface flex items-center justify-center transition-colors">
                            <svg x-show="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                            <svg x-show="isDark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-theme-navbar border-t border-theme-border py-12 transition-colors duration-300 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <div class="flex items-center mb-6 md:mb-0">
                    <img src="{{ asset('images/Logo Korkom Unisa v2 trannsparan.png') }}" alt="Logo" class="mr-4 grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition-all duration-300" style="height: 40px; width: auto;">
                    <span class="font-bold text-theme-secondary text-lg tracking-tight">IMM Korkom UNISA</span>
                </div>
                
                <div class="flex space-x-6 items-center">
                    <a href="https://www.instagram.com/korkom.unisa/" target="_blank" class="text-theme-secondary hover:text-theme-primary transition-colors" title="Instagram">
                        <span class="sr-only">Instagram</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    
                    <a href="mailto:immkorkom@unisayogya.ac.id" class="text-theme-secondary hover:text-theme-primary transition-colors" title="Email Kami">
                        <span class="sr-only">Email</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-theme-border/50">
                <p class="text-theme-secondary text-sm font-medium mb-4 md:mb-0">
                    <a href="mailto:immkorkom@unisayogya.ac.id" class="hover:text-theme-primary transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        immkorkom@unisayogya.ac.id
                    </a>
                </p>
                <p class="text-theme-secondary text-sm font-medium">&copy; {{ date('Y') }} IMM KORKOM UNISA. | by <a href="https://github.com/widad-sksn" target="_blank" class="font-bold hover:text-theme-primary transition-colors">widad-sksn</a></p>
            </div>
        </div>
    </footer>

</body>
</html>

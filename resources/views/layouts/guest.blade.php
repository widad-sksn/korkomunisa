<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $attributes->has('title') ? $attributes->get('title') . ' - KORKOM UNISA' : 'KORKOM UNISA' }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-theme-text bg-theme-surface antialiased transition-colors duration-300">
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Left Side: Branding / Visual (Hidden on mobile) -->
            <div class="hidden md:flex md:w-1/2 relative flex-col justify-center items-center p-12 overflow-hidden"
                 style="background: radial-gradient(circle at top left, #111827 0%, transparent 50%), linear-gradient(135deg, #111827 0%, #5C1026 50%, #9B1238 100%);">
                <!-- Abstract Campus Overlay -->
                <div class="absolute inset-0 z-0 opacity-[0.05] mix-blend-overlay bg-cover bg-center" style="background-image: url('{{ asset('images/campus_bg.png') }}');"></div>
                
                <div class="relative z-10 text-center flex flex-col items-center">
                    <a href="/" class="block hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('images/Logo Korkom Unisa v2 trannsparan.png') }}" alt="Logo IMM" style="width: 350px; height: auto;" class="drop-shadow-2xl">
                    </a>
                    <div class="mt-8">
                        <h2 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-md">KORKOM UNISA</h2>
                        <p class="text-white/80 mt-2 text-lg italic font-light">"Anggun dalam Moral, Unggul dalam Intelektual"</p>
                    </div>
                </div>
                
                <div class="absolute bottom-8 text-white/50 text-sm z-10">
                    &copy; {{ date('Y') }} IMM KORKOM UNISA. | developed by <a href="https://github.com/widad-sksn" target="_blank" class="hover:text-theme-primary transition-colors">widad-sksn</a>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="w-full md:w-1/2 min-h-screen flex flex-col justify-center items-center px-6 py-12 md:px-16 bg-theme-bg">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo (visible only on small screens) -->
                    <div class="md:hidden flex flex-col items-center mb-8">
                        <a href="/">
                            <img src="{{ asset('images/Logo Korkom Unisa v1 transparan.png') }}" alt="Logo IMM" style="width: 80px; height: auto;">
                        </a>
                    </div>

                    <div class="mb-10 text-center md:text-left">
                        @if (request()->routeIs('register'))
                            <h2 class="text-3xl font-extrabold text-theme-text tracking-tight">Daftar Akun Baru</h2>
                            <p class="text-theme-secondary mt-3">Lengkapi data di bawah ini untuk membuat akun baru.</p>
                        @else
                            <h2 class="text-3xl font-extrabold text-theme-text tracking-tight">Masuk ke Akun</h2>
                            <p class="text-theme-secondary mt-3">Silakan masuk menggunakan email dan password untuk melanjutkan ke dashboard.</p>
                        @endif
                    </div>
                    
                    <div class="bg-theme-surface p-8 rounded-3xl shadow-lg border border-theme-border/50">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>

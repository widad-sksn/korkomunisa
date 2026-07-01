<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $attributes->has('title') ? $attributes->get('title') . ' - CMS KORKOM UNISA' : 'CMS KORKOM UNISA' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="icon" href="{{ asset('images/Logo Korkom Unisa v1 transparan.png') }}" type="image/png">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Cropper.js -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
        
        <script>
            // Set dark mode early to prevent flicker
            if (!('theme' in localStorage)) {
                localStorage.theme = 'dark'; // Default to dark mode
            }
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body x-data="{ sidebarOpen: false, isDark: document.documentElement.classList.contains('dark'), toggleTheme() { this.isDark = !this.isDark; if(this.isDark) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } } }" class="font-sans antialiased text-theme-text bg-theme-bg transition-colors duration-300">
        <div class="flex h-screen overflow-hidden bg-theme-bg">
            
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Wrapper -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                
                <!-- Impersonation Banner -->
                @if(session()->has('impersonate_by'))
                    <div class="bg-orange-500 dark:bg-orange-600 text-white px-4 py-3 flex justify-between items-center z-50 shadow-md">
                        <span class="font-semibold text-sm">⚠️ Anda sedang masuk sebagai <strong class="font-bold">{{ auth()->user()->name }}</strong></span>
                        <form action="{{ route('leave-impersonate') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-bold py-1.5 px-4 rounded text-sm transition-colors shadow-sm">
                                Kembali ke Admin
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Top Header -->
                @include('layouts.topbar')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-theme-surface shadow-sm border-b border-theme-border transition-colors duration-300 z-10">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="p-4 sm:p-6 lg:p-8 w-full max-w-7xl mx-auto">
                    {{ $slot }}
                </main>
                
            </div>
        </div>
    </body>
</html>

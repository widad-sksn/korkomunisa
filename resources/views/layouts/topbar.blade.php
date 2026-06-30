<header class="sticky top-0 bg-theme-surface border-b border-theme-border z-30 transition-colors duration-300">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-14 sm:h-16 -mb-px">
            
            <!-- Header: Left side -->
            <div class="flex">
                <!-- Hamburger button for mobile -->
                <button class="p-2 -ml-2 mr-2 text-theme-secondary hover:text-theme-primary lg:hidden" @click="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="5" width="16" height="2" />
                        <rect x="4" y="11" width="16" height="2" />
                        <rect x="4" y="17" width="16" height="2" />
                    </svg>
                </button>
            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-1 sm:space-x-3">
                
                <!-- Lihat Website Button -->
                <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center px-3 py-1.5 border border-theme-primary text-xs leading-4 font-bold rounded text-theme-primary hover:bg-theme-primary hover:text-white focus:outline-none transition ease-in-out duration-150">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>{{ __('Lihat Website') }}</span>
                </a>

                <!-- Language Switcher -->
                <div class="hidden sm:block">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-theme-secondary hover:text-theme-primary focus:outline-none transition ease-in-out duration-150">
                                <div>{{ strtoupper(app()->getLocale()) }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('lang.switch', 'id')">ID (Indonesian)</x-dropdown-link>
                            <x-dropdown-link :href="route('lang.switch', 'en')">EN (English)</x-dropdown-link>
                            <x-dropdown-link :href="route('lang.switch', 'ar')">AR (Arabic)</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Theme Toggle -->
                <button @click="toggleTheme()" class="hidden sm:block text-theme-secondary hover:text-theme-primary focus:outline-none p-2 rounded-full hover:bg-theme-bg transition-colors">
                    <svg x-show="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg x-show="isDark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <div class="hidden sm:block h-6 w-px bg-theme-border mx-2"></div>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-1 sm:px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-md text-theme-text hover:text-theme-primary focus:outline-none transition ease-in-out duration-150">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-7 h-7 sm:w-6 sm:h-6 rounded-full object-cover mr-1 sm:mr-2">
                            @else
                                <div class="w-7 h-7 sm:w-6 sm:h-6 rounded-full bg-theme-primary text-white flex items-center justify-center text-xs mr-1 sm:mr-2">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="flex flex-col items-start leading-tight">
                                <span class="hidden sm:block">{{ Auth::user()->name }}</span>
                                <span class="sm:hidden text-xs">{{ Str::words(Auth::user()->name, 1, '') }}</span>
                                @if(Auth::user()->komisariat)
                                    <span class="hidden sm:block text-xs font-normal text-theme-secondary">{{ Auth::user()->komisariat }}</span>
                                @endif
                            </div>
                            <div class="ms-1 flex-shrink-0">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Mobile-only secondary menus -->
                        <div class="sm:hidden border-b border-theme-border mb-1 pb-1">
                            <x-dropdown-link :href="url('/')" target="_blank" class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                {{ __('Lihat Website') }}
                            </x-dropdown-link>
                            <button @click="toggleTheme()" class="w-full text-left flex items-center px-4 py-2 text-sm leading-5 text-theme-text hover:bg-theme-bg transition duration-150 ease-in-out">
                                <svg x-show="!isDark" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                                <svg x-show="isDark" x-cloak class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span x-show="!isDark">{{ __('Tema Gelap') }}</span>
                                <span x-show="isDark" x-cloak>{{ __('Tema Terang') }}</span>
                            </button>
                            <div class="px-4 py-2 text-[10px] font-bold text-theme-secondary uppercase tracking-wider bg-theme-bg/50 mt-1">
                                {{ __('Bahasa / Language') }}
                            </div>
                            <x-dropdown-link :href="route('lang.switch', 'id')" class="pl-6 flex justify-between items-center">
                                <span>Indonesian</span> <span class="text-xs text-theme-secondary font-mono">ID</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('lang.switch', 'en')" class="pl-6 flex justify-between items-center">
                                <span>English</span> <span class="text-xs text-theme-secondary font-mono">EN</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('lang.switch', 'ar')" class="pl-6 flex justify-between items-center">
                                <span>Arabic</span> <span class="text-xs text-theme-secondary font-mono">AR</span>
                            </x-dropdown-link>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="flex items-center text-red-500 hover:text-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</header>

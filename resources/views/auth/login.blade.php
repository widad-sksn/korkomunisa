<x-guest-layout title="Login">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Cloudflare Turnstile -->
        <div class="mt-4 flex flex-col justify-start">
            <div class="cf-turnstile" 
                 data-sitekey="{{ config('services.turnstile.site_key') }}"
                 data-callback="onTurnstileSuccess"
                 data-error-callback="onTurnstileError"
                 data-expired-callback="onTurnstileError">
            </div>
            <div id="turnstile-loading" class="mt-2 text-sm text-gray-500 flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-theme-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menunggu verifikasi keamanan...
            </div>
            <p id="turnstile-error" class="text-sm text-red-600 mt-2 hidden">Silakan selesaikan verifikasi keamanan terlebih dahulu.</p>
            <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-theme-secondary hover:text-theme-primary transition-colors focus:outline-none" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif

            <x-primary-button id="submit-btn" disabled class="ms-3 bg-theme-primary hover:bg-theme-hover text-white opacity-60 cursor-not-allowed transition-all duration-300 shadow-md">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script>
        function onTurnstileSuccess() {
            document.getElementById('turnstile-loading').classList.add('hidden');
            document.getElementById('turnstile-error').classList.add('hidden');
            
            const btn = document.getElementById('submit-btn');
            btn.removeAttribute('disabled');
            btn.classList.remove('opacity-60', 'cursor-not-allowed');
        }

        function onTurnstileError() {
            document.getElementById('turnstile-loading').classList.add('hidden');
            document.getElementById('turnstile-error').classList.remove('hidden');
            
            const btn = document.getElementById('submit-btn');
            btn.setAttribute('disabled', 'disabled');
            btn.classList.add('opacity-60', 'cursor-not-allowed');
        }
    </script>
</x-guest-layout>

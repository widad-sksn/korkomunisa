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

        <!-- Cloudflare Turnstile Error -->
        <div class="mt-2">
            <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-theme-secondary hover:text-theme-primary transition-colors focus:outline-none" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif

            <div class="flex items-center gap-3">
                
                <!-- Cloudflare Turnstile Hidden Widget -->
                <div class="cf-turnstile" 
                     data-sitekey="{{ config('services.turnstile.site_key') }}"
                     data-callback="onTurnstileSuccess"
                     data-error-callback="onTurnstileError"
                     data-expired-callback="onTurnstileError"
                     data-appearance="interaction-only">
                </div>

                <!-- Custom Turnstile UI -->
                <div id="custom-turnstile-ui" class="flex items-center bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded px-2.5 py-1.5 shadow-sm">
                    <!-- Cloud Logo -->
                    <svg class="w-4 h-4 mr-1.5 text-[#F38020]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.5 19c2.48 0 4.5-2.02 4.5-4.5S19.98 10 17.5 10c-.17 0-.34.01-.5.03C16.29 7.15 13.88 5 11 5 7.69 5 5 7.69 5 11c0 .12.01.24.02.36C2.75 11.85 1 13.72 1 16c0 2.76 2.24 5 5 5h11.5z"></path>
                    </svg>

                    <!-- Spinner State -->
                    <div id="custom-turnstile-spinner" class="flex items-center">
                        <svg class="animate-spin -ml-0.5 mr-1.5 h-3 w-3 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 font-medium tracking-wide">Protected by Cloudflare Turnstile</span>
                    </div>

                    <!-- Success State -->
                    <div id="custom-turnstile-success" class="hidden items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[11px] text-green-600 dark:text-green-400 font-medium tracking-wide">Verified by Cloudflare</span>
                    </div>

                    <!-- Error State -->
                    <div id="custom-turnstile-error" class="hidden items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="text-[11px] text-red-600 dark:text-red-400 font-medium tracking-wide">Verification Failed</span>
                    </div>
                </div>

                <x-primary-button id="submit-btn" disabled class="bg-theme-primary hover:bg-theme-hover text-white opacity-60 cursor-not-allowed transition-all duration-300 shadow-md">
                    {{ __('Masuk') }}
                </x-primary-button>
            </div>
        </div>
    </form>

    <script>
        // Define callbacks BEFORE loading the Turnstile script
        function onTurnstileSuccess() {
            const spinner = document.getElementById('custom-turnstile-spinner');
            const success = document.getElementById('custom-turnstile-success');
            const error = document.getElementById('custom-turnstile-error');
            
            if(spinner) spinner.classList.add('hidden');
            if(error) error.classList.add('hidden');
            if(success) {
                success.classList.remove('hidden');
                success.classList.add('flex');
            }
            
            const btn = document.getElementById('submit-btn');
            if(btn) {
                btn.removeAttribute('disabled');
                btn.classList.remove('opacity-60', 'cursor-not-allowed');
            }
        }

        function onTurnstileError() {
            const spinner = document.getElementById('custom-turnstile-spinner');
            const success = document.getElementById('custom-turnstile-success');
            const error = document.getElementById('custom-turnstile-error');
            
            if(spinner) spinner.classList.add('hidden');
            if(success) success.classList.add('hidden');
            if(error) {
                error.classList.remove('hidden');
                error.classList.add('flex');
            }
            
            const btn = document.getElementById('submit-btn');
            if(btn) {
                btn.setAttribute('disabled', 'disabled');
                btn.classList.add('opacity-60', 'cursor-not-allowed');
            }
        }
    </script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</x-guest-layout>

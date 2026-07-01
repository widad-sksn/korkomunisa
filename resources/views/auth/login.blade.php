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
                
                <!-- Cloudflare Turnstile Hidden Widget (Explicit Render) -->
                <div id="cf-turnstile-widget" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>

                <!-- Custom Turnstile UI (Text Only) -->
                <div id="custom-turnstile-ui" class="flex items-center text-[11px] font-medium tracking-wide">
                    <!-- Spinner State -->
                    <div id="custom-turnstile-spinner" class="flex items-center text-gray-500 dark:text-gray-400">
                        <span>⏳ Memverifikasi...</span>
                    </div>

                    <!-- Success State -->
                    <div id="custom-turnstile-success" class="hidden items-center text-green-600 dark:text-green-400">
                        <span>✓ Verifikasi Cloudflare</span>
                    </div>

                    <!-- Error State -->
                    <div id="custom-turnstile-error" class="hidden items-center text-red-600 dark:text-red-400">
                        <span>❌ Gagal diverifikasi</span>
                    </div>
                </div>

                <x-primary-button id="submit-btn" disabled class="bg-theme-primary hover:bg-theme-hover text-white opacity-60 cursor-not-allowed transition-all duration-300 shadow-md">
                    {{ __('Masuk') }}
                </x-primary-button>
            </div>
        </div>
    </form>

    <script>
        // Explicit rendering callback
        function onloadTurnstileCallback() {
            const widgetEl = document.getElementById('cf-turnstile-widget');
            if (!widgetEl) return;
            const siteKey = widgetEl.getAttribute('data-sitekey');
            turnstile.render('#cf-turnstile-widget', {
                sitekey: siteKey,
                appearance: 'interaction-only',
                callback: function(token) {
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
                },
                'error-callback': function() {
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
                },
                'expired-callback': function() {
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
            });
        }
    </script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback" async></script>
</x-guest-layout>

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

        <!-- Cloudflare Turnstile Official Widget -->
        <div class="mt-4 flex justify-center">
            <div class="cf-turnstile"
                 data-sitekey="{{ config('services.turnstile.site_key') }}"
                 data-callback="onTurnstileSuccess"
                 data-error-callback="onTurnstileError"
                 data-expired-callback="onTurnstileExpired"
                 data-theme="light">
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-theme-secondary hover:text-theme-primary transition-colors focus:outline-none" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif

            <x-primary-button id="submit-btn" disabled class="bg-theme-primary hover:bg-theme-hover text-white opacity-60 cursor-not-allowed transition-all duration-300 shadow-md">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function onTurnstileSuccess(token) {
            const btn = document.getElementById('submit-btn');
            if (btn) {
                btn.removeAttribute('disabled');
                btn.classList.remove('opacity-60', 'cursor-not-allowed');
            }
        }
        function onTurnstileError() {
            const btn = document.getElementById('submit-btn');
            if (btn) {
                btn.setAttribute('disabled', 'disabled');
                btn.classList.add('opacity-60', 'cursor-not-allowed');
            }
        }
        function onTurnstileExpired() {
            const btn = document.getElementById('submit-btn');
            if (btn) {
                btn.setAttribute('disabled', 'disabled');
                btn.classList.add('opacity-60', 'cursor-not-allowed');
            }
        }
    </script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</x-guest-layout>


<x-guest-layout title="Register">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Komisariat -->
        <div class="mt-4">
            <x-input-label for="komisariat" :value="__('Komisariat')" />
            <select id="komisariat" name="komisariat" class="mt-1 block w-full bg-theme-bg border-theme-border text-theme-text focus:border-theme-primary focus:ring-theme-primary rounded-xl shadow-sm transition-colors duration-200 py-2.5 px-4" required>
                <option value="" disabled selected>Pilih Komisariat</option>
                <option value="IMM FST" {{ old('komisariat') == 'IMM FST' ? 'selected' : '' }}>IMM FST</option>
                <option value="IMM Rosyad Sholeh" {{ old('komisariat') == 'IMM Rosyad Sholeh' ? 'selected' : '' }}>IMM Rosyad Sholeh</option>
                <option value="IMM FIKES" {{ old('komisariat') == 'IMM FIKES' ? 'selected' : '' }}>IMM FIKES</option>
                <option value="Korkom UNISA" {{ old('komisariat') == 'Korkom UNISA' ? 'selected' : '' }}>Korkom UNISA</option>
            </select>
            <x-input-error :messages="$errors->get('komisariat')" class="mt-2" />
        </div>

        <!-- Bidang -->
        <div class="mt-4">
            <x-input-label for="bidang" :value="__('Bidang (Opsional)')" />
            <x-text-input id="bidang" class="block mt-1 w-full" type="text" name="bidang" :value="old('bidang')" placeholder="Contoh: Kaderisasi" />
            <x-input-error :messages="$errors->get('bidang')" class="mt-2" />
        </div>

        <!-- Jabatan -->
        <div class="mt-4">
            <x-input-label for="jabatan" :value="__('Jabatan (Opsional)')" />
            <x-text-input id="jabatan" class="block mt-1 w-full" type="text" name="jabatan" :value="old('jabatan')" placeholder="Contoh: Ketua Bidang" />
            <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Cloudflare Turnstile Error -->
        <div class="mt-2">
            <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 gap-3">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

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
                {{ __('Register') }}
            </x-primary-button>
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

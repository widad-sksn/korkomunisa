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

        <div class="flex items-center justify-end mt-4 gap-3">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button id="submit-btn" disabled class="bg-theme-primary hover:bg-theme-hover text-white opacity-60 cursor-not-allowed transition-all duration-300 shadow-md">
                {{ __('Register') }}
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


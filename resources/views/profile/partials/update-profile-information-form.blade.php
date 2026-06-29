<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="komisariat" :value="__('Komisariat')" />
            <select id="komisariat" name="komisariat" class="mt-1 block w-full bg-theme-bg border-theme-border text-theme-text focus:border-theme-primary focus:ring-theme-primary rounded-xl shadow-sm transition-colors duration-200 py-2.5 px-4" required>
                <option value="" disabled>Pilih Komisariat</option>
                <option value="IMM FST" {{ old('komisariat', $user->komisariat) == 'IMM FST' ? 'selected' : '' }}>IMM FST</option>
                <option value="IMM Rosyad Sholeh" {{ old('komisariat', $user->komisariat) == 'IMM Rosyad Sholeh' ? 'selected' : '' }}>IMM Rosyad Sholeh</option>
                <option value="IMM FIKES" {{ old('komisariat', $user->komisariat) == 'IMM FIKES' ? 'selected' : '' }}>IMM FIKES</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('komisariat')" />
        </div>

        <div>
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            @if ($user->avatar)
                <div class="mt-2 mb-4">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover shadow">
                </div>
            @endif
            <input id="avatar" name="avatar" type="file" class="mt-1 block w-full text-sm text-theme-text file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-theme-primary file:text-white hover:file:opacity-90 transition-opacity cursor-pointer" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkannya kembali.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}" id="resend-form">
            @csrf

            <div>
                <x-primary-button id="resend-button">
                    {{ __('Kirim Ulang Email') }} <span id="countdown" class="ml-1 hidden"></span>
                </x-primary-button>
            </div>
        </form>

        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                {{ __('Sudah Verifikasi? Lanjutkan') }}
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Keluar') }}
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('resend-button');
            const countdownSpan = document.getElementById('countdown');
            const form = document.getElementById('resend-form');
            
            // Periksa apakah baru saja dikirim (ada status session)
            const justSent = {{ session('status') == 'verification-link-sent' ? 'true' : 'false' }};
            
            let cooldownEndTime = localStorage.getItem('resendCooldown');
            
            if (justSent) {
                // Set cooldown 60 detik dari sekarang
                cooldownEndTime = Date.now() + 60000;
                localStorage.setItem('resendCooldown', cooldownEndTime);
            }
            
            function updateCooldown() {
                if (!cooldownEndTime) return;
                
                const now = Date.now();
                const remaining = Math.ceil((cooldownEndTime - now) / 1000);
                
                if (remaining > 0) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                    countdownSpan.classList.remove('hidden');
                    countdownSpan.innerText = `(${remaining}s)`;
                    setTimeout(updateCooldown, 1000);
                } else {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    countdownSpan.classList.add('hidden');
                    localStorage.removeItem('resendCooldown');
                }
            }
            
            updateCooldown();
            
            form.addEventListener('submit', function(event) {
                if (btn.disabled) {
                    event.preventDefault();
                    return false;
                }
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
                btn.innerHTML = 'Mengirim...';
            });
        });
    </script>
</x-guest-layout>

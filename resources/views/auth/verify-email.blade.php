<x-guest-layout title="Verifikasi Email">
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkannya kembali.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col gap-3">
        {{-- Tombol utama: Kirim Ulang Email --}}
        <form method="POST" action="{{ route('verification.send') }}" id="resend-form">
            @csrf
            <x-primary-button id="resend-button" class="w-full justify-center px-6 py-3 text-sm tracking-wide">
                {{ __('Kirim Ulang Email Verifikasi') }} <span id="countdown" class="ml-1 hidden"></span>
            </x-primary-button>
        </form>

        {{-- Tombol sekunder: Cek & Lanjutkan --}}
        <button type="button" onclick="window.location.reload()" class="w-full inline-flex justify-center items-center px-6 py-3 border-2 border-[#8C1515] text-sm font-semibold text-[#8C1515] rounded-md hover:bg-[#8C1515] hover:text-white transition-all duration-200 tracking-wide cursor-pointer">
            {{ __('Sudah Verifikasi? Klik untuk Lanjutkan →') }}
        </button>

        {{-- Tombol tersier: Keluar --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-center text-sm text-gray-400 hover:text-gray-600 transition-colors duration-200 py-2">
                {{ __('Keluar dari Akun') }}
            </button>
        </form>
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

            // Auto-refresh setiap 15 detik untuk cek verifikasi
            setInterval(function() { window.location.reload(); }, 15000);
        });
    </script>
</x-guest-layout>

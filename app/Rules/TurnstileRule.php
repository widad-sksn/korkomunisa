<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class TurnstileRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail('Silakan selesaikan verifikasi keamanan terlebih dahulu.');
            return;
        }

        try {
            $response = Http::timeout(5)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret'),
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            $body = $response->json();

            if (!isset($body['success']) || $body['success'] !== true) {
                $fail('Verifikasi keamanan gagal. Silakan muat ulang halaman dan coba lagi.');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Turnstile verification failed: ' . $e->getMessage());
            $fail('Terjadi masalah dengan layanan verifikasi. Silakan coba lagi nanti.');
        }
    }
}

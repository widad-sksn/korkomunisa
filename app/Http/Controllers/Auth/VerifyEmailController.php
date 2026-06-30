<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified and log them in automatically.
     */
    public function __invoke(Request $request, $id, $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            Auth::login($user);
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1')
                ->with('success', 'Email sudah diverifikasi. Selamat datang di Portal IMM KORKOM UNISA.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1')
            ->with('success', 'Email berhasil diverifikasi. Selamat datang di Portal IMM KORKOM UNISA.');
    }
}

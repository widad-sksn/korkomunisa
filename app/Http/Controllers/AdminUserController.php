<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function verify(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('admin.users.index')->with('error', 'Pengguna ini sudah terverifikasi.');
        }

        $user->markEmailAsVerified();

        return redirect()->route('admin.users.index')->with('success', "Pengguna {$user->name} berhasil diverifikasi secara manual.");
    }

    public function impersonate(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat login sebagai diri sendiri.');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Tidak dapat masuk sebagai akun Admin lain.');
        }

        $adminId = auth()->id();
        $adminName = auth()->user()->name;

        // Log the action
        \Illuminate\Support\Facades\Log::info("Admin {$adminName} (ID: {$adminId}) has started impersonating user {$user->name} (ID: {$user->id})");

        // Store original admin ID in session
        session()->put('impersonate_by', $adminId);

        // Login as the user
        auth()->login($user);

        return redirect()->route('dashboard')->with('success', "Anda sekarang masuk sebagai {$user->name}.");
    }

    public function leaveImpersonate()
    {
        if (session()->has('impersonate_by')) {
            $adminId = session()->pull('impersonate_by');

            // Verify original user exists and is still an admin
            $admin = User::find($adminId);
            if ($admin && $admin->role === 'admin') {
                $currentUserId = auth()->id();
                \Illuminate\Support\Facades\Log::info("Admin (ID: {$adminId}) stopped impersonating user (ID: {$currentUserId}) and returned to admin account");

                auth()->logout();
                auth()->login($admin);

                return redirect()->route('admin.users.index')->with('success', 'Berhasil kembali ke akun Admin.');
            }

            // If session was invalid or user is not an admin anymore, logout cleanly
            auth()->logout();
            return redirect()->route('login')->with('error', 'Sesi admin tidak valid. Silakan login kembali.');
        }

        return redirect()->route('dashboard');
    }
}
